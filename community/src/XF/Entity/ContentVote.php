<?php

namespace XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int|null $vote_id
 * @property string $content_type
 * @property int $content_id
 * @property int $vote_user_id
 * @property int $content_user_id
 * @property bool $is_content_user_counted
 * @property int $score
 * @property int $vote_date
 *
 * GETTERS
 * @property ContentVoteTrait|Entity|null $Content
 * @property mixed $vote_type
 *
 * RELATIONS
 * @property \XF\Entity\User $VoteUser
 * @property \XF\Entity\User $ContentUser
 */
class ContentVote extends Entity
{
	const VOTE_UP = 'up';
	const VOTE_DOWN = 'down';

	const VOTE_UP_SCORE = 1;
	const VOTE_DOWN_SCORE = -1;

	public function canView(&$error = null)
	{
		$handler = $this->getHandler();
		$content = $this->Content;

		if ($handler && $content)
		{
			return $handler->canViewContent($content, $error);
		}
		else
		{
			return false;
		}
	}

	public function getVoteType()
	{
		if ($this->score > 0)
		{
			return self::VOTE_UP;
		}
		else if ($this->score < 0)
		{
			return self::VOTE_DOWN;
		}

		return null;
	}

	public function setVoteType($voteType)
	{
		if ($voteType === self::VOTE_UP)
		{
			$this->score = self::VOTE_UP_SCORE;
		}
		else if ($voteType === self::VOTE_DOWN)
		{
			$this->score = self::VOTE_DOWN_SCORE;
		}
		else
		{
			throw new \InvalidArgumentException("Received unknown vote type '$voteType'");
		}
	}

	protected function _preSave()
	{
		if ($this->score === 0)
		{
			throw new \LogicException("Cannot save vote with 0 score");
		}

		if ($this->vote_user_id === 0)
		{
			throw new \LogicException("Guests cannot vote");
		}
	}

	/**
	 * @return \XF\ContentVote\AbstractHandler|null
	 */
	public function getHandler()
	{
		return $this->getContentVoteRepo()->getVoteHandler($this->content_type);
	}

	/**
	 * @return ContentVoteTrait|Entity|null
	 */
	public function getContent()
	{
		$handler = $this->getHandler();
		return $handler ? $handler->getContent($this->content_id) : null;
	}

	public function setContent(Entity $content = null)
	{
		$this->_getterCache['Content'] = $content;
	}

	protected function _postSave()
	{
		$contentUserId = $this->content_user_id;
		$score = $this->score;
		$isContentUserCounted = $this->is_content_user_counted;

		if ($this->isInsert())
		{
			if ($isContentUserCounted)
			{
				$this->adjustUserVoteScore($contentUserId, $score);
			}
		}
		else
		{
			if ($this->isChanged('content_user_id'))
			{
				if ($this->getExistingValue('is_content_user_counted'))
				{
					$existingScore = $this->getExistingValue('score');

					$this->adjustUserVoteScore(
						$this->getExistingValue('content_user_id'),
						$this->getExistingValue('is_content_user_counted') ? -$existingScore : $existingScore
					);
				}
				if ($isContentUserCounted)
				{
					$this->adjustUserVoteScore($contentUserId, $score);
				}
			}
			else if ($this->isChanged('is_content_user_counted'))
			{
				// either now counted (increment) or no longer counted (decrement)
				$this->adjustUserVoteScore($contentUserId, $isContentUserCounted ? $score : -$score);
				// note that this assumes the score isn't changing
			}
			else if ($this->isChanged('score') && $isContentUserCounted)
			{
				$this->adjustUserVoteScore($contentUserId, $score - $this->getExistingValue('score'));
			}
		}

		if ($this->isChanged(['content_type', 'content_id', 'score']))
		{
			$this->rebuildContentVoteCache();
		}
	}

	protected function _postDelete()
	{
		if ($this->is_content_user_counted)
		{
			$this->adjustUserVoteScore($this->content_user_id, -$this->score);
		}

		$this->rebuildContentVoteCache();
	}

	protected function adjustUserVoteScore($userId, $score)
	{
		if (!$userId || !$score)
		{
			return;
		}

		$this->db()->query("
			UPDATE xf_user
			SET vote_score = vote_score + ?
			WHERE user_id = ?
		", [$score, $userId]);
	}

	public static function getStructure(Structure $structure)
	{
		$structure->table = 'xf_content_vote';
		$structure->shortName = 'XF:ContentVote';
		$structure->primaryKey = 'vote_id';
		$structure->columns = [
			'vote_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true],
			'content_type' => ['type' => self::STR, 'maxLength' => 25, 'required' => true],
			'content_id' => ['type' => self::UINT, 'required' => true],
			'vote_user_id' => ['type' => self::UINT, 'required' => true],
			'content_user_id' => ['type' => self::UINT, 'required' => true],
			'is_content_user_counted' => ['type' => self::BOOL, 'default' => true],
			'score' => ['type' => self::INT, 'required' => true],
			'vote_date' => ['type' => self::UINT, 'default' => \XF::$time]
		];
		$structure->getters = [
			'Content' => true,
			'vote_type' => false
		];
		$structure->relations = [
			'VoteUser' => [
				'entity' => 'XF:User',
				'type' => self::TO_ONE,
				'conditions' => [['user_id', '=', '$vote_user_id']],
				'primary' => true
			],
			'ContentUser' => [
				'entity' => 'XF:User',
				'type' => self::TO_ONE,
				'conditions' => [['user_id', '=', '$content_user_id']],
				'primary' => true
			]
		];

		return $structure;
	}

	protected function rebuildContentVoteCache()
	{
		// TODO: option to disable or defer this
		$this->getContentVoteRepo()->rebuildVoteCache(
			$this->content_type, $this->content_id, false
		);
	}

	/**
	 * @return \XF\Repository\ContentVote
	 */
	protected function getContentVoteRepo()
	{
		return $this->repository('XF:ContentVote');
	}
}