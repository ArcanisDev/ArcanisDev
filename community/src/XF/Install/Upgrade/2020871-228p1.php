<?php

namespace XF\Install\Upgrade;

class Version2020871 extends AbstractUpgrade
{
	public function getVersionName()
	{
		return '2.2.8 Patch 1';
	}

	public function step1()
	{
		$upgradeDate = $this->db()->fetchOne(
			"SELECT completion_date
				FROM xf_upgrade_log
				WHERE version_id = ?",
			'2020870'
		);

		if ($upgradeDate)
		{
			$this->executeUpgradeQuery(
				"UPDATE xf_image_proxy
					SET pruned = 1,
						file_hash = ''
					WHERE fetch_date > ?",
				$upgradeDate
			);
		}
	}
}