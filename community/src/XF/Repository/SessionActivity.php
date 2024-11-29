<?php

namespace XF\Repository;

use XF\Mvc\Entity\Repository;

use function call_user_func, intval, is_array, is_scalar, strlen;

class SessionActivity extends Repository
{
	public function getOnlineCounts($onlineCutOff = null)
	{
		if ($onlineCutOff === null)
		{
			$onlineCutOff = \XF::$time - $this->options()->onlineStatusTimeout * 60;
		}

		return $this->db()->fetchRow("
			SELECT
				SUM(IF(user_id >= 0 AND robot_key = '', 1, 0)) AS total,
				SUM(IF(user_id > 0, 1, 0)) AS members,
				SUM(IF(user_id = 0 AND robot_key = '', 1, 0)) AS guests
			FROM xf_session_activity
			WHERE view_date >= ?
		", $onlineCutOff);
	}

	public function getOnlineUsersList($limit)
	{
		/** @var \XF\Finder\SessionActivity $finder */
		$finder = $this->finder('XF:SessionActivity');
		$finder->restrictType('member')
			->applyMemberVisibilityRestriction()
			->activeOnly()
			->with('User')
			->order('view_date', 'DESC');

		if ($limit)
		{
			$finder->limit($limit);
		}

		return $finder->fetch()->pluckNamed('User', 'user_id');
	}

	public function getOnlineStaffList()
	{
		/** @var \XF\Finder\SessionActivity $finder */
		$finder = $this->finder('XF:SessionActivity');
		$finder->restrictType('member')
			->applyMemberVisibilityRestriction()
			->activeOnly()
			->with('User')
			->where('User.is_staff', 1)
			->order('view_date', 'DESC');

		return $finder->fetch()->pluckNamed('User', 'user_id');
	}

	public function getOnlineStatsBlockData($forceIncludeVisitor, $userLimit, $staffQuery = false)
	{
		$counts = $this->getOnlineCounts();
		$users = $this->getOnlineUsersList($userLimit)->toArray();

		if ($forceIncludeVisitor)
		{
			$visitor = \XF::visitor();
			if ($visitor->user_id && !isset($users[$visitor->user_id]))
			{
				$users = [$visitor->user_id => $visitor] + $users;
				$counts['members']++;
				$counts['total']++;
			}
		}

		// run extra query to show all online staff
		if ($staffQuery)
		{
			$users += $this->getOnlineStaffList()->toArray();
		}

		$counts['unseen'] = ($userLimit ? max($counts['members'] - $userLimit, 0) : 0);

		return [
			'counts' => $counts,
			'users' => $users
		];
	}

	public function isTypeRestrictionValid($type)
	{
		switch ($type)
		{
			case 'member':
			case 'guest':
			case 'robot':
			case '':
				return true;

			default:
				return false;
		}
	}

	public function findForOnlineList($typeLimit)
	{
		/** @var \XF\Finder\SessionActivity $finder */
		$finder = $this->finder('XF:SessionActivity');
		$finder->activeOnly()
			->restrictType($typeLimit)
			->withFullUser()
			->order('view_date', 'DESC');

		return $finder;
	}

	public function updateSessionActivity($userId, $ip, $controller, $action, array $params, $viewState, $robotKey)
	{
		$userId = intval($userId);
		$binaryIp = \XF\Util\Ip::convertIpStringToBinary($ip);
		$uniqueKey = $userId ?: $binaryIp;

		// TODO: swallow errors if upgrade is pending
		// work-around MySQL locking issues (https://bugs.mysql.com/bug.php?id=98324)
		$optimizationEnabled = (bool) $this->app()->config('sessionActivityOptimized');
		$expiration = $this->getDefaultSessionActivityExpiration();

		if ($optimizationEnabled)
		{
			$viewDate = $this->db()->fetchOne(
				'SELECT view_date
					FROM xf_session_activity
					WHERE user_id = ? AND unique_key = ?',
				[$userId, $uniqueKey]
			);
		}
		else
		{
			// we'll replace the record either way, so avoid an extra query
			$viewDate = 0;
		}

		if ($viewDate === false)
		{
			// the record did not exist, insert ignore it in case it has been created
			$operation = 'INSERT IGNORE';
		}
		else if (!$optimizationEnabled || $viewDate <= \XF::$time - $expiration + 60)
		{
			// optimization has been disabled, or the record was close to expiration
			// replace it in case it has been pruned
			$operation = 'REPLACE';
		}
		else if ($viewDate <= \XF::$time - 1)
		{
			// the record was not close to expiration, update it normally
			$operation = 'UPDATE';
		}
		else
		{
			// the record was already updated within the last second, skip updating
			return;
		}

		if ($operation === 'UPDATE')
		{
			$query = '-- XFDB=noForceAllWrite
				UPDATE xf_session_activity
				SET
					ip = ?,
					controller_name = ?,
					controller_action = ?,
					view_state = ?,
					params = ?,
					view_date = ?,
					robot_key = ?
				WHERE user_id = ? AND unique_key = ?';
		}
		else
		{
			$query = "-- XFDB=noForceAllWrite
				{$operation} INTO xf_session_activity (
					ip,
					controller_name,
					controller_action,
					view_state,
					params,
					view_date,
					robot_key,
					user_id,
					unique_key
				) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
			";
		}

		if ($userId)
		{
			$robotKey = '';
		}

		$logParams = [];
		foreach ($params AS $paramKey => $paramValue)
		{
			if (!strlen($paramKey) || !is_scalar($paramValue))
			{
				continue;
			}

			$logParams[] = "$paramKey=" . urlencode($paramValue);
		}
		$paramList = implode('&', $logParams);

		$controller = substr($controller, 0, 100);
		$action = substr($action, 0, 75);
		$paramList = substr($paramList, 0, 100);
		$robotKey = substr($robotKey, 0, 25);

		$this->db()->query($query, [
			$binaryIp,
			$controller,
			$action,
			$viewState,
			$paramList,
			\XF::$time,
			$robotKey,
			$userId,
			$uniqueKey
		]);
	}

	public function updateUserLastActivityFromSession()
	{
		$this->db()->query("
			UPDATE xf_user AS u
			INNER JOIN xf_session_activity AS a ON (a.user_id > 0 AND a.user_id = u.user_id)
			SET u.last_activity = a.view_date
		");
	}

	public function pruneExpiredActivityRecords($cutOff = null)
	{
		if ($cutOff === null)
		{
			$expiration = $this->getDefaultSessionActivityExpiration();
			if (!$expiration)
			{
				return;
			}

			$cutOff = \XF::$time - $expiration;
		}

		$this->db()->delete('xf_session_activity', 'view_date < ?', $cutOff);
	}

	public function getDefaultSessionActivityExpiration(): int
	{
		return $this->app()->config()['sessionActivityExpiration'];
	}

	public function clearUserActivity($userId, $ip)
	{
		$userId = intval($userId);
		$binaryIp = \XF\Util\Ip::convertIpStringToBinary($ip);
		$uniqueKey = ($userId ? $userId : $binaryIp);

		$this->db()->delete('xf_session_activity',
			'user_id = ? AND unique_key = ?',
			[$userId, $uniqueKey]
		);
	}

	public function applyActivityDetails($activities)
	{
		if ($activities instanceof \XF\Entity\SessionActivity)
		{
			$activities = [$activities];
		}

		$controllers = [];
		foreach ($activities AS $key => $activity)
		{
			$controllers[$activity->controller_name][$key] = $activity;
		}

		foreach ($controllers AS $controller => $entries)
		{
			$controller = $this->app()->extension()->extendClass($controller);
			try
			{
				$valid = ($controller
					&& class_exists($controller)
					&& is_callable([$controller, 'getActivityDetails'])
				);
			}
			catch (\Throwable $e)
			{
				// don't let a class load error (XFCP) error
				$valid = false;
			}

			if ($valid)
			{
				$controllerOutput = call_user_func([$controller, 'getActivityDetails'], $entries);
			}
			else
			{
				$controllerOutput = false;
			}

			if (is_array($controllerOutput))
			{
				foreach ($controllerOutput AS $key => $info)
				{
					if (!isset($entries[$key]))
					{
						continue;
					}

					/** @var \XF\Entity\SessionActivity $activity */
					$activity = $entries[$key];

					if (is_array($info))
					{
						$activity->setItemDetails($info['description'], $info['title'], $info['url']);
					}
					else
					{
						$activity->setItemDetails($info);
					}
				}
			}
			else
			{
				foreach ($entries AS $key => $activity)
				{
					$activity->setItemDetails($controllerOutput);
				}
			}
		}
	}
}