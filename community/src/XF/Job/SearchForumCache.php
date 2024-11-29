<?php

namespace XF\Job;

class SearchForumCache extends AbstractJob
{
	/**
	 * @var array
	 */
	protected $defaultData = [
		'node_id' => null
	];

	/**
	 * @param int|float $maxRunTime
	 *
	 * @return JobResult
	 *
	 * @throws \InvalidArgumentException
	 */
	public function run($maxRunTime)
	{
		if (!$this->data['node_id'])
		{
			throw new \InvalidArgumentException(
				'Cannot rebuild search forum cache without a node ID'
			);
		}

		/** @var \XF\Entity\SearchForum $searchForum */
		$searchForum = $this->app->find(
			'XF:SearchForum',
			$this->data['node_id'],
			['Cache']
		);
		if (!$searchForum)
		{
			return $this->complete();
		}

		/** @var \XF\Repository\SearchForum $searchForumRepo */
		$searchForumRepo = $this->app->repository('XF:SearchForum');
		$searchForumRepo->rebuildThreadsForSearchForum($searchForum);

		return $this->complete();
	}

	/**
	 * @return string
	 */
	public function getStatusMessage()
	{
		$actionPhrase = \XF::phrase('rebuilding');
		$typePhrase = \XF::phrase('search_forums');
		return sprintf('%s... %s', $actionPhrase, $typePhrase);
	}

	/**
	 * @return bool
	 */
	public function canCancel()
	{
		return false;
	}

	/**
	 * @return bool
	 */
	public function canTriggerByChoice()
	{
		return true;
	}
}
