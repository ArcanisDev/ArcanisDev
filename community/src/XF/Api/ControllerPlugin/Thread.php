<?php

namespace XF\Api\ControllerPlugin;

use function is_int;

class Thread extends AbstractPlugin
{
	/**
	 * @api-in int $prefix_id Filters to only threads with the specified prefix.
	 * @api-in int $starter_id Filters to only threads started by the specified user ID.
	 * @api-in int $last_days Filters to threads that have had a reply in the last X days.
	 * @api-in bool $unread Filters to unread threads only. Ignored for guests.
	 * @api-in str $thread_type Filters to threads of the specified thread type.
	 */
	public function applyThreadListFilters(\XF\Finder\Thread $threadFinder, \XF\Entity\Forum $forum = null)
	{
		$filters = [];

		$prefixId = $this->filter('prefix_id', 'uint');
		if ($prefixId)
		{
			$threadFinder->where('prefix_id', $prefixId);
			$filters['prefix_id'] = $prefixId;
		}

		$starterId = $this->filter('starter_id', 'uint');
		if ($starterId)
		{
			$threadFinder->where('user_id', $starterId);
			$filters['starter_id'] = $starterId;
		}

		$lastDays = $this->filter('last_days', '?uint');
		if (is_int($lastDays))
		{
			if ($lastDays)
			{
				$threadFinder->where('last_post_date', '>=', \XF::$time - ($lastDays * 86400));
			}
			// 0 means no limit here -- bypass the forum default limit if there is one

			$filters['last_days'] = $lastDays;
		}

		$unread = $this->filter('unread', 'bool');
		if ($unread)
		{
			$threadFinder->unreadOnly(\XF::visitor()->user_id);

			$filters['unread'] = true;
		}

		$threadType = $this->filter('thread_type', 'str');
		if ($threadType)
		{
			$threadFinder->where('discussion_type', $threadType);

			$filters['thread_type'] = $threadType;
		}

		return $filters;
	}

	/**
	 * @api-in str $order Method of ordering: last_post_date, post_date. When in a specific forum context: title, reply_count, view_count, vote_score, first_post_reaction_score.
	 * @api-in str $direction Either "asc" or "desc" for ascending or descending. Applies only if an order is provided.
	 */
	public function applyThreadListSort(\XF\Finder\Thread $threadFinder, \XF\Entity\Forum $forum = null)
	{
		$order = $this->filter('order', 'str');
		if (!$order)
		{
			return null;
		}

		$direction = $this->filter('direction', 'str');
		if ($direction !== 'asc')
		{
			$direction = 'desc';
		}

		switch ($order)
		{
			case 'last_post_date':
			case 'post_date':
				$threadFinder->order($order, $direction);
				return [$order, $direction];
		}

		if ($forum)
		{
			switch ($order)
			{
				case 'title':
				case 'reply_count':
				case 'view_count':
				case 'vote_score':
				case 'first_post_reaction_score':
					$threadFinder->order($order, $direction);
					return [$order, $direction];
			}
		}

		return null;
	}
}