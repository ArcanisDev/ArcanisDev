<?php

namespace XF\Authentication;

use function is_string;

class Discourse extends AbstractAuth
{
	protected function createHash($password, $algo, $salt, $iterations)
	{
		return hash_pbkdf2($algo, $password, $salt, $iterations);
	}

	public function authenticate($userId, $password)
	{
		if (!is_string($password)
			|| $password === ''
			|| empty($this->data['hash'])
			|| empty($this->data['algo'])
			|| empty($this->data['salt'])
			|| empty($this->data['iterations'])
		)
		{
			return false;
		}

		$userHash = $this->createHash(
			$password,
			$this->data['algo'],
			$this->data['salt'],
			$this->data['iterations']
		);

		return hash_equals($this->data['hash'], $userHash);
	}

	public function generate($password)
	{
		throw new \LogicException('Cannot generate authentication for this type.');
	}

	public function getAuthenticationName()
	{
		return 'XF:Discourse';
	}
}