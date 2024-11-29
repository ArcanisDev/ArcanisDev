<?php

namespace XF\SubContainer;

class Proxy extends AbstractSubContainer
{
	public function initialize()
	{
		$container = $this->container;

		$container['linker'] = function($c)
		{
			$options = $this->app->options();
			$types = [
				'image' => !empty($options->imageLinkProxy['images']),
				'link' => !empty($options->imageLinkProxy['links'])
			];
			$secret = $this->app->config('globalSalt') . $options->imageLinkProxyKey;

			$linker = new \XF\Proxy\Linker(
				$c['linker.format'],
				$types,
				$secret,
				$this->app['request.pather']
			);

			$imageProxyBypass = $options->imageProxyBypass;
			$bypassType = $imageProxyBypass['bypassType'] ?? null;
			switch ($bypassType)
			{
				case 'https':
					$linker->setBypassDomains('image', ['*']);
					break;

				case 'domains':
					$domains = \XF\Util\Arr::stringToArray($imageProxyBypass['bypassDomains'], '/\r?\n/');
					$linker->setBypassDomains('image', $domains);
					break;
			}

			return $linker;
		};

		$container['linker.format'] = function($c)
		{
			return $this->app->config('proxyUrlFormat');
		};

		$container['controller'] = function($c)
		{
			return new \XF\Proxy\Controller($this->app, $c['linker'], $this->app->request());
		};
	}

	/**
	 * @return \XF\Proxy\Linker
	 */
	public function linker()
	{
		return $this->container['linker'];
	}

	public function generate($type, $url)
	{
		return $this->linker()->generate($type, $url);
	}

	public function generateExtended($type, $url, array $options = [])
	{
		return $this->linker()->generateExtended($type, $url, $options);
	}

	public function hash($url)
	{
		return $this->linker()->hash($url);
	}

	/**
	 * @return \XF\Proxy\Controller
	 */
	public function controller()
	{
		return $this->container['controller'];
	}
}