<?php

namespace XF\ConnectedAccount\Service;

class GitHub extends \OAuth\OAuth2\Service\GitHub
{
	/**
	 * Read access to a user’s profile
	 */
	const SCOPE_READ_USER = 'read:user';

	protected function getAuthorizationMethod()
	{
		return static::AUTHORIZATION_METHOD_HEADER_BEARER;
	}

	protected function getExtraApiHeaders()
	{
		return ['Accept' => 'application/vnd.github.v3+json'];
	}
}