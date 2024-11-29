<?php

namespace XF\Import\Importer;

use XF\Import\StepState;

use function count;

trait StepPostsTrait
{
	protected static $postsStepLimit = 500;

	/**
	 * @return array
	 */
	abstract public function getStepEndThreads();

	/**
	 * @param $startAfter
	 * @param $end
	 * @param $threadLimit
	 *
	 * @return array
	 */
	abstract protected function getThreadIdsForPostsStep($startAfter, $end, $threadLimit);

	/**
	 * @param $threadId
	 * @param $startDate
	 *
	 * @return array
	 */
	abstract protected function getPostsForPostsStep($threadId, $startDate);

	/**
	 * @param array $posts
	 *
	 * @return void
	 */
	abstract protected function lookupUsers(array $posts);

	/**
	 * @return string
	 */
	abstract protected function getPostDateField();

	/**
	 * @return string
	 */
	abstract protected function getPostIdField();

	/**
	 * @param array $post
	 *
	 * @return \XF\Import\Data\Post
	 */
	abstract protected function handlePostImport(array $post, $newThreadId, StepState $state);

	public function getStepEndPosts()
	{
		return $this->getStepEndThreads();
	}

	public function stepPosts(StepState $state, array $stepConfig, $maxTime, $limit = 200)
	{
		if ($state->startAfter == 0 && $state->imported == 0)
		{
			// just in case these are lying around, get rid of them before continue...
			unset($state->extra['postDateStart'], $state->extra['postPosition']);
		}

		$timer = new \XF\Timer($maxTime);

		$threadIds = $this->getThreadIdsForPostsStep($state->startAfter, $state->end, $limit);

		if (!$threadIds)
		{
			return $state->complete();
		}

		$this->lookup('thread', $threadIds);

		$dateField = $this->getPostDateField();
		$idField = $this->getPostIdField();

		foreach ($threadIds AS $oldThreadId)
		{
			$newThreadId = $this->lookupId('thread', $oldThreadId);

			if (!$newThreadId)
			{
				$state = $this->setStateNextThread($state, $oldThreadId);
				continue;
			}

			$total = 0;

			if (empty($state->extra['postDateStart']))
			{
				// starting a new thread, so initialize the variables that tell us we are mid-thread
				$state->extra['postDateStart'] = 0;
				$state->extra['postPosition'] = 0;
			}

			$posts = $this->getPostsForPostsStep($oldThreadId, $state->extra['postDateStart']);

			if (!$posts)
			{
				$state = $this->setStateNextThread($state, $oldThreadId);
				continue;
			}

			$this->lookupUsers($posts);

			$continueSameThread = false;
			if (count($posts) == self::$postsStepLimit)
			{
				$continueSameThread = true;
				$lastDateline = $posts[self::$postsStepLimit - 1][$dateField];
				while (count($posts) && ($posts[count($posts) - 1][$dateField] == $lastDateline))
				{
					// since we limited the retrieved posts, we don't know
					// if there are further posts in the database with
					// the same dateline, so drop posts until we find one
					// with an earlier dateline.
					array_pop($posts);
				}
			}

			foreach ($posts AS $i => $post)
			{
				$state->extra['postDateStart'] = $post[$dateField];

				$import = $this->handlePostImport($post, $newThreadId, $state);

				if ($import->message_state == 'visible')
				{
					$state->extra['postPosition']++;
				}

				$newId = $import->save($post[$idField]);
				if ($newId)
				{
					$this->afterPostImport($import, $post, $newId);
					$state->imported++;
					$total++;
				}

				/*
				 * Only allow the timer to break the loop if the next post in the array
				 * has a dateline different from that of the current post, because when we
				 * pick up the loop again, we will only fetch posts that have a date that
				 * is greater than the current post, so in the event that the next post
				 * has a dateline that is the same as the current one, it would otherwise
				 * be omitted.
				 */
				$nextIndex = $i + 1;
				$next = $posts[$nextIndex] ?? null;

				if ($next && $next[$dateField] != $post[$dateField] && $timer->limitExceeded())
				{
					break 2; // end both the post loop, AND the thread loop -- this will continue the same thread
				}
			}

			if ($continueSameThread)
			{
				break; // will resume the same thread if needed
			}

			$state = $this->setStateNextThread($state, $oldThreadId);

			if ($timer->limitExceeded())
			{
				break;
			}
		}

		return $state->resumeIfNeeded();
	}

	protected function afterPostImport(\XF\Import\Data\Post $import, array $sourceData, int $newId)
	{
	}

	protected function setStateNextThread(StepState $state, $threadId)
	{
		// move on to the next thread
		$state->startAfter = $threadId;

		// we've reached the end of a thread, so reset the variables that tell us we are mid-thread
		$state->extra['postDateStart'] = 0;
		$state->extra['postPosition'] = 0;

		return $state;
	}
}
