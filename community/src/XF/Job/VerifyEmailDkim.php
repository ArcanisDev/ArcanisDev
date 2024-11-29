<?php

namespace XF\Job;

class VerifyEmailDkim extends AbstractJob
{
	protected $defaultData = [
		'attempts' => 0
	];

	public function run($maxRunTime): JobResult
	{
		$optionValue = \XF::options()->emailDkim;

		if (!$optionValue || $optionValue['verified'] == true)
		{
			return $this->complete();
		}

		/** @var \XF\Repository\Option $optionRepo */
		$optionRepo = $this->app->repository('XF:Option');

		/** @var \XF\Repository\EmailDkim $emailDkimRepo */
		$emailDkimRepo = $this->app->repository('XF:EmailDkim');
		$verified = $emailDkimRepo->verifyDnsRecordForDomain($optionValue['domain'], $optionValue['privateKey']);

		if (!$verified)
		{
			// gee, be nice if there was something generic for this

			$nextAttempt = $this->getNextAttemptDate($this->data['attempts']);
			if (!$nextAttempt)
			{
				// officially give up, something is wonky
				$optionValue['failed'] = true;
				$optionRepo->updateOption('emailDkim', $optionValue);

				return $this->complete();
			}

			$result = $this->resume();
			$result->data = [
				'attempts' => ++$this->data['attempts']
			];
			$result->continueDate = $nextAttempt;

			return $result;
		}

		$optionValue['verified'] = true;
		$optionRepo->updateOption('emailDkim', $optionValue);

		return $this->complete();
	}

	public function getStatusMessage(): string
	{
		$actionPhrase = \XF::phrase('verifying_dns_records_for_email_dkim');
		return sprintf('%s...', $actionPhrase);
	}

	public function canCancel(): bool
	{
		return false;
	}

	public function canTriggerByChoice(): bool
	{
		return false;
	}

	protected function getNextAttemptDate(int $previousAttempts)
	{
		switch ($previousAttempts)
		{
			case 0: $delay = 5 * 60; break; // 5 minutes
			case 1: $delay = 30 * 60; break; // 30 minutes
			case 2: $delay = 3600; break; // 1 hour
			case 3: $delay = 12 * 60 * 60; break; // 12 hours
			case 4: $delay = 24 * 60 * 60; break; // 24 hours
			default: return null; // give up
		}

		return time() + $delay;
	}
}