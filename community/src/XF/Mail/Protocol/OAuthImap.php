<?php

namespace XF\Mail\Protocol;

class OAuthImap extends \Laminas\Mail\Protocol\Imap
{
	public function login($user, $password)
	{
		$tokens = [
			'XOAUTH2', base64_encode(
				'user=' . $user . "\1" .
				'auth=Bearer ' . $password . "\1\1"
			)
		];
		return $this->requestAndResponse('AUTHENTICATE', $tokens, true);
	}
}