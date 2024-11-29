<?php

namespace XF\Install\Upgrade;

use XF\Db\Schema\Alter;

class Version2020370 extends AbstractUpgrade
{
	public function getVersionName()
	{
		return '2.2.3';
	}

	public function step1()
	{
		$this->alterTable('xf_thread', function (Alter $table)
		{
			$table->changeColumn('discussion_type', null, 50);
		});
	}
}