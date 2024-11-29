<?php

namespace XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int vote_score
 * @property int vote_count
 *
 * GETTERS
 * @property mixed vote_score_short
 *
 * RELATIONS
 * @property ContentVote[] ContentVotes
 */
trait ContentVoteTrait
{
	abstract public function isContentVotingSupported(): bool;

	abstract public function isContentDownvoteSupported(): bool;

	abstract protected function canVoteOnContentInternal(&$error = null): bool;

	public function canVoteOnContent(&$error = null): bool
	{
		if (!isset($this->user_id))
		{
			throw new \LogicException("No user_id column specified on entity, reimplement canVoteOnContent");
		}

		if (!$this->isContentVotingSupported())
		{
			return false;
		}

		$visitor = \XF::visitor();
		if (!$visitor->user_id)
		{
			return false;
		}

		if ($visitor->user_id == $this->user_id)
		{
			return false;
		}

		if (!$this->canVoteOnContentInternal($error))
		{
			return false;
		}

		return true;
	}

	public function canDownvoteContent(&$error = null): bool
	{
		return true;
	}

	public function getVisitorContentVote()
	{
		$visitor = \XF::visitor();
		if (!$visitor->user_id)
		{
			return false;
		}

		if (!isset($this->ContentVotes[$visitor->user_id]))
		{
			return false;
		}

		$vote = $this->ContentVotes[$visitor->user_id];

		if ($vote->score > 0)
		{
			return ContentVote::VOTE_UP;
		}
		else if ($vote->score < 0)
		{
			return ContentVote::VOTE_DOWN;
		}
		else
		{
			return false;
		}
	}

	public function getVoteScoreShort()
	{
		return \XF::language()->shortNumberFormat($this->vote_score, 1);
	}

	/**
	 * @param \XF\Api\Result\EntityResult $result
	 *
	 * @api-out int $vote_score <cond> The content's vote score (if supported)
	 * @api-out bool $can_content_vote <cond> True if the viewing user can vote on this content
	 * @api-out str[] $allowed_content_vote_types <cond> List of content vote types allowed on this content
	 * @api-out bool $is_content_voted <cond> True if the viewing user has voted on this content
	 * @api-out str $visitor_content_vote <cond> If the viewer reacted, the vote they case (up/down)
	 */
	protected function addContentVoteToApiResult(\XF\Api\Result\EntityResult $result)
	{
		$visitor = \XF::visitor();

		if ($this->isContentVotingSupported())
		{
			$result->vote_score = $this->vote_score;
			$result->can_content_vote = $this->canVoteOnContent();

			$voteTypes = [ContentVote::VOTE_UP];
			if (
				$this->isContentDownvoteSupported()
				&& $this->canDownvoteContent()
			)
			{
				$voteTypes[] = ContentVote::VOTE_DOWN;
			}
			$result->allowed_content_vote_types = $voteTypes;

			if ($visitor->user_id)
			{
				$visitorVote = $this->getVisitorContentVote();
				$result->is_content_voted = $visitorVote ? true : false;
				if ($visitorVote)
				{
					$result->visitor_content_vote = $visitorVote;
				}
			}
		}
	}

	public static function addVotableStructureElements(Structure $structure)
	{
		$structure->columns['vote_score'] = ['type' => Entity::INT, 'default' => 0];
		$structure->columns['vote_count'] = ['type' => Entity::UINT, 'forced' => true, 'default' => 0];

		$structure->getters['vote_score_short'] = false;

		$structure->relations['ContentVotes'] = [
			'entity' => 'XF:ContentVote',
			'type' => self::TO_MANY,
			'conditions' => [
				['content_type', '=', $structure->contentType],
				['content_id', '=', '$' . $structure->primaryKey]
			],
			'key' => 'vote_user_id',
			'order' => 'vote_date'
		];
	}

	/**
	 * @return \XF\Repository\ContentVote
	 */
	protected function getContentVoteRepo()
	{
		return $this->repository('XF:ContentVote');
	}
}