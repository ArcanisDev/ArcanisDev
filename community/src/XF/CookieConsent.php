<?php

namespace XF;

use function array_key_exists, in_array, is_string;

class CookieConsent
{
	/**
	 * @var string
	 */
	const MODE_SIMPLE = 'simple';

	/**
	 * @var string
	 */
	const MODE_ADVANCED = 'advanced';

	/**
	 * @var string
	 */
	const GROUP_REQUIRED = '_required';

	/**
	 * @var string
	 */
	const GROUP_UNKNOWN = '_unknown';

	/**
	 * @var string
	 */
	const GROUP_THIRD_PARTY = '_third_party';

	/**
	 * @var string
	 */
	const GROUP_OPTIONAL = 'optional';

	/**
	 * @var mixed[]
	 */
	protected $cookies = [];

	/**
	 * @var string[]
	 */
	protected $thirdParties = [];

	/**
	 * @var string[]
	 */
	protected $consentedGroups = [];

	public function getMode(): string
	{
		$options = \XF::options()->cookieConsent;
		return $options['type'] ?? 'disabled';
	}

	/**
	 * @return mixed[]
	 */
	public function getCookies(): array
	{
		return $this->cookies;
	}

	/**
	 * @return string[]
	 */
	public function getGroups(
		bool $includeInternal = true,
		bool $includeThirdParty = true
	): array
	{
		$cookieGroups = array_column($this->cookies, 'group');

		$extraGroups = [static::GROUP_UNKNOWN];

		$groups = array_unique(array_merge($cookieGroups, $extraGroups));
		sort($groups);

		if (!$includeInternal)
		{
			$groups = array_values(
				array_filter($groups, function (string $group) {
					return strpos($group, '_') !== 0;
				})
			);
		}

		if ($includeThirdParty && $this->getThirdParties())
		{
			$groups[] = static::GROUP_THIRD_PARTY;
		}

		return $groups;
	}

	/**
	 * @return mixed[]
	 */
	public function getCookiesInGroup(string $group): array
	{
		$this->assertValidGroup($group);

		return array_filter($this->cookies, function (array $cookie) use ($group)
		{
			return $cookie['group'] === $group;
		});
	}

	public function getCookieGroup(string $cookie): string
	{
		if (!$this->isValidCookie($cookie))
		{
			return static::GROUP_UNKNOWN;
		}

		return $this->cookies[$cookie]['group'];
	}

	/**
	 * @param mixed[] $cookies
	 */
	public function addCookies(array $cookies)
	{
		foreach ($cookies AS $cookie => $config)
		{
			if (is_string($config))
			{
				$config = ['group' => $config];
			}

			$config = array_merge(
				[
					'group' => static::GROUP_UNKNOWN,
					'prefix' => true,
					'localStorage' => false
				],
				$config
			);

			$this->addCookie(
				$cookie,
				$config['group'],
				$config['prefix'],
				$config['localStorage']
			);
		}
	}

	public function addCookie(
		string $cookie,
		string $group,
		bool $prefix = true,
		bool $localStorage = false
	)
	{
		if (substr($cookie, -1) === '*')
		{
			$regex = '/^' . substr($cookie, 0, -1) . '\w+$/i';
		}
		else
		{
			$regex = '/^' . $cookie . '$/i';
		}

		$this->cookies[$cookie] = [
			'group' => $group,
			'prefix' => $prefix,
			'localStorage' => $localStorage,
			'regex' => $regex
		];
		ksort($this->cookies);
	}

	public function removeCookie(string $cookie)
	{
		$this->assertValidCookie($cookie);

		unset($this->cookies[$cookie]);
	}

	/**
	 * @return string[]
	 */
	public function getThirdParties(): array
	{
		return array_keys($this->thirdParties);
	}

	/**
	 * @param string[] $thirdParties
	 */
	public function addThirdParties(array $thirdParties)
	{
		foreach ($thirdParties AS $thirdParty)
		{
			$this->addThirdParty($thirdParty);
		}
	}

	public function addThirdParty(string $thirdParty)
	{
		$this->thirdParties[$thirdParty] = true;
		ksort($this->thirdParties);
	}

	public function removeThirdParty(string $thirdParty)
	{
		$this->assertValidThirdParty($thirdParty);

		unset($this->thirdParties[$thirdParty]);
	}

	public function getCookieLabel(string $cookie): string
	{
		$prefix = $this->isValidCookie($cookie)
			? $this->cookies[$cookie]['prefix']
			: true;

		if (!$prefix)
		{
			return $cookie;
		}

		$cookieConfig = \XF::config('cookie');
		return $cookieConfig['prefix'] . $cookie;
	}

	public function getCookieDescription(string $cookie): \XF\Phrase
	{
		if (substr($cookie, -1) === '*')
		{
			$cookie = substr($cookie, 0, -1) . '_wildcard';
		}

		$cookie = preg_replace('/[^a-z0-9_]/i', '_', $cookie);

		return \XF::phrase('cookie_consent.cookie_description_' . $cookie);
	}

	public function getGroupLabel(string $group): \XF\Phrase
	{
		return \XF::phrase('cookie_consent.group_label_' . $group);
	}

	public function getGroupDescription(string $group): \XF\Phrase
	{
		return \XF::phrase('cookie_consent.group_description_' . $group);
	}

	public function getThirdPartyLabel(string $thirdParty): \XF\Phrase
	{
		return \XF::phrase('cookie_consent.third_party_label_' . $thirdParty);
	}

	public function getThirdPartyDescription(string $thirdParty): \XF\Phrase
	{
		return \XF::phrase('cookie_consent.third_party_description_' . $thirdParty);
	}

	/**
	 * @return string[]
	 */
	public function getConsentedGroups(): array
	{
		if ($this->getMode() !== static::MODE_ADVANCED)
		{
			return $this->getGroups(false);
		}

		return array_keys($this->consentedGroups);
	}

	/**
	 * @return array<string,bool>
	 */
	public function getGroupConsentState(): array
	{
		$consentedGroups = $this->getConsentedGroups();
		$groups = $this->getGroups(false);

		$output = [];

		foreach ($groups AS $group)
		{
			$output[$group] = in_array($group, $consentedGroups);
		}

		return $output;
	}

	/**
	 * @param string[] $groups
	 */
	public function addConsentedGroups(array $groups)
	{
		foreach ($groups AS $group)
		{
			$this->addConsentedGroup($group);
		}
	}

	public function addConsentedGroup(string $group)
	{
		if (!$this->isValidGroup($group))
		{
			return;
		}

		$this->consentedGroups[$group] = true;
		ksort($this->consentedGroups);
	}

	/**
	 * @param string[] $groups
	 */
	public function removeConsentedGroups(array $groups)
	{
		foreach ($groups AS $group)
		{
			$this->removeConsentedGroup($group);
		}
	}

	public function removeConsentedGroup(string $group)
	{
		unset($this->consentedGroups[$group]);
	}

	public function isCookieConsented(string $cookie): bool
	{
		$group = $this->getCookieGroup($cookie);

		return $this->isGroupConsented($group);
	}

	public function isGroupConsented(string $group): bool
	{
		if (!$this->isValidGroup($group))
		{
			return false;
		}

		if ($group === static::GROUP_REQUIRED)
		{
			return true;
		}

		if ($group === static::GROUP_UNKNOWN)
		{
			return true;
		}

		return in_array($group, $this->getConsentedGroups());
	}


	public function isThirdPartyConsented(string $thirdParty): bool
	{
		return $this->isGroupConsented(static::GROUP_THIRD_PARTY);
	}

	public function isCaptchaConsented(
		string $class = null,
		bool $force = false
	): bool
	{
		return empty($this->getUnconsentedThirdParties(
			$this->getCaptchaThirdParties($class, $force)
		));
	}

	/**
	 * @return string[]
	 */
	public function getUnconsentedCookies(\Closure $filter = null): array
	{
		if ($filter === null)
		{
			$filter = function (array $config, string $key) {
				return true;
			};
		}

		$cookies = array_keys(
			array_filter($this->cookies, $filter, ARRAY_FILTER_USE_BOTH)
		);

		$unconsented = [];

		foreach ($cookies AS $cookie)
		{
			if ($this->isCookieConsented($cookie))
			{
				continue;
			}

			$unconsented[] = $cookie;
		}

		return $unconsented;
	}

	/**
	 * @param string[] $groups
	 *
	 * @return string[]
	 */
	public function getUnconsentedGroups(array $groups): array
	{
		$unconsented = [];

		foreach ($groups AS $group)
		{
			if ($this->isGroupConsented($group))
			{
				continue;
			}

			$unconsented[] = $group;
		}

		return $unconsented;
	}

	/**
	 * @param string[] $thirdParties
	 *
	 * @return string[]
	 */
	public function getUnconsentedThirdParties(array $thirdParties): array
	{
		$unconsented = [];

		foreach ($thirdParties as $thirdParty)
		{
			if ($this->isThirdPartyConsented($thirdParty))
			{
				continue;
			}

			$unconsented[] = $thirdParty;
		}

		return $unconsented;
	}

	/**
	 * @return string[]
	 */
	public function getCaptchaThirdParties(
		string $class = null,
		bool $force = false
	): array
	{
		if (!$force && !\XF::visitor()->isShownCaptcha())
		{
			return [];
		}

		$captcha = \XF::app()->captcha($class);
		if (!$captcha)
		{
			return [];
		}

		return $captcha->getCookieThirdParties();
	}

	public function applyConsentPreferences(
		\XF\Http\Request $request,
		\XF\Http\Response $response
	)
	{
		$response->setCookie(
			'consent',
			json_encode($this->getConsentedGroups()),
			365 * 86400,
			null,
			false
		);

		$unconsentedCookies = $this->getUnconsentedCookies(
			function (array $config, string $key) use ($request) {
				return in_array($key, array_keys($request->getCookies()));
			}
		);
		foreach ($unconsentedCookies AS $cookie)
		{
			$response->setCookie($cookie, false);
		}

		$cookieConsentRepo = \XF::repository('XF:CookieConsent');
		$cookieConsentRepo->logCookieConsent(
			\XF::visitor()->user_id,
			$request->getIp(),
			$this->getConsentedGroups()
		);
	}

	protected function isValidCookie(string $cookie): bool
	{
		return array_key_exists($cookie, $this->cookies);
	}

	protected function assertValidCookie(string $cookie)
	{
		if ($this->isValidCookie($cookie))
		{
			return;
		}

		throw new \InvalidArgumentException("Invalid cookie: {$cookie}");
	}

	protected function isValidGroup(string $group): bool
	{
		return in_array($group, $this->getGroups(), true);
	}

	protected function assertValidGroup(string $group)
	{
		if ($this->isValidGroup($group))
		{
			return;
		}

		throw new \InvalidArgumentException("Invalid cookie group: {$group}");
	}

	protected function isValidThirdParty(string $thirdParty): bool
	{
		return in_array($thirdParty, $this->getThirdParties(), true);
	}

	protected function assertValidThirdParty(string $thirdParty)
	{
		if ($this->isValidThirdParty($thirdParty))
		{
			return;
		}

		throw new \InvalidArgumentException("Invalid third party: {$thirdParty}");
	}
}
