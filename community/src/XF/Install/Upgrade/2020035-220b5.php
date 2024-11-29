<?php

namespace XF\Install\Upgrade;

use XF\Db\Schema\Alter;

class Version2020035 extends AbstractUpgrade
{
	public function getVersionName()
	{
		return '2.2.0 Beta 5';
	}

	public function step1()
	{
		// duplication of 2020010 (step 3) to pick up users who may still have the old schema

		$this->alterTable('xf_option', function (Alter $table)
		{
			$table->changeColumn('advanced')->setDefault(0);
		});

		$this->alterTable('xf_option_group', function (Alter $table)
		{
			$table->changeColumn('advanced')->setDefault(0);
		});
	}
}