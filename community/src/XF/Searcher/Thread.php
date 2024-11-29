<?php

namespace XF\Searcher;

use XF\Mvc\Entity\Finder;

use function is_array;

/**
 * @method \XF\Finder\Thread getFinder()
 */
class Thread extends AbstractSearcher
{
	protected $allowedRelations = ['Forum'];

	protected $formats = [
		'title' => 'like',
		'username' => 'like',
		'post_date' => 'date',
		'last_post_date' => 'date'
	];

	protected $arrayValueKeys = [
		'thread_field'
	];

	protected $whitelistOrder = [
		'title' => true,
		'username' => true,
		'post_date' => true,
		'last_post_date' => true,
		'reply_count' => true,
		'view_count' => true,
		'first_post_reaction_score' => true,
		'vote_score' => true
	];

	protected $order = [['last_post_date', 'desc']];

	protected function getEntityType()
	{
		return 'XF:Thread';
	}

	protected function getDefaultOrderOptions()
	{
		return [
			'last_post_date' => \XF::phrase('forum_sort.last_post_date'),
			'post_date' => \XF::phrase('forum_sort.post_date'),
			'title' => \XF::phrase('forum_sort.title'),
			'reply_count' => \XF::phrase('forum_sort.reply_count'),
			'view_count' => \XF::phrase('forum_sort.view_count'),
			'first_post_reaction_score' => \XF::phrase('forum_sort.first_post_reaction_score'),
			'vote_score' => \XF::phrase('forum_sort.vote_score')
		];
	}

	protected function validateSpecialCriteriaValueAfter($key, &$value, $column, $format, $relation)
	{
		if ($key == 'posted_in_last' || $key == 'last_post_in_last')
		{
			if (!is_array($value) || !isset($value['value']) || $value['value'] <= 0)
			{
				return false;
			}
		}
		if ($key == 'prefix_id' && $value == -1)
		{
			return false;
		}
		if ($key == 'node_id')
		{
			if (
				$value == 0
				|| (is_array($value) && isset($value[0]) && $value[0] == 0)
			)
			{
				return false;
			}
		}
		if (
			($key == 'starter_user_group_id' || $key == 'starter_not_user_group_id')
			&& !$value
		)
		{
			return false;
		}

		return null;
	}

	protected function applySpecialCriteriaValue(Finder $finder, $key, $value, $column, $format, $relation)
	{
		if ($key == 'node_id')
		{
			if (!is_array($value))
			{
				$value = [$value];
			}

			if (isset($value['search_type']) && $value['search_type'] === 'exclude')
			{
				$matchInForums = false;
			}
			else
			{
				$matchInForums = true;
			}
			unset($value['search_type']);

			$finder->where('node_id', $matchInForums ? '=' : '<>', $value);

			return true;
		}

		if ($key == 'thread_type')
		{
			$finder->where('discussion_type', $value);
		}

		if ($key == 'posted_in_last' || $key == 'last_post_in_last')
		{
			$cutOff = $this->convertRelativeTimeToCutoff(
				$value['value'],
				$value['unit']
			);
			if ($cutOff)
			{
				$column = $key == 'posted_in_last' ? 'post_date' : 'last_post_date';

				$finder->where($column, '>=', $cutOff);
			}
			return true;
		}

		if ($key == 'not_discussion_type')
		{
			$finder->where('discussion_type', '<>', $value);
			return true;
		}

		if ($key == 'thread_field')
		{
			$exactMatchFields = !empty($value['exact']) ? $value['exact'] : []; // used for multi-choice field searches
			$customFields = $value + $exactMatchFields;
			unset($customFields['exact']);

			foreach ($customFields AS $fieldId => $value)
			{
				if ($value === '' || (is_array($value) && !$value))
				{
					continue;
				}

				$finder->with('CustomFields|' . $fieldId);
				$isExact = !empty($exactMatchFields[$fieldId]);
				$conditions = [];

				foreach ((array)$value AS $possible)
				{
					$columnName = 'CustomFields|' . $fieldId . '.field_value';
					if ($isExact)
					{
						$conditions[] = [$columnName, '=', $possible];
					}
					else
					{
						$conditions[] = [$columnName, 'LIKE', $finder->escapeLike($possible, '%?%')];
					}
				}

				if ($conditions)
				{
					$finder->whereOr($conditions);
				}
			}
		}

		if ($key == 'tags')
		{
			/** @var \XF\Repository\Tag $tagRepo */
			$tagRepo = $this->em->getRepository('XF:Tag');

			$tags = $tagRepo->splitTagList($value);
			if ($tags)
			{
				$validTags = $tagRepo->getTags($tags, $notFound);
				if ($notFound)
				{
					// if they entered an unknown tag, we don't want to ignore it, so we need to force no results
					$finder->whereImpossible();
				}
				else
				{
					foreach (array_keys($validTags) AS $tagId)
					{
						$finder->with('Tags|' . $tagId, true);
					}
				}

				return true;
			}
		}

		if ($key == 'starter_user_group_id' || $key == 'starter_not_user_group_id')
		{
			if (!is_array($value))
			{
				$value = [$value];
			}

			$finder->with('User');

			$userGroupIdColumn = $finder->columnSqlName('User.user_group_id');
			$secondaryGroupIdsColumn = $finder->columnSqlName('User.secondary_group_ids');
			$positiveMatch = ($key == 'starter_user_group_id');
			$parts = [];

			// for negative matches, we default to allowing guests, but if they say "not the guest"
			// group, then we'll disable it
			$orIsGuest = $positiveMatch ? false : true;

			foreach ($value AS $userGroupId)
			{
				$quotedGroupId = $finder->quote($userGroupId);
				if ($positiveMatch)
				{
					$parts[] = "$userGroupIdColumn = $quotedGroupId "
						. "OR FIND_IN_SET($quotedGroupId, $secondaryGroupIdsColumn)";

					if ($userGroupId == \XF\Entity\User::GROUP_GUEST)
					{
						// if explicitly selecting the guest group, allow guest threads
						// as they're hard to filter for otherwise
						$parts[] = $finder->columnSqlName('user_id') . ' = 0';
					}
				}
				else
				{
					$parts[] = "$userGroupIdColumn <> $quotedGroupId "
						. "AND FIND_IN_SET($quotedGroupId, $secondaryGroupIdsColumn) = 0";

					if ($userGroupId == \XF\Entity\User::GROUP_GUEST)
					{
						$orIsGuest = false;
					}
				}
			}
			if ($parts)
			{
				$joiner = $positiveMatch ? ' OR ' : ' AND ';
				$sql = implode($joiner, $parts);
				if ($orIsGuest)
				{
					$sql = "($sql) OR " . $finder->columnSqlName('user_id') . ' = 0';
				}
				$finder->whereSql($sql);
			}
			return true;
		}

		return false;
	}

	public function getFormData()
	{
		/** @var \XF\Repository\ThreadPrefix $prefixRepo */
		$prefixRepo = $this->em->getRepository('XF:ThreadPrefix');
		$prefixes = $prefixRepo->getPrefixListData();

		/** @var \XF\Repository\Node $nodeRepo */
		$nodeRepo = $this->em->getRepository('XF:Node');
		$forums = $nodeRepo->getNodeOptionsData(false, 'Forum');

		/** @var \XF\Repository\UserGroup $userGroupRepo */
		$userGroupRepo = $this->em->getRepository('XF:UserGroup');
		$userGroups = $userGroupRepo->findUserGroupsForList()->fetch();

		/** @var \XF\Repository\ThreadType */
		$threadTypeRepo = $this->em->getRepository('XF:ThreadType');
		$threadTypes = $threadTypeRepo->getThreadTypeListData();

		return [
			'prefixes' => $prefixes,
			'forums' => $forums,
			'userGroups' => $userGroups,
			'threadTypes' => $threadTypes,
		];
	}

	public function getFormDefaults()
	{
		$threadTypes = \XF::app()->container('threadTypes');
		unset($threadTypes['redirect']);

		return [
			'prefix_id' => -1,
			'thread_type' => array_keys($threadTypes),
			'node_id' => 0,

			'reply_count' => ['end' => -1],
			'view_count' => ['end' => -1],

			'discussion_state' => ['visible', 'moderated', 'deleted'],
			'discussion_open' => [0, 1],
			'sticky' => [0, 1]
		];
	}
}