<?php

$phpVersion = phpversion();
if (version_compare($phpVersion, '7.0.0', '<'))
{
	die("PHP 7.0.0 or newer is required. $phpVersion does not meet this requirement. Please ask your host to upgrade PHP.");
}

$rootDir = realpath(__DIR__ . '/..');
chdir($rootDir);
require($rootDir . '/src/XF.php');

XF::start($rootDir);
XF::runApp('XF\Install\App');