<?php

namespace XF;

use Doctrine\Common\Cache\CacheProvider;

use function intval, is_string, strlen, strval;

class PageCache
{
	const CACHE_VERSION = 1;

	/**
	 * @var Http\Request
	 */
	protected $request;

	/**
	 * @var CacheProvider
	 */
	protected $cache;

	protected $lifetime = 300;

	protected $cacheId;

	protected $recordSessionActivity = true;
	protected $sessionActivity;

	/**
	 * @var \Closure|null
	 */
	protected $cacheIdGenerator = null;

	public function __construct(Http\Request $request, CacheProvider $cache, $lifetime = 300)
	{
		$this->request = $request;
		$this->cache = $cache;
		$this->setLifetime($lifetime);
	}

	public function getRequest()
	{
		return $this->request;
	}

	public function getLifetime()
	{
		return $this->lifetime;
	}

	public function setLifetime($lifetime)
	{
		$this->lifetime = max(10, intval($lifetime));
	}

	public function setRecordSessionActivity($record)
	{
		$this->recordSessionActivity = (bool)$record;
	}

	public function getRecordSessionActivity()
	{
		return $this->recordSessionActivity;
	}

	public function setSessionActivity(array $activity = null)
	{
		$this->sessionActivity = $activity;
	}

	public function setCacheIdGenerator(\Closure $generator = null)
	{
		if ($this->cacheId)
		{
			throw new \LogicException("Cannot change the cache ID generator after one has been created");
		}

		$this->cacheIdGenerator = $generator;
	}

	public function isDefinitelyGuest()
	{
		$sessionCookie = $this->request->getCookie('session');
		$userCookie = $this->request->getCookie('user');

		return (!$sessionCookie && !$userCookie);
	}

	public function isRequestCacheable()
	{
		if (!$this->request->isGet() || $this->request->isXhr())
		{
			return false;
		}

		if ($this->request->getCookie('dbWriteForced'))
		{
			return false;
		}

		return true;
	}

	public function routeMatchesPrefixes(array $prefixes)
	{
		$route = $this->request->getRoutePath();

		foreach ($prefixes AS $prefix)
		{
			if (!$prefix)
			{
				// allow an empty prefix to match the index route
				if (!$route)
				{
					return true;
				}
				continue;
			}

			if ($prefix[0] == '#')
			{
				if (preg_match($prefix, $route))
				{
					return true;
				}
			}
			else if (strpos($route, $prefix) === 0)
			{
				return true;
			}
		}

		return false;
	}

	public function getCachedPage(\XF\App $app)
	{
		$cacheId = $this->getCacheId();

		$result = $this->cache->fetch($cacheId);
		if (!$result)
		{
			return null;
		}

		if (!empty($result['sessionActivity']))
		{
			$activity = $result['sessionActivity'];

			/** @var \XF\Repository\SessionActivity $activityRepo */
			$activityRepo = $app->repository('XF:SessionActivity');
			$activityRepo->updateSessionActivity(
				\XF::visitor()->user_id, $this->request->getIp(),
				$activity['controller'], $activity['action'], $activity['params'], $activity['viewState'],
				$this->request->getRobotName()
			);
		}

		$response = $app->response();
		$response->contentType($result['contentType'], $result['charset']);
		$response->replaceHeaders($result['headers']);
		$response->header('Expires', gmdate('D, d M Y H:i:s', $result['expires']) . ' GMT');
		$response->header('X-XF-Cache-Status', 'HIT');

		$now = \XF::$time;
		$body = str_replace($result['csrfToken'], $app['csrf.token'], $result['body']);
		$body = str_replace(urlencode($result['csrfToken']), urlencode($app['csrf.token']), $body);
		$body = str_replace("now: $result[date],", "now: $now,", $body);
		// accept that some dates might be slightly off

		$response->body($body);

		return $response;
	}

	public function saveToCache(Http\Response $response, \XF\App $app)
	{
		if (!$this->isResponseSaveable($response))
		{
			return false;
		}

		$cacheId = $this->getCacheId();

		$data = [
			'date' => \XF::$time,
			'expires' => \XF::$time + $this->lifetime,
			'contentType' => $response->contentType(),
			'charset' => $response->charset(),
			'headers' => $response->headers(),
			'body' => strval($response->body()),
			'csrfToken' => $app['csrf.token']
		];
		if ($this->recordSessionActivity && $this->sessionActivity)
		{
			$data['sessionActivity'] = $this->sessionActivity;
		}

		$this->cache->save($cacheId, $data, $this->lifetime);
		return true;
	}

	public function isResponseSaveable(Http\Response $response)
	{
		if ($response->httpCode() !== 200)
		{
			return false;
		}

		if ($response->contentType() != 'text/html')
		{
			return false;
		}

		if ($response->getCookiesExcept(['session', 'csrf', 'from_search'], true))
		{
			// if we are setting a cookie other than the session/csrf/from_search, this is likely to be user specific
			return false;
		}

		$body = $response->body();
		if (!is_string($body) || strlen($body) >= 800 * 1024)
		{
			// don't cache files or bodies over 800KB
			return false;
		}

		return true;
	}

	public function getCacheId()
	{
		if (!$this->cacheId)
		{
			$this->cacheId = $this->generateCacheId();
		}

		return $this->cacheId;
	}

	protected function generateCacheId()
	{
		if ($this->cacheIdGenerator)
		{
			$generator = $this->cacheIdGenerator;
			$cacheId = $generator($this->request);
		}
		else
		{
			$options = \XF::options();
			$request = $this->request;

			$styleId = intval($request->getCookie('style_id', 0));
			if (!$styleId)
			{
				$styleId = $options->defaultStyleId;
			}
			$languageId = intval($request->getCookie('language_id', 0));
			if (!$languageId)
			{
				$languageId = $options->defaultLanguageId;
			}

			$consentedCookieGroups = @json_decode(
				$request->getCookie('consent', '[]'),
				true
			);
			sort($consentedCookieGroups);
			$cookieConsentId = md5(implode(',', $consentedCookieGroups));

			$uri = $request->getFullRequestUri();
			$uri = preg_replace('#(\?|&)_debug=[^&]*#', '', $uri);

			$cacheId = 'page_' . sha1($uri) . '_' . strlen($uri) . "_s{$styleId}_l{$languageId}_c{$cookieConsentId}_v" . self::CACHE_VERSION;
		}

		\XF::app()->fire('page_cache_id', [&$cacheId, $this->request]);

		return $cacheId;
	}

	public function hasCacheId()
	{
		return $this->cacheId ? true : false;
	}
}