<?php

namespace XF\Authentication;

use function is_string;

class MyBb extends AbstractAuth
{
	protected function createHash($password, $salt)
	{
		return md5(md5($salt) . md5($password));
	}

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

		$userHash = $this->createHash($password, $this->data['salt']);
		return hash_equals($this->data['hash'], $userHash);
	}

	public function getAuthenticationName()
	{
		return 'XF:MyBb';
	}
}