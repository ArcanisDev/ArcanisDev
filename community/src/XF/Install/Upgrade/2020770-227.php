<?php

namespace XF\Install\Upgrade;

use XF\Db\Schema\Alter;

class Version2020770 extends AbstractUpgrade
{
	public function getVersionName()
	{
		return '2.2.7';
	}

	public function step1()
	{
		$db = $this->db();

		$registrationDefaults = $db->fetchOne('
			SELECT option_value
			FROM xf_option
			WHERE option_id = \'registrationDefaults\'
		');

		$registrationDefaults = json_decode($registrationDefaults, true);
		$registrationDefaults['push_on_conversation'] = true;

		$this->executeUpgradeQuery('
			UPDATE xf_option
			SET option_value = ?
			WHERE option_id = \'registrationDefaults\'
		', json_encode($registrationDefaults));
	}

	public function step2()
	{
		$this->alterTable('xf_attachment', function (Alter $table)
		{
			$table->addKey('attach_date');
		});

		$this->alterTable('xf_attachment_data', function (Alter $table)
		{
			$table->addKey('file_size');
		});
	}
}