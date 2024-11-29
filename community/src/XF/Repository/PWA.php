<?php

namespace XF\Repository;

use XF\Entity\Style;
use XF\Entity\StylePropertyMap;
use XF\Mvc\Entity\AbstractCollection;
use XF\Mvc\Entity\Repository;

class PWA extends Repository
{
	public function isInstallable(): bool
	{
		$request = $this->app()->request();
		if (!$request->isSecure() && !$request->isHostLocal())
		{
			return false;
		}

		$options = $this->options();
		if (!$options->boardTitle && !$options->boardShortTitle)
		{
			return false;
		}

		$style = $this->app()->style(0);
		if (
			!$style->getProperty('publicIconUrl') ||
			!$style->getProperty('publicIconUrlLarge')
		)
		{
			return false;
		}

		return true;
	}

	/**
	 * @return StylePropertyMap[]|\XF\Mvc\Entity\AbstractCollection
	 */
	public function getApplicableStylePropertyMaps(Style $style): AbstractCollection
	{
		$stylePropertyNames = $this->getApplicableStylePropertyNames();
		$stylePropertyOrders = array_flip($stylePropertyNames);

		$stylePropertyRepo = $this->repository('XF:StyleProperty');
		$stylePropertyMapFinder = $stylePropertyRepo->findPropertyMapForEditing($style)
			->where('property_name', $stylePropertyNames);
		$stylePropertyMaps = $stylePropertyMapFinder->fetch();

		$stylePropertyMaps = $stylePropertyMaps->toArray();
		uasort(
			$stylePropertyMaps,
			function(StylePropertyMap $a, StylePropertyMap $b) use ($stylePropertyOrders)
			{
				return $stylePropertyOrders[$a->property_name] <=> $stylePropertyOrders[$b->property_name];
			}
		);
		return $this->em->getBasicCollection($stylePropertyMaps);
	}

	/**
	 * @return string[]
	 */
	public function getApplicableStylePropertyNames(): array
	{
		return [
			'metaThemeColor',
			'pageBg',
			'publicIconUrl',
			'publicIconUrlLarge',
			'publicIconsMaskable'
		];
	}
}
