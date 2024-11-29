<?php

namespace XF\Admin\View\User;

use XF\Entity\User;
use XF\Mvc\Entity\ArrayCollection;
use XF\Mvc\View;

use function in_array;

class ExportListing extends View
{
	public function renderRaw()
	{
		$this->response
			->contentType('text/csv', 'utf-8')
			->setDownloadFileName($this->getCsvFileName());

		$fp = fopen('php://memory', 'r+');

		$fields = $this->getUserDataFieldsForExport();
		fputcsv($fp, array_merge(array_keys($fields), $this->getUserGroupHeadings($this->params['user_groups'])));

		/** @var User $user */
		foreach ($this->params['users'] AS $user)
		{
			$userData = $this->getUserDataForExport($user, $fields, $this->params['user_groups']);

			fputcsv($fp, $userData);
		}

		rewind($fp);
		$csv = stream_get_contents($fp);
		fclose($fp);

		return $csv;
	}

	/**
	 * Extend this method to change the exported fields.
	 *
	 * Format is [field_name] => [option] where [option] can be either true to export the raw field value from the User entity
	 * or a callback to return formatted or manipulated data
	 *
	 * @return array
	 */
	protected function getUserDataFieldsForExport()
	{
		return [
			'email' => true,
			'username' => true,
			'last_activity' => function(User $user)
			{
				return gmdate('Y-m-d', $user->last_activity);
			},
			'register_date' => function(User $user)
			{
				return gmdate('Y-m-d', $user->register_date);
			},
			'user_state' => true,
			'message_count' => true,
			'receive_admin_email' => function(User $user)
			{
				return $user->Option->receive_admin_email;
			},
			'is_banned' => true,
			'is_staff' => true,
			'user_group_id' => true,
		];
	}

	protected function getUserDataForExport(User $user, array $fields, ArrayCollection $userGroups)
	{
		$output = [];

		foreach ($fields AS $fieldName => $action)
		{
			if (is_callable($action))
			{
				$output[] = $action($user);
			}
			else
			{
				$output[] = $user->$fieldName;
			}
		}

		foreach ($userGroups AS $userGroupId => $title)
		{
			$output[] = in_array($userGroupId, $user->secondary_group_ids) ? 1 : '';
		}

		return $output;
	}

	protected function getUserGroupHeadings(ArrayCollection $userGroups)
	{
		$output = [];

		foreach ($userGroups AS $userGroupId => $userGroup)
		{
			$output[] = sprintf('[%d] %s', $userGroupId, $userGroup->title);
		}

		return $output;
	}

	protected function getCsvFileName()
	{
		return sprintf("XenForo Users %s.csv", gmdate('Y-m-d', \XF::$time));
	}
}