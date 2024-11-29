<?php

namespace XF\ConnectedAccount\Service;

use OAuth\OAuth2\Token\StdOAuth2Token;
use OAuth\OAuth2\Service\AbstractService;
use OAuth\Common\Http\Exception\TokenResponseException;
use OAuth\Common\Http\Uri\Uri;
use OAuth\Common\Consumer\CredentialsInterface;
use OAuth\Common\Http\Client\ClientInterface;
use OAuth\Common\Storage\TokenStorageInterface;
use OAuth\Common\Http\Uri\UriInterface;

use function is_array;

/**
 * Linkedin Oauth definition for the lusitanian/oauth library.
 * (The provided Linkedin Oauth lib is outdated)
 * Credit: https://github.com/Lusitanian/PHPoAuthLib/issues/554#issuecomment-511760327
 */
class Linkedin extends AbstractService
{
	/**
	 * Defined scopes
	 */
	const SCOPE_R_LITEPROFILE      = 'r_liteprofile';
	const SCOPE_R_EMAILADDRESS     = 'r_emailaddress';
	const SCOPE_W_MEMBER_SOCIAL    = 'w_member_social';

	public function __construct(
		CredentialsInterface $credentials,
		ClientInterface $httpClient,
		TokenStorageInterface $storage,
		$scopes = array(),
		UriInterface $baseApiUri = null
	) {
		parent::__construct($credentials, $httpClient, $storage, $scopes, $baseApiUri, true);

		if (null === $baseApiUri) {
			$this->baseApiUri = new Uri('https://api.linkedin.com/v2/');
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAuthorizationEndpoint()
	{
		return new Uri('https://www.linkedin.com/oauth/v2/authorization');
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAccessTokenEndpoint()
	{
		return new Uri('https://www.linkedin.com/oauth/v2/accessToken');
	}

	/**
	 * {@inheritdoc}
	 */
	protected function getAuthorizationMethod()
	{
		return static::AUTHORIZATION_METHOD_HEADER_BEARER;
	}

	/**
	 * {@inheritdoc}
	 */
	protected function parseAccessTokenResponse($responseBody)
	{
		$data = json_decode($responseBody, true);

		if (null === $data || !is_array($data)) {
			throw new TokenResponseException('Unable to parse response.');
		} elseif (isset($data['error'])) {
			throw new TokenResponseException('Error in retrieving token: "' . $data['error'] . '"');
		}

		$token = new StdOAuth2Token();
		$token->setAccessToken($data['access_token']);
		$token->setLifeTime($data['expires_in']);

		if (isset($data['refresh_token'])) {
			$token->setRefreshToken($data['refresh_token']);
			unset($data['refresh_token']);
		}

		unset($data['access_token']);
		unset($data['expires_in']);

		$token->setExtraParams($data);

		return $token;
	}
}