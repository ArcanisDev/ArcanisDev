<?php

namespace XF\Api\Controller;

use XF\Mvc\Entity\Entity;
use XF\Mvc\ParameterBag;

use function is_array, is_string, strlen;

/**
 * @api-group Auth
 */
class Auth extends AbstractController
{
	protected function preDispatchController($action, ParameterBag $params)
	{
		$this->assertSuperUserKey();
		$this->assertApiScope('auth');
	}

	/**
	 * @api-desc Tests a login and password for validity. Only available to super user keys. We strongly recommend the login and password parameters are passed into the request body rather than the query string.
	 *
	 * @api-in <req> str $login The username or email address of the user to test
	 * @api-in <req> str $password The password of the user
	 * @api-in str $limit_ip The IP that should be considered to be making the request. If provided, this will be used to prevent brute force attempts.
	 *
	 * @api-out User $user If successful, the user record of the matching user
	 */
	public function actionPost()
	{
		$this->assertRequiredApiInput(['login', 'password']);

		$input = $this->filter([
			'login' => 'str',
			'password' => 'str',
			'limit_ip' => 'str'
		]);

		/** @var \XF\Service\User\Login $loginService */
		$loginService = $this->service('XF:User\Login', $input['login'], $input['limit_ip']);
		if ($loginService->isLoginLimited($limitType))
		{
			return $this->error(\XF::phrase('your_account_has_temporarily_been_locked_due_to_failed_login_attempts'));
		}

		$user = $loginService->validate($input['password'], $error);
		if (!$user)
		{
			return $this->error($error);
		}

		if ($user->security_lock)
		{
			return $this->error(\XF::phrase('your_account_is_currently_security_locked'));
		}

		return $this->apiSuccess([
			'user' => $user->toApiResult(Entity::VERBOSITY_VERBOSE, ['full_profile' => true])
		]);
	}

	/**
	 * @api-desc Looks up the active XenForo user based on session ID or remember cookie value.
	 *      This can be used to help with seamless SSO with XF, assuming the session or remember cookies are
	 *      available to your page. At least one of session_id and remember_cookie must be provided.
	 *      Only available to super user keys.
	 *
	 * @api-in str $session_id If provided, checks for an active session with that ID.
	 * @api-in str $remember_cookie If provided, checks to see if this is an active "remember me" cookie value.
	 *
	 * @api-out bool $success If false, no session or remember cookie could be found
	 * @api-out User $user If successful, the user record of the matching user. May be a guest.
	 */
	public function actionPostFromSession()
	{
		$sessionId = $this->filter('session_id', 'str');
		$rememberCookie = $this->filter('remember_cookie', 'str');

		if (!$sessionId && !$rememberCookie)
		{
			$this->assertRequiredApiInput(['session_id', 'remember_cookie']);
		}

		if ($sessionId)
		{
			/** @var \XF\Session\StorageInterface $publicSessions */
			$publicSessions = $this->app->get('session.public.storage');
			$sessionData = $publicSessions->getSession($sessionId);

			if (is_array($sessionData))
			{
				$sessionIpLimit = $this->filter('session_ip_limit', '?str');
				if (is_string($sessionIpLimit))
				{
					$ipValidated = $this->validateIpAgainstSession($sessionData, $sessionIpLimit);
				}
				else
				{
					$ipValidated = true;
				}

				if ($ipValidated)
				{
					$user = $this->getUserFromSessionData($sessionData);

					return $this->apiSuccess([
						'user' => $user->toApiResult(Entity::VERBOSITY_VERBOSE, ['full_profile' => true])
					]);
				}
			}
		}

		if ($rememberCookie)
		{
			/** @var \XF\Repository\UserRemember $rememberRepo */
			$rememberRepo = $this->repository('XF:UserRemember');

			if ($rememberRepo->validateByCookieValue($rememberCookie, $remember))
			{
				$user = $this->em()->find('XF:User', $remember->user_id, 'api');

				return $this->apiSuccess([
					'user' => $user->toApiResult(Entity::VERBOSITY_VERBOSE, ['full_profile' => true])
				]);
			}
		}

		return $this->apiBoolResult(false);
	}

	protected function validateIpAgainstSession(array $sessionData, string $expectedIp): bool
	{
		// this is basically copied out of the session class...

		if (!isset($sessionData['_ip']) || empty($sessionData['_ip']) || empty($expectedIp))
		{
			return true; // no IP to check against
		}

		$expectedIp = \XF\Util\Ip::convertIpStringToBinary($expectedIp);

		$cidr = strlen($expectedIp) == 4 ? 24 : 64;

		if (empty($sessionData['userId']) || $cidr <= 0)
		{
			return true; // IP check disabled
		}

		return \XF\Util\Ip::ipMatchesCidrRange($expectedIp, $sessionData['_ip'], $cidr);
	}

	protected function getUserFromSessionData(array $sessionData): \XF\Entity\User
	{
		if (!empty($sessionData['userId']))
		{
			$user = $this->em()->find('XF:User', $sessionData['userId'], 'api');
			if ($user)
			{
				$userPasswordDate = $user->Profile ? $user->Profile->password_date : 0;
				if (!isset($sessionData['passwordDate']) || $sessionData['passwordDate'] == $userPasswordDate)
				{
					// we have a user and the password date matches, so we can consider them logged in
					return $user;
				}
			}
		}

		return $this->repository('XF:User')->getGuestUser();
	}

	/**
	 * @api-desc Generates a token that can automatically log into a specific XenForo user when the login URL
	 *      is visited. If the visitor is already logged into a XenForo account, they will not be logged into
	 *      the specified account. Only available to super user keys.
	 *
	 * @api-in <req> int $user_id
	 * @api-in str $limit_ip If provided, locks the token to the specified IP for additional security
	 * @api-in str $return_url If provided, after logging the user will be returned to this URL. Otherwise they'll go to the XenForo index.
	 * @api-in bool $force If provided, the login URL will forcibly replace the currently logged in user if a user is already logged in and different to the currently logged in user. Defaults to false.
	 * @api-in bool $remember Controls whether the a "remember me" cookie will be set when the user logs in. Defaults to true.
	 *
	 * @api-out str $login_token
	 * @api-out str $login_url Direct user to this URL to trigger a login
	 * @api-out int $expiry_date Unix timestamp of when the token expires. An error will be displayed if the token is expired or invalid
	 */
	public function actionPostLoginToken()
	{
		$this->assertApiScope('auth:login_token');
		$this->assertRequiredApiInput('user_id');

		$userId = $this->filter('user_id', 'uint');

		/** @var \XF\Entity\User $user */
		$user = $this->assertRecordExists('XF:User', $userId, 'api');

		/** @var \XF\Entity\ApiLoginToken $loginToken */
		$loginToken = $this->em()->create('XF:ApiLoginToken');
		$loginToken->user_id = $user->user_id;

		$limitIp = $this->filter('limit_ip', 'str');
		if ($limitIp)
		{
			$loginToken->limit_ip = $limitIp;
		}

		$loginToken->save();

		$returnUrl = $this->filter('return_url', 'str');
		$returnUrl = $returnUrl ? $this->request->convertToAbsoluteUri($returnUrl, true) : null;

		$force = $this->filter('force', 'bool', false);
		$remember = $this->filter('remember', 'bool', true);

		$publicRouter = $this->app->router('public');

		return $this->apiResult([
			'login_token' => $loginToken->login_token,
			'login_url' => $publicRouter->buildLink(
				'canonical:login/api-token',
				null,
				[
					'token' => $loginToken->login_token,
					'return_url' => $returnUrl,
					'force' => $force ? 1 : 0,
					'remember' => $remember ? 1 : 0,
				]
			),
			'expiry_date' => $loginToken->expiry_date,
		]);
	}
}