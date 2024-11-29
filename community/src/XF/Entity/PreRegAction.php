<?php

namespace XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int|null $action_id
 * @property string|null $guest_key
 * @property int|null $user_id
 * @property int $content_id
 * @property string $ip_address
 * @property int $last_update
 * @property string $action_class
 * @property array $action_data_
 *
 * GETTERS
 * @property \XF\PreRegAction\AbstractHandler|null $Handler
 * @property mixed $ContainerContent
 * @property array $action_data
 *
 * RELATIONS
 * @property \XF\Entity\User $User
 */
class PreRegAction extends Entity
{
	/**
	 * Returns true if this relates to a newly-registered user. This currently based on
	 * recency of the registration date.
	 *
	 * @return bool
	 */
	public function isForNewUser(): bool
	{
		if (!$this->User)
		{
			return false;
		}

		return $this->User->register_date > \XF::$time - 3 * 86400;
	}

	public function getContainerContent()
	{
		$handler = $this->Handler;
		return $handler ? $handler->getContainerContent($this->content_id) : null;
	}

	/**
	 * @return \XF\PreRegAction\AbstractHandler|null
	 */
	public function getHandler()
	{
		return $this->getPreRegActionRepo()->getActionHandler($this->action_class);
	}

	/**
	 * @return array
	 */
	public function getActionData()
	{
		$data = $this->getValue('action_data');
		$handler = $this->Handler;

		return $handler ? array_replace($handler->getDefaultActionData(), $data) : $data;
	}

	protected function _preSave()
	{
		if ($this->isUpdate() && $this->hasChanges())
		{
			$this->last_update = \XF::$time;
		}

		if ($this->isInsert() && $this->user_id === null && !$this->guest_key)
		{
			$this->guest_key = \XF::generateRandomString(16);
		}

		if ($this->guest_key !== null && $this->user_id !== null)
		{
			// this is a developer error
			throw new \LogicException("Only one of guest_key and user_id may be specified");
		}

		if ($this->isChanged('action_class') && !$this->getHandler())
		{
			// also a developer error
			throw new \LogicException("Invalid pre-reg action class: " . $this->action_class);
		}
	}

	public static function getStructure(Structure $structure)
	{
		$structure->table = 'xf_pre_reg_action';
		$structure->shortName = 'XF:PreRegAction';
		$structure->primaryKey = 'action_id';
		$structure->columns = [
			'action_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true],
			'guest_key' => ['type' => self::STR, 'maxLength' => 75, 'nullable' => true],
			'user_id' => ['type' => self::UINT, 'nullable' => true],
			'content_id' => ['type' => self::UINT, 'required' => true],
			'ip_address' => ['type' => self::BINARY, 'maxLength' => 16, 'default' => ''],
			'last_update' => ['type' => self::UINT, 'default' => \XF::$time],
			'action_class' => ['type' => self::STR, 'maxLength' => 100, 'required' => true],
			'action_data' => ['type' => self::JSON_ARRAY, 'default' => []]
		];
		$structure->getters = [
			'Handler' => true,
			'ContainerContent' => true,
			'action_data' => true
		];
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

	/**
	 * @return \XF\Repository\PreRegAction
	 */
	protected function getPreRegActionRepo()
	{
		return $this->repository('XF:PreRegAction');
	}
}