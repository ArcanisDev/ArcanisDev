<?php

namespace XF\Job;

class SearchForum extends AbstractRebuildJob
{
	/**
	 * @var array
	 */
	protected $defaultData = [
		'expired_only' => true
	];

	/**
	 * @param int $start
	 * @param int $batch
	 *
	 * @return int[]
	 */
	protected function getNextIds($start, $batch)
	{
		$db = $this->app->db();
		return $db->fetchAllColumn(
			$db->limit(
				'SELECT node_id
					FROM xf_search_forum
					WHERE node_id > ?
					ORDER BY node_id',
				$batch
			),
			$start
		);
	}

	/**
	 * @param int $id
	 */
	protected function rebuildById($id)
	{
		/** @var \XF\Entity\SearchForum $searchForum */
		$searchForum = $this->app->find('XF:SearchForum', $id, ['Cache']);
		if (!$searchForum)
		{
			return;
		}

		$expired = $searchForum->Cache ? $searchForum->Cache->isExpired() : true;
		if ($this->data['expired_only'] && !$expired)
		{
			return;
		}

		/** @var \XF\Repository\SearchForum $searchForumRepo */
		$searchForumRepo = $this->app->repository('XF:SearchForum');
		$searchForumRepo->rebuildThreadsForSearchForum($searchForum);
	}

	/**
	 * @return \XF\phrase
	 */
	protected function getStatusType()
	{
		return \XF::phrase('search_forums');
	}
}