<?php

namespace XF\Option;

use XF\Entity\Option;

class Email extends AbstractOption
{
	public static function verifyOption(string &$value, Option $option): bool
	{
		if ($option->isInsert())
		{
			// always allow a new value to be submitted so we don't blow up installation
			return true;
		}

		$emailValidator = \XF::app()->validator('Email');
		$emailValidator->setOptions([
			'allow_empty' => true,
			'allow_local' => true
		]);
		$value = $emailValidator->coerceValue($value);
		if (!$emailValidator->isValid($value, $errorKey))
		{
			$option->error(
				\XF::phrase('please_enter_valid_email'),
				$option->option_id
			);
			return false;
		}

		return true;
	}
}