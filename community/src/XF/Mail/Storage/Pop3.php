<?php

namespace XF\Mail\Storage;

use function intval;

class Pop3 extends \Laminas\Mail\Storage\Pop3
{
	public static function setupFromHandler(array $handler): self
	{
		$config = [
			'host' => $handler['host'],
			'port' => $handler['port'] ? intval($handler['port']) : null,
			'ssl' => $handler['encryption'] ? strtoupper($handler['encryption']) : false,
			'user' => $handler['username'],
			'password' => $handler['password']
		];

		if (!empty($handler['oauth']))
		{
			/** @var array|\XF\Mail\Protocol\OAuthPop3 $protocol */
			$protocol = new \XF\Mail\Protocol\OAuthPop3($config['host'], $config['port'], $config['ssl']);
		}
		else
		{
			$protocol = new \Laminas\Mail\Protocol\Pop3($config['host'], $config['port'], $config['ssl']);
		}

		$protocol->login($config['user'], $config['password'], true);

		return new self($protocol);
	}
}