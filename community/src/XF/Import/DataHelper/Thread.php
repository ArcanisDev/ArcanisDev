<?php

namespace XF\Import\DataHelper;

use function is_scalar;

class Thread extends AbstractHelper
{
	public function importThreadWatch($threadId, $userId, $email = false)
	{
		$this->importThreadWatchBulk($threadId, [$userId => $email]);
	}

	public function importThreadWatchBulk($threadId, array $userConfigs)
	{
		$insert = [];

		foreach ($userConfigs AS $userId => $config)
		{
			if (is_scalar($config))
			{
				$config = ['email_subscribe' => (bool)$config];
			}

			$insert[] = [
				'user_id' => $userId,
				'thread_id' => $threadId,
				'email_subscribe' => empty($config['email_subscribe']) ? 0 : 1
			];
		}

		if ($insert)
		{
			$this->db()->insertBulk(
				'xf_thread_watch',
				$insert,
				false,
				'email_subscribe = VALUES(email_subscribe)'
			);
		}
	}

	public function updateQuestionSolution(int $threadId, int $postId)
	{
		if (!$threadId || !$postId)
		{
			return;
		}

		$db = $this->db();

		$solutionPost = $db->fetchRow("
			SELECT post.thread_id, 
			       post.user_id,
			       post.message_state, 
			       thread.discussion_state,
			       forum.count_messages
			FROM xf_post AS post
			INNER JOIN xf_thread AS thread ON (post.thread_id = thread.thread_id)
			INNER JOIN xf_forum AS forum ON (thread.node_id = forum.node_id)
			WHERE post.post_id = ?
		", $postId);
		if (!$solutionPost)
		{
			return;
		}

		if (
			$solutionPost['thread_id'] != $threadId
			|| $solutionPost['message_state'] != 'visible'
		)
		{
			// solution isn't in the expected thread or isn't visible
			return;
		}

		$db->update(
			'xf_thread_question',
			['solution_post_id' => $postId, 'solution_user_id' => $solutionPost['user_id']],
			'thread_id = ?',
			$threadId
		);

		if (
			$solutionPost['discussion_state'] == 'visible'
			&& $solutionPost['count_messages']
			&& $solutionPost['user_id']
		)
		{
			// thread is visible and in a message counting forum, add to user solution count
			$db->query("
				UPDATE xf_user
				SET question_solution_count = question_solution_count + 1
				WHERE user_id = ?
			", $solutionPost['user_id']);
		}
	}
}