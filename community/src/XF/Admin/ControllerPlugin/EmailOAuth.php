<?php

namespace XF\Admin\ControllerPlugin;

class EmailOAuth extends AbstractPlugin
{
	public function actionTriggerOAuthRequest(array $oAuthEmailSetup): \XF\Mvc\Reply\AbstractReply
	{
		$provider = $this->app->oAuth()->provider($oAuthEmailSetup['provider'], $oAuthEmailSetup['config']);
		if (method_exists($provider, 'setAccessType'))
		{
			$provider->setAccessType('offline');
		}

		$this->session()->oAuthEmailSetup = $oAuthEmailSetup;

		return $this->redirect($provider->getAuthorizationUri([
			'prompt' => 'consent'
		]));
	}

	public function getGoogleOAuthEmailSetupConfig($clientId, $clientSecret, $returnUrl, array $input = [])
	{
		return [
			'provider' => 'Google',
			'config' => [
				'key' => $clientId,
				'secret' => $clientSecret,
				'scopes' => ['email', 'https://mail.google.com/'],
				'redirect' => $this->buildLink('canonical:misc/email-oauth-setup'),
				'storageType' => 'local'
			],
			'returnUrl' => $returnUrl,
			'input' => $input
		];
	}

	public function getMicrosoftOAuthEmailSetupConfig($clientId, $clientSecret, $returnUrl, array $input = [])
	{
		return [
			'provider' => 'XF:Service\MicrosoftEmail',
			'config' => [
				'key' => $clientId,
				'secret' => $clientSecret,
				'scopes' => [
					'https://outlook.office.com/SMTP.Send',
					'https://outlook.office.com/IMAP.AccessAsUser.All',
					'https://outlook.office.com/POP.AccessAsUser.All',
					'openid', 'profile', 'email', 'offline_access'
				],
				'redirect' => $this->buildLink('canonical:misc/email-oauth-setup'),
				'storageType' => 'local'
			],
			'returnUrl' => $returnUrl,
			'input' => $input
		];
	}

	public function assertOAuthEmailSetupData(bool $withToken): array
	{
		$oAuthEmailSetup = $this->session()->oAuthEmailSetup;
		if (!$oAuthEmailSetup)
		{
			throw $this->exception(
				$this->error(\XF::phrase('something_went_wrong_please_try_again'))
			);
		}

		if ($withToken && empty($oAuthEmailSetup['tokenData']))
		{
			throw $this->exception(
				$this->error(\XF::phrase('something_went_wrong_please_try_again'))
			);
		}

		return $oAuthEmailSetup;
	}

	public function getOAuthEmailOptionData(array $oAuthEmailSetup): array
	{
		$oAuthConfig = $oAuthEmailSetup['config'];
		$tokenData = $oAuthEmailSetup['tokenData'];

		return [
			'provider' => $oAuthEmailSetup['provider'],
			'client_id' => $oAuthConfig['key'],
			'client_secret' => $oAuthConfig['secret'],
			'scopes' => $oAuthConfig['scopes'],
			'token_expiry' => $tokenData['token_expiry'],
			'refresh_token' => $tokenData['refresh_token']
		];
	}

	public function getLoginUserNameFromProvider($providerName, \OAuth\Common\Service\ServiceInterface $provider)
	{
		if ($provider instanceof \OAuth\OAuth2\Service\Google)
		{
			$userInfo = $provider->request('userinfo');
			if ($userInfo)
			{
				$decoded = @json_decode($userInfo, true);
				return $decoded['email'] ?? null;
			}
		}

		return null;
	}

	public function getDefaultProviderConnectionData($providerName, $connectionType)
	{
		if ($providerName == 'Google')
		{
			switch ($connectionType)
			{
				case 'pop3':
					return [
						'host' => 'pop.gmail.com',
						'port' => 995,
						'encryption' => 'ssl'
					];

				case 'imap':
					return [
						'host' => 'imap.gmail.com',
						'port' => 993,
						'encryption' => 'ssl'
					];

				case 'smtp':
					return [
						'host' => 'smtp.gmail.com',
						'port' => 465,
						'encryption' => 'ssl'
					];
			}
		}

		if ($providerName == 'XF:Service\MicrosoftEmail')
		{
			switch ($connectionType)
			{
				case 'pop3':
					return [
						'host' => 'outlook.office365.com',
						'port' => 995,
						'encryption' => 'ssl'
					];

				case 'imap':
					return [
						'host' => 'outlook.office365.com',
						'port' => 993,
						'encryption' => 'ssl'
					];

				case 'smtp':
					return [
						'host' => 'smtp.office365.com',
						'port' => 587,
						'encryption' => 'tls'
					];
			}
		}

		return null;
	}
}
