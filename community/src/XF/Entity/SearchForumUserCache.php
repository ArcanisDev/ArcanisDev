<?php

namespace XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

use function array_slice, count;

/**
 * COLUMNS
 * @property int $node_id
 * @property int $user_id
 * @property array $results
 * @property int $cache_date
 *
 * GETTERS
 * @property int $result_count
 *
 * RELATIONS
 * @property \XF\Entity\SearchForum $SearchForum
 */
class SearchForumUserCache extends Entity
{
	/**
	 * @return bool
	 */
	public function isExpired(): bool
	{
		$cacheTtl = $this->SearchForum->cache_ttl ?? 0;
		$cutOff = \XF::$time - $cacheTtl * 60;
		return $this->cache_date < $cutOff;
	}

	/**
	 * @param int $page
	 * @param int $perPage
	 *
	 * @return int[]
	 */
	public function sliceResultsToPage(int $page, int $perPage): array
	{
		$page = max(1, $page);
		$perPage = max(1, $perPage);

		return array_slice($this->results, ($page - 1) * $perPage, $perPage);
	}

	/**
	 * @param int $page
	 * @param int $perPage
	 * @param string[] $extraWith
	 *
	 * @return \XF\Mvc\Entity\AbstractCollection|\XF\Entity\Thread[]
	 */
	public function getThreadsByPage(int $page, int $perPage, array $extraWith = [])
	{
		$threadIds = $this->sliceResultsToPage($page, $perPage);

		return $this->getSearchForumRepo()
			->getThreadsByIdsOrdered($threadIds, $extraWith)
			->filterViewable();
	}

	/**
	 * @return int
	 */
	public function getResultCount(): int
	{
		return count($this->results);
	}

	public function _preSave()
	{
		$this->cache_date = \XF::$time;
	}

	/**
	 * @return Structure
	 */
	public static function getStructure(Structure $structure)
	{
		$structure->table = 'xf_search_forum_cache_user';
		$structure->shortName = 'XF:SearchForumUserCache';
		$structure->primaryKey = ['node_id', 'user_id'];
		$structure->columns = [
			'node_id' => [
				'type' => self::UINT,
				'required' => true
			],
			'user_id' => [
				'type' => self::UINT,
				'required' => true
			],
			'results' => [
				'type' => self::LIST_COMMA,
				'default' => [],
				'list' => [
					'type' => 'posint',
					'unique' => true
				]
			],
			'cache_date' => [
				'type' => self::UINT,
				'default' => 0
			]
		];
		$structure->getters = [
			'result_count' => true
		];
		$structure->relations = [
			'SearchForum' => [
				'entity' => 'XF:SearchForum',
				'type' => self::TO_ONE,
				'conditions' => 'node_id',
				'primary' => true
			]
		];

		return $structure;
	}

	/**
	 * @return \XF\Repository\SearchForum
	 */
	protected function getSearchForumRepo()
	{
		return $this->repository('XF:SearchForum');
	}
}