<?php

namespace XF\Service\User;

use XF\Entity\User;

use function count, is_array;

class Merge extends \XF\Service\AbstractService
{
	use \XF\MultiPartRunnerTrait;

	/**
	 * @var User
	 */
	protected $source;

	/**
	 * @var User
	 */
	protected $target;

	protected $steps = [
		'stepPreMerge',
		'stepDeleteSelfReactions',
		'stepDeleteSelfContentVotes',
		'stepMergeUserData',
		'stepReassignContent',
		'stepFinalizeMerge'
	];

	public function __construct(\XF\App $app)
	{
		parent::__construct($app);

		// not passing in the source/target here to make the code explicit as to which is which
	}

	public function setSource(User $source)
	{
		$this->source = $source;

		return $this;
	}

	/**
	 * @return User
	 */
	public function getSource()
	{
		return $this->source;
	}

	public function setTarget(User $target)
	{
		$this->target = $target;

		return $this;
	}

	/**
	 * @return User
	 */
	public function getTarget()
	{
		return $this->target;
	}

	protected function getSteps()
	{
		return $this->steps;
	}

	public function merge($maxRunTime = 0)
	{
		if (!$this->source)
		{
			throw new \LogicException("No source user provided");
		}
		if (!$this->target)
		{
			throw new \LogicException("No target user provided");
		}

		if ($this->source->user_id == $this->target->user_id)
		{
			// no work to do
			return \XF\ContinuationResult::completed();
		}

		$this->db()->beginTransaction();
		$result = $this->runLoop($maxRunTime);
		$this->db()->commit();

		return $result;
	}

	protected function stepPreMerge()
	{
	}

	protected function stepDeleteSelfReactions($lastOffset, $maxRunTime)
	{
		$start = microtime(true);

		// Find cases where the source/target have reacted to each other. These would become self reactions, so remove them.

		$finder = $this->finder('XF:ReactionContent')
			->whereOr(
				[
					['reaction_user_id', $this->source->user_id],
					['content_user_id', $this->target->user_id]
				],
				[
					['reaction_user_id', $this->target->user_id],
					['content_user_id', $this->source->user_id]
				]
			)
			->order('reaction_content_id');

		if ($lastOffset !== null)
		{
			$finder->where('reaction_content_id', '>', $lastOffset);
		}

		$maxFetch = 1000;

		/** @var \XF\Entity\ReactionContent[] $reactions */
		$reactions = $finder->fetch($maxFetch);
		$fetchedReactions = count($reactions);

		if (!$reactions)
		{
			return null; // done or nothing to do
		}

		foreach ($reactions AS $reaction)
		{
			$lastOffset = $reaction->reaction_content_id;

			$reaction->delete();

			if ($maxRunTime && microtime(true) - $start > $maxRunTime)
			{
				return $lastOffset; // continue at this position
			}
		}

		if ($fetchedReactions == $maxFetch)
		{
			return $lastOffset; // more to do
		}
		else
		{
			return null;
		}
	}

	protected function stepDeleteSelfContentVotes($lastOffset, $maxRunTime)
	{
		$start = microtime(true);

		// Find cases where the source/target have voted for each other. These would become self votes, so remove them.

		$finder = $this->finder('XF:ContentVote')
			->whereOr(
				[
					['vote_user_id', $this->source->user_id],
					['content_user_id', $this->target->user_id]
				],
				[
					['vote_user_id', $this->target->user_id],
					['content_user_id', $this->source->user_id]
				]
			)
			->order('vote_id');

		if ($lastOffset !== null)
		{
			$finder->where('vote_id', '>', $lastOffset);
		}

		$maxFetch = 1000;

		/** @var \XF\Entity\ContentVote[] $votes */
		$votes = $finder->fetch($maxFetch);
		$fetchedVotes = count($votes);

		if (!$votes)
		{
			return null; // done or nothing to do
		}

		foreach ($votes AS $vote)
		{
			$lastOffset = $vote->vote_id;

			$vote->delete();

			if ($maxRunTime && microtime(true) - $start > $maxRunTime)
			{
				return $lastOffset; // continue at this position
			}
		}

		if ($fetchedVotes == $maxFetch)
		{
			return $lastOffset; // more to do
		}
		else
		{
			return null;
		}
	}

	protected function stepMergeUserData()
	{
		$this->combineData();

		$this->target->save();
	}

	protected function combineData()
	{
		// it's possible for some of these values to be changed earlier in the request (such as via vote clean up),
		// so grab the latest DB values and use them instead
		$sourceData = $this->db()->fetchRow("
			SELECT message_count, question_solution_count, reaction_score, vote_score
			FROM xf_user
			WHERE user_id = ?
		", $this->source->user_id);

		$this->target->message_count += $sourceData['message_count'];
		$this->target->question_solution_count += $sourceData['question_solution_count'];
		$this->target->reaction_score += $sourceData['reaction_score'];
		$this->target->vote_score += $sourceData['vote_score'];
		$this->target->conversations_unread += $this->source->conversations_unread;
		$this->target->alerts_unviewed += $this->source->alerts_unviewed;
		$this->target->alerts_unread += $this->source->alerts_unread;
		$this->target->warning_points += $this->source->warning_points;
		$this->target->register_date = min($this->target->register_date, $this->source->register_date);
		$this->target->last_activity = max($this->target->last_activity, $this->source->last_activity);

		$this->app->fire('user_merge_combine', [$this->target, $this->source, $this]);
	}

	protected function stepReassignContent($lastOffset, $maxRunTime)
	{
		/** @var \XF\Service\User\ContentChange $contentChanger */
		$contentChanger = $this->service('XF:User\ContentChange', $this->source);
		$contentChanger->setupForMerge($this->target);

		if (is_array($lastOffset))
		{
			list($changeStep, $changeLastOffset) = $lastOffset;
			$contentChanger->restoreState($changeStep, $changeLastOffset);
		}

		$result = $contentChanger->apply($maxRunTime);
		if ($result->isCompleted())
		{
			return null;
		}
		else
		{
			$continueData = $result->getContinueData();
			return [$continueData['currentStep'], $continueData['lastOffset']];
		}
	}

	protected function stepFinalizeMerge()
	{
		$this->source->delete();

		$this->postMergeCleanUp();
	}

	protected function postMergeCleanUp()
	{
		/** @var \XF\Repository\Trophy $trophyRepo */
		$trophyRepo = $this->repository('XF:Trophy');
		$trophyRepo->recalculateUserTrophyPoints($this->target);

		// anything left over is where both users were in the same conversation so we can remove the old records
		$this->db()->delete('xf_conversation_recipient', 'user_id = ?', $this->source->user_id);

		// prevent situations where a user can be following/ignoring themselves
		$this->db()->delete(
			'xf_user_follow',
			'user_id = ? AND (follow_user_id = ? OR follow_user_id = ?)',
			[$this->target->user_id, $this->target->user_id, $this->source->user_id]
		);
		$this->db()->delete(
			'xf_user_ignored',
			'user_id = ? AND (ignored_user_id = ? OR ignored_user_id = ?)',
			[$this->target->user_id, $this->target->user_id, $this->source->user_id]
		);

		$this->repository('XF:UserFollow')->rebuildFollowingCache($this->target->user_id);
		$this->repository('XF:UserIgnored')->rebuildIgnoredCache($this->target->user_id);

		// if we moved ignore records over, we need to update those users' ignore caches
		$this->repository('XF:UserIgnored')->rebuildIgnoredCacheByIgnoredUser($this->target->user_id);

		/** @var \XF\Repository\UsernameChange $usernameChangeRepo */
		$usernameChangeRepo = $this->repository('XF:UsernameChange');

		$usernameChangeRepo->insertUsernameChangeLog(
			$this->target->user_id,
			$this->source->username,
			$this->target->username,
			true
		);

		$usernameChangeRepo->rebuildLastUsernameChange($this->target);
	}
}