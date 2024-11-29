<?php

namespace XF\Job;

class Gravatar extends AbstractRebuildJob
{
	protected $defaultData = [
		'posters_only' => false,
		'import_table_name' => ''
	];

	protected function setupData(array $data)
	{
		if (!$this->app->options()->gravatarEnable)
		{
			throw new \XF\PrintableException(\XF::phrase('gravatar_support_is_disabled'));
		}

		$db = $this->app->db();

		if (empty($data['import_table']))
		{
			unset($data['import_table_name']);
		}
		else if (!empty($data['import_table_name']))
		{
			$importTableName = $data['import_table_name'];
			if (!$importTable = $db->fetchOne("SHOW TABLES LIKE {$db->quote($importTableName)}"))
			{
				throw new \XF\PrintableException(\XF::phrase('database_does_not_contain_table_called_x', ['name' => $importTableName]));
			}
		}

		return parent::setupData($data);
	}

	protected function getNextIds($start, $batch)
	{
		$db = $this->app->db();

		$importJoin = '';
		if (!empty($this->data['import_table_name']))
		{
			$importJoin = "INNER JOIN {$this->data['import_table_name']} AS iTable ON (iTable.content_type = 'user' AND iTable.new_id = xf_user.user_id)";
		}

		$postersCondition = $this->data['posters_only'] ? 'AND xf_user.message_count > 0' : '';

		return $db->fetchAllColumn($db->limit(
			"
				SELECT xf_user.user_id
				FROM xf_user
				{$importJoin}
				WHERE xf_user.user_id > ?
				AND xf_user.avatar_date = 0 AND xf_user.gravatar = ''
				{$postersCondition}
				ORDER BY xf_user.user_id
			", $batch
		), $start);
	}

	protected function rebuildById($id)
	{
		/** @var \XF\Entity\User $user */
		$user = $this->app->finder('XF:User')->where('user_id', $id)->fetchOne();

		$gravatarValidator = $this->app->validator('Gravatar');
		$gravatar = $gravatarValidator->coerceValue($user->email);
		if ($this->app->validator('Gravatar')->isValid($gravatar))
		{
			/** @var \XF\Service\User\Avatar $avatarService */
			$avatarService = $this->app->service('XF:User\Avatar', $user);
			$avatarService->setGravatar($gravatar);
		}
	}

	protected function getStatusType()
	{
		return \XF::phrase('gravatar');
	}
}