<?php

namespace XF\Entity;

use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int $node_id
 * @property array $search_criteria
 * @property string $sort_order
 * @property string $sort_direction
 * @property int $max_results
 * @property int $cache_ttl
 * @property int $discussion_count
 * @property int $message_count
 * @property int $last_post_id
 * @property int $last_post_date
 * @property int $last_post_user_id
 * @property string $last_post_username
 * @property int $last_thread_id
 * @property string $last_thread_title
 * @property int $last_thread_prefix_id
 *
 * GETTERS
 * @property string|null $node_name
 * @property string|null $title
 * @property string|null $description
 * @property int $depth
 *
 * RELATIONS
 * @property \XF\Entity\SearchForumCache $Cache
 * @property \XF\Mvc\Entity\AbstractCollection|\XF\Entity\SearchForumUserCache[] $UserCaches
 * @property \XF\Entity\Post $LastPost
 * @property \XF\Entity\User $LastPostUser
 * @property \XF\Entity\Thread $LastThread
 * @property \XF\Entity\Node $Node
 */
class SearchForum extends AbstractNode
{
	public function isSearchEngineIndexable(): bool
	{
		return false;
	}

	/**
	 * @param int $depth
	 *
	 * @return string[]
	 */
	public function getNodeTemplateRenderer($depth)
	{
		return [
			'template' => 'node_list_search_forum',
			'macro' => $depth <= 2 ? 'depth' . $depth : 'depthN'
		];
	}

	/**
	 * @return array
	 */
	public function getNodeListExtras()
	{
		$output = [
			'max_results' => $this->max_results,
			'discussion_count' => $this->discussion_count,
			'message_count' => $this->message_count
		];

		if ($this->last_post_date && $this->LastThread && $this->LastThread->canView())
		{
			$output['last_post_id'] = $this->last_post_id;
			$output['last_post_date'] = $this->last_post_date;
			$output['last_post_user_id'] = $this->last_post_user_id;
			$output['last_post_username'] = $this->last_post_username;
			$output['last_thread_id'] = $this->last_thread_id;
			$output['last_thread_title'] = $this->last_thread_title;
			$output['last_thread_prefix_id'] = $this->last_thread_prefix_id;

			$output['LastPostUser'] = $this->LastPostUser;
			$output['LastThread'] = $this->LastThread;
		}

		return $output;
	}

	/**
	 * @return string[]
	 */
	public static function getListedWith()
	{
		$with = ['LastPostUser', 'LastThread'];

		$visitor = \XF::visitor();
		if ($visitor->user_id)
		{
			$with[] = "LastThread.Read|{$visitor->user_id}";
		}

		return $with;
	}

	/**
	 * @param string[] $options
	 *
	 * @return \XF\Api\Result\EntityResult
	 */
	public function getNodeTypeApiData($verbosity = self::VERBOSITY_NORMAL, array $options = [])
	{
		$result = parent::getNodeTypeApiData();

		$result->includeExtra([
			'discussion_count' => $this->discussion_count,
			'message_count' => $this->message_count
		]);

		if ($this->last_post_date && $this->LastThread->canView())
		{
			$result->includeExtra([
				'last_post_id' => $this->last_post_id,
				'last_post_date' => $this->last_post_date,
				'last_post_username' => $this->last_post_username,
				'last_thread_id' => $this->last_thread_id,
				'last_thread_title' => $this->last_thread_title,
				'last_thread_prefix_id' => $this->last_thread_prefix_id
			]);
		}

		return $result;
	}

	public function isCacheRebuildNeeded(): bool
	{
		return !$this->Cache || $this->Cache->isExpired();
	}

	/**
	 * @param User $user
	 * @param bool $isRebuildPending
	 *
	 * @return \XF\Entity\SearchForumUserCache
	 */
	public function getUserCacheForUser(User $user, bool $isRebuildPending = false): SearchForumUserCache
	{
		$userCache = $this->UserCaches[$user->user_id] ?? null;
		if (!$userCache)
		{
			/** @var \XF\Entity\SearchForumUserCache $userCache */
			$userCache = $this->_em->create('XF:SearchForumUserCache');
			$userCache->node_id = $this->node_id;
			$userCache->user_id = $user->user_id;

			$forceCache = true;
		}
		else
		{
			$forceCache = false;
		}

		$updateResults = (
			!$userCache->exists()
			|| ($userCache->isExpired() && !$isRebuildPending)
		);
		if ($updateResults)
		{
			$userCache->results = $this->getSearchForumRepo()->getThreadIdsForUserCache($this, $user);
		}

		if (!$isRebuildPending)
		{
			// only save if we're not in the process of updating the global cache since this will potentially be
			// based on out of date info
			try
			{
				$userCache->saveIfChanged();
			}
			catch (\XF\Db\DuplicateKeyException $e)
			{
				$newUserCache = $this->_em->findOne('XF:SearchForumUserCache', [
					'node_id' => $this->node_id,
					'user_id' => $user->user_id
				]);
				if ($newUserCache)
				{
					$userCache = $newUserCache;
					$forceCache = true;
				}
			}
		}

		if ($forceCache)
		{
			$this->UserCaches->forceCache($userCache);
		}

		return $userCache;
	}

	/**
	 * @return array
	 */
	public function getDefaultSearchCriteria(): array
	{
		return [
			'discussion_state' => 'visible',
			'posted_in_last' => ['unit' => 'day'],
			'last_post_in_last' => ['unit' => 'day'],
			'thread_type' => 'any'
		];
	}

	protected function _postSave()
	{
		if ($this->isInsert() || $this->areSearchColumnsChanged())
		{
			\XF::runLater(function()
			{
				$this->rebuildResultCaches();
			});
		}
	}

	protected function _postDelete()
	{
		$this->deleteResultCaches();
	}

	/**
	 * @return bool
	 */
	protected function areSearchColumnsChanged(): bool
	{
		return $this->isChanged([
			'search_criteria',
			'sort_order',
			'sort_direction',
			'max_results'
		]);
	}

	protected function rebuildResultCaches()
	{
		$this->getSearchForumRepo()->rebuildThreadsForSearchForum($this);
	}

	protected function deleteResultCaches()
	{
		$this->db()->delete(
			'xf_search_forum_cache',
			'node_id = ?',
			$this->node_id
		);

		$this->db()->delete(
			'xf_search_forum_cache_user',
			'node_id = ?',
			$this->node_id
		);
	}

	/**
	 * @return Structure
	 */
	public static function getStructure(Structure $structure)
	{
		$structure->table = 'xf_search_forum';
		$structure->shortName = 'XF:SearchForum';
		$structure->primaryKey = 'node_id';
		$structure->columns = [
			'node_id' => [
				'type' => self::UINT,
				'required' => true
			],
			'search_criteria' => [
				'type' => self::JSON_ARRAY,
				'default' => []
			],
			'sort_order' => [
				'type' => self::STR,
				'default' => 'last_post_date',
				'allowedValues' => [
					'title',
					'post_date',
					'reply_count',
					'view_count',
					'last_post_date'
				]
			],
			'sort_direction' => [
				'type' => self::STR,
				'default' => 'desc',
				'allowedValues' => ['asc', 'desc']
			],
			'max_results' => [
				'type' => self::UINT,
				'default' => 200,
				'min' => 20,
				'max' => 1000
			],
			'cache_ttl' => [
				'type' => self::UINT,
				'default' => 10,
				'min' => 1,
				'max' => 1440
			],
			'discussion_count' => [
				'type' => self::UINT,
				'default' => 0
			],
			'message_count' => [
				'type' => self::UINT,
				'default' => 0
			],
			'last_post_id' => [
				'type' => self::UINT,
				'default' => 0
			],
			'last_post_date' => [
				'type' => self::UINT,
				'default' => 0
			],
			'last_post_user_id' => [
				'type' => self::UINT,
				'default' => 0
			],
			'last_post_username' => [
				'type' => self::STR,
				'default' => '',
				'maxLength' => 50
			],
			'last_thread_id' => [
				'type' => self::UINT,
				'default' => 0
			],
			'last_thread_title' => [
				'type' => self::STR,
				'default' => '',
				'maxLength' => 150,
				'censor' => true
			],
			'last_thread_prefix_id' => [
				'type' => self::UINT,
				'default' => 0
			]
		];
		$structure->getters = [];
		$structure->relations = [
			'Cache' => [
				'entity' => 'XF:SearchForumCache',
				'type' => self::TO_ONE,
				'conditions' => 'node_id',
				'primary' => true
			],
			'UserCaches' => [
				'entity' => 'XF:SearchForumUserCache',
				'type' => self::TO_MANY,
				'conditions' => 'node_id',
				'key' => 'user_id'
			],
			'LastPost' => [
				'entity' => 'XF:Post',
				'type' => self::TO_ONE,
				'conditions' => [['post_id', '=', '$last_post_id']],
				'primary' => true
			],
			'LastPostUser' => [
				'entity' => 'XF:User',
				'type' => self::TO_ONE,
				'conditions' => [['user_id', '=', '$last_post_user_id']],
				'primary' => true
			],
			'LastThread' => [
				'entity' => 'XF:Thread',
				'type' => self::TO_ONE,
				'conditions' => [['thread_id', '=', '$last_thread_id']],
				'primary' => true
			]
		];

		static::addDefaultNodeElements($structure);

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
