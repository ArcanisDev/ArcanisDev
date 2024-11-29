<?php

namespace XF\Authentication;

use function is_string;

class PhpBb3 extends AbstractAuth
{
	public function generate($password)
	{
		throw new \LogicException('Cannot generate authentication for this type.');
	}

	public function authenticate($userId, $password)
	{
		if (!is_string($password) || $password === '' || empty($this->data))
		{
			return false;
		}

		$password = str_replace(["\r\n", "\r", "\0"], ["\n", "\n", ''], $password);
		$password = htmlspecialchars($password, ENT_COMPAT, 'UTF-8');

		if (!\Normalizer::isNormalized($password))
		{
			$password = \Normalizer::normalize($password);
		}

		$passwordHash = new PasswordHash(8, true);

		if ($this->isLegacyHash())
		{
			return $passwordHash->CheckPassword($password, $this->data['hash']);
		}
		else
		{
			return password_verify($password, $this->data['hash']);
		}
	}

	public function getAuthenticationName()
	{
		return 'XF:PhpBb3';
	}
}