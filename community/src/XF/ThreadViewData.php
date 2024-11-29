<?php

namespace XF;

use XF\Mvc\Entity\AbstractCollection;

use function is_array;

class ThreadViewData
{
	/**
	 * @var \XF\Entity\Thread
	 */
	protected $thread;

	/**
	 * Posts that will be displayed in the "main" post list
	 *
	 * @var array
	 */
	protected $mainPosts;

	/**
	 * @var array
	 */
	protected $extraPosts = [];

	/**
	 * @var \XF\Entity\Post|null
	 */
	protected $pinnedFirstPost;

	/**
	 * @var array
	 */
	protected $highlightedPosts = [];

	/**
	 * @param Entity\Thread $thread
	 * @param AbstractCollection|array $posts All fetched posts, including extra
	 * @param int[] $extraFetchedIds List of extra fetched post IDs (those not normally displayed on this page)
	 */
	public function __construct(\XF\Entity\Thread $thread, $posts, array $extraFetchedIds = [])
	{
		if ($posts instanceof AbstractCollection)
		{
			$posts = $posts->toArray();
		}
		else if (!is_array($posts))
		{
			throw new \InvalidArgumentException("Posts must be AbstractCollection or array");
		}

		// remove these from the main posts list immediately
		foreach ($extraFetchedIds AS $extraFetchedId)
		{
			if (isset($posts[$extraFetchedId]))
			{
				$this->extraPosts[$extraFetchedId] = $posts[$extraFetchedId];
				unset($posts[$extraFetchedId]);
			}
		}

		$this->thread = $thread;
		$this->mainPosts = $posts;
	}

	/**
	 * Gets the posts for the main post list.
	 *
	 * @return array
	 */
	public function getMainPosts(): array
	{
		return $this->mainPosts;
	}

	/**
	 * Marks the first post of the thread as pinned. It will be moved out of the main post list.
	 */
	public function pinFirstPost()
	{
		$postId = $this->thread->first_post_id;

		if (isset($this->mainPosts[$postId]))
		{
			$this->pinnedFirstPost = $this->mainPosts[$postId];
			unset($this->mainPosts[$postId]); // remove it from the flow
		}
		else if (isset($this->extraPosts[$postId]))
		{
			$this->pinnedFirstPost = $this->extraPosts[$postId];
		}
		else
		{
			throw new \InvalidArgumentException("First post ($postId) in thread {$this->thread->thread_id} could not be pinned");
		}
	}

	/**
	 * @return Entity\Post|null
	 */
	public function getPinnedFirstPost()
	{
		return $this->pinnedFirstPost;
	}

	/**
	 * Marks the specific posts as highlighted. These will be collected into a highlighted post list
	 * in the order provided in the array.
	 *
	 * Highlighted posts will not be removed from the main post list.
	 *
	 * @param int[] $highlightPostIds
	 */
	public function addHighlightedPosts(array $highlightPostIds)
	{
		foreach ($highlightPostIds AS $highlightPostId)
		{
			if (isset($this->mainPosts[$highlightPostId]))
			{
				$this->highlightedPosts[$highlightPostId] = $this->mainPosts[$highlightPostId];
			}
			else if (isset($this->extraPosts[$highlightPostId]))
			{
				$this->highlightedPosts[$highlightPostId] = $this->extraPosts[$highlightPostId];
			}
		}
	}

	/**
	 * @return array
	 */
	public function getHighlightedPosts(): array
	{
		return $this->highlightedPosts;
	}

	/**
	 * Gets all of the fully displayed posts. This will include the pinned first post and the main post list.
	 *
	 * @return array
	 */
	public function getFullyDisplayedPosts(): array
	{
		return iterator_to_array($this->generatePostList());
	}

	/**
	 * Sets up a generator that iterates over all posts in the setup display order.
	 *
	 * @return \Generator
	 */
	protected function generatePostList()
	{
		if ($this->pinnedFirstPost)
		{
			yield $this->pinnedFirstPost->post_id => $this->pinnedFirstPost;
		}

		foreach ($this->mainPosts AS $id => $post)
		{
			yield $id => $post;
		}
	}

	/**
	 * Gets the first post that will be displayed on the page, respecting the display order.
	 *
	 * Note that this is the first post on the page, not necessarily the first by date.
	 *
	 * @return \XF\Entity\Post|null
	 */
	public function getFirstPost()
	{
		return $this->generatePostList()->current();
	}

	/**
	 * Gets the last post that will be displayed on the page, respecting the display order.
	 *
	 * Note that this is the last post on the page, not the last by date.
	 *
	 * @return \XF\Entity\Post|null
	 */
	public function getLastPost()
	{
		$last = null;

		foreach ($this->generatePostList() AS $post)
		{
			$last = $post;
		}

		return $last;
	}

	/**
	 * Gets the first unread post on the page, respecting display order. This is only meaningful in date order.
	 *
	 * @return \XF\Entity\Post|null
	 */
	public function getFirstUnread()
	{
		foreach ($this->generatePostList() AS $post)
		{
			/** @var \XF\Entity\Post $post */
			if ($post->isUnread())
			{
				return $post;
			}
		}

		return null;
	}

	/**
	 * Determines if any of the posts on the page allow inline moderation use.
	 *
	 * @return bool
	 */
	public function canUseInlineModeration(): bool
	{
		foreach ($this->generatePostList() AS $post)
		{
			/** @var \XF\Entity\Post $post */
			if ($post->canUseInlineModeration())
			{
				return true;
			}
		}

		return false;
	}
}