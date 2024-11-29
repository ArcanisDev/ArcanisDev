<?php

namespace XF\Install\Upgrade;

class Version2020570 extends AbstractUpgrade
{
	public function getVersionName()
	{
		return '2.2.5';
	}

	public function step1()
	{
		$options = $this->db()->fetchPairs("
			SELECT option_id, option_value
			FROM xf_option
			WHERE option_id IN ('captcha', 'extraCaptchaKeys')
		");

		$captchaType = $options['captcha'] ?? null;
		$captchaKeys = $options['extraCaptchaKeys'] ?? [];
		if (is_string($captchaKeys))
		{
			$captchaKeys = json_decode($captchaKeys, true);
		}

		if ($captchaType === 'ReCaptcha' && empty($captchaKeys['reCaptchaSiteKey']))
		{
			// Using ReCAPTCHA with the standard key, change to hCaptcha. We don't have to bother
			// updating the extraCaptchaKeys since the ReCAPTCHA values will be ignored.

			$this->db()->update(
				'xf_option',
				['option_value' => 'HCaptcha'],
				"option_id = 'captcha'"
			);
		}
	}
}