<?php

namespace XF\Captcha;

use XF\Template\Templater;

class ReCaptcha extends AbstractCaptcha
{
	/**
	 * reCAPTCHA site key
	 *
	 * @var null|string
	 */
	protected $siteKey;

	/**
	 * reCAPTCHA secret key
	 *
	 * @var null|string
	 */
	protected $secretKey;

	/**
	 * Enable reCAPTCHA invisible mode
	 *
	 * @var bool
	 */
	protected $invisibleMode = false;

	public function __construct(\XF\App $app)
	{
		parent::__construct($app);
		$extraKeys = $app->options()->extraCaptchaKeys;
		if (!empty($extraKeys['reCaptchaSiteKey']) && !empty($extraKeys['reCaptchaSecretKey']))
		{
			$this->siteKey = $extraKeys['reCaptchaSiteKey'];
			$this->secretKey = $extraKeys['reCaptchaSecretKey'];
		}
		if (!empty($extraKeys['reCaptchaInvisible']))
		{
			$this->invisibleMode = $extraKeys['reCaptchaInvisible'];
		}
	}

	public function renderInternal(Templater $templater)
	{
		if (!$this->siteKey)
		{
			return '';
		}

		return $templater->renderTemplate('public:captcha_recaptcha', [
			'siteKey'   => $this->siteKey,
			'invisible' => $this->invisibleMode && !$this->forceVisible
		]);
	}

	public function isValid()
	{
		if (!$this->siteKey || !$this->secretKey)
		{
			return true; // if not configured, always pass
		}

		$request = $this->app->request();

		$captchaResponse = $request->filter('g-recaptcha-response', 'str');
		if (!$captchaResponse)
		{
			return false;
		}

		try
		{
			$client = $this->app->http()->client();

			$response = \GuzzleHttp\json_decode($client->post('https://www.recaptcha.net/recaptcha/api/siteverify',
				[
					'form_params' => [
						'secret'   => $this->secretKey,
						'response' => $captchaResponse,
						'remoteip' => $request->getIp()
					]
				])->getBody()->getContents(), true);

			$this->setResponse($response);

			if (isset($response['success']) && isset($response['hostname']) && $response['hostname'] == $request->getHost())
			{
				return $response['success'];
			}

			return false;
		}
		catch (\GuzzleHttp\Exception\RequestException $e)
		{
			// this is an exception with the underlying request, so let it go through
			\XF::logException($e, false, 'ReCAPTCHA connection error: ');
			return true;
		}
	}

	public function getPrivacyPolicy()
	{
		return \XF::phrase('recaptcha_privacy_policy');
	}

	/**
	 * @return string[]
	 */
	public function getCookieThirdParties(): array
	{
		return ['google_recaptcha'];
	}
}