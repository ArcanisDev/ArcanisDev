<?php

namespace XF\ConnectedAccount\ProviderData;

class Yahoo extends AbstractProviderData
{
	public function getDefaultEndpoint()
	{
		return 'https://api.login.yahoo.com/openid/v1/userinfo';
	}

	public function getProviderKey()
	{
		$profile = $this->requestFromEndpoint();
		return $profile['sub'] ?? null;
	}

	public function getUsername()
	{
		$profile = $this->requestFromEndpoint();
		return $profile['preferred_username'] ?? $profile['name'] ?? null;
	}

	public function getAvatarUrl()
	{
		$profile = $this->requestFromEndpoint();
		return $profile['picture'] ?? null;
	}
}