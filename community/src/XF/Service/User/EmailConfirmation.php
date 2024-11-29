<?php

namespace XF\Service\User;

class EmailConfirmation extends AbstractConfirmationService
{
	/**
	 * @var \XF\Mvc\Entity\Entity|null
	 */
	protected $preRegContent;

	public function getType()
	{
		return 'email';
	}

	public function canTriggerConfirmation(&$error = null)
	{
		if (!$this->user->isAwaitingEmailConfirmation())
		{
			$error = \XF::phrase('your_account_does_not_require_confirmation');
			return false;
		}

		if (!$this->user->email)
		{
			$error = \XF::phrase('this_account_cannot_be_confirmed_without_email_address');
			return false;
		}

		return true;
	}

	public function emailConfirmed()
	{
		$user = $this->user;
		if (!$user->isAwaitingEmailConfirmation())
		{
			return false;
		}

		$originalUserState = $user->user_state;

		if ($user->user_state == 'email_confirm')
		{
			// don't log when changing from initial confirm state as it creates a lot of noise
			$user->getBehavior('XF:ChangeLoggable')->setOption('enabled', false);
		}

		$this->advanceUserState();
		$user->save();

		if ($this->confirmation->exists())
		{
			$this->confirmation->delete();
		}

		$this->triggerExtraActions($originalUserState);

		return true;
	}

	public function getPreRegContent()
	{
		return $this->preRegContent;
	}

	protected function advanceUserState()
	{
		$user = $this->user;

		switch ($user->user_state)
		{
			case 'email_confirm':
				if ($this->app->options()->registrationSetup['moderation'])
				{
					$user->user_state = 'moderated';
					break;
				}
			// otherwise, fall through

			case 'email_confirm_edit': // this is a user editing email, never send back to moderation
			case 'moderated':
				$user->user_state = 'valid';
				break;
		}
	}

	protected function triggerExtraActions($originalUserState)
	{
		$user = $this->user;

		if ($originalUserState == 'email_confirm' && $user->user_state == 'valid')
		{
			/** @var \XF\Service\User\RegistrationComplete $regComplete */
			$regComplete = $this->service('XF:User\RegistrationComplete', $user);
			$regComplete->triggerCompletionActions();
			$this->preRegContent = $regComplete->getPreRegContent();
		}
		else
		{
			/** @var \XF\Repository\PreRegAction $preRegActionRepo */
			$preRegActionRepo = $this->repository('XF:PreRegAction');
			$preRegActionRepo->completeUserActionIfPossible($user);
		}

		$this->repository('XF:Ip')->logIp(
			$user->user_id,
			\XF::app()->request()->getIp(),
			'user',
			$user->user_id,
			'email_confirm'
		);
	}
}