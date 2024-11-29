<?php

namespace XF\Install\Upgrade;

use XF\CookieConsent;
use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;

class Version2021270 extends AbstractUpgrade
{
	public function getVersionName()
	{
		return '2.2.12';
	}

	public function step1()
	{
		$showFirstCookieNotice = json_decode(
			$this->db()->fetchOne(
				"SELECT option_value
					FROM xf_option
					WHERE option_id = 'showFirstCookieNotice'"
			),
			true
		);

		$optionValue = [
			'type' => $showFirstCookieNotice === 1 ? CookieConsent::MODE_SIMPLE : 'disabled'
		];
		$defaultValue = [
			'type' => 'disabled'
		];

		$this->executeUpgradeQuery(
			'INSERT IGNORE INTO xf_option
				(option_id, option_value, default_value, edit_format, edit_format_params, data_type, sub_options, validation_class, validation_method, advanced, addon_id)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
			[
				'cookieConsent',
				json_encode($optionValue),
				json_encode($defaultValue),
				'template',
				'option_template_cookieConsent',
				'array',
				'type',
				'',
				'',
				0,
				'XF'
			]
		);
	}

	public function step2()
	{
		$this->alterTable('xf_bb_code_media_site', function (Alter $table)
		{
			$table->addColumn('cookie_third_parties', 'varchar', 250)->setDefault('');
		});
	}

	public function step3()
	{
		$this->createTable('xf_cookie_consent_log', function(Create $table)
		{
			$table->addColumn('cookie_consent_log_id', 'int')->autoIncrement();
			$table->addColumn('log_date', 'int');
			$table->addColumn('user_id', 'int');
			$table->addColumn('ip_address', 'varbinary', 16)->setDefault('');
			$table->addColumn('consented_groups', 'blob');
			$table->addKey('log_date');
			$table->addKey(['user_id', 'log_date']);
			$table->addKey(['ip_address', 'log_date']);
		});
	}
}