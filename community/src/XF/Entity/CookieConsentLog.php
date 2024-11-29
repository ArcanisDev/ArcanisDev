<?php

namespace XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int|null $cookie_consent_log_id
 * @property int $log_date
 * @property int $user_id
 * @property string $ip_address
 * @property array $consented_groups
 *
 * RELATIONS
 * @property \XF\Entity\User $User
 */
class CookieConsentLog extends Entity
{
	public static function getStructure(Structure $structure): Structure
	{
		$structure->table = 'xf_cookie_consent_log';
		$structure->shortName = 'XF:CookieConsentLog';
		$structure->primaryKey = 'cookie_consent_log_id';
		$structure->columns = [
			'cookie_consent_log_id' => [
				'type' => self::UINT,
				'autoIncrement' => true,
				'nullable' => true,
			],
			'log_date' => [
				'type' => self::UINT,
				'default' => \XF::$time
			],
			'user_id' => [
				'type' => self::UINT,
				'required' => true
			],
			'ip_address' => [
				'type' => self::BINARY,
				'maxLength' => 16,
				'default' => ''
			],
			'consented_groups' => [
				'type' => self::JSON_ARRAY,
				'default' => []
			]
		];
		$structure->getters = [];
		$structure->relations = [
			'User' => [
				'entity' => 'XF:User',
				'type' => self::TO_ONE,
				'conditions' => 'user_id',
				'primary' => true
			]
		];

		return $structure;
	}
}
