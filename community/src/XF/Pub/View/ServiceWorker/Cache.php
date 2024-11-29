<?php

namespace XF\Pub\View\ServiceWorker;

use XF\Mvc\View;

class Cache extends View
{
	/**
	 * @return array
	 */
	public function renderJson()
	{
		$files = $this->params['files'];

		return [
			'key' => \XF::visitor()->getClientSideCacheKey(),
			'files' => $files
		];
	}
}
