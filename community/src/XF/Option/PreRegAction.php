<?php

namespace XF\Option;

use function array_key_exists, is_array;

class PreRegAction extends AbstractOption
{
	public static function renderOption(\XF\Entity\Option $option, array $htmlParams)
	{
		/** @var \XF\Repository\UserGroup $userGroupRepo */
		$userGroupRepo = \XF::repository('XF:UserGroup');

		$userGroups = $userGroupRepo->getUserGroupOptionsData(false, 'option');

		return self::getTemplate('admin:option_template_preRegAction', $option, $htmlParams, [
			'userGroups' => $userGroups,
		]);
	}

	public static function verifyOption(array &$value, \XF\Entity\Option $option)
	{
		if (!array_key_exists('enabled', $value))
		{
			return true;
		}

		if (!array_key_exists('userGroups', $value) || !is_array($value['userGroups']))
		{
			$option->error(\XF::phrase('you_must_select_at_least_one_group_check_permissions_against'), $option->option_id);
			return false;
		}

		sort($value['userGroups'], SORT_NUMERIC);

		/** @var \XF\Repository\PermissionCombination $permComboRepo */
		$permComboRepo = \XF::app()->repository('XF:PermissionCombination');
		$combination = $permComboRepo->getPermissionCombinationOrPlaceholder($value['userGroups']);
		if (!$combination->exists())
		{
			$combination->save();
		}

		$value['permissionCombinationId'] = $combination->permission_combination_id;

		return true;
	}
}