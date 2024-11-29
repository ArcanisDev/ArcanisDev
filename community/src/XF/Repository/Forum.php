<?php

namespace XF\Repository;

use XF\Db\AbstractAdapter;
use XF\Mvc\Entity\Repository;

use function in_array, is_array;

class Forum extends Repository
{
	public function getViewableForums(array $where = [], $with = null)
	{
		$visitor = \XF::visitor();

		$forumFinder = $this->finder('XF:Forum')
			->with('Node.Permissions|' . $visitor->permission_combination_id);

		if ($where)
		{
			$forumFinder->where($where);
		}
		if ($with)
		{
			$forumFinder->with($with);
		}

		return $forumFinder->fetch()->filterViewable();
	}

	public function markForumReadByUser(\XF\Entity\Forum $forum, $userId, $newRead = null)
	{
		if (!$userId)
		{
			return false;
		}

		if ($newRead === null)
		{
			$newRead = max(\XF::$time, $forum->last_post_date);
		}

		$cutOff = \XF::$time - $this->options()->readMarkingDataLifetime * 86400;
		if ($newRead <= $cutOff)
		{
			return false;
		}

		$read = $forum->Read[$userId];
		if ($read && $newRead <= $read->forum_read_date)
		{
			return false;
		}

		\XF::db()->executeTransaction(function(AbstractAdapter $db) use ($forum, $userId, $newRead)
		{
			$db->insert('xf_forum_read', [
				'node_id' => $forum->node_id,
				'user_id' => $userId,
				'forum_read_date' => $newRead
			], false, 'forum_read_date = VALUES(forum_read_date)');
		}, AbstractAdapter::ALLOW_DEADLOCK_RERUN);

		return true;
	}

	public function markForumReadByVisitor(\XF\Entity\Forum $forum, $newRead = null)
	{
		$userId = \XF::visitor()->user_id;
		return $this->markForumReadByUser($forum, $userId, $newRead);
	}

	public function markForumReadIfPossible(\XF\Entity\Forum $forum, $newRead = null)
	{
		$userId = \XF::visitor()->user_id;
		if (!$userId)
		{
			return false;
		}

		$threadRepo = $this->repository('XF:Thread');
		$unread = $threadRepo->countUnreadThreadsInForum($forum);
		if ($unread)
		{
			return false;
		}

		return $this->markForumReadByVisitor($forum, $newRead);
	}

	public function markForumTreeReadByVisitor(\XF\Entity\AbstractNode $baseNode = null, $newRead = null)
	{
		$userId = \XF::visitor()->user_id;
		if (!$userId)
		{
			return [];
		}

		if ($newRead === null)
		{
			$newRead = \XF::$time;
		}

		$cutOff = \XF::$time - $this->options()->readMarkingDataLifetime * 86400;
		if ($newRead <= $cutOff)
		{
			return [];
		}

		/** @var \XF\Repository\Node $nodeRepo */
		$nodeRepo = $this->repository('XF:Node');

		if ($baseNode)
		{
			$childNodes = $nodeRepo->findDescendants($baseNode->Node, false)->fetch();
			$nodes = $childNodes->unshift($baseNode->Node);
		}
		else
		{
			$nodes = $nodeRepo->getFullNodeList();
		}

		$forumIds = [];
		foreach ($nodes AS $nodeId => $node)
		{
			/** @var \XF\Entity\Node $node */
			if ($node->node_type_id == 'Forum')
			{
				$forumIds[] = $node->node_id;
			}
		}

		$forums = $this->em->findByIds(
			'XF:Forum',
			$forumIds,
			[
				'Node.Permissions|' . \XF::visitor()->permission_combination_id,
				'Read|' . $userId
			]
		);

		$markedRead = [];
		$inserts = [];

		foreach ($forums AS $forum)
		{
			/** @var \XF\Entity\Forum $forum */
			if (!$forum->canView())
			{
				continue;
			}

			$read = $forum->Read[$userId];
			if ($read && $newRead <= $read->forum_read_date)
			{
				continue;
			}

			$inserts[] = [
				'node_id' => $forum->node_id,
				'user_id' => $userId,
				'forum_read_date' => $newRead
			];
			$markedRead[] = $forum->node_id;
		}

		if ($inserts)
		{
			\XF::db()->executeTransaction(function(AbstractAdapter $db) use ($inserts)
			{
				$this->db()->insertBulk(
					'xf_forum_read',
					$inserts,
					false,
					'forum_read_date = VALUES(forum_read_date)'
				);
			}, AbstractAdapter::ALLOW_DEADLOCK_RERUN);
		}

		return $markedRead;
	}

	public function pruneForumReadLogs($cutOff = null)
	{
		if ($cutOff === null)
		{
			$cutOff = \XF::$time - ($this->options()->readMarkingDataLifetime * 86400);
		}

		$this->db()->delete('xf_forum_read', 'forum_read_date < ?', $cutOff);
	}

	public function getForumCounterTotals()
	{
		return $this->db()->fetchRow("
			SELECT SUM(discussion_count) AS threads,
				SUM(message_count) AS messages
			FROM xf_forum
		");
	}

	/**
	 * @param bool $includeEmpty
	 * @param string[]|string|null $enableTypes
	 * @param string|null $type
	 * @param bool $checkPerms
	 *
	 * @return array
	 */
	public function getForumOptionsData(
		bool $includeEmpty = true,
		$enableTypes = null,
		string $type = null,
		bool $checkPerms = false
	)
	{
		$choices = [];

		if ($includeEmpty)
		{
			$choices[0] = [
				'_type' => 'option',
				'value' => 0,
				'label' => \XF::phrase('(none)')
			];
		}

		/** @var \XF\Repository\Node $nodeRepo */
		$nodeRepo = $this->repository('XF:Node');
		$nodeList = $nodeRepo->getFullNodeList();
		$nodeRepo->loadNodeTypeDataForNodes($nodeList);

		if ($checkPerms)
		{
			$nodeList = $nodeList->filterViewable();
		}

		foreach ($nodeRepo->createNodeTree($nodeList)->getFlattened() AS $entry)
		{
			/** @var \XF\Entity\Node $node */
			$node = $entry['record'];

			if ($node['depth'])
			{
				$prefix = str_repeat('--', $entry['depth']) . ' ';
			}
			else
			{
				$prefix = '';
			}

			$choice = [
				'value' => $node->node_id,
				'label' => $prefix . $node->title
			];

			if ($node->node_type_id == 'Forum' && $node->Data)
			{
				if ($enableTypes !== null)
				{
					if (!is_array($enableTypes))
					{
						$enableTypes = [$enableTypes];
					}

					/** @var \XF\Entity\Forum $forum */
					$forum = $node->Data;
					$choice['disabled'] = in_array($forum->forum_type_id, $enableTypes)
						? false
						: 'disabled';
				}
				else
				{
					$choice['disabled'] = false;
				}
			}
			else
			{
				$choice['disabled'] = 'disabled';
			}

			if ($type !== null)
			{
				$choice['_type'] = $type;
			}

			$choices[$node->node_id] = $choice;
		}

		return $choices;
	}
}