<?php

namespace XF\Http;


use function call_user_func, call_user_func_array, intval, is_array, is_string, strlen;

class Response
{
	protected $contentType = 'unknown/unknown';
	protected $charset = 'utf-8';
	protected $httpCode = 200;
	protected $compressIfAble = true;
	protected $includeContentLength = true;
	protected $cookieConfig = [
		'path' => '/',
		'domain' => '',
		'prefix' => '',
		'secure' => false,
		'samesite' => null
	];

	protected $headers = [];
	protected $cookies = [];
	protected $body = '';
	protected $compress = false;

	public function setCookieConfig(array $config)
	{
		$this->cookieConfig = array_merge($this->cookieConfig, $config);
	}

	public function getCookiePath()
	{
		return $this->cookieConfig['path'];
	}

	public function getCookieDomain()
	{
		return $this->cookieConfig['domain'];
	}

	public function getCookiePrefix()
	{
		return $this->cookieConfig['prefix'];
	}

	public function contentType($contentType = null, $charset = null)
	{
		if ($contentType === null)
		{
			return $this->contentType;
		}

		if (!preg_match('#^[a-zA-Z0-9]+/[a-zA-Z0-9-+._]+$#', $contentType))
		{
			throw new \InvalidArgumentException('Invalid content type');
		}
		$this->contentType = $contentType;

		if ($charset !== null)
		{
			$this->charset($charset);
		}

		return $this;
	}

	public function charset($charset = null)
	{
		if ($charset === null)
		{
			return $this->charset;
		}

		$this->charset = $charset;

		return $this;
	}

	public function httpCode($httpCode = null)
	{
		if ($httpCode === null)
		{
			return $this->httpCode;
		}

		$this->httpCode = intval($httpCode);

		return $this;
	}

	public function redirect($url = null, $httpCode = null)
	{
		if ($url === null)
		{
			return $this->header('Location');
		}

		$this->header('Location', $url);
		$this->httpCode($httpCode);

		return $this;
	}

	public function header($name, $value = null, $overwrite = true)
	{
		$name = $this->standardizeHeaderName($name);

		if ($value === null)
		{
			return $this->headers[$name] ?? false;
		}

		if ($overwrite || !isset($this->headers[$name]))
		{
			$this->headers[$name] = $value;
		}
		else
		{
			$existingValue = $this->headers[$name];
			if (!is_array($existingValue))
			{
				$newValue = [$existingValue];
			} else
			{
				$newValue = $existingValue;
			}

			if (is_array($value))
			{
				$newValue = array_merge($newValue, $value);
			} else
			{
				$newValue[] = $value;
			}
			$this->headers[$name] = $newValue;
		}

		return $this;
	}

	public function headerExists($name)
	{
		$name = $this->standardizeHeaderName($name);

		return isset($this->headers[$name]);
	}

	public function setDownloadFileName($fileName, $inline = false)
	{
		$type = ($inline ? 'inline' : 'attachment');

		$fileName = str_replace('"', '', $fileName);
		if (preg_match('/[\x80-\xFF]/', $fileName))
		{
			$altNamePart = "; filename*=UTF-8''" . rawurlencode($fileName);
		}
		else
		{
			$altNamePart = '';
		}

		$this->header('Content-Disposition',
			$type . '; filename="' . str_replace('"', '', $fileName) . '"' . $altNamePart,
			true
		);

		return $this;
	}

	protected function isInlineDisplaySafe(string $extension, &$contentType = null): bool
	{
		return (
			\XF\Util\File::isImageInlineDisplaySafe($extension, $contentType)
			|| \XF\Util\File::isVideoInlineDisplaySafe($extension, $contentType)
			|| \XF\Util\File::isAudioInlineDisplaySafe($extension, $contentType)
		);
	}

	public function setAttachmentFileParams($fileName, $extension = null)
	{
		if ($extension === null)
		{
			$extension = pathinfo($fileName, PATHINFO_EXTENSION);
		}

		$extension = strtolower($extension);

		if ($this->isInlineDisplaySafe($extension, $contentType))
		{
			$this->contentType($contentType, '')
				->setDownloadFileName($fileName, true);
		}
		else
		{
			$this->contentType('application/octet-stream', '')
				->setDownloadFileName($fileName);
		}

		return $this;
	}

	public function removeHeader($name)
	{
		$name = $this->standardizeHeaderName($name);
		unset($this->headers[$name]);

		return $this;
	}

	public function headers()
	{
		return $this->headers;
	}

	public function replaceHeaders(array $headers)
	{
		$this->headers = $headers;

		return $this;
	}

	protected function standardizeHeaderName($name)
	{
		$name = preg_replace('#\s+#', ' ', str_replace('-', ' ', trim($name)));
		$name = str_replace(' ', '-', ucwords($name));
		return $name;
	}

	public function body($body = null)
	{
		if ($body === null)
		{
			return $this->body;
		}

		$this->body = $body;

		return $this;
	}

	public function responseFile($fileName)
	{
		return new ResponseFile($fileName);
	}

	public function responseStream($resource, $length = null)
	{
		return new ResponseStream($resource, $length);
	}

	public function compressIfAble($compress = null)
	{
		if ($compress === null)
		{
			return $this->compressIfAble;
		}

		$this->compressIfAble = (bool)$compress;

		return $this;
	}

	public function includeContentLength($use = null)
	{
		if ($use === null)
		{
			return $this->includeContentLength;
		}

		$this->includeContentLength = (bool)$use;

		return $this;
	}

	public function send(Request $request = null)
	{
		$this->prepareForOutput($request);
		$this->sendHeaders();
		$this->sendBody();
	}

	public function prepareForOutput(Request $request = null)
	{
		$this->compress = ($this->compressIfAble && $request && $this->contentIsCompressible($request));
		if ($this->compress)
		{
			$this->header('content-encoding', 'gzip');
			$this->header('vary', 'Accept-Encoding');
		}

		if ($this->header('Location') && ($this->httpCode < 300 || $this->httpCode >= 400))
		{
			$this->httpCode = 302;
		}

		return $this;
	}

	public function getCookie($name, $addPrefix = false)
	{
		if ($addPrefix)
		{
			$name = $this->cookieConfig['prefix'] . $name;;
		}

		return $this->cookies[$name] ?? [];
	}

	public function getCookies()
	{
		return $this->cookies;
	}

	public function getCookiesExcept(array $skip, $addPrefix = false)
	{
		$cookies = $this->cookies;
		foreach ($skip AS $name)
		{
			if ($addPrefix)
			{
				$name = $this->cookieConfig['prefix'] . $name;;
			}
			unset($cookies[$name]);
		}

		return $cookies;
	}

	public function setCookie($name, $value, $lifetime = 0, $secure = null, $httpOnly = true, $sameSite = null)
	{
		$cookieConfig = $this->cookieConfig;

		$path = $cookieConfig['path'];
		$domain = $cookieConfig['domain'];
		$name = $cookieConfig['prefix'] . $name;

		if ($secure === null)
		{
			$secure = $cookieConfig['secure'];
		}

		if ($sameSite === null)
		{
			$sameSite = $cookieConfig['samesite'];
		}

		return $this->setCookieRaw($name, $value, $lifetime, $path, $domain, $secure, $httpOnly, $sameSite);
	}

	public function setCookieRaw($name, $value = '', $lifetime = 0, $path = '/', $domain = '', $secure = false, $httpOnly = true, $sameSite = null)
	{
		if ($value === false)
		{
			$expire = \XF::$time - 86400 * 365;
			$value = '';
		}
		else
		{
			$expire = ($lifetime ? (\XF::$time + $lifetime) : 0);
		}

		$this->cookies[$name] = [$name, $value, $expire, $path, $domain, $secure, $httpOnly, $sameSite];

		return $this;
	}

	public function removeCookie($name)
	{
		unset($this->cookies[$name]);

		return $this;
	}

	public function sendHeaders()
	{
		foreach ($this->headers AS $key => $value)
		{
			if (is_array($value))
			{
				foreach ($value AS $innerValue)
				{
					header("$key: $innerValue", false);
				}
			} else
			{
				header("$key: $value", false);
			}
		}

		$sendCode = $this->httpCode;

		if ($this->contentType)
		{
			header('Content-Type: ' . $this->contentType
			. ($this->charset ? '; charset=' . $this->charset : ''), true, $sendCode);
			$sendCode = false;
		}

		if ($sendCode)
		{
			header('X-No-Headers: true', false, $sendCode);
		}

		// TODO: we can set cookies as headers directly if lack of
		//  samesite support below PHP 7.3 becomes problematic
		foreach ($this->cookies AS $cookie)
		{
			if (PHP_VERSION_ID < 70300)
			{
				array_pop($cookie); // no SameSite support here

				call_user_func_array('setcookie', $cookie);
			}
			else
			{
				$name = array_shift($cookie);
				$value = array_shift($cookie);

				$options = array_combine([
					'expires',
					'path',
					'domain',
					'secure',
					'httponly',
					'samesite'
				], $cookie);

				if (empty($options['samesite']))
				{
					unset($options['samesite']);
				}

				call_user_func('setcookie', $name, $value, $options);
			}
		}
	}

	public function sendBody()
	{
		if ($this->body instanceof ResponseFile)
		{
			if ($this->includeContentLength)
			{
				header('Content-Length: ' . $this->body->getLength());
			}

			$this->body->output();
		}
		else if ($this->body instanceof ResponseStream)
		{
			if ($this->includeContentLength)
			{
				$length = $this->body->getLength();
				if ($length !== null)
				{
					header('Content-Length: ' . $length);
				}
			}

			$this->body->output();
		}
		else
		{
			if ($this->compress)
			{
				$toPrint = gzencode($this->body, 1);
			}
			else
			{
				$toPrint = $this->body;
			}

			if ($this->includeContentLength)
			{
				header('Content-Length: ' . strlen($toPrint));
			}

			echo $toPrint;
		}
	}

	public function contentIsCompressible(Request $request)
	{
		if (
			!is_string($this->body)
			|| !preg_match('#^(?:text/|application/(?:json|xml|rss\+xml)$)#i', $this->contentType)
			|| strpos($request->getServer('HTTP_ACCEPT_ENCODING', ''), 'gzip') === false
		)
		{
			return false;
		}

		if (!function_exists('gzencode'))
		{
			return false;
		}

		return (strlen($this->body) >= 20);
	}
}