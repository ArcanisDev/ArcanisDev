<?php

namespace XF\Install\Upgrade;

use XF\Db\Schema\Alter;

class Version2020670 extends AbstractUpgrade
{
	public function getVersionName()
	{
		return '2.2.6';
	}

	public function step1()
	{
		$this->alterTable('xf_upgrade_check', function(Alter $alter)
		{
			$alter->addColumn('response_data', 'mediumblob')->nullable();
		});
	}
}