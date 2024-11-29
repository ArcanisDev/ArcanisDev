<?php

namespace XF\ContentVote;

use XF\Entity\ContentVoteTrait;
use XF\Mvc\Entity\Entity;

abstract class AbstractHandler
{
	protected $contentType;

	abstract public function isCountedForContentUser(Entity $entity);

	public function __construct($contentType)
	{
		$this->contentType = $contentType;
	}

	/**
	 * @param Entity|ContentVoteTrait $entity
	 * @param null $error
	 *
	 * @return bool
	 */
	public function canViewContent(Entity $entity, &$error = null)
	{
		if (method_exists($entity, 'canView'))
		{
			return $entity->canView($error);
		}
		throw new \LogicException("Could not determine content viewability; please override");
	}

	public function getContentUserId(Entity $entity)
	{
		if (isset($entity->user_id))
		{
			return $entity->user_id;
		}
		else if (isset($entity->User))
		{
			$user = $entity->User;
			if ($user instanceof \XF\Entity\User)
			{
				return $user->user_id;
			}
			else
			{
				throw new \LogicException("Found a User relation but it did not match a user; please override");
			}
		}

		throw new \LogicException("Could not determine content user ID; please override");
	}

	/**
	 * @param Entity|ContentVoteTrait $entity
	 * @param int $totalScore
	 * @param int $voteCount
	 * @param array $extra Any extra info that may be passed in (currently unused)
	 */
	public function updateContentVotes(Entity $entity, $totalScore, $voteCount, array $extra = [])
	{
		$entity->vote_count = $voteCount;
		$entity->vote_score = $totalScore;
		$entity->save();
	}

	public function getEntityWith()
	{
		return [];
	}

	public function getContent($id)
	{
		return \XF::app()->findByContentType($this->contentType, $id, $this->getEntityWith());
	}

	public function getContentType()
	{
		return $this->contentType;
	}
}