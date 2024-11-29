<?php

namespace XF\Captcha;

use XF\Template\Templater;

use function is_array;

class HCaptcha extends AbstractCaptcha
{
	/**
	 * hCaptcha site key
	 *
	 * @var string
	 */
	protected $siteKey = 'f1592dee-67b6-4670-9062-649933011aa2';

	/**
	 * hCaptcha secret key
	 *
	 * @var string
	 */
	protected $secretKey = '0x47fD9C7F7B1db151F1c0c36a938Ab1BDcDa9CBAA';

	/**
	 * Enable hCaptcha invisible mode
	 *
	 * @var bool
	 */
	protected $invisibleMode = false;

	public function __construct(\XF\App $app)
	{
		parent::__construct($app);
		$extraKeys = $app->options()->extraCaptchaKeys;
		if (!empty($extraKeys['hCaptchaSiteKey']) && !empty($extraKeys['hCaptchaSecretKey']))
		{
			$this->siteKey = $extraKeys['hCaptchaSiteKey'];
			$this->secretKey = $extraKeys['hCaptchaSecretKey'];
		}
		if (!empty($extraKeys['hCaptchaInvisible']))
		{
			$this->invisibleMode = $extraKeys['hCaptchaInvisible'];
		}
	}

	public function renderInternal(Templater $templater)
	{
		if (!$this->siteKey)
		{
			return '';
		}

		if ($this->isLocalDomain())
		{
			return '';
		}

		return $templater->renderTemplate('public:captcha_hcaptcha', [
			'siteKey' => $this->siteKey,
			'invisible' => $this->invisibleMode && !$this->forceVisible
		]);
	}

	public function isValid()
	{
		if (!$this->siteKey || !$this->secretKey)
		{
			return true; // if not configured, always pass
		}

		if ($this->isLocalDomain())
		{
			return true;
		}

		$request = $this->app->request();

		$captchaResponse = $request->filter('h-captcha-response', 'str');
		if (!$captchaResponse)
		{
			return false;
		}

		try
		{
			$client = $this->app->http()->client();

			$response = \GuzzleHttp\json_decode($client->post('https://hcaptcha.com/siteverify',
				['form_params' => [
					'sitekey' => $this->siteKey,
					'secret' => $this->secretKey,
					'response' => $captchaResponse,
					'remoteip' => $request->getIp()
				]
				])->getBody()->getContents(), true);

			$this->setResponse($response);

			if (!empty($response['success']))
			{
				return true;
			}

			$logErrors = [];
			if (!empty($response['error-codes']) && is_array($response['error-codes']))
			{
				foreach ($response['error-codes'] AS $errorCode)
				{
					switch ($errorCode)
					{
						case 'missing-input-secret':
						case 'invalid-input-secret':
						case 'sitekey-secret-mismatch':
						case 'invalid-remoteip':
							$logErrors[] = $errorCode;
					}
				}

				if ($logErrors)
				{
					\XF::logError("hCaptcha configuration error: " . implode(', ', $logErrors));
				}
			}

			return false;
		}
		catch(\GuzzleHttp\Exception\RequestException $e)
		{
			// this is an exception with the underlying request, so let it go through
			\XF::logException($e, false, 'hCaptcha connection error: ');
			return true;
		}
	}

	/**
	 * hCaptcha doesn't work on localhost/127.0.0.1. It's potentially dangerous
	 * to rely on HTTP_HOST/SERVER_NAME to check this because there are some situations
	 * where they could be spoofed. Therefore, check if the canonical URL refers
	 * to one of those and if so, just bypass the CAPTCHA.
	 *
	 * @return bool
	 */
	protected function isLocalDomain(): bool
	{
		$boardUrl = $this->app->options()->boardUrl ?? '';

		return preg_match('#^https?://(localhost|127.0.0.1)[/:]#i', $boardUrl);
	}

	public function getPrivacyPolicy()
	{
		return \XF::phrase('hcaptcha_privacy_policy');
	}

	/**
	 * @return string[]
	 */
	public function getCookieThirdParties(): array
	{
		return ['h_captcha'];
	}
}