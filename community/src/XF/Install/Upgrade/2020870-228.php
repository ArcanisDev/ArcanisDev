<?php

namespace XF\Install\Upgrade;

use XF\Db\Schema\Alter;

class Version2020870 extends AbstractUpgrade
{
	public function getVersionName()
	{
		return '2.2.8';
	}

	public function step1()
	{
		$this->alterTable('xf_image_proxy', function (Alter $table)
		{
			$table->addColumn('file_hash', 'varchar', 32)->setDefault('')->after('file_name');
		});
	}

	public function step2()
	{
		$this->alterTable('xf_upgrade_check', function (Alter $table)
		{
			$table->addColumn('last_agreement_date', 'int')->nullable()->after('license_expired');
			$table->addColumn('last_agreement_update', 'int')->nullable()->after('last_agreement_date');
		});
	}
}