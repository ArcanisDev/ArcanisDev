<?php

namespace XF\Api\ControllerPlugin;

use XF\Entity\ContentVoteTrait;
use XF\Mvc\Entity\Entity;

class ContentVote extends AbstractPlugin
{
	/**
	 * @api-in <req> str $type Type of vote, "up" or "down". Use the current type to undo.
	 *
	 * @api-out true $success
	 * @api-out str $action "insert" or "delete" based on whether the reaction was added or removed.
	 *
	 * @param Entity|ContentVoteTrait $content
	 *
	 * @return \XF\Api\Mvc\Reply\ApiResult
	 * @throws \XF\Mvc\Reply\Exception
	 */
	public function actionVote(Entity $content)
	{
		$this->assertRequiredApiInput('type');
		$voteType = $this->filter('type', 'str');

		$voteRepo = $this->getVoteRepo();

		if (!$voteRepo->isValidVoteType($voteType))
		{
			throw $this->exception($this->noPermission());
		}

		if (\XF::isApiCheckingPermissions() && !$content->canVoteOnContent($error))
		{
			throw $this->exception($this->noPermission($error));
		}

		if ($voteType == \XF\Entity\ContentVote::VOTE_DOWN)
		{
			if (!$content->isContentDownvoteSupported())
			{
				throw $this->exception($this->noPermission());
			}
			else if (\XF::isApiCheckingPermissions() && !$content->canDownvoteContent($error))
			{
				throw $this->exception($this->noPermission($error));
			}
		}

		$vote = $voteRepo->vote(
			$content->getEntityContentType(),
			$content->getEntityId(),
			$voteType
		);

		return $this->apiSuccess([
			'action' => $vote ? 'insert' : 'delete'
		]);
	}

	/**
	 * @return \XF\Repository\ContentVote
	 */
	protected function getVoteRepo()
	{
		return $this->repository('XF:ContentVote');
	}
}