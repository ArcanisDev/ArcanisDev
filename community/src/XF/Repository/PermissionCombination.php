<?php

namespace XF\Repository;

use XF\Mvc\Entity\Repository;

use function intval;

class PermissionCombination extends Repository
{
	protected $combinationMapCache = [];

	/**
	 * @param \XF\Entity\User $user
	 * @param bool|null $hasUserPermissions
	 *
	 * @return \XF\Entity\PermissionCombination
	 */
	public function getPermissionCombinationForUser(\XF\Entity\User $user, $hasUserPermissions = null)
	{
		if ($hasUserPermissions === null)
		{
			$hasUserPermissions = $this->hasUserSpecificPermissions($user->user_id);
		}

		$userId = $hasUserPermissions ? intval($user->user_id) : 0;

		$groups = $user->secondary_group_ids;
		$groups[] = $user->user_group_id;

		$groups = array_unique($groups);
		sort($groups, SORT_NUMERIC);

		$cacheId = "$userId-" . implode(',', $groups);

		if (isset($this->combinationMapCache[$cacheId]))
		{
			return $this->combinationMapCache[$cacheId];
		}

		$combination = $this->getPermissionCombinationOrPlaceholder($groups, $userId);

		$this->combinationMapCache[$cacheId] = $combination;

		return $combination;
	}

	/**
	 * Gets a permission combination for a specific group ID-user ID set. If one does not exist,
	 * an entity will be setup for a new combination. This entity will not be automatically saved!
	 *
	 * @param array $groupIds
	 * @param int $userId
	 *
	 * @return \XF\Entity\PermissionCombination
	 */
	public function getPermissionCombinationOrPlaceholder(array $groupIds, int $userId = 0)
	{
		$groupIds = array_unique($groupIds);
		sort($groupIds, SORT_NUMERIC);

		$combination = $this->finder('XF:PermissionCombination')
			->where('user_id', $userId)
			->where('user_group_list', implode(',', $groupIds))
			->fetchOne();

		if (!$combination)
		{
			$combination = $this->em->create('XF:PermissionCombination');
			$combination->user_id = $userId;
			$combination->user_group_list = $groupIds;
		}

		return $combination;
	}

	public function updatePermissionCombinationForUser(\XF\Entity\User $user, $buildOnCreate = true)
	{
		$combination = $this->getPermissionCombinationForUser($user);
		if (!$combination->exists())
		{
			$combination->setOption('rebuild_permission_cache', $buildOnCreate);
			$combination->save();
		}

		if ($combination->permission_combination_id != $user->permission_combination_id)
		{
			$user->fastUpdate('permission_combination_id', $combination->permission_combination_id);
		}

		return $combination;
	}

	public function hasUserSpecificPermissions($userId)
	{
		if (!$userId)
		{
			return false;
		}

		return (bool)$this->db()->fetchOne("
			(SELECT 1 FROM xf_permission_entry WHERE user_group_id = 0 AND user_id = ? LIMIT 1)
			UNION ALL
			(SELECT 1 FROM xf_permission_entry_content WHERE user_group_id = 0 AND user_id = ? LIMIT 1)
		", [$userId, $userId]);
	}

	public function getPermissionCombinationsForUserGroup($userGroupId)
	{
		$groupCombinations = $this->finder('XF:PermissionCombinationUserGroup')
			->where('user_group_id', $userGroupId)
			->with('PermissionCombination', true)
			->fetch();

		return $groupCombinations->pluck(function($groupCombination)
		{
			return [$groupCombination->permission_combination_id, $groupCombination->PermissionCombination];
		});
	}

	public function deleteUnusedPermissionCombinations()
	{
		$db = $this->db();

		$preRegActionCondition = '';
		if ($preRegCombination = \XF::options()->preRegAction['permissionCombinationId'])
		{
			$preRegActionCondition = "AND p.permission_combination_id <> " . $db->quote($preRegCombination);
		}

		$combinationIds = $db->fetchAllColumn("
			SELECT p.permission_combination_id
			FROM xf_permission_combination AS p
			LEFT JOIN (SELECT DISTINCT u.permission_combination_id FROM xf_user AS u) AS up
				ON (p.permission_combination_id = up.permission_combination_id)
			WHERE up.permission_combination_id IS NULL
				AND p.user_group_list <> '1'
				AND p.permission_combination_id <> 1
				{$preRegActionCondition}
		");
		if ($combinationIds)
		{
			$combinationCondition = 'permission_combination_id IN (' . $db->quote($combinationIds) . ')';

			$db->delete('xf_permission_combination', $combinationCondition);
			$db->delete('xf_permission_combination_user_group', $combinationCondition);
			$db->delete('xf_permission_cache_content', $combinationCondition);
		}

		return $combinationIds;
	}

	public function insertGuestCombinationIfMissing()
	{
		$db = $this->db();

		$guestCombination = $db->fetchRow('SELECT * FROM xf_permission_combination WHERE permission_combination_id = 1');

		if (!$guestCombination)
		{
			$db->insert('xf_permission_combination', [
				'permission_combination_id' => 1,
				'user_id' => 0,
				'user_group_list' => '1',
				'cache_value' => ''
			]);

			$db->insert('xf_permission_combination_user_group', [
				'user_group_id' => 1,
				'permission_combination_id' => 1
			], true);

			return true;
		}
		else
		{
			return false;
		}
	}
}