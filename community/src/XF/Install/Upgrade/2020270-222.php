<?php

namespace XF\Install\Upgrade;

class Version2020270 extends AbstractUpgrade
{
	public function getVersionName()
	{
		return '2.2.2';
	}

	public function step1()
	{
		// We no longer grant this permission to the unconfirmed group automatically in upgrades,
		// so remove it and require it to be explicitly added. It's unlikely to be desirable in most
		// cases, so better to just remove. See XF-187415 for more details.
		$this->executeUpgradeQuery("
			DELETE FROM xf_permission_entry
			WHERE user_group_id = 1
				AND user_id = 0
				AND permission_group_id = 'general'
				AND permission_id = 'changeUsername'
		");
	}
}