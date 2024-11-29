<?php

namespace XF\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\AbstractReply;

class SecurityLock extends AbstractController
{
	public function actionIndex()
	{
		return $this->redirect($this->buildLink('index'));
	}

	public function actionResend(ParameterBag $params)
	{
		$visitor = \XF::visitor();

		if (!$visitor->user_id || $visitor->security_lock !== 'reset')
		{
			return $this->redirect($this->buildLink('index'));
		}

		/** @var \XF\Service\User\SecurityLockReset $securityLock */
		$securityLock = $this->service('XF:User\SecurityLockReset', $visitor);

		if (!$securityLock->canTriggerConfirmation($error))
		{
			return $this->error($error);
		}

		if ($this->request->isPost())
		{
			$securityLock->triggerConfirmation();

			return $this->redirect(
				$this->buildLink('index'), \XF::phrase('security_lock_reset_email_has_been_resent')
			);
		}
		else
		{
			$viewParams = [];
			return $this->view('XF:SecurityLock/Resend', 'security_lock_resend', $viewParams);
		}
	}

	public function actionReset(ParameterBag $params)
	{
		/** @var \XF\Entity\User $user */
		$user = $this->assertRecordExists('XF:User', $params->user_id);

		if ($user->security_lock !== 'reset')
		{
			return $this->redirect($this->buildLink('index'));
		}

		/** @var \XF\Service\User\SecurityLockReset $securityLock */
		$securityLock = $this->service('XF:User\SecurityLockReset', $user);

		$confirmationKey = $this->filter('c', 'str');
		if (!$securityLock->isConfirmationVerified($confirmationKey))
		{
			return $this->error(\XF::phrase('your_action_could_not_be_confirmed_request_new'));
		}

		if ($this->isPost())
		{
			$passwords = $this->filter([
				'password' => 'str',
				'password_confirm' => 'str'
			]);

			if (!$passwords['password'])
			{
				return $this->error(\XF::phrase('please_enter_valid_password'));
			}

			if (!$passwords['password_confirm'] || $passwords['password'] !== $passwords['password_confirm'])
			{
				return $this->error(\XF::phrase('passwords_did_not_match'));
			}

			$securityLock->setAllowPasswordReuse(false);
			$securityLock->resetLostPassword($passwords['password']);

			/** @var \XF\ControllerPlugin\Login $loginPlugin */
			$loginPlugin = $this->plugin('XF:Login');
			$loginPlugin->triggerIfTfaConfirmationRequired(
				$user,
				$this->buildLink('login/two-step', null, [
					'_xfRedirect' => $this->buildLink('index')
				])
			);

			$this->session()->changeUser($user);

			return $this->redirect($this->buildLink('index'), \XF::phrase('your_password_has_been_reset'));
		}
		else
		{
			$viewParams = [
				'user' => $user,
				'c' => $confirmationKey
			];
			return $this->view('XF:SecurityLock\Reset', 'security_lock_reset', $viewParams);
		}
	}

	public function updateSessionActivity($action, ParameterBag $params, AbstractReply &$reply) {}

	public function assertViewingPermissions($action) {}
	public function assertCorrectVersion($action) {}
	public function assertBoardActive($action) {}
	public function assertTfaRequirement($action) {}
	public function assertNotSecurityLocked($action) {}
	public function assertPolicyAcceptance($action) {}
}