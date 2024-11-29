<?php

namespace XF\Repository;

use XF\Mvc\Entity\Repository;

class PreRegAction extends Repository
{
	/**
	 * @param string $guestKey
	 *
	 * @return \XF\Entity\PreRegAction|null
	 */
	public function getActionByKey(string $guestKey)
	{
		return $this->em->findOne('XF:PreRegAction', ['guest_key' => $guestKey]);
	}

	/**
	 * @param int $userId
	 *
	 * @return \XF\Entity\PreRegAction|null
	 */
	public function getActionByUser(int $userId)
	{
		return $this->em->findOne('XF:PreRegAction', ['user_id' => $userId]);
	}

	/**
	 * @param string $guestKey
	 *
	 * @return bool
	 */
	public function deleteActionByKey(string $guestKey): bool
	{
		$action = $this->getActionByKey($guestKey);
		if ($action)
		{
			$action->delete();
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Associates an action with the guest key with a specific user instead. Note that this will delete
	 * any previous actions associated with the user. (Check for a record before if you don't want this behavior.)
	 *
	 * @param string $guestKey
	 * @param int $userId
	 *
	 * @return bool True if we found a guest key record and updated it
	 */
	public function associateActionWithUser(string $guestKey, int $userId): bool
	{
		$db = $this->db();

		$db->beginTransaction();

		$db->delete('xf_pre_reg_action', 'user_id = ?', $userId);

		$rowsUpdated = $db->update(
			'xf_pre_reg_action',
			['user_id' => $userId, 'guest_key' => null],
			'guest_key = ?',
			$guestKey
		);

		$db->commit();

		return $rowsUpdated ? true : false;
	}

	/**
	 * Completes the action associated with this user, if there is one.
	 *
	 * @param \XF\Entity\User $user
	 * @param \XF\Mvc\Entity\Entity|null $content Reference to created content (or null if not created)
	 *
	 * @return bool True if completed (even with an error), false otherwise
	 */
	public function completeUserAction(\XF\Entity\User $user, &$content = null): bool
	{
		$action = $this->getActionByUser($user->user_id);
		if ($action)
		{
			$actionHandler = $action->Handler;
			if ($actionHandler)
			{
				$content = $actionHandler->completeAction($action, $user);
				return true;
			}
		}

		return false;
	}

	/**
	 * Completes the action associated with this user, if there is one, assuming the user is in a state where it's
	 * possible. By default, this only applies when the user is in a valid state and the system is enabled.
	 *
	 * @param \XF\Entity\User $user
	 * @param \XF\Mvc\Entity\Entity|null $content Reference to created content (or null if not created)
	 *
	 * @return bool
	 */
	public function completeUserActionIfPossible(\XF\Entity\User $user, &$content = null): bool
	{
		if (empty($this->options()->preRegAction['enabled']))
		{
			// this empty check is mostly for upgrades, as this can be called in places where this isn't created yet
			return false;
		}

		if ($user->user_state !== 'valid')
		{
			return false;
		}

		return $this->completeUserAction($user, $content);
	}

	public function getActionHandler(string $type)
	{
		$class = \XF::stringToClass($type, '%s\PreRegAction\%s');
		if (!class_exists($class))
		{
			return null;
		}

		$class = \XF::extendClass($class);
		return new $class($type);
	}

	public function pruneActions(int $cutOff = null)
	{
		if ($cutOff === null)
		{
			$cutOff = \XF::$time - 86400 * 21;
		}

		return $this->db()->delete('xf_pre_reg_action', 'last_update < ?', $cutOff);
	}
}