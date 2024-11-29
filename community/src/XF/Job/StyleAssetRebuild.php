<?php

namespace XF\Job;

class StyleAssetRebuild extends AbstractJob
{
	public function run($maxRunTime)
	{
		/** @var \XF\Service\Style\AssetRebuild $rebuildService */
		$rebuildService = $this->app->service('XF:Style\AssetRebuild');

		$rebuildService->rebuildAssetStyleCache();

		return $this->complete();
	}

	public function getStatusMessage()
	{
		$actionPhrase = \XF::phrase('rebuilding');
		$typePhrase = \XF::phrase('style_assets');
		return sprintf('%s... %s', $actionPhrase, $typePhrase);
	}

	public function canCancel()
	{
		return false;
	}

	public function canTriggerByChoice()
	{
		return false;
	}
}