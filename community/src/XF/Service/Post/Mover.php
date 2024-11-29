<?php

namespace XF\Service\Post;

use XF\Entity\Post;
use XF\Entity\Thread;
use XF\Service\ModerationAlertSendableTrait;

use function array_key_exists, intval, is_array;

class Mover extends \XF\Service\AbstractService
{
	use ModerationAlertSendableTrait;

	/**
	 * @var Thread
	 */
	protected $target;

	protected $existingTarget = false;

	protected $alert = false;
	protected $alertReason = '';

	protected $prefixId = null;

	protected $log = true;

	/**
	 * @var Thread[]
	 */
	protected $sourceThreads = [];

	/**
	 * @var Post[]
	 */
	protected $sourcePosts = [];

	public function __construct(\XF\App $app, Thread $target)
	{
		parent::__construct($app);
		$this->target = $target;
	}

	public function getTarget()
	{
		return $this->target;
	}

	public function setExistingTarget($existing)
	{
		$this->existingTarget = (bool)$existing;
	}

	public function setLog($log)
	{
		$this->log = (bool)$log;
	}

	public function setSendAlert($alert, $reason = null)
	{
		$this->alert = (bool)$alert;
		if ($reason !== null)
		{
			$this->alertReason = $reason;
		}
	}

	public function setPrefix($prefixId)
	{
		$this->prefixId = ($prefixId === null ? $prefixId : intval($prefixId));
	}

	public function move($sourcePostsRaw)
	{
		if ($sourcePostsRaw instanceof \XF\Mvc\Entity\AbstractCollection)
		{
			$sourcePostsRaw = $sourcePostsRaw->toArray();
		}
		else if ($sourcePostsRaw instanceof Post)
		{
			$sourcePostsRaw = [$sourcePostsRaw];
		}
		else if (!is_array($sourcePostsRaw))
		{
			throw new \InvalidArgumentException('Posts must be provided as collection, array or entity');
		}

		if (!$sourcePostsRaw)
		{
			return false;
		}

		if ($this->alert)
		{
			$contentIds = [$this->target->node_id];
			$permissionCombinationIds = [];
			foreach ($sourcePostsRaw AS $sourcePost)
			{
				/** @var Post $sourcePost */
				if (!$sourcePost->user_id || !$sourcePost->User)
				{
					continue;
				}

				$contentIds[] = $sourcePost->Thread->node_id;
				$permissionCombinationIds[] = $sourcePost->User->permission_combination_id;
			}

			static::cacheContentPermissions(
				'node',
				$contentIds,
				$permissionCombinationIds
			);

			foreach ($sourcePostsRaw AS $sourcePost)
			{
				/** @var Post $sourcePost */
				$this->wasVisibleForAlert[$sourcePost->post_id] = $this->isContentVisibleToContentAuthor(
					$sourcePost,
					$sourcePost
				);
				$this->isVisibleForAlert[$sourcePost->post_id] = $this->isContentVisibleToContentAuthor(
					$this->target,
					$sourcePost
				);
			}
		}

		$db = $this->db();

		/** @var Post[] $sourcePosts */
		/** @var Thread[] $sourceThreads */
		$sourcePosts = [];
		$sourceThreads = [];

		$target = $this->target;

		foreach ($sourcePostsRaw AS $sourcePost)
		{
			if ($sourcePost->thread_id == $target->thread_id)
			{
				continue;
			}

			$sourcePost->setOption('log_moderator', false);
			$sourcePosts[$sourcePost->post_id] = $sourcePost;

			/** @var Thread $sourceThread */
			$sourceThread = $sourcePost->Thread;
			if ($sourceThread && !isset($sourceThreads[$sourceThread->thread_id]))
			{
				$sourceThread->setOption('log_moderator', false);
				$sourceThreads[$sourceThread->thread_id] = $sourceThread;
			}
		}

		if (!$sourcePosts)
		{
			return false; // nothing to do
		}

		$sourcePosts = \XF\Util\Arr::columnSort($sourcePosts, 'post_date');

		$this->sourceThreads = $sourceThreads;
		$this->sourcePosts = $sourcePosts;

		$target->setOption('log_moderator', false);

		if (!$target->thread_id)
		{
			$firstPost = reset($sourcePosts);

			$target->user_id = $firstPost->user_id;
			$target->username = $firstPost->username;
			$target->post_date = $firstPost->post_date;
		}

		$db->beginTransaction();

		$target->save();

		$this->moveDataToTarget();
		$this->updateTargetData();
		$this->updateSourceData();
		$this->updateUserCounters();

		if ($this->alert)
		{
			$this->sendAlert();
		}

		$this->finalActions();

		$db->commit();

		return true;
	}

	protected function isTargetFirstPost(\XF\Entity\Post $post)
	{
		return (!$this->existingTarget || $post->post_date <= $this->target->post_date);
	}

	protected function moveDataToTarget()
	{
		$db = $this->db();
		$target = $this->target;

		$sourcePosts = $this->sourcePosts;
		$sourcePostIds = array_keys($sourcePosts);
		$sourceIdsQuoted = $db->quote($sourcePostIds);

		// we need to keep the original thread/state references locally, but we want the global/cached
		// versions of the entities to reflect their new status, so we'll update the local versions
		// to be a clone and then we'll update $sourcePosts (which will share references with the global ones)
		$this->sourcePosts = \XF\Util\Arr::cloneArray($sourcePosts);

		$db->update('xf_post',
			['thread_id' => $target->thread_id],
			"post_id IN ($sourceIdsQuoted)"
		);

		foreach ($sourcePosts AS $sourcePost)
		{
			$sourcePost->setAsSaved('thread_id', $target->thread_id);
		}

		$firstPost = reset($sourcePosts);
		if (
			$firstPost->message_state != 'visible'
			&& $this->isTargetFirstPost($firstPost)
		)
		{
			$firstPost->message_state = 'visible';
			$firstPost->save();
			// this used to clone, but we've already done that above
		}

		if (!$this->existingTarget)
		{
			$db->update('xf_bookmark_item', [
				'content_type' => 'thread',
				'content_id' => $target->thread_id
			], 'content_type = ? AND content_id = ?', ['post', $firstPost->post_id]);
		}
	}

	protected function updateTargetData()
	{
		$target = $this->target;
		$firstPost = reset($this->sourcePosts);

		if ($this->prefixId !== null)
		{
			$target->prefix_id = $this->prefixId;
		}

		if ($this->isTargetFirstPost($firstPost))
		{
			$target->discussion_state = $firstPost->message_state;
		}

		$target->rebuildCounters();
		$target->save();

		$target->Forum->rebuildCounters();
		$target->Forum->save();

		/** @var \XF\Repository\Thread $threadRepo */
		$threadRepo = $this->repository('XF:Thread');
		$threadRepo->rebuildThreadPostPositions($target->thread_id);
		$threadRepo->rebuildThreadUserPostCounters($target->thread_id);
	}

	protected function updateSourceData()
	{
		/** @var \XF\Repository\Thread $threadRepo */
		$threadRepo = $this->repository('XF:Thread');

		foreach ($this->sourceThreads AS $sourceThread)
		{
			$sourceThread->rebuildCounters();

			$sourceThread->save(); // has to be saved for the delete to work (if needed).

			if (array_key_exists($sourceThread->first_post_id, $this->sourcePosts) && $sourceThread->reply_count == 0)
			{
				$sourceThread->delete(); // first post has been moved out, no other replies, thread now empty
			}
			else
			{
				if (!$sourceThread->FirstPost->isVisible())
				{
					$sourceThread->discussion_state = $sourceThread->FirstPost->message_state;
					$sourceThread->save();

					$sourceThread->FirstPost->message_state = 'visible';
					$sourceThread->FirstPost->save();
				}

				$threadRepo->rebuildThreadPostPositions($sourceThread->thread_id);
				$threadRepo->rebuildThreadUserPostCounters($sourceThread->thread_id);
			}

			$sourceThread->Forum->rebuildCounters();
			$sourceThread->Forum->save();
		}
	}

	protected function updateUserCounters()
	{
		$target = $this->target;

		$targetMessagesCount = (
			$target->Forum && $target->Forum->count_messages
			&& $target->discussion_state == 'visible'
		);
		$targetReactionsCount = ($target->discussion_state == 'visible');

		$sourcesMessagesCount = [];
		$sourcesReactionsCount = [];
		foreach ($this->sourceThreads AS $id => $sourceThread)
		{
			$sourcesMessagesCount[$id] = (
				$sourceThread->Forum && $sourceThread->Forum->count_messages
				&& $sourceThread->discussion_state == 'visible'
			);
			$sourcesReactionsCount[$id] = ($sourceThread->discussion_state == 'visible');
		}

		$reactionsEnable = [];
		$reactionsDisable = [];
		$userMessageCountAdjust = [];

		/** @var \XF\Repository\NewsFeed $newsFeedRepo */
		$newsFeedRepo = $this->repository('XF:NewsFeed');

		foreach ($this->sourcePosts AS $id => $post)
		{
			if ($post->message_state != 'visible')
			{
				continue; // everything will stay the same in the new thread
			}

			$sourceMessagesCount = !empty($sourcesMessagesCount[$post->thread_id]);
			$sourceReactionsCount = !empty($sourcesReactionsCount[$post->thread_id]);

			if ($post->reactions)
			{
				if ($sourceReactionsCount && !$targetReactionsCount)
				{
					$reactionsDisable[] = $id;
				}
				else if (!$sourceReactionsCount && $targetReactionsCount)
				{
					$reactionsEnable[] = $id;
				}
			}

			$userId = $post->user_id;
			if ($userId)
			{
				if ($sourceMessagesCount && !$targetMessagesCount)
				{
					if (!isset($userMessageCountAdjust[$userId]))
					{
						$userMessageCountAdjust[$userId] = 0;
					}
					$userMessageCountAdjust[$userId]--;
				}
				else if (!$sourceMessagesCount && $targetMessagesCount)
				{
					if (!isset($userMessageCountAdjust[$userId]))
					{
						$userMessageCountAdjust[$userId] = 0;
					}
					$userMessageCountAdjust[$userId]++;
				}
			}

			if (!$this->existingTarget)
			{
				// if moving to a new thread (which will publish a new feed entry)
				// unpublish the original reply to prevent a duplicate entry.
				$newsFeedRepo->unpublish('post', $post->post_id, $post->user_id, 'insert');
			}
		}

		if ($reactionsDisable)
		{
			/** @var \XF\Repository\Reaction $reactionRepo */
			$reactionRepo = $this->repository('XF:Reaction');
			$reactionRepo->fastUpdateReactionIsCounted('post', $reactionsDisable, false);
		}
		if ($reactionsEnable)
		{
			/** @var \XF\Repository\Reaction $reactionRepo */
			$reactionRepo = $this->repository('XF:Reaction');
			$reactionRepo->fastUpdateReactionIsCounted('post', $reactionsEnable, true);
		}
		foreach ($userMessageCountAdjust AS $userId => $adjust)
		{
			if ($adjust)
			{
				$this->db()->query("
					UPDATE xf_user
					SET message_count = GREATEST(0, message_count + ?)
					WHERE user_id = ?
				", [$adjust, $userId]);
			}
		}
	}

	protected function sendAlert()
	{
		$target = $this->target;

		/** @var \XF\Repository\Post $postRepo */
		$postRepo = $this->repository('XF:Post');

		foreach ($this->sourcePosts AS $sourcePost)
		{
			if ($sourcePost->Thread->discussion_state == 'visible'
				&& $sourcePost->message_state == 'visible'
				&& $sourcePost->user_id != \XF::visitor()->user_id
				&& (
					!empty($this->wasVisibleForAlert[$sourcePost->post_id])
					|| !empty($this->isVisibleForAlert[$sourcePost->post_id])
				)
			)
			{
				$targetPost = clone $sourcePost;
				$targetPost->setAsSaved('thread_id', $target->thread_id);

				$alertExtras = [
					'sourceTitle' => $sourcePost->Thread->title,
					'targetLink' => $this->app->router('public')->buildLink('nopath:posts', $sourcePost),
					'wasVisible' => !empty($this->wasVisibleForAlert[$sourcePost->post_id]),
					'isVisible' => !empty($this->isVisibleForAlert[$sourcePost->post_id])
				];

				$postRepo->sendModeratorActionAlert($targetPost, 'move', $this->alertReason, $alertExtras);
			}
		}
	}

	protected function finalActions()
	{
		$target = $this->target;
		$postIds = array_keys($this->sourcePosts);

		if ($postIds)
		{
			$this->app->jobManager()->enqueue('XF:SearchIndex', [
				'content_type' => 'post',
				'content_ids' => $postIds
			]);
		}

		if ($this->log)
		{
			$this->app->logger()->logModeratorAction('thread', $target, 'post_move_target' . ($this->existingTarget ? '_existing' : ''),
				['ids' => implode(', ', $postIds)]
			);

			foreach ($this->sourceThreads AS $sourceThread)
			{
				$this->app->logger()->logModeratorAction('thread', $sourceThread, 'post_move_source', [
					'url' => $this->app->router('public')->buildLink('nopath:threads', $target),
					'title' => $target->title
				]);
			}
		}
	}
}