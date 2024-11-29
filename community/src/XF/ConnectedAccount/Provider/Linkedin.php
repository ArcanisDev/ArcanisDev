<?php

namespace XF\ConnectedAccount\Provider;

use XF\Entity\ConnectedAccountProvider;
use XF\ConnectedAccount\Http\HttpResponseException;

class Linkedin extends AbstractProvider
{
	public function getOAuthServiceName()
	{
		return 'XF:Service\Linkedin';
	}

	public function getProviderDataClass()
	{
		return 'XF:ProviderData\Linkedin';
	}

	public function getDefaultOptions()
	{
		return [
			'client_id' => '',
			'client_secret' => ''
		];
	}

	public function getOAuthConfig(ConnectedAccountProvider $provider, $redirectUri = null)
	{
		return [
			'key' => $provider->options['client_id'],
			'secret' => $provider->options['client_secret'],
			'scopes' => ['r_liteprofile', 'r_emailaddress'],
			'redirect' => $redirectUri ?: $this->getRedirectUri($provider)
		];
	}

	public function parseProviderError(HttpResponseException $e, &$error = null)
	{
		$errorDetails = json_decode($e->getResponseContent(), true);
		if (isset($errorDetails['error_description']))
		{
			$e->setMessage($errorDetails['error_description']);
		}
		parent::parseProviderError($e, $error);
	}
}