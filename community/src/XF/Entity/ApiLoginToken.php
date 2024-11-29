<?php

namespace XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int|null $login_token_id
 * @property string $login_token
 * @property int $user_id
 * @property int $expiry_date
 * @property string|null $limit_ip
 *
 * RELATIONS
 * @property \XF\Entity\User $User
 */
class ApiLoginToken extends Entity
{
	public function isValid(string $requestIp = null): bool
	{
		if ($this->expiry_date < \XF::$time)
		{
			return false;
		}

		if (!$this->User)
		{
			return false;
		}

		if ($requestIp && $this->limit_ip)
		{
			$requestIp = \XF\Util\Ip::convertIpStringToBinary($requestIp);
			if ($requestIp !== $this->limit_ip)
			{
				return false;
			}
		}

		return true;
	}

	protected function verifyLimitIp(&$ip): bool
	{
		$ip = \XF\Util\Ip::convertIpStringToBinary($ip);
		if ($ip === false)
		{
			$this->error(\XF::phrase('provided_limit_ip_does_not_appear_to_be_valid_ip_address'));
			return false;
		}

		return true;
	}

	public function generateTokenValue(): string
	{
		return \XF::generateRandomString(32);
	}

	protected function _preSave()
	{
		if ($this->isInsert())
		{
			$this->login_token = $this->generateTokenValue();

			if (!$this->expiry_date)
			{
				$this->expiry_date = \XF::$time + 10 * 60;
			}
		}
	}

	public static function getStructure(Structure $structure)
	{
		$structure->table = 'xf_api_login_token';
		$structure->shortName = 'XF:ApiLoginToken';
		$structure->primaryKey = 'login_token_id';
		$structure->columns = [
			'login_token_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true],
			'login_token' => ['type' => self::STR, 'required' => true, 'maxlength' => 32],
			'user_id' => ['type' => self::UINT, 'required' => true],
			'expiry_date' => ['type' => self::UINT, 'required' => true],
			'limit_ip' => ['type' => self::BINARY, 'maxLength' => 16, 'nullable' => true],
		];
		$structure->behaviors = [];
		$structure->getters = [];
		$structure->relations = [
			'User' => [
				'entity' => 'XF:User',
				'type' => self::TO_ONE,
				'conditions' => 'user_id',
				'primary' => true
			]
		];
		$structure->options = [];

		return $structure;
	}
}