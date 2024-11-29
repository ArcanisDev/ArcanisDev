<?php

namespace XF\Spam;

use XF\Entity\User;

use function boolval, count, strval;

class Cleaner
{
	protected $app;
	protected $db;

	/** @var User */
	protected $user;

	protected $log = [];
	protected $errors = [];

	protected $inTransaction = false;

	public function __construct(\XF\App $app, User $user)
	{
		$this->app = $app;

		$this->db = $app->db();

		$this->setUser($user);
	}

	public function setUser(User $user)
	{
		$this->user = $user;
	}

	public function isAlreadyCleaned()
	{
		$db = $this->db;

		return boolval($db->fetchOne('
			SELECT COUNT(*)
			FROM xf_spam_cleaner_log
			WHERE user_id = ?
			AND restored_date = 0
		', $this->user->user_id));
	}

	public function isRecentlyCleaned(int $recentSeconds = null): bool
	{
		$db = $this->db;

		// done this way to give us future flexibility without requiring a method signature change
		if ($recentSeconds === null)
		{
			$recentSeconds = 120;
		}

		return boolval($db->fetchOne('
			SELECT COUNT(*)
			FROM xf_spam_cleaner_log
			WHERE user_id = ?
			AND restored_date = 0
			AND application_date >= ?
		', [$this->user->user_id, time() - $recentSeconds]));
	}

	public function banUser()
	{
		$this->forceTransaction();

		$this->log('user', 'banned');

		$user = $this->user;

		$reason = strval(\XF::phrase('spam_cleaner_ban_reason'));

		/** @var \XF\Repository\Banning $banningRepo */
		$banningRepo = $this->app->repository('XF:Banning');

		$success = $banningRepo->banUser($user, 0, $reason, $error);
		if (!$success)
		{
			$this->logError('ban', $error);
			return;
		}

		if ($user->avatar_date > 0 || $user->gravatar)
		{
			/** @var \XF\Service\User\Avatar $avatarService */
			$avatarService = $this->app->service('XF:User\Avatar', $user);
			$avatarService->logIp(false);
			$avatarService->deleteAvatar();
		}

		if ($user->Profile && $user->Profile->banner_date > 0)
		{
			/** @var \XF\Service\User\ProfileBanner $bannerService */
			$bannerService = $this->app->service('XF:User\ProfileBanner', $user);
			$bannerService->logIp(false);
			$bannerService->deleteBanner();
		}

		$this->submitData();
	}

	public function submitData()
	{
		$submitter = $this->app->container('spam.userSubmitter');
		$submitter->submit($this->user);
	}

	protected function getDefaultActions()
	{
		return [
			'action_threads' => false,
			'delete_messages' => false,
			'delete_conversations' => false,
			'ban_user' => false,
			'check_ips' => false
		];
	}

	protected function prepareActions(array $actions)
	{
		return array_replace($this->getDefaultActions(), $actions);
	}

	public function cleanUp(array $actions)
	{
		$actions = $this->prepareActions($actions);

		$this->forceTransaction();

		if ($actions['ban_user'])
		{
			$this->banUser();
		}

		$this->cleanUpContent($actions);
	}

	public function cleanUpContent(array $actions)
	{
		$actions = $this->prepareActions($actions);

		$this->forceTransaction();

		/** @var \XF\Repository\Spam $spamRepo */
		$spamRepo = $this->app->repository('XF:Spam');

		$spamHandlers = $spamRepo->getSpamHandlers($this->user);
		foreach ($spamHandlers AS $contentType => $spamHandler)
		{
			if ($spamHandler->canCleanUp($actions))
			{
				if (!$spamHandler->cleanUp($this->log, $error))
				{
					$this->logError($contentType, $error);

					return;
				}
			}
		}

		if ($actions['delete_messages'])
		{
			$reports = $this->app->finder('XF:Report')->where('content_user_id', $this->user->user_id);
			foreach ($reports->fetch() AS $report)
			{
				$report->report_state = 'resolved';
				$report->save();
			}
		}
	}

	public function finalize()
	{
		$db = $this->db;

		if (count($this->errors))
		{
			if ($this->inTransaction)
			{
				$db->rollback();
				$this->inTransaction = false;
			}

			return false;
		}

		$this->user->save();
		$this->writeLog();

		if ($this->inTransaction)
		{
			$db->commit();
			$this->inTransaction = false;
		}

		return true;
	}

	protected function writeLog()
	{
		$db = $this->db;

		$user = $this->user;
		$visitor = \XF::visitor();

		// log progress
		$db->insert('xf_spam_cleaner_log', [
			'user_id' => $user->user_id,
			'username' => $user->username,
			'applying_user_id' => $visitor->user_id,
			'applying_username' => $visitor->username,
			'application_date' => time(),
			'data' => (count($this->log) ? json_encode($this->log) : '')
		]);

		$this->app->logger()->logModeratorAction('user', $user, 'spam_clean');
	}

	protected function forceTransaction()
	{
		if (!$this->inTransaction)
		{
			$this->db->beginTransaction();
			$this->inTransaction = true;
		}
	}

	public function getErrors()
	{
		return $this->errors;
	}

	protected function log($logKey, $value)
	{
		$this->log[$logKey] = $value;
	}

	protected function logError($logKey, $value)
	{
		$this->errors[$logKey] = $value;
	}
}