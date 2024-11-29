<?php

namespace XF\Mail\Protocol;

class OAuthPop3 extends \Laminas\Mail\Protocol\Pop3
{
	public function login($user, $password, $tryApop = true)
	{
		$this->request("AUTH XOAUTH2 " . base64_encode("user=$user\1auth=Bearer $password\1\1"));
	}
}