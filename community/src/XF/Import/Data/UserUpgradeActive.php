<?php

namespace XF\Import\Data;

class UserUpgradeActive extends AbstractEmulatedData
{
	protected $userGroupIds;

	public function getImportType()
	{
		return 'user_upgrade_active';
	}

	public function getEntityShortName()
	{
		return 'XF:UserUpgradeActive';
	}

	public function setUserGroupIds($userGroupIds)
	{
		$this->userGroupIds = $userGroupIds;
	}

	protected function postSave($oldId, $newId)
	{
		if ($this->userGroupIds)
		{
			$this->db()->insert('xf_user_group_change', [
				'user_id' => $this->user_id,
				'change_key' => "userUpgrade-{$this->user_upgrade_id}",
				'group_ids' => $this->userGroupIds
			], null, 'group_ids = VALUES(group_ids)');
		}
	}
}