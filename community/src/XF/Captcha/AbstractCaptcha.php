<?php

namespace XF\Captcha;

use XF\Entity\CaptchaLog;
use XF\Template\Templater;

use function is_array;

abstract class AbstractCaptcha
{
	/**
	 * @var \XF\App
	 */
	protected $app;

	/**
	 * Rendered output cache.
	 */
	protected $_rendered = null;

	/**
	 * If the CAPTCHA system supports a visible/invisible option,
	 * this should determine whether the visible version is forced
	 * regardless of general preferences
	 */
	protected $forceVisible = false;

	/**
	 * If the CAPTCHA system supports an action/context option for analytics,
	 * this should determine what that action/context is.
	 *
	 * Currently only used by Turnstile.
	 *
	 * @var string
	 */
	protected $context = '';

	/**
	 * Response from the CAPTCHA system after validation isValid() has been called
	 */
	protected $response = null;

	public function __construct(\XF\App $app)
	{
		$this->app = $app;
	}

	/**
	 * Renders the CAPTCHA for use in a template. This should only render the CAPTCHA area itself.
	 * The CAPTCHA may be used in a form row or own its own.
	 */
	abstract public function renderInternal(Templater $templater);

	public function render(Templater $templater)
	{
		if ($this->_rendered === null)
		{
			$this->_rendered = $this->renderInternal($templater);
		}

		return $this->_rendered;
	}

	public function setForceVisible($force)
	{
		$this->forceVisible = $force;
	}

	public function setContext(string $context)
	{
		$this->context = $context;
	}

	/**
	 * Determines if the CAPTCHA has been passed.
	 *
	 * @return boolean
	 */
	abstract public function isValid();

	/**
	 * @return string|\XF\Phrase
	 */
	public function getPrivacyPolicy()
	{
		return '';
	}

	protected function setResponse($response)
	{
		if ($response instanceof CaptchaLog)
		{
			$response = [
				'type' => $response->captcha_type,
				'date' => $response->captcha_date,
				'data' => $response->captcha_data
			];
		}

		if (!is_array($response))
		{
			$response = [$response];
		}

		$this->response = $response;
	}

	/**
	 * Returns whatever response we got from the CAPTCHA system during isValid()
	 *
	 * @return mixed
	 */
	public function getResponse()
	{
		return $this->response;
	}

	/**
	 * If the CAPTCHA provider sets third party cookies, this should return the
	 * names of the parties setting the cookies.
	 *
	 * @return string[]
	 */
	public function getCookieThirdParties(): array
	{
		return [];
	}
}