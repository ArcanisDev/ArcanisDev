<?php

namespace XF\Util;

class Exec
{
	/**
	 * Helper to run command via exec with properly escaped arguments.
	 * This function will wait for the command to finish.
	 *
	 * Note: This function should only be called if you can guarantee that exec is available.
	 *
	 * @param          $command
	 * @param int|null $resultCode
	 * @param          ...$args
	 *
	 * @return array
	 */
	public static function executeCommand($command, int &$resultCode = null, ...$args): array
	{
		return static::_executeCommand($command, false, $resultCode, $args);
	}

	/**
	 * Helper to run command via exec with properly escaped arguments asynchronously.
	 * This function will execute the command silently with no output.
	 * There is no indication of success with this method.
	 *
	 * Note: This function should only be called if you can guarantee that exec is available.
	 *
	 * @param $command
	 * @param ...$args
	 */
	public static function executeAsyncCommand($command, ...$args)
	{
		static::_executeCommand($command, true, $null, $args);
	}

	protected static function _executeCommand($command, bool $async, int &$resultCode = null, array $args = []): array
	{
		static::assertCanExecuteCommand($async);

		if ($args)
		{
			$args = array_map('escapeshellarg', $args);

			$command = vsprintf($command, $args);
		}

		$output = [];

		if ($async)
		{
			if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') // Windows
			{
				if (class_exists('COM', false))
				{
					$shell = new \COM("WScript.Shell");
					$shell->Run($command, 0, false);
				}
				else
				{

					pclose(popen("start \"XF\" /B $command", 'r'));
				}
			}
			else
			{
				exec("nohup $command > /dev/null 2> /dev/null &");
			}
		}
		else
		{
			exec($command, $output, $resultCode);
		}

		return $output;
	}

	protected static function assertCanExecuteCommand(bool $async)
	{
		if ($async)
		{
			if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') // Windows
			{
				if (!class_exists('COM', false))
				{
					if (!function_exists('popen') || !function_exists('pclose'))
					{
						throw new \BadFunctionCallException("Cannot run specified command as class COM or functions pclose/popen are unavailable on this system.");
					}
				}
			}
			else
			{
				if (!function_exists('exec'))
				{
					throw new \BadFunctionCallException("Cannot run specified command as exec is unavailable on this system.");
				}
			}
		}
		else
		{
			if (!function_exists('exec'))
			{
				throw new \BadFunctionCallException("Cannot run specified command as exec is unavailable on this system.");
			}
		}
	}
}