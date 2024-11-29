<?php

namespace XF\Api\Controller;

use XF\Mvc\Entity\Entity;
use XF\Mvc\ParameterBag;

use function intval;

/**
 * @api-group Search forums
 */
class SearchForum extends AbstractController
{
	protected function preDispatchController($action, ParameterBag $params)
	{
		$this->assertApiScopeByRequestMethod('node');
	}

	/**
	 * @api-desc Gets information about the specified search forum
	 *
	 * @api-in bool $with_threads If true, gets a page of threads in this search forum
	 * @api-in int $page
	 *
	 * @api-out SearchForum $search_forum
	 * @api-see self::getThreadsInSearchForumPaginated()
	 */
	public function actionGet(ParameterBag $params)
	{
		$searchForum = $this->assertViewableSearchForum($params->node_id);

		if ($this->filter('with_threads', 'bool'))
		{
			$this->assertApiScope('thread:read');
			$threadData = $this->getThreadsInSearchForumPaginated($searchForum, $this->filterPage());
		}
		else
		{
			$threadData = [];
		}

		$result = [
			'search_forum' => $searchForum->toApiResult(Entity::VERBOSITY_VERBOSE)
		];
		$result += $threadData;

		return $this->apiResult($result);
	}

	/**
	 * @api-desc Gets a page of threads from the specified search forum.
	 *
	 * @api-see self::getThreadsInSearchForumPaginated()
	 */
	public function actionGetThreads(ParameterBag $params)
	{
		$this->assertApiScope('thread:read');

		$searchForum = $this->assertViewableSearchForum($params->node_id);
		$threadData = $this->getThreadsInSearchForumPaginated($searchForum, $this->filterPage());

		return $this->apiResult($threadData);
	}

	/**
	 * @api-out Thread[] $threads Threads on this page. Note: this will always respect viewing user permissions regardless of whether the API is set to bypass permissions.
	 * @api-out pagination $pagination Pagination information
	 * @api-out Thread[] $sticky If on page 1, a list of sticky threads in this forum. Does not count towards the per page limit.
	 */
	protected function getThreadsInSearchForumPaginated(\XF\Entity\SearchForum $searchForum, $page = 1, $perPage = null)
	{
		$perPage = intval($perPage);
		if ($perPage <= 0)
		{
			$perPage = $this->options()->discussionsPerPage;
		}

		/** @var \XF\Repository\SearchForum $searchForumRepo */
		$searchForumRepo = $this->repository('XF:SearchForum');

		$isRebuildPending = $searchForumRepo->enqueueCacheRebuildIfNeeded($searchForum);
		$userCache = $searchForum->getUserCacheForUser(\XF::visitor(), $isRebuildPending);
		$total = $userCache->result_count;

		$this->assertValidApiPage($page, $perPage, $total);

		$threads = $userCache->getThreadsByPage($page, $perPage, ['api']);
		$threadResults = $threads->toApiResults();

		return [
			'threads' => $threadResults,
			'pagination' => $this->getPaginationData($threadResults, $page, $perPage, $total)
		];
	}

	/**
	 * @param int $id
	 * @param string|array $with
	 *
	 * @return \XF\Entity\SearchForum
	 *
	 * @throws \XF\Mvc\Reply\Exception
	 */
	protected function assertViewableSearchForum($id, $with = 'api')
	{
		return $this->assertViewableApiRecord('XF:SearchForum', $id, $with);
	}
}