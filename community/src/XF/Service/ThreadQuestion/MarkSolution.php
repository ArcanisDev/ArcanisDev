<?php

namespace XF\Service\ThreadQuestion;

use XF\Entity\Post;
use XF\Entity\Thread;
use XF\Service\AbstractService;

class MarkSolution extends AbstractService
{
	/**
	 * @var Thread
	 */
	protected $thread;

	protected $notify = true;

	public function __construct(\XF\App $app, Thread $thread)
	{
		parent::__construct($app);
		$this->thread = $thread;
	}

	public function setNotify(bool $notify)
	{
		$this->notify = $notify;
	}

	public function unmarkSolution()
	{
		$thread = $this->thread;
		$typeData = $thread->type_data;

		$existingSolutionUserId = $typeData['solution_user_id'];
		$existingSolutionPostId = $typeData['solution_post_id'];

		unset($typeData['solution_post_id'], $typeData['solution_user_id']);
		$thread->type_data = $typeData;

		$thread->save();

		if ($existingSolutionUserId && $existingSolutionPostId)
		{
			/** @var \XF\Repository\UserAlert $alertRepo */
			$alertRepo = $this->repository('XF:UserAlert');
			$alertRepo->fastDeleteAlertsToUser(
				$existingSolutionUserId,
				'post',
				$existingSolutionPostId,
				'question_solution'
			);
		}
	}

	public function markSolution(Post $post)
	{
		$thread = $this->thread;

		$typeData = $thread->type_data;
		$typeData['solution_post_id'] = $post->post_id;
		$typeData['solution_user_id'] = $post->user_id;

		$thread->type_data = $typeData;

		$thread->save();

		if ($this->notify)
		{
			$user = $post->User;
			$visitor = \XF::visitor();

			if ($user && $visitor->user_id && $user->user_id != $visitor->user_id)
			{
				/** @var \XF\Repository\UserAlert $alertRepo */
				$alertRepo = $this->repository('XF:UserAlert');

				$alertRepo->alertFromUser(
					$user, $visitor,
					'post', $post->post_id,
					'question_solution'
				);
			}
		}
	}
}