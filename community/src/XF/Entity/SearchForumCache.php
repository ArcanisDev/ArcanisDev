<?php

namespace XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

use function count;

/**
 * COLUMNS
 * @property int $node_id
 * @property array $results
 * @property int $cache_date
 *
 * GETTERS
 * @property int $result_count
 *
 * RELATIONS
 * @property \XF\Entity\SearchForum $SearchForum
 */
class SearchForumCache extends Entity
{
	/**
	 * @return bool
	 */
	public function isExpired()
	{
		$cacheTtl = $this->SearchForum->cache_ttl ?? 0;
		$cutOff = \XF::$time - $cacheTtl * 60;
		return $this->cache_date < $cutOff;
	}

	/**
	 * @return int
	 */
	public function getResultCount()
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
		$structure->table = 'xf_search_forum_cache';
		$structure->shortName = 'XF:SearchForumCache';
		$structure->primaryKey = 'node_id';
		$structure->columns = [
			'node_id' => [
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
}
