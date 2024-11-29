<?php

namespace XF\Repository;

use XF\Mvc\Entity\Repository;

class ThreadType extends Repository
{
	/**
	 * Filters thread types to those that can be converted individually (non-bulk)
	 */
	const FILTER_SINGLE_CONVERTIBLE = 0x1;

	/**
	 * Filters thread type to those that can be bulk converted.
	 */
	const FILTER_BULK_CONVERTIBLE = 0x2;

	public function rebuildThreadTypeCache(): array
	{
		$cache = $this->db()->fetchPairs("
			SELECT tt.thread_type_id, tt.handler_class
			FROM xf_thread_type AS tt
			LEFT JOIN xf_addon AS addon ON (tt.addon_id = addon.addon_id)
			WHERE (addon.active = 1 OR tt.addon_id = '')
		");

		\XF::registry()->set('threadTypes', $cache);

		return $cache;
	}

	public function getThreadTypeListData(array $threadTypeIds = null, int $filters = 0): array
	{
		if ($threadTypeIds === null)
		{
			$threadTypeIds = array_keys($this->app()->container('threadTypes'));
		}

		$listData = [];

		foreach ($threadTypeIds AS $threadTypeId)
		{
			if ($typeHandler = $this->app()->threadType($threadTypeId))
			{
				if ($filters & self::FILTER_SINGLE_CONVERTIBLE && !$typeHandler->canConvertThreadToType(false))
				{
					continue;
				}

				if ($filters & self::FILTER_BULK_CONVERTIBLE && !$typeHandler->canConvertThreadToType(true))
				{
					continue;
				}

				$listData[$threadTypeId] = $typeHandler->getTypeTitle();
			}
		}

		return $listData;
	}
}