<?php

namespace XF\Service\User;

use XF\Entity\User;
use XF\Service\ValidateAndSavableTrait;

class UsernameChange extends \XF\Service\AbstractService
{
    use ValidateAndSavableTrait;

	/**
	 * @var User
	 */
	protected $user;

	/**
	 * @var \XF\Entity\UsernameChange
	 */
	protected $usernameChange;

	protected $logIp = true;

	protected $isModeratorAction = false;

	protected $notify = false;

	public function __construct(\XF\App $app, $userOrChange)
	{
		parent::__construct($app);

		if ($userOrChange instanceof User)
		{
			$this->user = $userOrChange;
			$this->usernameChange = $this->setupNewUsernameChange($userOrChange);
		}
		else if ($userOrChange instanceof \XF\Entity\UsernameChange)
		{
			if ($userOrChange->change_state != 'moderated')
			{
				throw new \InvalidArgumentException("Can only action existing username changes when pending");
			}

			if (!$userOrChange->User)
			{
				throw new \InvalidArgumentException("Username change is missing User relation value");
			}

			$this->usernameChange = $userOrChange;
			$this->user = $userOrChange->User;
		}
		else
		{
			throw new \InvalidArgumentException("Must pass User or UsernameChange entity into service");
		}
	}

	protected function setupNewUsernameChange(\XF\Entity\User $user): \XF\Entity\UsernameChange
	{
		/** @var \XF\Entity\UsernameChange $usernameChange */
		$usernameChange = $this->em()->create('XF:UsernameChange');
		$usernameChange->user_id = $this->user->user_id;
		$usernameChange->old_username = $this->user->username;
		$usernameChange->change_user_id = \XF::visitor()->user_id;
		$usernameChange->change_state = $this->getDefaultChangeState();

		return $usernameChange;
	}

	protected function getDefaultChangeState(): string
	{
		$visitor = \XF::visitor();

		if ($visitor->hasPermission('general', 'approveUsernameChange')
			|| $visitor->hasPermission('general', 'changeUsernameNoApproval')
		)
		{
			return 'approved';
		}
		else
		{
			return 'moderated';
		}
	}

	public function getUser(): \XF\Entity\User
	{
		return $this->user;
	}

	public function getUsernameChange(): \XF\Entity\UsernameChange
	{
		return $this->usernameChange;
	}

	public function setAdminEdit()
	{
		$this->logIp(false);
		$this->usernameChange->setOption('admin_edit', true);
		$this->usernameChange->change_state = 'approved';
	}

	public function setModeratorRejection(bool $notify = false, string $reason = '')
	{
		$this->usernameChange->change_state = 'rejected';
		$this->usernameChange->moderator_user_id = \XF::visitor()->user_id;
		$this->usernameChange->reject_reason = $reason;

		$this->logIp(false);
		$this->isModeratorAction = true;
		$this->notify = $notify;
	}

	public function setModeratorApproval(bool $notify = false)
	{
		$this->usernameChange->change_state = 'approved';
		$this->usernameChange->moderator_user_id = \XF::visitor()->user_id;

		$this->logIp(false);
		$this->isModeratorAction = true;
		$this->notify = $notify;
	}

	public function setNewUsername(string $newUsername)
	{
		$this->usernameChange->new_username = $newUsername;
	}

	public function setChangeReason(string $reason)
	{
		$this->usernameChange->change_reason = $reason;
	}

	public function setVisibility(bool $visibility)
	{
		$this->usernameChange->visible = $visibility;
	}

	public function logIp($logIp)
	{
		$this->logIp = $logIp;
	}

	protected function finalSetup()
	{
	}

	protected function _validate()
	{
		$this->finalSetup();

		$this->usernameChange->preSave();
		return $this->usernameChange->getErrors();
	}

	protected function _save()
	{
		$user = $this->user;
		$usernameChange = $this->usernameChange;

		$isInsert = $usernameChange->isInsert();

		if ($usernameChange->change_state == 'approved')
		{
			// set the user to admin_edit as we have already validated most changes and we want to bypass things like
			// the pending name check
			$user->setOption('admin_edit', true);
			$user->username = $usernameChange->new_username;
			$user->setOption('admin_edit', false);

			// we already have that record here
			$user->setOption('insert_username_change_history', false);

			$usernameChange->addCascadedSave($user);
		}

		$this->db()->beginTransaction();

		$usernameChange->save(true, false);

		if ($usernameChange->change_state == 'approved')
		{
			$this->onApproval();
		}
		else if ($usernameChange->change_state == 'rejected')
		{
			$this->onRejection();
		}
		else if ($isInsert && $usernameChange->change_state == 'moderated')
		{
			$this->onAwaitingApproval();
		}

		$this->db()->commit();

		// reset this
		$user->setOption('insert_username_change_history', true);

		return $usernameChange;
	}

	protected function onApproval()
	{
		$user = $this->user;
		$usernameChange = $this->usernameChange;

		if ($this->logIp)
		{
			$ip = ($this->logIp === true ? $this->app->request()->getIp() : $this->logIp);
			$this->writeIpLog($ip);
		}

		if ($this->notify)
		{
			/** @var \XF\Repository\UserAlert $alertRepo */
			$alertRepo = \XF::app()->repository('XF:UserAlert');
			$alertRepo->alert(
				$this->user,
				0, '',
				'user', $user->user_id,
				'username_change_approved', [
					'oldUsername' => $usernameChange->old_username,
					'newUsername' => $usernameChange->new_username
				]
			);
		}

		if ($this->isModeratorAction)
		{
			\XF::app()->logger()->logModeratorAction('user', $user, 'username_change_approved', [
				'old' => $usernameChange->old_username,
				'new' => $usernameChange->new_username
			]);
		}
	}

	protected function onRejection()
	{
		$user = $this->user;
		$usernameChange = $this->usernameChange;
		$reason = $usernameChange->reject_reason;

		if ($this->notify)
		{
			/** @var \XF\Repository\UserAlert $alertRepo */
			$alertRepo = \XF::app()->repository('XF:UserAlert');
			$alertRepo->alert(
				$user,
				0, '',
				'user', $user->user_id,
				'username_change_rejected', [
					'rejectedUsername' => $usernameChange->new_username,
					'reason' => $reason
				]
			);
		}

		if ($this->isModeratorAction)
		{
			\XF::app()->logger()->logModeratorAction('user', $user, 'username_change_rejected', [
				'old' => $usernameChange->old_username,
				'new' => $usernameChange->new_username,
				'reason' => $reason
			]);
		}
	}

	protected function onAwaitingApproval()
	{
		if ($this->logIp)
		{
			$ip = ($this->logIp === true ? $this->app->request()->getIp() : $this->logIp);
			$user = $this->user;

			/** @var \XF\Repository\Ip $ipRepo */
			$ipRepo = $this->repository('XF:Ip');
			$ipRepo->logIp($user->user_id, $ip, 'user', $user->user_id, 'username_change_request');
			// note: can't use writeIpLog as the action is different than expected there
		}
	}

	protected function writeIpLog($ip)
	{
		$user = $this->user;

		/** @var \XF\Repository\Ip $ipRepo */
		$ipRepo = $this->repository('XF:Ip');
		$ipRepo->logIp($user->user_id, $ip, 'user', $user->user_id, 'username_change');
	}
}