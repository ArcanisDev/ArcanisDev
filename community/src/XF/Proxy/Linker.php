<?php

namespace XF\Proxy;

class Linker
{
	protected $types = [];
	protected $secret = '';
	protected $pather;

	// example: proxy.php?{type}={url}&hash={hash}
	protected $linkFormat = '';

	/**
	 * @var array[]
	 */
	protected $bypassDomains;

	public function __construct($linkFormat, array $types, $secret, callable $pather)
	{
		$this->linkFormat = $linkFormat;
		$this->types = $types;
		$this->secret = $secret;
		$this->pather = $pather;
	}

	/**
	 * @param string $type
	 * @param array  $bypass List of domains to bypass, use * as a wildcard (a value of * will bypass everything)
	 */
	public function setBypassDomains(string $type, array $bypass)
	{
		$this->bypassDomains[$type] = array_filter($bypass, 'strlen');
	}

	public function generate($type, $url)
	{
		if (empty($this->types[$type]))
		{
			return null;
		}

		if ($this->isUrlBypassed($type, $url))
		{
			return null;
		}

		$link = strtr($this->linkFormat, [
			'{type}' => urlencode($type),
			'{url}' => urlencode($url),
			'{hash}' => urlencode($this->hash($url))
		]);

		if ($this->pather)
		{
			$pather = $this->pather;
			$link = $pather($link, 'base');
		}

		return $link;
	}

	public function generateExtended($type, $url, array $options = [])
	{
		$url = $this->generate($type, $url);

		if ($url === null)
		{
			return null;
		}

		if ($options)
		{
			$queryString = http_build_query($options);
			$url .= (strpos($url, '?') !== false ? '&' : '?') . $queryString;
		}

		return $url;
	}

	public function isTypeEnabled($type)
	{
		return !empty($this->types[$type]);
	}

	public function isUrlBypassed(string $type, string $url): bool
	{
		$bypassDomains = $this->bypassDomains[$type] ?? null;
		if (!$bypassDomains)
		{
			return false;
		}

		$urlParsed = parse_url($url);
		if (!$urlParsed)
		{
			return false;
		}

		if (!isset($urlParsed['host'], $urlParsed['scheme']))
		{
			return false;
		}

		if (strtolower($urlParsed['scheme']) !== 'https')
		{
			// always proxy non-https links
			return false;
		}

		$host = strtolower($urlParsed['host']);

		foreach ($bypassDomains AS $bypassDomain)
		{
			if ($bypassDomain == '*')
			{
				return true;
			}

			if ($bypassDomain[0] != '/')
			{
				$regex = '#(^|\.)' . preg_quote($bypassDomain, '#') . '$#i';
			}
			else
			{
				if (preg_match('/\W[\s\w]*e[\s\w]*$/', $bypassDomain))
				{
					// can't run a /e regex
					continue;
				}

				$regex = $bypassDomain;
			}

			try
			{
				if (preg_match($regex, $host))
				{
					return true;
				}
			}
			catch (\ErrorException $e) {}
		}

		return false;
	}

	public function verifyHash($url, $hash)
	{
		return $this->hash($url) === $hash;
	}

	public function hash($url)
	{
		return hash_hmac('md5', $url, $this->secret);
	}
}