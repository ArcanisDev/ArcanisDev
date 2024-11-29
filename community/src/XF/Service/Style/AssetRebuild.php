<?php

namespace XF\Service\Style;

use XF\Service\AbstractService;

class AssetRebuild extends AbstractService
{
	/**
	 * @var \XF\Tree
	 */
	protected $styleTree;

	protected function setupStyleTree()
	{
		if ($this->styleTree)
		{
			return;
		}

		/** @var \XF\Repository\Style $repo */
		$repo = $this->app->em()->getRepository('XF:Style');
		$this->styleTree = $repo->getStyleTree(false);
	}

	public function rebuildAssetStyleCache()
	{
		$this->rebuildAssetStyleCacheForStyle(0);
		$this->repository('XF:Style')->updateAllStylesLastModifiedDateLater();
	}

	public function rebuildAssetStyleCacheForStyle($styleId)
	{
		$this->setupStyleTree();

		$byStyle = [];
		foreach ($this->styleTree->getFlattened() AS $id => $style)
		{
			foreach ($style['record']->assets AS $key => $path)
			{
				$byStyle[$id][$key] = $path;
			}
		}

		$effectiveAssets = [];

		if ($styleId)
		{
			/** @var \XF\Entity\Style|null $style */
			$style = $this->styleTree->getData($styleId);
			if (!$style)
			{
				// invalid style, nothing to do
				return;
			}

			if (isset($byStyle[$style->parent_id]))
			{
				$effectiveAssets = $byStyle[$style->parent_id];
			}
		}
		// master style doesn't contain any assets by default at this point

		$this->db()->beginTransaction();
		$this->_rebuildAssetStyleCacheForStyle($styleId, $byStyle, $effectiveAssets);
		$this->db()->commit();
	}

	protected function _rebuildAssetStyleCacheForStyle($styleId, array $assetsByStyle, array $effectiveAssets)
	{
		if (isset($assetsByStyle[$styleId]))
		{
			foreach ($assetsByStyle[$styleId] AS $key => $path)
			{
				$effectiveAssets[$key] = $path;
			}
		}

		if ($styleId)
		{
			/** @var \XF\Entity\Style|null $style */
			$style = $this->styleTree->getData($styleId);
			if ($style)
			{
				$style->effective_assets = $effectiveAssets;
				$style->saveIfChanged($saved, true, false);
			}
		}

		foreach ($this->styleTree->childIds($styleId) AS $childId)
		{
			$this->_rebuildAssetStyleCacheForStyle($childId, $assetsByStyle, $effectiveAssets);
		}
	}
}