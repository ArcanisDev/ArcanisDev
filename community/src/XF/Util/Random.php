<?php

namespace XF\Util;

use function in_array, intval, is_string, strlen;

class Random
{
	protected static $sources = null;
	protected static $lastUsed = null;

	public static function getRandomBytes($length)
	{
		if (static::$sources === null)
		{
			static::$sources = static::getAvailableSources();
		}

		$length = intval($length);
		if ($length < 1)
		{
			throw new \LogicException("Must fetch 1 or more random bytes");
		}

		$output = '';
		$remaining = $length;
		$lastUsed = null;

		foreach (static::$sources AS $type => $fn)
		{
			$result = static::$fn($remaining);
			if (is_string($result) && $added = strlen($result))
			{
				$lastUsed = $type;

				$output .= $result;
				$remaining -= $added;
				if ($remaining <= 0)
				{
					break;
				}
			}
		}

		if (strlen($output) < $length)
		{
			throw new \ErrorException("Could not generate random bytes of significant length");
		}

		static::$lastUsed = $lastUsed;

		return substr($output, 0, $length);
	}

	public static function getRandomString($length)
	{
		$random = static::getRandomBytes($length);
		$string = strtr(base64_encode($random), [
			'=' => '',
			"\r" => '',
			"\n" => '',
			'+' => '-',
			'/' => '_'
		]);

		return substr($string, 0, $length);
	}

	/**
	 * Returns the name of the last used source of random data.
	 *
	 * @return string
	 */
	public static function getLastUsedSource()
	{
		if (static::$lastUsed === null)
		{
			static::getRandomBytes(1);
		}

		return static::$lastUsed;
	}

	protected static function _genRandomBytes($length)
	{
		return random_bytes($length);
	}

	protected static $urandomFp;

	protected static function _genUrandom($length)
	{
		if (!static::$urandomFp)
		{
			$fp = @fopen('/dev/urandom', 'rb');
			if (!$fp)
			{
				return false;
			}

			stream_set_read_buffer($fp, 8);
			stream_set_chunk_size($fp, 8);

			static::$urandomFp = $fp;
		}

		return fread(static::$urandomFp, $length);
	}

	protected static function _genMcrypt($length)
	{
		return mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
	}

	protected static function _genOpenSsl($length)
	{
		$random = openssl_random_pseudo_bytes($length);
		// mixing for fork safety https://wiki.openssl.org/index.php/Random_fork-safety
		return static::mixWithInternal($random);
	}

	protected static function _genInternal($length)
	{
		$data = '';
		do
		{
			$data .= static::getInternalRandomData();
		}
		while (strlen($data) < $length);

		return substr($data, 0, $length);
	}

	protected static function mixWithInternal($random)
	{
		$length = strlen($random);
		$internal = static::_genInternal($length);
		$blockSize = 20; // length of the hash, change if hash changed

		$randomParts = str_split($random, $blockSize);
		$internalParts = str_split($internal, $blockSize);

		$output = '';
		foreach ($randomParts AS $i => $randomPart)
		{
			$internalPart = $internalParts[$i];
			if ($i % 2 == 0)
			{
				$output .= hash_hmac('sha1', $internalPart, $randomPart, true);
			}
			else
			{
				$output .= hash_hmac('sha1', $randomPart, $internalPart, true);
			}
		}

		return substr($output, 0, $length);
	}

	protected static $internalRandomState;

	protected static function getInternalRandomData()
	{
		if (!static::$internalRandomState)
		{
			static::$internalRandomState = sha1(
				(
					memory_get_usage()
					. getmypid()
					. serialize($_ENV)
					. serialize($_SERVER)
					. mt_rand()
					. microtime()
					. spl_object_hash(new \stdClass)
				),
				true
			);
		}

		gc_collect_cycles();
		$parts = mt_rand()
			. memory_get_usage()
			. microtime()
			. static::$internalRandomState;
		static::$internalRandomState = sha1($parts, true);

		return substr(static::$internalRandomState, 0, 10);
	}

	public static function getAvailableSources()
	{
		$available = [
			'random_byes' => '_genRandomBytes'
		];

		if (function_exists('mcrypt_create_iv'))
		{
			$available['mcrypt'] = '_genMcrypt';
		}

		if (\XF::$DS === '/')
		{
			$baseDir = @ini_get('open_basedir');
			if ($baseDir)
			{
				$uRandomAllowed = false;
				$dirs = explode(':', $baseDir);
				foreach (['/dev', '/dev/', '/dev/urandom'] AS $c)
				{
					if (in_array($c, $dirs))
					{
						$uRandomAllowed = true;
						break;
					}
				}
			}
			else
			{
				$uRandomAllowed = true;
			}

			if ($uRandomAllowed && @is_readable('/dev/urandom'))
			{
				$available['urandom'] = '_genUrandom';
			}
		}

		if (function_exists('openssl_random_pseudo_bytes'))
		{
			$available['openssl'] = '_genOpenSsl';
		}

		$available['internal'] = '_genInternal';

		return $available;
	}

	public static function removeSource($source)
	{
		if (static::$sources === null)
		{
			static::$sources = static::getAvailableSources();
		}

		unset(static::$sources[$source]);
	}
}