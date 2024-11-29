<?php

namespace XF\Validator;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;
use XF\Util\Url;

class Email extends AbstractValidator
{
	protected $options = [
		'banned' => [],
		'allow_empty' => false,
		'allow_local' => false,
		'check_typos' => false
	];

	public function isValid($value, &$errorKey = null)
	{
		if ($value === '')
		{
			if ($this->options['allow_empty'])
			{
				return true;
			}

			$errorKey = 'empty';
			return false;
		}

		$validator = new EmailValidator();
		if (!$validator->isValid($value, new RFCValidation()))
		{
			$errorKey = 'invalid';
			return false;
		}

		list ($local, $domain) = explode('@', $value);

		if (preg_match('/[^\x00-\x7F]/', $local))
		{
			// Swiftmailer will error if it runs into this
			$errorKey = 'invalid';
			return false;
		}

		if (preg_match('/[^\x00-\x7F]/', $domain))
		{
			// IDNs should be ASCII encoded
			// we attempt this automatically when coercing a value
			$errorKey = 'invalid';
			return false;
		}

		if (!$this->options['allow_local'])
		{
			if (strpos($domain, '.') === false)
			{
				$errorKey = 'local';
				return false;
			}
		}

		if (preg_match('/["\'\s\\\\]/', $value))
		{
			// intentionally reject some odd (though technically valid) emails
			$errorKey = 'invalid';
			return false;
		}

		if ($this->options['banned'])
		{
			/** @var \XF\Repository\Banning $banRepo */
			$banRepo = $this->app->repository('XF:Banning');

			if ($banRepo->isEmailBanned($value, $this->options['banned']))
			{
				$errorKey = 'banned';
				return false;
			}
		}

		if ($this->options['check_typos'])
		{
			// This is a very basic function and is really just trying to catch simple typos.
			// Most significantly, gamil.com since this can trigger an SFS action unexpectedly.
			$matches = [
				'gamil.com',
				'gmial.com',
				'gmail.cmo',
				'gmail.co',
				'gmail.cm',
				'gnail.com',
				'gmai.com',
				'hotnail.com',
				'hotmail.cmo',
				'hotmail.co',
				'hotmail.cm',
				'yahooo.com',
				'yaho.com',
				'yahoo.co',
				'yahoo.cmo',
				'yahoo.cm'
			];

			$regex = implode('|', array_map('preg_quote', $matches));
			if (preg_match('/@(' . $regex . ')$/i', $value))
			{
				$errorKey = 'typo';
				return false;
			}
		}

		return true;
	}

	/**
	 * Attempt to coerce UTF8 IDNs into ASCII.
	 *
	 * @param string $value
	 *
	 * @return string
	 */
	public function coerceValue($value)
	{
		return Url::emailToAscii($value, false);
	}
}