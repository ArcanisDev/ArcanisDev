<?php

namespace XF\ControllerPlugin;

use XF\Entity\ContentVoteTrait;
use XF\Mvc\Entity\Entity;

class ContentVote extends AbstractPlugin
{
	/**
	 * @param Entity|ContentVoteTrait $content
	 * @param string $returnUrl
	 * @param string $confirmUrl
	 *
	 * @return \XF\Mvc\Reply\AbstractReply
	 * @throws \InvalidArgumentException
	 */
	public function actionVote(Entity $content, $returnUrl, $confirmUrl)
	{
		$contentType = $content->getEntityContentType();
		if (!$contentType)
		{
			throw new \InvalidArgumentException("Provided entity must define a content type in its structure");
		}

		$voteRepo = $this->getVoteRepo();

		$voteType = $this->filter('type', 'str');

		// TODO: better behavior if there's no vote type?
		if (!$voteRepo->isValidVoteType($voteType))
		{
			return $this->noPermission();
		}

		if (!$content->canVoteOnContent($error))
		{
			return $this->noPermission($error);
		}

		if ($voteType == \XF\Entity\ContentVote::VOTE_DOWN)
		{
			if (!$content->isContentDownvoteSupported())
			{
				return $this->noPermission();
			}
			else if (!$content->canDownvoteContent($error))
			{
				return $this->noPermission($error);
			}
		}

		$contentId = $content->getEntityId();

		if ($this->isPost())
		{
			$vote = $voteRepo->vote($contentType, $contentId, $voteType);

			if ($this->filter('_xfWithData', 'bool'))
			{
				if ($vote)
				{
					if ($vote->vote_type == \XF\Entity\ContentVote::VOTE_UP)
					{
						$message = \XF::phrase('vote_action_upvoted');
					}
					else
					{
						$message = \XF::phrase('vote_action_downvoted');
					}
				}
				else
				{
					$message = \XF::phrase('vote_action_cancelled');
				}

				$reply = $this->message($message);
				$reply->setJsonParams([
					'vote' => $vote ? $vote->vote_type : null,
					'voteScore' => $content->vote_score,
					'voteScoreShort' => $content->vote_score_short,
				]);
				return $reply;
			}
			else
			{
				return $this->redirect($returnUrl);
			}
		}
		else
		{
			$viewParams = [
				'confirmUrl' => $confirmUrl,
				'content' => $content,
				'vote' => $content->getVisitorContentVote(),
				'voteType' => $voteType,
			];
			return $this->view('XF:ContentVote\VoteConfirm','content_vote_confirm', $viewParams);
		}
	}

	/**
	 * @return \XF\Mvc\Entity\Repository|\XF\Repository\ContentVote
	 */
	protected function getVoteRepo()
	{
		return $this->repository('XF:ContentVote');
	}
}