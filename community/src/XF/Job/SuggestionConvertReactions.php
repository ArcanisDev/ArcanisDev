<?php

namespace XF\Job;

use function count;

class SuggestionConvertReactions extends AbstractJob
{
	protected $defaultData = [
		'node_id' => null,

		'count' => 0,
		'last' => 0,
		'total' => null
	];

	/**
	 * @var \XF\Entity\Forum
	 */
	protected $forum;

	/**
	 * @var null|\XF\Entity\Reaction[]
	 */
	protected $countableReactions;

	public function run($maxRunTime)
	{
		$s = microtime(true);

		if (!$this->data['node_id'])
		{
			throw new \InvalidArgumentException('Cannot change forum thread types without a node_id.');
		}

		/** @var \XF\Entity\Forum $forum */
		$forum = $this->app->find('XF:Forum', $this->data['node_id']);
		if (!$forum || (!$forum->TypeHandler instanceof \XF\ForumType\Suggestion))
		{
			return $this->complete();
		}

		$this->forum = $forum;
		$typeHandler = $forum->TypeHandler;

		$threadFinder = $this->app->finder('XF:Thread')
			->where('node_id', $this->data['node_id'])
			->where('discussion_type', $typeHandler->getDefaultThreadType($forum))
			->order('thread_id');

		if ($this->data['total'] === null)
		{
			$this->data['total'] = $threadFinder->total();
			if (!$this->data['total'])
			{
				return $this->complete();
			}
		}

		$threadFinder->where('thread_id', '>', $this->data['last']);

		$maxFetch = 1000;

		$threadIds = $threadFinder->pluckFrom('thread_id')->fetch($maxFetch)->toArray();
		if (!$threadIds)
		{
			return $this->complete();
		}

		$continue = count($threadIds) < $maxFetch ? false : true;

		$this->countableReactions = \XF::finder('XF:Reaction')
			->where('reaction_score', '<>', 0)
			->fetch()
			->toArray();

		foreach ($threadIds AS $threadId)
		{
			$this->data['count']++;
			$this->data['last'] = $threadId;

			/** @var \XF\Entity\Thread $thread */
			$thread = $this->app->find('XF:Thread', $threadId);
			if (!$thread)
			{
				continue;
			}

			$forum = $thread->Forum;

			// sanity check - shouldn't fail
			if ($thread->discussion_type !== $typeHandler->getDefaultThreadType($forum))
			{
				continue;
			}

			$this->convertReactions($thread);

			if ($maxRunTime && microtime(true) - $s > $maxRunTime)
			{
				$continue = true;
				break;
			}
		}

		return $continue ? $this->resume() : $this->complete();
	}

	protected function convertReactions(\XF\Entity\Thread $thread)
	{
		$firstPostId = $thread->first_post_id;
		if (!$firstPostId)
		{
			return;
		}

		$db = \XF::db();

		$reactions = $db->fetchAll("
			SELECT reaction_user_id, reaction_id, reaction_date
			FROM xf_reaction_content
			WHERE content_type = 'post' AND content_id = ?
		", $firstPostId);
		if (!$reactions)
		{
			return;
		}

		$allowDownvote = $this->forum->type_config['allow_downvote'];

		$voteRepo = \XF::repository('XF:ContentVote');
		$isContentUserCounted = $voteRepo->getVoteHandler('thread')->isCountedForContentUser($thread);

		$inserts = [];

		foreach ($reactions AS $reaction)
		{
			$reactionDef = $this->countableReactions[$reaction['reaction_id']] ?? null;

			if (!$reactionDef)
			{
				// deleted reaction or a neutral reaction
				continue;
			}

			if ($reactionDef['reaction_score'] < 0 && !$allowDownvote)
			{
				// negative reaction but no downvotes allowed
				continue;
			}

			$inserts[] = [
				'content_type' => 'thread',
				'content_id' => $thread->thread_id,
				'vote_user_id' => $reaction['reaction_user_id'],
				'content_user_id' => $thread->user_id,
				'is_content_user_counted' => $isContentUserCounted ? 1 : 0,
				'score' => $reactionDef['reaction_score'] > 0 ? 1 : -1,
				'vote_date' => $reaction['reaction_date']
			];
		}

		if (!$inserts)
		{
			return;
		}

		$db->beginTransaction();

		$db->insertBulk('xf_content_vote', $inserts, false, false, 'IGNORE');
		$voteRepo->rebuildVoteCache('thread', $thread->thread_id);

		$db->commit();
	}

	public function getStatusMessage()
	{
		$actionPhrase = \XF::phrase('converting_reactions');
		return sprintf('%s... (%s/%s)', $actionPhrase,
			\XF::language()->numberFormat($this->data['count']), \XF::language()->numberFormat($this->data['total'])
		);
	}

	public function canCancel()
	{
		return true;
	}

	public function canTriggerByChoice()
	{
		return false;
	}
}