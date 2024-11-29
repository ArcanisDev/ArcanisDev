<?php

namespace XF\Authentication;

class vBulletin5 extends AbstractAuth
{
	public function getAuthenticationName()
	{
		return 'XF:vBulletin5';
	}

	public function generate($password)
	{
		throw new \LogicException('Cannot generate authentication for this type.');
	}

	protected function createHash($password)
	{
		return md5($password);
	}

	public function authenticate($userId, $password)
	{
		if (!is_string($password) || $password === '' || empty($this->data))
		{
			return false;
		}

		$userHash = $this->createHash($password);
		return password_verify($userHash, $this->data['token']);
	}
}