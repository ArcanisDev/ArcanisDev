<?php

namespace XF\Mail;

class SmtpTransport extends \Swift_SmtpTransport
{
	public function __construct($host = 'localhost', $port = 25, $encryption = null)
	{
		// workaround a PHP 8.1 bug in swiftmailer
		if ($encryption === null)
		{
			$encryption = '';
		}

		parent::__construct($host, $port, $encryption);
	}

	public function stop()
	{
		parent::stop();

		// Workaround for https://github.com/swiftmailer/swiftmailer/issues/1338
		$this->pipeline = [];
	}
}