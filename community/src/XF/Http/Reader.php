<?php

namespace XF\Http;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriResolver;
use Psr\Http\Message\ResponseInterface;
use XF\Util\Ip;

use function defined, in_array, intval, is_string, strval;

class Reader
{
	const ERROR_TIME = 1;
	const ERROR_SIZE = 2;
	const ERROR_CONNECTION = 3;

	/**
	 * @var ClientInterface
	 */
	protected $clientTrusted;

	/**
	 * @var ClientInterface
	 */
	protected $clientUntrusted;

	protected $untrustedAllowedSchemes = ['http', 'https'];
	protected $untrustedAllowedPorts = [80, 443];

	protected $lastLocation;

	public function __construct(ClientInterface $clientTrusted, ClientInterface $clientUntrusted)
	{
		$this->clientTrusted = $clientTrusted;
		$this->clientUntrusted = $clientUntrusted;
	}

	/**
	 * @param string $url
	 * @param array $limits
	 * @param null  $saveTo
	 * @param array $options
	 * @param null  $error
	 *
	 * @return ResponseInterface|null
	 */
	public function get($url, array $limits = [], $saveTo = null, array $options = [], &$error = null)
	{
		return $this->_request($this->clientTrusted, 'get', $url, $limits, $saveTo, $options, $error);
	}

	/**
	 * @param string $method
	 * @param string $url
	 * @param array $limits
	 * @param null  $saveTo
	 * @param array $options
	 * @param null  $error
	 *
	 * @return ResponseInterface|null
	 */
	public function request($method, $url, array $limits = [], $saveTo = null, array $options = [], &$error = null)
	{
		return $this->_request($this->clientTrusted, $method, $url, $limits, $saveTo, $options, $error);
	}

	/**
	 * @param string $url
	 * @param array $limits
	 * @param null  $saveTo
	 * @param array $options
	 * @param null  $error
	 *
	 * @return ResponseInterface|null
	 */
	public function getUntrusted($url, array $limits = [], $saveTo = null, array $options = [], &$error = null)
	{
		return $this->requestUntrusted('get', $url, $limits, $saveTo, $options, $error);
	}

	/**
	 * @param string $method
	 * @param string $url
	 * @param array $limits
	 * @param null  $saveTo
	 * @param array $options
	 * @param null  $error
	 *
	 * @return ResponseInterface|null
	 */
	public function requestUntrusted($method, $url, array $limits = [], $saveTo = null, array $options = [], &$error = null)
	{
		$options['allow_redirects'] = false;

		$requests = 0;

		do
		{
			$continue = false;
			$requests++;

			$url = preg_replace('/#.*$/', '', $url);
			if (!$this->isRequestableUntrustedUrlExtended($url, $data, $untrustedError))
			{
				$error = "The URL is not requestable ($untrustedError)";
				return null;
			}

			if (
				defined('CURLOPT_CONNECT_TO') &&
				$this->clientUntrusted->getConfig('proxy') === null
			)
			{
				$ips = array_merge(
					$data['ipv4s'],
					array_map(
						function ($ipv6) { return '[' . $ipv6 . ']'; },
						$data['ipv6s']
					)
				);
				foreach ($ips AS $ip)
				{
					$options['curl'][CURLOPT_CONNECT_TO] = ["::{$ip}:"];

					$response = $this->_request(
						$this->clientUntrusted,
						$method,
						$url,
						$limits,
						$saveTo,
						$options,
						$error
					);

					if ($response !== null)
					{
						break;
					}
				}
			}
			else
			{
				$response = $this->_request(
					$this->clientUntrusted,
					$method,
					$url,
					$limits,
					$saveTo,
					$options,
					$error
				);
			}

			if (
				$response instanceof ResponseInterface
				&& $response->getStatusCode() >= 300
				&& $response->getStatusCode() < 400
				&& ($location = $response->getHeader('Location'))
			)
			{
				$location = reset($location);
				if ($location && $location[0] == '/')
				{
					// sometimes we get redirects to a path that includes a colon and PHP doesn't parse that
					// as you would expect
					$location = preg_replace_callback(
						'#^(.*)(\?|$)#U',
						function ($match)
						{
							return str_replace(':', '%3A', $match[0]);
						},
						$location
					);
				}

				try
				{
					$location = new Uri($location);
				}
				catch (\InvalidArgumentException $e)
				{
					$error = "The URL returned a redirect to an invalid URL (" . $e->getMessage() . ")";
					return null;
				}

				if (!Uri::isAbsolute($location))
				{
					$originalUrl = new Uri($url);
					$location = UriResolver::resolve($originalUrl, $location);
				}
				$location = strval($location);

				if ($location != $url)
				{
					$url = $location;
					$this->lastLocation = $location;
					$continue = true;
				}
			}
		}
		while ($continue && $requests < 5);

		return $response;
	}

	public function getLastLocation()
	{
		return $this->lastLocation;
	}

	public function isRequestableUntrustedUrl($url, &$error = null)
	{
		return $this->isRequestableUntrustedUrlExtended($url, $data, $error);
	}

	public function isRequestableUntrustedUrlExtended($url, &$data = [], &$error = null)
	{
		$parts = @parse_url($url);

		if (!$parts || empty($parts['scheme']) || empty($parts['host']))
		{
			$error = 'invalid';
			return false;
		}

		if (!in_array(strtolower($parts['scheme']), $this->untrustedAllowedSchemes))
		{
			$error = 'scheme';
			return false;
		}

		if (!empty($parts['port']) && !in_array($parts['port'], $this->untrustedAllowedPorts))
		{
			$error = 'port';
			return false;
		}

		if (!empty($parts['user']) || !empty($parts['pass']))
		{
			$error = 'userpass';
			return false;
		}

		if (strpos($parts['host'], '[') !== false)
		{
			$error = 'ipv6';
			return false;
		}

		if (preg_match('/^[0-9]+$/', $parts['host']))
		{
			$error = 'ipv4int';
			return false;
		}

		$hasValidIp = false;

		$ips = @gethostbynamel($parts['host']) ?: [];
		if ($ips)
		{
			foreach ($ips AS $ip)
			{
				if ($this->isLocalIpv4($ip))
				{
					$error = "local: $ip";
					return false;
				}
				else
				{
					$hasValidIp = true;
				}
			}
		}

		$ipv6s = [];
		if (function_exists('dns_get_record') && defined('DNS_AAAA'))
		{
			$hasIpv6 = defined('AF_INET6');
			if (!$hasIpv6 && function_exists('curl_version') && defined('CURL_VERSION_IPV6'))
			{
				$version = curl_version();
				if ($version['features'] & CURL_VERSION_IPV6)
				{
					$hasIpv6 = true;
				}
			}

			if ($hasIpv6)
			{
				$ipv6s = @dns_get_record($parts['host'], DNS_AAAA) ?: [];
				if ($ipv6s)
				{
					foreach ($ipv6s AS $ipv6)
					{
						$ip = $ipv6['ipv6'];
						if ($this->isLocalIpv6($ip))
						{
							$error = "local: $ip";
							return false;
						}
						else
						{
							$hasValidIp = true;
						}
					}
				}
			}
		}

		if (!$hasValidIp)
		{
			$error = 'dns';
			return false;
		}

		$data = [
			'scheme' => $parts['scheme'],
			'host' => $parts['host'],
			'port' => $parts['port'] ?? null,
			'ipv4s' => $ips,
			'ipv6s' => array_column($ipv6s, 'ipv6')
		];
		return true;
	}

	protected function isLocalIpv4($ip)
	{
		$ip = @inet_pton($ip);

		$ranges = [
			'0.0.0.0' => 8,
			'10.0.0.0' => 8,
			'100.64.0.0' => 10,
			'127.0.0.0' => 8,
			'169.254.0.0' => 16,
			'172.16.0.0' => 12,
			'192.0.0.0' => 24,
			'192.0.2.0' => 24,
			'192.88.99.0' => 24,
			'192.168.0.0' => 16,
			'198.18.0.0' => 15,
			'198.51.100.0' => 24,
			'203.0.113.0' => 24,
			'244.0.0.0' => 4,
			'233.252.0.0' => 24,
			'240.0.0.0' => 4,
			'255.255.255.255' => 32
		];

		foreach ($ranges AS $rangeIp => $cidr)
		{
			$rangeIp = inet_pton($rangeIp);
			if (Ip::ipMatchesCidrRange($ip, $rangeIp, $cidr))
			{
				return true;
			}
		}

		return false;
	}

	protected function isLocalIpv6($ip)
	{
		$ip = inet_pton($ip);
		if (!Ip::ipMatchesCidrRange($ip, inet_pton('2000::'), 3))
		{
			return true;
		}

		$ranges = [
			'2001::' => 23,
			'2001:db8::' => 32,
			'2002::' => 16
		];
		foreach ($ranges AS $rangeIp => $cidr)
		{
			$rangeIp = inet_pton($rangeIp);
			if (Ip::ipMatchesCidrRange($ip, $rangeIp, $cidr))
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * @param \GuzzleHttp\Client $client
	 * @param string $url
	 * @param array $limits
	 * @param null|string $saveTo
	 * @param array $options
	 * @param mixed $error
	 *
	 * @return ResponseInterface|null
	 */
	protected function _get(ClientInterface $client,
		$url, array $limits = [], $saveTo = null, array $options = [], &$error = null
	)
	{
		return $this->_request($client, 'get', $url, $limits, $saveTo, $options, $error);
	}

	/**
	 * @param \GuzzleHttp\Client $client
	 * @param string $method
	 * @param string $url
	 * @param array $limits
	 * @param null|string $saveTo
	 * @param array $options
	 * @param mixed $error
	 *
	 * @return ResponseInterface|null
	 */
	protected function _request(ClientInterface $client,
		$method, $url, array $limits = [], $saveTo = null, array $options = [], &$error = null
	)
	{
		$limits = array_merge([
			'time' => -1,
			'bytes' => -1
		], $limits);
		$maxTime = intval($limits['time']);
		$maxSize = intval($limits['bytes']);

		$options = array_merge([
			'decode_content' => 'identity',
			'timeout' => $maxTime > -1 ? $maxTime + 1 : 30,
			'connect_timeout' => 3,
			'exceptions' => false
		], $options);

		if (!$saveTo)
		{
			$saveTo = 'php://temp';
		}

		if (is_string($saveTo))
		{
			$closeOnError = true;
			$saveTo = fopen($saveTo, 'w+');
		}
		else
		{
			$closeOnError = false;
		}

		$saveTo = \GuzzleHttp\Psr7\stream_for($saveTo);
		$saveTo = new Stream($saveTo, $maxSize, $maxTime);

		$options['save_to'] = $saveTo;

		try
		{
			$response = $client->request($method, $url, $options);
		}
		catch (RequestException $e)
		{
			if ($saveTo->hasError($errorCode))
			{
				$error = $this->getErrorMessage($errorCode);
			}
			else
			{
				$error = $e->getMessage();
			}

			if ($closeOnError)
			{
				$saveTo->close();
			}

			return null;
		}
		catch (\InvalidArgumentException $e)
		{
			return null;
		}

		if ($saveTo->hasError($errorCode))
		{
			$error = $this->getErrorMessage($errorCode);

			if ($closeOnError)
			{
				$saveTo->close();
			}

			return null;
		}

		return $response;
	}

	public function getErrorMessage($code)
	{
		switch ($code)
		{
			case self::ERROR_SIZE:
				return \XF::phraseDeferred('file_is_too_large');

			case self::ERROR_TIME:
				return \XF::phrase('server_was_too_slow');

			default:
				return \XF::phraseDeferred('unknown');
		}
	}

	/**
	 * @param array $contentType
	 * @return string
	 */
	public function getCharset(array $contentType)
	{
		$charset = null;

		if ($contentType)
		{
			$parts = explode(';', implode(';', $contentType), 2);

			$type = trim($parts[0]);
			if ($type != 'text/html')
			{
				return '';
			}

			if (isset($parts[1]) && preg_match('/charset=([-a-z0-9_]+)/i', trim($parts[1]), $match))
			{
				$charset = $match[1];
			}
		}

		return $charset;
	}
}