<?php

namespace XF\Option;

use XF\Entity\Option;

class StopForumSpam extends AbstractOption
{
	public static function verifyOption(&$value, Option $option)
	{
		if ($option->isUpdate() && !empty($value['submitRejections']))
		{
			if (empty($value['apiKey']))
			{
				$option->error(\XF::phrase('please_enter_value_for_required_field_x', ['field' => 'stopForumSpam[apiKey]']), $option->option_id);
				return false;
			}

			if (!preg_match('/^[a-zA-Z0-9]+$/', $value['apiKey']))
			{
				$option->error(\XF::phrase('please_enter_a_valid_api_key'), $option->option_id);
				return false;
			}
		}

		return true;
	}
}