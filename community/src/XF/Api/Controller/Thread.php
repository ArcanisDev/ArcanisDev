<?php

namespace XF\Api\Controller;

use XF\Mvc\Entity\Entity;
use XF\Mvc\ParameterBag;

use function intval;

/**
 * @api-group Threads
 */
class Thread extends AbstractController
{
	protected function preDispatchController($action, ParameterBag $params)
	{
		if (strtolower($action) === 'postmarkread')
		{
			// Marking a thread as read is something that happens when simply viewing a thread normally,
			// so we're tying the mark-read action to read requirements only. Connecting it to thread:write
			// may strictly be more correct, but most thread:write actions are much more dramatic (creating
			// or editing a thread, etc) and thus thread:read feels more appropriate.
			$this->assertApiScope('thread:read');
		}
		else
		{
			$this->assertApiScopeByRequestMethod('thread');
		}
	}

	/**
	 * @api-desc Gets information about the specified thread.
	 *
	 * @api-in bool $with_posts If specified, the response will include a page of posts.
	 * @api-in int $page The page of posts to include
	 * @api-in bool $with_first_post If specified, the response will contain the first post in the thread.
	 * @api-in bool $with_last_post If specified, the response will contain the last post in the thread.
	 *
	 * @api-out Thread $thread
	 * @api-out Post $first_unread <cond> If the thread is unread, information about the first unread post.
	 * @api-out Post $first_post <cond> If requested, information about the first post in the thread.
	 * @api-out Post $last_post <cond> If requested, information about the last post in the thread.
	 * @api-see self::getPostsInThreadPaginated()
	 */
	public function actionGet(ParameterBag $params)
	{
		$with = ['api'];

		$options = [
			'first_post' => 'FirstPost',
			'last_post' => 'LastPost',
		];

		$relationOptions = [];

		foreach ($options AS $param => $relation)
		{
			$relationOptions[$param] = $this->filter("with_{$param}", 'bool');
			if ($relationOptions[$param])
			{
				$with[] = $relation . ".api";
			}
		}

		$thread = $this->assertViewableThread($params->thread_id, $with);

		if ($this->filter('with_posts', 'bool'))
		{
			$postData = $this->getPostsInThreadPaginated($thread, $this->filterPage());
		}
		else
		{
			$postData = [];
		}

		$result = [
			'thread' => $thread->toApiResult(Entity::VERBOSITY_VERBOSE),
		];

		if ($thread->isUnread())
		{
			/** @var \XF\Entity\Post $firstUnread */
			$firstUnread = $this->getPostRepo()
				->findNextPostsInThread($thread, $thread->getVisitorReadDate())
				->skipIgnored()
				->with('api')
				->fetchOne();

			if ($firstUnread)
			{
				$result['first_unread'] = $firstUnread->toApiResult();
			}
		}

		foreach ($options AS $param => $relation)
		{
			if ($relationOptions[$param])
			{
				$result[$param] = $thread->$relation->toApiResult();
			}
		}

		$result += $postData;

		return $this->apiResult($result);
	}

	/**
	 * @api-desc Gets a page of posts in the specified conversation.
	 *
	 * @api-in int $page
	 *
	 * @api-see self::getPostsInThreadPaginated
	 */
	public function actionGetPosts(ParameterBag $params)
	{
		$thread = $this->assertViewableThread($params->thread_id);

		$postData = $this->getPostsInThreadPaginated($thread, $this->filterPage());

		return $this->apiResult($postData);
	}

	/**
	 * @api-in string $order Request a particular sort order for posts from the available options for the thread type
	 *
	 * @api-out Post $pinned_post <cond> The pinned first post of the thread, if specified by the thread type.
	 * @api-out Post[] $highlighted_posts <cond> A list of highlighted posts, if relevant to the thread type. The reason for highlighting depends on thread type.
	 * @api-out Post[] $posts List of posts on the requested page. Note that even if the first post is pinned, it will be included here.
	 * @api-out pagination $pagination Pagination details
	 *
	 * @param \XF\Entity\Thread $thread
	 * @param int $page
	 * @param null|int $perPage
	 *
	 * @return array
	 *
	 * @throws \XF\Mvc\Reply\Exception
	 */
	protected function getPostsInThreadPaginated(\XF\Entity\Thread $thread, $page = 1, $perPage = null)
	{
		$perPage = intval($perPage);
		if ($perPage <= 0)
		{
			$perPage = $this->options()->messagesPerPage;
		}

		$threadPlugin = $this->plugin('XF:Thread');

		$filters = $this->getPostListFilterInput($thread);
		$effectiveOrder = $threadPlugin->getEffectivePostListOrder(
			$thread,
			$this->filter('order', 'str'),
			$defaultOrder,
			$availableSorts
		);

		$postList = $this->setupPostFinder($thread);
		$postList->order($availableSorts[$effectiveOrder]);
		$this->applyPostListFilters($thread, $postList, $filters);

		$thread->TypeHandler->adjustThreadPostListFinder($thread, $postList, $page, $this->request);

		if ($effectiveOrder == 'post_date' && !$filters)
		{
			$postList->onPage($page, $perPage);
		}
		else
		{
			$postList->limitByPage($page, $perPage);
		}

		$total = $filters ? $postList->total() : ($thread->reply_count + 1);

		$this->assertValidApiPage($page, $perPage, $total);

		$posts = $postList->fetch();
		$originalPagePostIds = $posts->keys();

		$isFirstPostPinned = $thread->TypeHandler->isFirstPostPinned($thread);
		$highlightPostIds = $thread->TypeHandler->getHighlightedPostIds($thread, $filters);

		$extraFetchIds = [];

		if ($isFirstPostPinned && !isset($posts[$thread->first_post_id]))
		{
			$extraFetchIds[$thread->first_post_id] = $thread->first_post_id;
		}
		foreach ($highlightPostIds AS $highlightPostId)
		{
			if (!isset($posts[$highlightPostId]))
			{
				$extraFetchIds[$highlightPostId] = $highlightPostId;
			}
		}

		if ($extraFetchIds)
		{
			/** @var \XF\Finder\Post $finder */
			$extraFinder = $this->finder('XF:Post')
				->inThread($thread)
				->where('post_id', $extraFetchIds)
				->with('api');

			$this->applyPostListFilters($thread, $extraFinder, $filters, $extraFetchIds);
			$thread->TypeHandler->adjustThreadPostListFinder(
				$thread, $extraFinder, $page, $this->request, $extraFetchIds
			);

			$fetchPinnedPosts = $extraFinder->fetch();
			$posts = $posts->merge($fetchPinnedPosts);
		}

		/** @var \XF\Repository\Attachment $attachmentRepo */
		$attachmentRepo = $this->repository('XF:Attachment');
		$attachmentRepo->addAttachmentsToContent($posts, 'post');

		$returnData = [];

		$threadViewData = $thread->TypeHandler->setupThreadViewData($thread, $posts, $extraFetchIds);

		if ($isFirstPostPinned)
		{
			$threadViewData->pinFirstPost();
			$pinnedPost = $threadViewData->getPinnedFirstPost();
			$returnData['pinned_post'] = $pinnedPost->toApiResult();
		}

		if ($highlightPostIds)
		{
			$threadViewData->addHighlightedPosts($highlightPostIds);
			$highlightedPosts = $threadViewData->getHighlightedPosts();
			$returnData['highlighted_posts'] = $this->em()->getBasicCollection($highlightedPosts)->toApiResults();
		}

		$originalPosts = [];
		foreach ($originalPagePostIds AS $originalPostId)
		{
			$originalPosts[$originalPostId] = $posts[$originalPostId];
		}

		return $returnData + [
			'posts' => $this->em()->getBasicCollection($originalPosts)->toApiResults(),
			'pagination' => $this->getPaginationData($originalPosts, $page, $perPage, $total)
		];
	}

	protected function getPostListFilterInput(\XF\Entity\Thread $thread): array
	{
		// Currently no globally supported filters
		$filters = [];

		return $thread->TypeHandler->getPostListFilterInput($thread, $this->request, $filters);
	}

	protected function applyPostListFilters(
		\XF\Entity\Thread $thread,
		\XF\Finder\Post $postList,
		array $filters,
		array $extraFetchIds = null
	)
	{
		// Note that if global filters are added, they should be skipped if there are $extraFetchIds.
		// The type handler should opt into that if needed as otherwise it could break thread display.

		$thread->TypeHandler->applyPostListFilters($thread, $postList, $filters, $extraFetchIds);
	}

	/**
	 * @param \XF\Entity\Thread $thread
	 * @return \XF\Finder\Post
	 */
	protected function setupPostFinder(\XF\Entity\Thread $thread)
	{
		/** @var \XF\Finder\Post $finder */
		$finder = $this->finder('XF:Post');
		$finder
			->inThread($thread)
			->orderByDate()
			->with('api');

		return $finder;
	}

	/**
	 * @param \XF\Entity\Thread $thread
	 *
	 * @return \XF\Service\Thread\Editor
	 */
	protected function setupThreadEdit(\XF\Entity\Thread $thread)
	{
		/** @var \XF\Service\Thread\Editor $editor */
		$editor = $this->service('XF:Thread\Editor', $thread);

		$input = $this->filter([
			'prefix_id' => '?uint',
			'title' => '?str',
			'discussion_open' => '?bool',
			'sticky' => '?bool',
			'custom_fields' => 'array',
			'add_tags' => 'array-str',
			'remove_tags' => 'array-str',
		]);

		$isBypassingPermissions = \XF::isApiBypassingPermissions();
		$isCheckingPermissions = \XF::isApiCheckingPermissions();

		if (isset($input['prefix_id']) && ($isBypassingPermissions || $thread->isPrefixEditable()))
		{
			$prefixId = $input['prefix_id'];
			if ($prefixId != $thread->prefix_id
				&& $isCheckingPermissions
				&& !$thread->Forum->isPrefixUsable($input['prefix_id'])
			)
			{
				$prefixId = 0; // not usable, just blank it out
			}
			$editor->setPrefix($prefixId);
		}

		if (isset($input['title']))
		{
			$editor->setTitle($input['title']);
		}

		if (isset($input['discussion_open']) && ($isBypassingPermissions || $thread->canLockUnlock()))
		{
			$editor->setDiscussionOpen($input['discussion_open']);
		}
		if (isset($input['sticky']) && ($isBypassingPermissions || $thread->canStickUnstick()))
		{
			$editor->setSticky($input['sticky']);
		}

		if ($input['custom_fields'])
		{
			$editor->setCustomFields($input['custom_fields'], true);
		}

		if ($isBypassingPermissions || $thread->canEditTags())
		{
			if ($input['add_tags'])
			{
				$editor->addTags($input['add_tags']);
			}
			if ($input['remove_tags'])
			{
				$editor->removeTags($input['remove_tags']);
			}
		}

		$editor->setDiscussionTypeDataForApi($this->request);

		return $editor;
	}

	/**
	 * @api-desc Updates the specified thread
	 *
	 * @api-in int $prefix_id
	 * @api-in str $title
	 * @api-in bool $discussion_open
	 * @api-in bool $sticky
	 * @api-in string $custom_fields[<name>]
	 * @api-in array $add_tags
	 * @api-in array $remove_tags
	 *
	 * @api-out true $success
	 * @api-out Thread $thread
	 */
	public function actionPost(ParameterBag $params)
	{
		$thread = $this->assertViewableThread($params->thread_id);

		if (\XF::isApiCheckingPermissions() && !$thread->canEdit($error))
		{
			return $this->noPermission($error);
		}

		$editor = $this->setupThreadEdit($thread);
		if (!$editor->validate($errors))
		{
			return $this->error($errors);
		}

		$editor->save();

		return $this->apiSuccess([
			'thread' => $thread->toApiResult(Entity::VERBOSITY_VERBOSE)
		]);
	}

	/**
	 * @api-desc Deletes the specified thread. Default to soft deletion.
	 *
	 * @api-in bool $hard_delete
	 * @api-in str $reason
	 * @api-in bool $starter_alert
	 * @api-in str $starter_alert_reason
	 *
	 * @api-out true $success
	 */
	public function actionDelete(ParameterBag $params)
	{
		$thread = $this->assertViewableThread($params->thread_id);

		if (\XF::isApiCheckingPermissions() && !$thread->canDelete('soft', $error))
		{
			return $this->noPermission($error);
		}

		$type = 'soft';
		$reason = $this->filter('reason', 'str');

		if ($this->filter('hard_delete', 'bool'))
		{
			$this->assertApiScope('thread:delete_hard');

			if (\XF::isApiCheckingPermissions() && !$thread->canDelete('hard', $error))
			{
				return $this->noPermission($error);
			}

			$type = 'hard';
		}

		/** @var \XF\Service\Thread\Deleter $deleter */
		$deleter = $this->service('XF:Thread\Deleter', $thread);

		if ($this->filter('starter_alert', 'bool'))
		{
			$deleter->setSendAlert(true, $this->filter('starter_alert_reason', 'str'));
		}

		$deleter->delete($type, $reason);

		return $this->apiSuccess();
	}

	/**
	 * @api-desc Votes on the specified thread (if applicable)
	 *
	 * @api-see \XF\Api\ControllerPlugin\ContentVote::actionVote()
	 */
	public function actionPostVote(ParameterBag $params)
	{
		$thread = $this->assertViewableThread($params->thread_id);

		/** @var \XF\Api\ControllerPlugin\ContentVote $votePlugin */
		$votePlugin = $this->plugin('XF:Api:ContentVote');
		return $votePlugin->actionVote($thread);
	}

	/**
	 * @api-desc Marks the thread as read up until the specified time. This cannot mark a thread as unread or
	 *  move the read marking date to an earlier point in time.
	 *
	 * @api-in int $date Unix timestamp to mark the thread read to. If not specified, defaults to the current time.
	 *
	 * @api-out true $success
	 */
	public function actionPostMarkRead(ParameterBag $params)
	{
		$this->assertRegisteredUser();

		$thread = $this->assertViewableThread($params->thread_id);

		$readDate = $this->filter('date', '?uint');
		if (!$readDate || $readDate > \XF::$time)
		{
			$readDate = null;
		}
		else if ($readDate < $thread->post_date)
		{
			$readDate = $thread->post_date;
		}

		$this->getThreadRepo()->markThreadReadByVisitor($thread, $readDate);

		return $this->apiSuccess();
	}

	/**
	 * @param \XF\Entity\Thread $thread
	 * @param \XF\Entity\Forum $targetForum
	 *
	 * @return \XF\Service\Thread\Mover
	 */
	protected function setupThreadMove(\XF\Entity\Thread $thread, \XF\Entity\Forum $targetForum)
	{
		$options = $this->filter([
			'notify_watchers' => 'bool',
			'starter_alert' => 'bool',
			'starter_alert_reason' => 'str',
			'prefix_id' => '?uint',
			'title' => '?str'
		]);

		/** @var \XF\Service\Thread\Mover $mover */
		$mover = $this->service('XF:Thread\Mover', $thread);

		if ($options['starter_alert'])
		{
			$mover->setSendAlert(true, $options['starter_alert_reason']);
		}

		if ($options['notify_watchers'])
		{
			$mover->setNotifyWatchers();
		}

		if ($options['prefix_id'] !== null)
		{
			$mover->setPrefix($options['prefix_id']);
		}

		$mover->addExtraSetup(function($thread) use ($options)
		{
			if ($options['title'] !== null)
			{
				$thread->title = $options['title'];
			}
		});

		return $mover;
	}

	/**
	 * @api-desc Moves the specified thread to a different forum. Only simple title/prefix updates are supported at the same time
	 *
	 * @api-in <req> int $target_node_id
	 * @api-in int $prefix_id If set, will update the thread's prefix. Prefix must be valid in the target forum.
	 * @api-in str $title If set, updates the thread's title
	 * @api-in bool $notify_watchers If true, users watching the target forum will receive a notification as if this thread were created in the target forum
	 * @api-in bool $starter_alert If true, the thread starter will receive an alert notifying them of the move
	 * @api-in bool $starter_alert_reason The reason for the move to include with the thread starter alert
	 *
	 * @api-out true $success
	 * @api-out Thread $thread
	 */
	public function actionPostMove(ParameterBag $params)
	{
		$this->assertRequiredApiInput('target_node_id');

		$thread = $this->assertViewableThread($params->thread_id);

		if (\XF::isApiCheckingPermissions() && !$thread->canMove($error))
		{
			return $this->noPermission($error);
		}

		/** @var \XF\Entity\Forum $targetForum */
		$targetForum = $this->assertViewableApiRecord('XF:Forum', $this->filter('target_node_id', 'uint'));

		$this->setupThreadMove($thread, $targetForum)->move($targetForum);

		return $this->apiSuccess([
			'thread' => $thread->toApiResult(Entity::VERBOSITY_VERBOSE)
		]);
	}

	/**
	 * @api-desc Converts a thread to the specified type. Additional thread type data can be set using input specific to the new thread type.
	 *
	 * @api-in <req> str $new_thread_type_id
	 *
	 * @api-out true $success
	 * @api-out Thread $thread
	 */
	public function actionPostChangeType(ParameterBag $params)
	{
		$this->assertRequiredApiInput('new_thread_type_id');

		$thread = $this->assertViewableThread($params->thread_id);

		if (\XF::isApiCheckingPermissions() && !$thread->canChangeType($error))
		{
			return $this->noPermission($error);
		}

		// this is normally part of canChangeType, but because we might bypass that, we need to check again
		if (!$thread->TypeHandler->canThreadTypeBeChanged($thread))
		{
			return $this->noPermission(\XF::phrase('threads_type_not_changeable'));
		}

		$newThreadType = $this->filter('new_thread_type_id', 'str');
		$newThreadType = $this->app()->threadType($newThreadType);

		$currentThreadType = $thread->TypeHandler;

		if ($newThreadType && $newThreadType->getTypeId() == $currentThreadType->getTypeId())
		{
			return $this->error(\XF::phrase('thread_is_already_that_type'));
		}

		/** @var \XF\Service\Thread\ChangeType $typeChanger */
		$typeChanger = $this->setupThreadChangeType($thread, $newThreadType);

		if (!$typeChanger->validate($errors))
		{
			return $this->error($errors);
		}

		$typeChanger->save();

		return $this->apiSuccess([
			'thread' => $thread->toApiResult(Entity::VERBOSITY_VERBOSE)
		]);
	}

	protected function setupThreadChangeType(\XF\Entity\Thread $thread, \XF\ThreadType\AbstractHandler $newThreadType)
	{
		$input = $this->filter([
			'allow_uncreatable_type' => 'bool'
		]);

		/** @var \XF\Service\Thread\ChangeType $typeChanger */
		$typeChanger = $this->service('XF:Thread\ChangeType', $thread);

		$allowUncreatable = \XF::isApiBypassingPermissions() && $input['allow_uncreatable_type'];
		$typeChanger->setDiscussionTypeAndDataForApi($newThreadType->getTypeId(), $this->request, [], $allowUncreatable);

		return $typeChanger;
	}

	/**
	 * @param int $id
	 * @param string|array $with
	 *
	 * @return \XF\Entity\Thread
	 *
	 * @throws \XF\Mvc\Reply\Exception
	 */
	protected function assertViewableThread($id, $with = 'api')
	{
		return $this->assertViewableApiRecord('XF:Thread', $id, $with);
	}

	/**
	 * @return \XF\Repository\Thread
	 */
	protected function getThreadRepo()
	{
		return $this->repository('XF:Thread');
	}

	/**
	 * @return \XF\Repository\Post
	 */
	protected function getPostRepo()
	{
		return $this->repository('XF:Post');
	}
}