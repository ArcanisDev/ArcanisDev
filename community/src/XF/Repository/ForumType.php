<?php

namespace XF\Repository;

use XF\Mvc\Entity\Repository;

class ForumType extends Repository
{
	/**
	 * Filter to only include types that are manually creatable
	 */
	const FILTER_MANUAL_CREATE = 0x1;

	/**
	 * @return \XF\ForumType\AbstractHandler[]
	 */
	public function getForumTypeHandlers(): array
	{
		$handlers = [];
		$app = $this->app();

		foreach ($app->forumTypes AS $typeId => $null)
		{
			$forumType = $app->forumType($typeId);

			$handlers[$typeId] = $forumType;
		}

		return $handlers;
	}

	/**
	 * Gets a printable list of forum type info.
	 *
	 * @param int $filters Bit mask of FILTER_* constants attached to this repository. Only include types that match filters.
	 *
	 * @return array [$typeId] => [title: string/phrase, description: string/phrase]
	 */
	public function getForumTypesList($filters = 0): array
	{
		$handlers = $this->getForumTypeHandlers();

		if ($filters)
		{
			$handlers = array_filter($handlers, function(\XF\ForumType\AbstractHandler $handler) use ($filters)
			{
				if ($filters & self::FILTER_MANUAL_CREATE && !$handler->canManuallyCreateForum())
				{
					return false;
				}

				return true;
			});
		}

		uasort($handlers, function(\XF\ForumType\AbstractHandler $a, \XF\ForumType\AbstractHandler $b)
		{
			return $a->getDisplayOrder() <=> $b->getDisplayOrder();
		});

		$info = [];
		foreach ($handlers AS $typeId => $handler)
		{
			$info[$typeId] = [
				'title' => $handler->getTypeTitle(),
				'description' => $handler->getTypeDescription()
			];
		}

		return $info;
	}

	public function rebuildForumTypeCache(): array
	{
		$cache = $this->db()->fetchPairs("
			SELECT ft.forum_type_id, ft.handler_class
			FROM xf_forum_type AS ft
			LEFT JOIN xf_addon AS addon ON (ft.addon_id = addon.addon_id)
			WHERE (addon.active = 1 OR ft.addon_id = '')
		");

		\XF::registry()->set('forumTypes', $cache);

		return $cache;
	}
}