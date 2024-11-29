<?php

namespace XF\Service;

use XF\Mvc\Entity\Entity;

use function count;

trait ModerationAlertSendableTrait
{
	/**
	 * @var bool[]
	 */
	protected $wasVisibleForAlert = [];

	/**
	 * @var bool[]
	 */
	protected $isVisibleForAlert = [];

	public static function cacheContentPermissions(
		string $contentType,
		array $contentIds,
		array $permissionCombinationIds
	)
	{
		if (empty($contentIds) || empty($permissionCombinationIds))
		{
			return;
		}

		$contentIds = array_unique($contentIds);
		$permissionCombinationIds = array_unique($permissionCombinationIds);

		if (count($permissionCombinationIds) < count($contentIds))
		{
			foreach ($permissionCombinationIds AS $permissionCombinationId)
			{
				\XF::permissionCache()->cacheContentPermsByIds(
					$permissionCombinationId,
					$contentType,
					$contentIds
				);
			}
		}
		else
		{
			foreach ($contentIds AS $contentId)
			{
				\XF::permissionCache()->cacheMultipleContentPermsForContent(
					$permissionCombinationIds,
					$contentType,
					$contentId
				);
			}
		}
	}

	protected function isContentVisibleToContentAuthor(
		Entity $content,
		Entity $authorContent
	): bool
	{
		if ($authorContent === null)
		{
			$authorContent = $content;
		}

		if (!method_exists($content, 'canView'))
		{
			throw new \LogicException('Could not determine content viewability');
		}

		if (!isset($authorContent->user_id) || !isset($authorContent->User))
		{
			throw new \LogicException('Could not determine content author');
		}

		if (!$authorContent->user_id || !$authorContent->User)
		{
			return false;
		}

		return \XF::asVisitor($authorContent->User, function () use ($content)
		{
			return $content->canView();
		});
	}
}
