<?php

namespace XF\Option;

class EmailDkim extends AbstractOption
{
	protected static function canUseEmailDkim(&$error = null): bool
	{
		if (!extension_loaded('openssl'))
		{
			$error = \XF::phrase('required_php_extension_x_not_found', [
				'extension' => 'openssl'
			]);
			return false;
		}

		return true;
	}

	public static function renderOption(\XF\Entity\Option $option, array $htmlParams): string
	{
		$canUseEmailDkim = self::canUseEmailDkim($error);

		return self::getTemplate('admin:option_template_emailDkim', $option, $htmlParams, [
			'canUseEmailDkim' => $canUseEmailDkim,
			'error' => $error
		]);
	}
}