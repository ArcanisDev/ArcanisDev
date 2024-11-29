<?php

namespace XF\Install\Upgrade;

use XF\Db\Schema\Alter;
use XF\Util\Url;

class Version2021370 extends AbstractUpgrade
{
	public function getVersionName()
	{
		return '2.2.13';
	}

	public function step1()
	{
		$this->alterTable('xf_ip', function (Alter $table)
		{
			$table->addKey(['user_id', 'ip', ['log_date', 'descending' => true]]);
		});
	}

	public function step2()
	{
		$this->alterTable('xf_user_push_subscription', function (Alter $table)
		{
			$table->addColumn('error_count', 'int')->setDefault(0);
		});
	}

	public function step3(int $position, array $stepData)
	{
		if (!isset($stepData['max']))
		{
			$stepData['max'] = $this->db()->fetchOne(
				'SELECT MAX(user_id)
					FROM xf_user
					WHERE LENGTH(email) > CHAR_LENGTH(email)'
			);
		}

		$users = $this->db()->fetchAllKeyed(
			$this->db()->limit(
				'SELECT *
					FROM xf_user
					WHERE user_id > ?
						AND LENGTH(email) > CHAR_LENGTH(email)
					ORDER BY user_id',
				500
			),
			'user_id',
			[$position]
		);
		if (!$users)
		{
			return true;
		}

		$next = 0;

		foreach ($users AS $id => $user)
		{
			$next = $id;

			$email = $user['email'];
			$newEmail = Url::emailToAscii($email, false);
			if ($newEmail === $email)
			{
				continue;
			}

			if (!preg_match('/(.+)@(.+)$/i', $newEmail, $matches))
			{
				continue;
			}

			$local = $matches[1];
			$domain = $matches[2];
			$i = 0;

			do
			{
				if ($i > 0)
				{
					$newEmail = $local . '+' . $i . '@' . $domain;
				}
				else
				{
					$newEmail = $local . '@' . $domain;
				}

				$matchByEmail = $this->db()->fetchOne(
					'SELECT user_id
						FROM xf_user
						WHERE email = ?',
					[$newEmail]
				);

				$i++;
			}
			while ($matchByEmail);

			if ($user['user_state'] === 'valid')
			{
				$this->db()->update(
					'xf_user',
					[
						'email' => $newEmail,
						'user_state' => 'email_confirm_edit'
					],
					'user_id = ?',
					[$id]
				);
			}
			else
			{
				$this->db()->update(
					'xf_user',
					['email' => $newEmail],
					'user_id = ?',
					[$id]
				);
			}
		}

		return [$next, "{$next} / {$stepData['max']}", $stepData];
	}
}