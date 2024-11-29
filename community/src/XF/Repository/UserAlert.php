<?php

namespace XF\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

use function count, is_array;

class UserAlert extends Repository
{
	/**
	 * @param int $userId
	 * @param null|int $cutOff
	 *
	 * @return Finder
	 */
	public function findAlertsForUser($userId, $cutOff = null)
	{
		$finder = $this->finder('XF:UserAlert')
			->where('alerted_user_id', $userId)
			->whereAddOnActive([
				'column' => 'depends_on_addon_id'
			])
			->order('event_date', 'desc')
			->with('User');

		if ($cutOff)
		{
			$finder->whereOr(
				[
					['read_date', '=', 0],
					['view_date', '=', 0],
					['view_date', '>=', $cutOff]
				]
			);
		}

		return $finder;
	}

	public function userReceivesAlert(\XF\Entity\User $receiver, $senderId, $contentType, $action)
	{
		if (!$receiver->user_id)
		{
			return false;
		}

		if ($senderId && $receiver->isIgnoring($senderId))
		{
			return false;
		}

		if ($receiver->Option)
		{
			/** @var \XF\Entity\UserOption $userOption */
			$userOption = $receiver->Option;
			return $userOption->doesReceiveAlert($contentType, $action);
		}
		else
		{
			return true;
		}
	}

	public function userReceivesPush(\XF\Entity\User $receiver, $senderId, $contentType, $action)
	{
		if (!$receiver->user_id || $receiver->is_banned)
		{
			return false;
		}

		if ($senderId && $receiver->isIgnoring($senderId))
		{
			return false;
		}

		if ($receiver->Option)
		{
			/** @var \XF\Entity\UserOption $userOption */
			$userOption = $receiver->Option;
			return $userOption->doesReceivePush($contentType, $action);
		}
		else
		{
			return true;
		}
	}

	public function alertFromUser(
		\XF\Entity\User $receiver, \XF\Entity\User $sender = null,
		$contentType, $contentId, $action, array $extra = [], array $options = []
	)
	{
		$senderId = $sender ? $sender->user_id : 0;
		$senderName = $sender ? $sender->username : '';

		if (!$this->userReceivesAlert($receiver, $senderId, $contentType, $action))
		{
			return false;
		}

		return $this->insertAlert($receiver->user_id, $senderId, $senderName, $contentType, $contentId, $action, $extra, $options);
	}

	public function alert(
		\XF\Entity\User $receiver, $senderId, $senderName,
		$contentType, $contentId, $action, array $extra = [], array $options = []
	)
	{
		if (!$this->userReceivesAlert($receiver, $senderId, $contentType, $action))
		{
			return false;
		}

		return $this->insertAlert($receiver->user_id, $senderId, $senderName, $contentType, $contentId, $action, $extra, $options);
	}

	public function insertAlert(
		$receiverId, $senderId, $senderName,
		$contentType, $contentId, $action, array $extra = [], array $options = []
	)
	{
		if (!$receiverId)
		{
			return false;
		}

		$options = array_replace([
			'autoRead' => true,
			'dependsOnAddOnId' => null
		], $options);

		if ($options['dependsOnAddOnId'] === null)
		{
			if (isset($extra['depends_on_addon_id']))
			{
				$options['dependsOnAddOnId'] = $extra['depends_on_addon_id'];
				unset($extra['depends_on_addon_id']);
			}
			else
			{
				$options['dependsOnAddOnId'] = '';
			}
		}

		/** @var \XF\Entity\UserAlert $alert */
		$alert = $this->em->create('XF:UserAlert');
		$alert->alerted_user_id = $receiverId;
		$alert->user_id = $senderId;
		$alert->username = $senderName;
		$alert->content_type = $contentType;
		$alert->content_id = $contentId;
		$alert->action = $action;
		$alert->extra_data = $extra;
		$alert->depends_on_addon_id = $options['dependsOnAddOnId'];
		$alert->auto_read = (bool)$options['autoRead'];

		$alert->save();

		if ($alert->Receiver && $this->userReceivesPush($alert->Receiver, $senderId, $contentType, $action))
		{
			/** @var \XF\Service\Alert\Pusher $pusher */
			$pusher = $this->app()->service('XF:Alert\Pusher', $alert->Receiver, $alert);
			$pusher->push();
		}

		return true;
	}

	public function fastDeleteAlertsToUser($toUserId, $contentType, $contentId, $action)
	{
		$finder = $this->finder('XF:UserAlert')
			->where([
				'content_type' => $contentType,
				'content_id' => $contentId,
				'action' => $action,
				'alerted_user_id' => $toUserId
			]);
		$this->deleteAlertsInternal($finder);
		// TODO: approach will need to change if there's alert folding
	}

	public function fastDeleteAlertsFromUser($fromUserId, $contentType, $contentId, $action)
	{
		$finder = $this->finder('XF:UserAlert')
			->where([
				'content_type' => $contentType,
				'content_id' => $contentId,
				'action' => $action,
				'user_id' => $fromUserId
			]);
		$this->deleteAlertsInternal($finder);
		// TODO: approach will need to change if there's alert folding
	}

	public function fastDeleteAlertsForContent($contentType, $contentId)
	{
		$finder = $this->finder('XF:UserAlert')
			->where([
				'content_type' => $contentType,
				'content_id' => $contentId
			]);
		$this->deleteAlertsInternal($finder);
	}

	protected function deleteAlertsInternal(Finder $matches)
	{
		$results = $matches->fetchColumns('alert_id', 'alerted_user_id', 'view_date', 'read_date');
		if (!$results)
		{
			return;
		}

		$userIds = [];
		$viewCountChange = [];
		$readCountChange = [];
		$delete = [];

		foreach ($results AS $result)
		{
			$delete[] = $result['alert_id'];

			$userIds[$result['alerted_user_id']] = $result['alerted_user_id'];

			if (!$result['view_date'])
			{
				if (isset($viewCountChange[$result['alerted_user_id']]))
				{
					$viewCountChange[$result['alerted_user_id']]++;
				}
				else
				{
					$viewCountChange[$result['alerted_user_id']] = 1;
				}
			}

			if (!$result['read_date'])
			{
				if (isset($readCountChange[$result['alerted_user_id']]))
				{
					$readCountChange[$result['alerted_user_id']]++;
				}
				else
				{
					$readCountChange[$result['alerted_user_id']] = 1;
				}
			}
		}

		$db = $this->db();
		$db->beginTransaction();

		$db->delete('xf_user_alert', 'alert_id IN (' . $db->quote($delete) . ')');

		foreach ($userIds AS $userId)
		{
			$viewChange = $viewCountChange[$userId] ?? 0;
			$readChange = $readCountChange[$userId] ?? 0;

			$db->query("
				UPDATE xf_user
				SET alerts_unviewed = GREATEST(0, CAST(alerts_unviewed AS SIGNED) - ?),
					alerts_unread = GREATEST(0, CAST(alerts_unread AS SIGNED) - ?)
				WHERE user_id = ?
			", [$viewChange, $readChange, $userId]);
		}

		$db->commit();
	}

	public function markUserAlertsViewed(\XF\Entity\User $user, $viewDate = null)
	{
		if ($viewDate === null)
		{
			$viewDate = \XF::$time;
		}

		if (!$user->user_id)
		{
			throw new \LogicException("Trying to mark alerts viewed for an invalid user");
		}

		$db = $this->db();
		$db->executeTransaction(function() use ($db, $viewDate, $user)
		{
			$db->update('xf_user_alert', ['view_date' => $viewDate], "alerted_user_id = ? AND view_date = 0", $user->user_id);

			$user->alerts_unviewed = 0;
			$user->save(true, false);
		}, \XF\Db\AbstractAdapter::ALLOW_DEADLOCK_RERUN);
	}

	public function markUserAlertViewed(\XF\Entity\UserAlert $alert, $viewDate = null)
	{
		if ($viewDate === null)
		{
			$viewDate = \XF::$time;
		}

		if (!$alert->isUnviewed())
		{
			return;
		}

		$user = $alert->Receiver;

		$db = $this->db();

		$db->executeTransaction(function() use ($db, $alert, $user, $viewDate)
		{
			$db->update('xf_user_alert',
				['view_date' => $viewDate],
				'alert_id = ?',
				$alert->alert_id
			);

			if ($user)
			{
				if ($alert->isUnviewed())
				{
					$user->alerts_unviewed = ($user->alerts_unviewed - 1);
				}

				$user->saveIfChanged($null, true, false);
			}
		}, \XF\Db\AbstractAdapter::ALLOW_DEADLOCK_RERUN);
	}

	public function markUserAlertsRead(\XF\Entity\User $user, $readDate = null)
	{
		if ($readDate === null)
		{
			$readDate = \XF::$time;
		}

		if (!$user->user_id)
		{
			throw new \LogicException("Trying to mark alerts read for an invalid user");
		}

		$db = $this->db();
		$db->executeTransaction(function() use ($db, $readDate, $user)
		{
			$db->update('xf_user_alert', ['view_date' => $readDate], "alerted_user_id = ? AND view_date = 0", $user->user_id);
			$db->update('xf_user_alert', ['read_date' => $readDate], "alerted_user_id = ? AND read_date = 0", $user->user_id);

			$user->alerts_unviewed = 0;
			$user->alerts_unread = 0;
			$user->save(true, false);
		}, \XF\Db\AbstractAdapter::ALLOW_DEADLOCK_RERUN);
	}

	public function autoMarkUserAlertsRead(\XF\Mvc\Entity\AbstractCollection $alerts, \XF\Entity\User $user, $readDate = null)
	{
		$alerts = $alerts->filter(function(\XF\Entity\UserAlert $alert)
		{
			return ($alert->isUnread() && $alert->auto_read);
		});

		$this->markSpecificUserAlertsRead($alerts, $user, $readDate);
	}

	protected function markSpecificUserAlertsRead(
		\XF\Mvc\Entity\AbstractCollection $alerts,
		\XF\Entity\User $user,
		int $readDate = null)
	{
		if (!$user->user_id)
		{
			throw new \LogicException("Trying to mark alerts read for an invalid user");
		}

		if ($readDate === null)
		{
			$readDate = \XF::$time;
		}

		$unreadAlertIds = [];
		foreach ($alerts AS $alert)
		{
			/** @var \XF\Entity\UserAlert $alert */
			if ($alert->isUnread())
			{
				$unreadAlertIds[] = $alert->alert_id;
				$alert->setAsSaved('view_date', $readDate);
				$alert->setAsSaved('read_date', $readDate);

				// we need to treat this as unread for the current request so it can display the way we want
				$alert->setOption('force_unread_in_ui', true);
			}
		}

		if (!$unreadAlertIds)
		{
			return;
		}

		$db = $this->db();
		$db->executeTransaction(function() use ($db, $readDate, $user, $unreadAlertIds)
		{
			$alertsUnviewed = $db->fetchOne("
				SELECT COUNT(*)
				FROM xf_user_alert
				WHERE view_date = 0
					AND alert_id IN(" . $db->quote($unreadAlertIds) . ")
			");

			$db->update('xf_user_alert',
				['view_date' => $readDate, 'read_date' => $readDate],
				'alert_id IN(' . $db->quote($unreadAlertIds) . ')'
			);

			$user->alerts_unviewed = ($user->alerts_unviewed - $alertsUnviewed);
			$user->alerts_unread = ($user->alerts_unread - count($unreadAlertIds));
			$user->save(true, false);
		}, \XF\Db\AbstractAdapter::ALLOW_DEADLOCK_RERUN);
	}

	public function markUserAlertsReadForContent($contentType, $contentIds, $onlyActions = null, \XF\Entity\User $user = null, $readDate = null)
	{
		if ($user === null)
		{
			$user = \XF::visitor();
		}

		if (!$user->user_id || !$user->alerts_unread)
		{
			return;
		}

		if (!is_array($contentIds))
		{
			$contentIds = [$contentIds];
		}

		if (!$contentIds)
		{
			return;
		}

		if ($readDate === null)
		{
			$readDate = \XF::$time;
		}

		$db = $this->db();

		$excludeActionsClause = '';
		if ($onlyActions)
		{
			if (!is_array($onlyActions))
			{
				$onlyActions = [$onlyActions];
			}

			$excludeActionsClause = ' AND action IN (' . $db->quote($onlyActions) . ')';
		}

		$unreadAlertIds = $db->fetchAllColumn('
			SELECT alert_id
			FROM xf_user_alert
			WHERE content_type = ?
				AND content_id IN(' . $db->quote($contentIds) . ')
				AND alerted_user_id = ?
				AND read_date = 0
				AND event_date < ?
		' . $excludeActionsClause, [$contentType, $user->user_id, $readDate]);

		if (!$unreadAlertIds)
		{
			return;
		}

		$db->executeTransaction(function() use ($db, $unreadAlertIds, $readDate, $user)
		{
			$alertsUnviewed = $db->fetchOne("
				SELECT COUNT(*)
				FROM xf_user_alert
				WHERE view_date = 0
				AND alert_id IN(" . $db->quote($unreadAlertIds) . ")
			");

			$db->update('xf_user_alert',
				['view_date' => $readDate, 'read_date' => $readDate],
				'alert_id IN(' . $db->quote($unreadAlertIds) . ')'
			);

			$user->alerts_unviewed = ($user->alerts_unviewed - $alertsUnviewed);
			$user->alerts_unread = ($user->alerts_unread - count($unreadAlertIds));
			$user->save(true, false);
		}, \XF\Db\AbstractAdapter::ALLOW_DEADLOCK_RERUN);
	}

	public function markUserAlertRead(\XF\Entity\UserAlert $alert, $readDate = null)
	{
		if ($readDate === null)
		{
			$readDate = \XF::$time;
		}

		if (!$alert->isUnread())
		{
			return;
		}

		$user = $alert->Receiver;

		$db = $this->db();

		$db->executeTransaction(function() use ($db, $alert, $user, $readDate)
		{
			$db->update('xf_user_alert',
				['view_date' => $readDate, 'read_date' => $readDate],
				'alert_id = ?',
				$alert->alert_id
			);

			if ($user)
			{
				if ($alert->isUnviewed())
				{
					$user->alerts_unviewed = ($user->alerts_unviewed - 1);
				}
				$user->alerts_unread = ($user->alerts_unread - 1);

				$user->saveIfChanged($null, true, false);
			}
		}, \XF\Db\AbstractAdapter::ALLOW_DEADLOCK_RERUN);
	}

	public function markUserAlertUnread(\XF\Entity\UserAlert $alert, bool $disableAutoRead = true)
	{
		if ($alert->isUnread())
		{
			return;
		}

		$user = $alert->Receiver;

		$db = $this->db();

		$db->executeTransaction(function() use ($db, $alert, $user, $disableAutoRead)
		{
			$update = ['read_date' => 0];
			if ($disableAutoRead)
			{
				$update['auto_read'] = 0;
			}

			$db->update('xf_user_alert',
				$update,
				'alert_id = ?',
				$alert->alert_id
			);

			if ($user)
			{
				$user->alerts_unread = ($user->alerts_unread + 1);

				$user->saveIfChanged($null, true, false);
			}
		}, \XF\Db\AbstractAdapter::ALLOW_DEADLOCK_RERUN);
	}

	/**
	 * Makes alerts that aren't accessible as read. This is primarily to prevent unread alerts being "stuck".
	 * Alerts meet this criteria if they depend on a disabled add-on, don't have a valid handler or the related
	 * content is not viewable.
	 *
	 * @param \XF\Entity\User $user
	 */
	public function markInaccessibleAlertsRead(\XF\Entity\User $user)
	{
		$unreadAlerts = $this->finder('XF:UserAlert')
			->where([
				'alerted_user_id' => $user->user_id,
				'read_date' => 0
			])
			->fetch();

		$this->addContentToAlerts($unreadAlerts);

		$addOns = \XF::app()->container('addon.cache');

		$invalidAlerts = $unreadAlerts->filter(function(\XF\Entity\UserAlert $alert) use($addOns)
		{
			if ($alert->depends_on_addon_id)
			{
				if (!isset($addOns[$alert->depends_on_addon_id]))
				{
					return true;
				}
			}

			if (!$alert->canView())
			{
				return true;
			}

			return false;
		});

		$this->markSpecificUserAlertsRead($invalidAlerts, $user);
	}

	public function pruneViewedAlerts($cutOff = null)
	{
		if ($cutOff === null)
		{
			$cutOff = \XF::$time - $this->options()->alertExpiryDays * 86400;
		}

		$finder = $this->finder('XF:UserAlert')
			->where('view_date', '>', 0)
			->where('view_date', '<', $cutOff);
		$this->deleteAlertsInternal($finder);
	}

	public function pruneUnviewedAlerts($cutOff = null)
	{
		if ($cutOff === null)
		{
			$cutOff = \XF::$time - 30 * 86400;
		}

		$finder = $this->finder('XF:UserAlert')
			->where('view_date', 0)
			->where('event_date', '<', $cutOff);
		$this->deleteAlertsInternal($finder);
	}

	/**
	 * @param \XF\Entity\User $user
	 *
	 * @return bool
	 */
	public function updateUnviewedCountForUser(\XF\Entity\User $user)
	{
		if (!$user->user_id)
		{
			return false;
		}

		$count = $this->findAlertsForUser($user->user_id)
			->where('view_date', 0)
			->total();

		$user->alerts_unviewed = $count;
		$user->saveIfChanged($updated);

		return $updated;
	}

	/**
	 * @param \XF\Entity\User $user
	 *
	 * @return bool
	 */
	public function updateUnreadCountForUser(\XF\Entity\User $user)
	{
		if (!$user->user_id)
		{
			return false;
		}

		$count = $this->findAlertsForUser($user->user_id)
			->where('read_date', 0)
			->total();

		$user->alerts_unread = $count;
		$user->saveIfChanged($updated);

		return $updated;
	}

	/**
	 * @return \XF\Alert\AbstractHandler[]
	 */
	public function getAlertHandlers()
	{
		$handlers = [];

		foreach (\XF::app()->getContentTypeField('alert_handler_class') AS $contentType => $handlerClass)
		{
			if (class_exists($handlerClass))
			{
				$handlerClass = \XF::extendClass($handlerClass);
				$handlers[$contentType] = new $handlerClass($contentType);
			}
		}

		return $handlers;
	}

	/**
	 * @param string $type
	 * @param bool $throw
	 *
	 * @return \XF\Alert\AbstractHandler|null
	 */
	public function getAlertHandler($type, $throw = false)
	{
		$handlerClass = \XF::app()->getContentTypeFieldValue($type, 'alert_handler_class');
		if (!$handlerClass)
		{
			if ($throw)
			{
				throw new \InvalidArgumentException("No Alert handler for '$type'");
			}
			return null;
		}

		if (!class_exists($handlerClass))
		{
			if ($throw)
			{
				throw new \InvalidArgumentException("Alert handler for '$type' does not exist: $handlerClass");
			}
			return null;
		}

		$handlerClass = \XF::extendClass($handlerClass);
		return new $handlerClass($type);
	}

	/**
	 * @param \XF\Mvc\Entity\ArrayCollection|\XF\Entity\UserAlert[] $alerts
	 */
	public function addContentToAlerts($alerts)
	{
		$contentMap = [];
		foreach ($alerts AS $key => $alert)
		{
			$contentType = $alert->content_type;
			if (!isset($contentMap[$contentType]))
			{
				$contentMap[$contentType] = [];
			}
			$contentMap[$contentType][$key] = $alert->content_id;
		}

		foreach ($contentMap AS $contentType => $contentIds)
		{
			$handler = $this->getAlertHandler($contentType);
			if (!$handler)
			{
				continue;
			}
			$data = $handler->getContent($contentIds);
			foreach ($contentIds AS $alertId => $contentId)
			{
				$content = $data[$contentId] ?? null;
				$alerts[$alertId]->setContent($content);
			}
		}
	}

	public function getAlertOptOuts()
	{
		$handlers = $this->getAlertHandlers();

		$alertOptOuts = [];
		$orderedTypes = [];

		foreach ($handlers AS $contentType => $handler)
		{
			$optOuts = $handler->getOptOutsMap();
			if (!$optOuts)
			{
				continue;
			}

			$alertOptOuts[$contentType] = $optOuts;
			$orderedTypes[$contentType] = $handler->getOptOutDisplayOrder();
		}
		asort($orderedTypes);

		$orderedOptOuts = [];
		foreach ($orderedTypes AS $contentType => $null)
		{
			$orderedOptOuts[$contentType] = $alertOptOuts[$contentType];
		}

		return $orderedOptOuts;
	}

	public function getAlertOptOutActions()
	{
		$handlers = $this->getAlertHandlers();

		$actions = [];
		foreach ($handlers AS $contentType => $handler)
		{
			foreach ($handler->getOptOutActions() AS $action)
			{
				$actions[$contentType . '_' . $action] = true;
			}
		}

		return $actions;
	}
}