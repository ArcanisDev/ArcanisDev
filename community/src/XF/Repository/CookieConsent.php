<?php

namespace XF\Repository;

use XF\Entity\CookieConsentLog;
use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class CookieConsent extends Repository
{
	public function findLogsForList(): Finder
	{
		return $this->finder('XF:CookieConsentLog')
			->with('User')
			->setDefaultOrder('log_date', 'DESC');
	}

	/**
	 * @param string[] $consentedGroups
	 */
	public function logCookieConsent(
		int $userId,
		string $ipAddress,
		array $consentedGroups
	): CookieConsentLog
	{
		$ipAddress = \XF\Util\Ip::convertIpStringToBinary($ipAddress);

		$cookieConsentLog = $this->em->create('XF:CookieConsentLog');
		$cookieConsentLog->user_id = $userId;
		$cookieConsentLog->ip_address = $ipAddress;
		$cookieConsentLog->consented_groups = $consentedGroups;
		$cookieConsentLog->save();

		return $cookieConsentLog;
	}

	public function pruneCookieConsentLogs(int $cutOff = null): int
	{
		if ($cutOff === null)
		{
			$logLength = $this->options()->cookieConsentLogLength;
			if (!$logLength)
			{
				return 0;
			}

			$cutOff = \XF::$time - 86400 * $logLength;
		}

		return $this->db()->delete(
			'xf_cookie_consent_log',
			'log_date < ?',
			$cutOff
		);
	}
}
