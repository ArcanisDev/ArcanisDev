<?php

namespace XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int|null $change_id
 * @property int $user_id
 * @property string $old_username
 * @property string $new_username
 * @property string $change_reason
 * @property string $change_state
 * @property int $change_user_id
 * @property int $change_date
 * @property int $moderator_user_id
 * @property string $reject_reason
 * @property bool $visible
 *
 * RELATIONS
 * @property \XF\Entity\User $User
 * @property \XF\Entity\User $ChangeUser
 * @property \XF\Entity\User $Moderator
 * @property \XF\Entity\ApprovalQueue $ApprovalQueue
 */
class UsernameChange extends Entity
{
	protected function verifyNewUsername(&$username): bool
	{
		/** @var \XF\Validator\Username $validator */
		$validator = $this->app()->validator('Username');

		$username = $validator->coerceValue($username);

		$visitor = \XF::visitor();
		if ($this->user_id && $visitor->user_id == $this->user_id)
		{
			$validator->setOption('self_user_id', $this->user_id);
		}
		if ($this->getOption('admin_edit'))
		{
			$validator->setOption('admin_edit', true);
		}

		if (!$validator->isValid($username, $errorKey))
		{
			$this->error($validator->getPrintableErrorValue($errorKey), 'new_username');
			return false;
		}

		return true;
	}

	protected function _preSave()
	{
		if ($this->isInsert() && $this->old_username === $this->new_username)
		{
			$this->error(\XF::phrase('please_enter_new_username_that_differs_from_current_username'), 'new_username');
		}
	}

	protected function _postSave()
	{
		$approvalChange = $this->isStateChanged('change_state', 'moderated');

		if ($this->isUpdate())
		{
			if ($approvalChange == 'leave' && $this->ApprovalQueue)
			{
				$this->ApprovalQueue->delete();
			}
		}

		if ($approvalChange == 'enter')
		{
			// remove/reject any other pending changes
			$this->getUsernameChangeRepo()->clearPendingUsernameChanges($this->User, $this);

			$approvalQueue = $this->getRelationOrDefault('ApprovalQueue', false);
			$approvalQueue->content_date = $this->change_date;
			$approvalQueue->save();
		}

		if ($this->isInsert())
		{
			$updateLastVisibleChange = ($this->change_state == 'approved' && $this->visible);
		}
		else if ($this->visible || $this->isChanged('visible'))
		{
			$updateLastVisibleChange = (
				$this->isStateChanged('change_state', 'approved')
				|| ($this->change_state == 'approved' && $this->isChanged('visible'))
			);
		}
		else
		{
			$updateLastVisibleChange = false;
		}

		if ($updateLastVisibleChange)
		{
			$this->rebuildLastVisibleUsernameChange();
		}
	}

	protected function _postDelete()
	{
		if ($this->change_state == 'moderated' && $this->ApprovalQueue)
		{
			$this->ApprovalQueue->delete();
		}

		if ($this->visible)
		{
			$this->rebuildLastVisibleUsernameChange();
		}
	}

	public function rebuildLastVisibleUsernameChange()
	{
		\XF::runOnce('rebuildLastVisibleUsernameChange' . $this->user_id, function()
		{
			$user = $this->User;
			if ($user)
			{
				$this->getUsernameChangeRepo()->rebuildLastVisibleUsernameChange($user);
			}
		});
	}

	public static function getStructure(Structure $structure)
	{
		$structure->table = 'xf_username_change';
		$structure->shortName = 'XF:UsernameChange';
		$structure->contentType = 'username_change';
		$structure->primaryKey = 'change_id';
		$structure->columns = [
			'change_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true],
			'user_id' => ['type' => self::UINT, 'required' => true],
			'old_username' => ['type' => self::STR, 'maxLength' => 50, 'required' => true],
			'new_username' => ['type' => self::STR, 'maxLength' => 50, 'required' => true],
			'change_reason' => ['type' => self::STR, 'maxLength' => 200, 'default' => ''],
			'change_state' => ['type' => self::STR, 'required' => true,
				'allowedValues' => ['moderated', 'approved', 'rejected']
			],
			'change_user_id' => ['type' => self::UINT, 'required' => true],
			'change_date' => ['type' => self::UINT, 'default' => \XF::$time],
			'moderator_user_id' => ['type' => self::UINT, 'default' => 0],
			'reject_reason' => ['type' => self::STR, 'maxLength' => 200, 'default' => ''],
			'visible' => ['type' => self::BOOL, 'default' => true],
		];
		$structure->getters = [];
		$structure->relations = [
			'User' => [
				'entity' => 'XF:User',
				'type' => self::TO_ONE,
				'conditions' => 'user_id',
				'primary' => true
			],
			'ChangeUser' => [
				'entity' => 'XF:User',
				'type' => self::TO_ONE,
				'conditions' => [['user_id', '=', '$change_user_id']],
				'primary' => true
			],
			'Moderator' => [
				'entity' => 'XF:User',
				'type' => self::TO_ONE,
				'conditions' => [['user_id', '=', '$moderator_user_id']],
				'primary' => true
			],
			'ApprovalQueue' => [
				'entity' => 'XF:ApprovalQueue',
				'type' => self::TO_ONE,
				'conditions' => [
					['content_type', '=', 'username_change'],
					['content_id', '=', '$change_id']
				],
				'primary' => true
			]
		];
		$structure->options = [
			'admin_edit' => false
		];

		return $structure;
	}

	protected function getUsernameChangeRepo(): \XF\Repository\UsernameChange
	{
		return $this->repository('XF:UsernameChange');
	}
}
