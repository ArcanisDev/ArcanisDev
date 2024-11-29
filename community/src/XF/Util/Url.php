<?php

namespace XF\Util;

class Url
{
	/**
	 * Attempt to convert an URL string into its IDNA ASCII form.
	 */
	public static function urlToAscii(string $url, bool $throw = true): string
	{
		try
		{
			$parts = static::parseUrl($url, $throw);
		}
		catch (\InvalidArgumentException $e)
		{
			if ($throw)
			{
				throw $e;
			}

			return $url;
		}

		if (isset($parts['host']))
		{
			$host = idn_to_ascii($parts['host']);
			if ($host === false)
			{
				if ($throw)
				{
					throw new \InvalidArgumentException(
						'The URL could not be converted to ASCII'
					);
				}

				$host = $parts['host'];
			}

			$parts['host'] = $host;
		}

		return static::unparseUrl($parts);
	}

	/**
	 * Attempt to convert an URL string into its IDNA Unicode form.
	 */
	public static function urlToUtf8(string $url, bool $throw = true): string
	{
		try
		{
			$parts = static::parseUrl($url, $throw);
		}
		catch (\InvalidArgumentException $e)
		{
			if ($throw)
			{
				throw $e;
			}

			return $url;
		}

		if (isset($parts['host']))
		{
			$host = idn_to_utf8($parts['host']);
			if ($host === false)
			{
				if ($throw)
				{
					throw new \InvalidArgumentException(
						'The URL could not be converted to UTF-8'
					);
				}

				$host = $parts['host'];
			}

			$parts['host'] = $host;
		}

		return static::unparseUrl($parts);
	}

	protected static function parseUrl(string $url): array
	{
		$parts = parse_url($url);
		if ($parts === false)
		{
			throw new \InvalidArgumentException('The URL could not be parsed');
		}

		return $parts;
	}

	protected static function unparseUrl(array $parts): string
	{
		return (isset($parts['scheme']) ? $parts['scheme'] . ':' : '')
			. (isset($parts['user']) || isset($parts['host']) ? '//' : '')
			. ($parts['user'] ?? '')
			. (isset($parts['pass']) ? ':' . $parts['pass'] : '')
			. (isset($parts['user']) ? '@' : '')
			. ($parts['host'] ?? '')
			. (isset($parts['port']) ? ':' . $parts['port'] : '')
			. ($parts['path'] ?? '')
			. (isset($parts['query'] ) ? '?' . $parts['query'] : '')
			. (isset($parts['fragment'] ) ? '#' . $parts['fragment'] : '');
	}

	/**
	 * Attempt to convert an email string into its IDNA ASCII form.
	 */
	public static function emailToAscii(string $email, bool $throw = true)
	{
		if (!preg_match('/(.+)@(.+)$/i', $email, $matches))
		{
			if ($throw)
			{
				throw new \InvalidArgumentException(
					'The email could not be converted to ASCII'
				);
			}

			return $email;
		}

		$local = $matches[1];
		$domain = $matches[2];

		$domain = idn_to_ascii($domain);
		if ($domain === false)
		{
			if ($throw)
			{
				throw new \InvalidArgumentException(
					'The email could not be converted to ASCII'
				);
			}

			$domain = $matches[2];
		}

		return $local . '@' . $domain;
	}

	/**
	 * Attempt to convert an email string into its IDNA Unicode form.
	 */
	public static function emailToUtf8(string $email, bool $throw = true)
	{
		if (!preg_match('/(.+)@(.+)$/i', $email, $matches))
		{
			if ($throw)
			{
				throw new \InvalidArgumentException(
					'The email could not be converted to UTF-8'
				);
			}

			return $email;
		}

		$local = $matches[1];
		$domain = $matches[2];

		$domain = idn_to_utf8($matches[2]);
		if ($domain === false)
		{
			if ($throw)
			{
				throw new \InvalidArgumentException(
					'The email could not be converted to UTF-8'
				);
			}

			$domain = $matches[2];
		}

		return $local . '@' . $domain;
	}
}