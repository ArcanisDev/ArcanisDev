<?php

namespace XF\Service\User;

class SecurityLockReset extends PasswordReset
{
	public function getType()
	{
		return 'security_lock_reset';
	}

	public function canTriggerConfirmation(&$error = null)
	{
		if ($this->user->email == '')
		{
			// this is a pretty hard dead-end but should be rare for a user not to have an email address
			$error = \XF::phrase('your_account_is_currently_security_locked_and_you_cannot_login');
			return false;
		}

		return true;
	}

	protected function getRecordLifetime(): int
	{
		return 12 * 3600; // 12 hours
	}
}