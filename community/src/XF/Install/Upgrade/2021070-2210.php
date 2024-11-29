<?php

namespace XF\Install\Upgrade;

use XF\Db\Schema\Alter;

class Version2021070 extends AbstractUpgrade
{
	public function getVersionName()
	{
		return '2.2.10';
	}

	public function step1()
	{
		$this->alterTable('xf_user_upgrade_active', function (Alter $table)
		{
			$table->addKey('purchase_request_key');
		});

		$this->alterTable('xf_user_upgrade_expired', function (Alter $table)
		{
			$table->addKey('start_date');
			$table->addKey('purchase_request_key');
		});
	}
}