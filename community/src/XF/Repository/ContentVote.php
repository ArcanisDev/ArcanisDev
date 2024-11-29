<?php

namespace XF\Repository;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Repository;

use function intval, is_array;

class ContentVote extends Repository
{
	/**
	 * Modifier for voting. When set, removes the vote if the same vote is recast.
	 */
	const REMOVE_SAME = 0x01;

	/**
	 * Modifier for voting. When set, only removes the existing vote when the opposite vote is cast.
	 */
	const REMOVE_OPPOSITE = 0x02;

	/**
	 * Validates a vote type based on a type we might receive from user input. Notably, this tends to be
	 * "up" or "down" rather than a score (1 or -1).
	 *
	 * @param string $voteType
	 *
	 * @return bool
	 */
	public function isValidVoteType(string $voteType): bool
	{
		switch ($voteType)
		{
			case \XF\Entity\ContentVote::VOTE_UP:
			case \XF\Entity\ContentVote::VOTE_DOWN:
				return true;

			default:
				return false;
		}
	}

	/**
	 * Gets the unique vote record for a specific user on a piece of content.
	 *
	 * @param string $contentType
	 * @param int $contentId
	 * @param int $userId
	 *
	 * @return \XF\Entity\ContentVote|null
	 */
	public function getVoteByContentAndVoteUser($contentType, $contentId, $userId)
	{
		return $this->finder('XF:ContentVote')->where([
			'content_type' => $contentType,
			'content_id' => $contentId,
			'vote_user_id' => $userId
		])->fetchOne();
	}

	/**
	 * Votes on a piece of content. Note that guests can't vote.
	 *
	 * @param string $contentType
	 * @param int $contentId
	 * @param string $voteType Value should be one of the \XF\Entity\ContentType VOTE_UP/VOTE_DOWN constants
	 * @param int|null $modifiers Vote behavior changes, using the REMOVE_SAME/REMOVE_OPPOSITE options
	 * @param \XF\Entity\User|null $voteUser User voting, null for visitor
	 *
	 * @return \XF\Entity\ContentVote|null Inserted/updated entity or null if deleting
	 */
	public function vote(
		string $contentType,
		int $contentId,
		string $voteType,
		int $modifiers = null,
		\XF\Entity\User $voteUser = null
	)
	{
		if ($modifiers === null)
		{
			$modifiers = self::REMOVE_SAME| self::REMOVE_OPPOSITE;
		}

		$voteUser = $voteUser ?: \XF::visitor();

		$vote = $this->getVoteByContentAndVoteUser($contentType, $contentId, $voteUser->user_id);
		if ($vote)
		{
			if ($vote->vote_type == $voteType)
			{
				// vote is the same as what's in the DB...
				if ($modifiers & self::REMOVE_SAME)
				{
					// ... and we flagged to remove it in that case
					$vote->delete();
					return null;
				}
				else
				{
					// ... otherwise we have no work to do
					return $vote;
				}
			}
			else if ($modifiers & self::REMOVE_OPPOSITE)
			{
				// vote is the opposite of what's been cast and we treat that as a removal
				$vote->delete();
				return null;
			}
			// else we need to change the vote
		}
		else
		{
			$voteHandler = $this->getVoteHandler($contentType, true);
			$entity = $voteHandler->getContent($contentId);

			/** @var \XF\Entity\ContentVote $vote */
			$vote = $this->em->create('XF:ContentVote');
			$vote->content_type = $contentType;
			$vote->content_id = $contentId;
			$vote->vote_user_id = $voteUser->user_id;
			$vote->content_user_id = $voteHandler->getContentUserId($entity);
			$vote->is_content_user_counted = $voteHandler->isCountedForContentUser($entity);
		}

		$vote->setVoteType($voteType);

		try
		{
			$vote->save();
		}
		catch (\XF\Db\DuplicateKeyException $e)
		{
			// race condition so we should just re-look up thevote and return that
			return $this->getVoteByContentAndVoteUser($contentType, $contentId, $voteUser->user_id);
		}

		return $vote;
	}

	/**
	 * Removes the vote from a piece of content for the specified user.
	 *
	 * @param string $contentType
	 * @param int $contentId
	 * @param \XF\Entity\User|null $voteUser
	 *
	 * @return bool
	 */
	public function removeVote($contentType, $contentId, \XF\Entity\User $voteUser = null)
	{
		$voteUser = $voteUser ?: \XF::visitor();

		$existingVote = $this->getVoteByContentAndVoteUser($contentType, $contentId, $voteUser->user_id);
		if ($existingVote)
		{
			$existingVote->delete();
		}

		return true;
	}

	/**
	 * Recalculates whether votes counts towards a content user's score for the specified content.
	 *
	 * @param string $contentType
	 * @param int|array $contentIds
	 */
	public function recalculateVoteIsCounted($contentType, $contentIds)
	{
		$voteHandler = $this->getVoteHandler($contentType, true);

		if (!is_array($contentIds))
		{
			$contentIds = [$contentIds];
		}
		if (!$contentIds)
		{
			return;
		}

		$entities = $voteHandler->getContent($contentIds);
		$enableIds = [];
		$disableIds = [];

		foreach ($entities AS $id => $entity)
		{
			if ($voteHandler->isCountedForContentUser($entity))
			{
				$enableIds[] = $id;
			}
			else
			{
				$disableIds[] = $id;
			}
		}

		if ($enableIds)
		{
			$this->fastUpdateVoteIsCounted($contentType, $enableIds, true);
		}
		if ($disableIds)
		{
			$this->fastUpdateVoteIsCounted($contentType, $disableIds, false);
		}
	}

	/**
	 * Updates whether a votes count towards a user's vote score. Typically triggered when content is hidden/shown.
	 *
	 * @param string $contentType
	 * @param array|int $contentIds
	 * @param bool $newValue
	 */
	public function fastUpdateVoteIsCounted($contentType, $contentIds, $newValue)
	{
		if (!is_array($contentIds))
		{
			$contentIds = [$contentIds];
		}
		if (!$contentIds)
		{
			return;
		}

		$newDbValue = $newValue ? 1 : 0;
		$oldDbValue = $newValue ? 0 : 1;

		$db = $this->db();

		$updates = $db->fetchPairs("
			SELECT content_user_id, SUM(score)
			FROM xf_content_vote
			WHERE content_type = ?
				AND content_id IN (" . $db->quote($contentIds) . ")
				AND is_content_user_counted = ?
				AND content_user_id > 0
			GROUP BY content_user_id
		", [$contentType, $oldDbValue]);

		$db->beginTransaction();

		$db->update('xf_content_vote',
			['is_content_user_counted' => $newDbValue],
			'content_type = ?
				AND content_id IN (' . $db->quote($contentIds) . ')
				AND is_content_user_counted = ?',
			[$contentType, $oldDbValue]
		);

		$operator = $newDbValue ? '+' : '-';
		foreach ($updates AS $userId => $totalChange)
		{
			if (!$totalChange)
			{
				continue;
			}

			$db->query("
				UPDATE xf_user
				SET vote_score = vote_score {$operator} ?
				WHERE user_id = ?
			", [$totalChange, $userId]);
		}

		$db->commit();
	}

	/**
	 * Quickly deletes the votes for particular pieces of content, updating the user vote scores as needed.
	 *
	 * @param string $contentType
	 * @param array|int $contentIds
	 */
	public function fastDeleteVotesForContent($contentType, $contentIds)
	{
		if (!is_array($contentIds))
		{
			$contentIds = [$contentIds];
		}
		if (!$contentIds)
		{
			return;
		}

		$db = $this->db();

		$updates = $db->fetchPairs("
			SELECT content_user_id, SUM(score)
			FROM xf_content_vote
			WHERE content_type = ?
				AND content_id IN (" . $db->quote($contentIds) . ")
				AND is_content_user_counted = 1
				AND content_user_id > 0
			GROUP BY content_user_id
		", $contentType);

		$db->beginTransaction();

		foreach ($updates AS $userId => $totalChange)
		{
			$db->query("
				UPDATE xf_user
				SET vote_score = vote_score - ?
				WHERE user_id = ?
			", [$totalChange, $userId]);
		}

		$db->delete('xf_content_vote',
			'content_type = ? AND content_id IN (' . $db->quote($contentIds) . ')',
			$contentType
		);

		$db->commit();
	}

	public function moveVotesBetweenContent(Entity $target, array $sources)
	{
		if (!(method_exists($target, 'isContentVotingSupported')))
		{
			throw new \InvalidArgumentException("Target must be an entity that implements ContentVoteTrait");
		}

		$contentType = $target->getEntityContentType();
		if (!$contentType)
		{
			throw new \InvalidArgumentException("Target entity must provide a content type");
		}

		$voteHandler = $this->getVoteHandler($contentType, true);
		$sourceIds = [];

		foreach ($sources AS $source)
		{
			if (!($source instanceof Entity))
			{
				throw new \InvalidArgumentException("All sources must be entities");
			}

			if ($source->getEntityContentType() !== $contentType)
			{
				throw new \InvalidArgumentException("All sources must match the content type of the target");
			}

			$sourceId = $source->getEntityId();
			$sourceIds[] = $sourceId;
		}

		if (!$target->isContentVotingSupported())
		{
			// voting isn't supported which is fine/expected, we just can't move stuff
			return false;
		}
		if (!$sources)
		{
			return true;
		}

		$targetId = $target->getEntityId();
		$isTargetCounted = $voteHandler->isCountedForContentUser($target);
		$targetUserId = $voteHandler->getContentUserId($target);

		$db = $this->db();

		$sourceVotes = $db->fetchAllKeyed("
			SELECT *
			FROM xf_content_vote
			WHERE content_type = ?
				AND content_id IN (" . $db->quote($sourceIds) . ")
		", 'vote_id', $contentType);
		if (!$sourceVotes)
		{
			return true;
		}

		$targetVotesByUser = $db->fetchAllKeyed("
			SELECT *
			FROM xf_content_vote
			WHERE content_type = ?
				AND content_id = ?
		", 'vote_user_id', [$contentType, $targetId]);

		$moveVoteIds = [];
		$userScoreAdjust = [];

		foreach ($sourceVotes AS $sourceVoteId => $sourceVote)
		{
			$sourceVoterId = $sourceVote['vote_user_id'];
			if ($sourceVoterId == $targetUserId || isset($targetVotesByUser[$sourceVoterId]))
			{
				// user already voted on target or is the creator
				continue;
			}

			$moveVoteIds[] = $sourceVoteId;
			$targetVotesByUser[$sourceVoterId] = $sourceVote; // to account for votes on multiple sources

			if ($sourceVote['is_content_user_counted'])
			{
				$sourceContentUserId = $sourceVote['content_user_id'];

				if (!isset($userScoreAdjust[$sourceContentUserId]))
				{
					$userScoreAdjust[$sourceContentUserId] = 0;
				}

				$userScoreAdjust[$sourceContentUserId] -= $sourceVote['score'];
			}

			if ($isTargetCounted)
			{
				if (!isset($userScoreAdjust[$targetUserId]))
				{
					$userScoreAdjust[$targetUserId] = 0;
				}

				$userScoreAdjust[$targetUserId] += $sourceVote['score'];
			}
		}

		if ($moveVoteIds)
		{
			$db->beginTransaction();

			$db->update(
				'xf_content_vote',
				[
					'content_id' => $targetId,
					'content_user_id' => $targetUserId,
					'is_content_user_counted' => $isTargetCounted ? 1 : 0
				],
				'vote_id IN (' . $db->quote($moveVoteIds) . ')'
			);

			$this->rebuildVoteCache($contentType, $targetId);

			unset($userScoreAdjust[0]); // make sure we don't try to update any guest records, just in case
			foreach ($userScoreAdjust AS $userId => $adjust)
			{
				if (!$adjust)
				{
					continue;
				}

				$this->db()->query(
					'UPDATE xf_user
						SET vote_score = vote_score + ?
						WHERE user_id = ?',
					[$adjust, $userId]
				);
			}

			$db->commit();
		}

		return true;
	}

	/**
	 * Gets the vote score based on the vote's the user's content has received. Only includes
	 * "counted" votes (which may vary depending on context).
	 *
	 * @param $userId
	 *
	 * @return int
	 */
	public function getUserVoteScore($userId)
	{
		if ($userId instanceof \XF\Entity\User)
		{
			$userId = $userId->user_id;
		}

		return intval($this->db()->fetchOne("
			SELECT SUM(score)
			FROM xf_content_vote
			WHERE content_user_id = ?
				AND is_content_user_counted = 1
		", $userId));
	}

	/**
	 * Gets the relevant content vote handler for a content type.
	 *
	 * @param string $type
	 * @param bool $throw If true, throws exceptions on errors; otherwise, returns null on failure
	 *
	 * @return null|\XF\ContentVote\AbstractHandler
	 *
	 * @throws \Exception
	 */
	public function getVoteHandler($type, $throw = false)
	{
		$handlerClass = \XF::app()->getContentTypeFieldValue($type, 'content_vote_handler_class');
		if (!$handlerClass)
		{
			if ($throw)
			{
				throw new \InvalidArgumentException("No vote handler for '$type'");
			}
			return null;
		}

		if (!class_exists($handlerClass))
		{
			if ($throw)
			{
				throw new \InvalidArgumentException("Vote handler for '$type' does not exist: $handlerClass");
			}
			return null;
		}

		$handlerClass = \XF::extendClass($handlerClass);
		return new $handlerClass($type);
	}

	/**
	 * Rebuilds the vote cache for a piece of content.
	 *
	 * @param string $contentType
	 * @param int $contentId
	 * @param bool $throw
	 *
	 * @return bool
	 *
	 * @throws \Exception
	 */
	public function rebuildVoteCache($contentType, $contentId, $throw = true)
	{
		$voteHandler = $this->getVoteHandler($contentType, $throw);
		if (!$voteHandler)
		{
			// throwing would be handled within getVoteHandler if desired
			return false;
		}

		$content = $voteHandler->getContent($contentId);
		if (!$content)
		{
			if ($throw)
			{
				throw new \InvalidArgumentException("No entity found for '$contentType' with ID $contentId");
			}
			return false;
		}

		$counts = $this->db()->fetchRow('
			SELECT SUM(score) AS vote_score, COUNT(*) AS vote_count
			FROM xf_content_vote
			WHERE content_type = ? AND content_id = ?
		', [$contentType, $contentId]);

		$voteHandler->updateContentVotes($content, $counts['vote_score'] ?: 0, $counts['vote_count']);

		return true;
	}
}