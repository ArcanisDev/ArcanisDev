<?php

namespace XF\Admin\Controller;

use XF\Mvc\ParameterBag;

class Misc extends AbstractController
{
	public function actionEmailOAuthSetup(ParameterBag $params)
	{
		/** @var \XF\Admin\ControllerPlugin\EmailOAuth $oAuthPlugin */
		$oAuthPlugin = $this->plugin('XF:Admin:EmailOAuth');

		$oAuthEmailSetup = $oAuthPlugin->assertOAuthEmailSetupData(false);

		$provider = $this->app->oAuth()->provider($oAuthEmailSetup['provider'], $oAuthEmailSetup['config']);
		if (method_exists($provider, 'setAccessType'))
		{
			$provider->setAccessType('offline');
		}

		$code = $this->filter('code', 'str');

		try
		{
			$token = $provider->requestAccessToken($code);
		}
		catch (\Exception $e)
		{
			\XF::logException($e);
			return $this->error(\XF::phrase('something_went_wrong_please_try_again'));
		}

		$oAuthEmailSetup['tokenData'] = [
			'token' => $token->getAccessToken(),
			'token_expiry' => $token->getEndOfLife(),
			'refresh_token' => $token->getRefreshToken()
		];

		if ($provider instanceof \XF\ConnectedAccount\Service\MicrosoftEmail)
		{
			$jwt = $token->getExtraParams()['id_token'];
			list($headers, $payload, $sig) = explode('.', $jwt);
			$payload = json_decode(base64_decode($payload), true);

			$oAuthEmailSetup['loginUserName'] = $payload['email'];
		}
		else
		{
			$oAuthEmailSetup['loginUserName'] = $oAuthPlugin->getLoginUserNameFromProvider(
				$oAuthEmailSetup['provider'],
				$provider
			);
		}

		$this->session()->oAuthEmailSetup = $oAuthEmailSetup;

		return $this->redirect($oAuthEmailSetup['returnUrl']);
	}
}