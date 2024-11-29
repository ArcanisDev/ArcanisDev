<?php

namespace XF\Pub\Controller;

use XF\Mvc\ParameterBag;

use function count, in_array, intval, is_int, strval;

class Forum extends AbstractController
{
	/**
	 * @param ParameterBag $params
	 *
	 * @return \XF\Mvc\Reply\Reroute|\XF\Mvc\Reply\View
	 */
	public function actionIndex(ParameterBag $params)
	{
		if ($params->node_id || $params->node_name)
		{
			return $this->rerouteController('XF:Forum', 'Forum', $params);
		}

		if ($this->responseType == 'rss')
		{
			return $this->getForumRss();
		}

		switch ($this->options()->forumsDefaultPage)
		{
			case 'new_posts':
				return $this->rerouteController(__CLASS__, 'newposts');

			case 'forums':
			default:
				return $this->rerouteController(__CLASS__, 'list');
		}
	}

	public function actionList(ParameterBag $params)
	{
		$this->assertNotEmbeddedImageRequest();

		if ($params->node_id || $params->node_name)
		{
			$forum = $this->assertViewableForum($params->node_id ?: $params->node_name);
			return $this->redirectPermanently($this->buildLink('forums', $forum));
		}

		$selfRoute = ($this->options()->forumsDefaultPage == 'forums' ? 'forums' : 'forums/list');

		$this->assertCanonicalUrl($this->buildLink($selfRoute));

		$nodeRepo = $this->getNodeRepo();
		$nodes = $nodeRepo->getNodeList();

		$nodeTree = $nodeRepo->createNodeTree($nodes);
		$nodeExtras = $nodeRepo->getNodeListExtras($nodeTree);

		$viewParams = [
			'nodeTree' => $nodeTree,
			'nodeExtras' => $nodeExtras,
			'selfRoute' => $selfRoute
		];
		return $this->view('XF:Forum\Listing', 'forum_list', $viewParams);
	}

	public function actionNewPosts(ParameterBag $params)
	{
		$this->assertNotEmbeddedImageRequest();

		if ($params->node_id || $params->node_name)
		{
			$forum = $this->assertViewableForum($params->node_id ?: $params->node_name);
			return $this->redirectPermanently($this->buildLink('forums', $forum));
		}

		if ($this->options()->forumsDefaultPage != 'new_posts')
		{
			return $this->redirectPermanently($this->buildLink('whats-new/posts'));
		}

		/** @var \XF\ControllerPlugin\FindNew $findNewPlugin */
		$findNewPlugin = $this->plugin('XF:FindNew');

		$handler = $findNewPlugin->getFindNewHandler('thread');
		if (!$handler)
		{
			return $this->noPermission();
		}

		$page = $this->filterPage();
		$perPage = $handler->getResultsPerPage();

		$findNewId = $this->filter('f', 'uint');

		if ($this->options()->forumsDefaultPage == 'new_posts')
		{
			if (!$findNewId && $page == 1)
			{
				$selfRoute = 'forums';
			}
			else
			{
				$selfRoute = 'forums/new-posts';
			}
		}
		else
		{
			$selfRoute = 'forums/new-posts';
		}

		$this->assertCanonicalUrl($this->buildLink($selfRoute));

		$findNew = $findNewPlugin->getFindNewRecord($findNewId, 'thread');
		if (!$findNew)
		{
			$filters = $findNewPlugin->getRequestedFilters($handler);
			$findNew = $findNewPlugin->runFindNewSearch($handler, $filters);

			if ($this->filter('save', 'bool') && $this->isPost())
			{
				$findNewPlugin->saveDefaultFilters($handler, $filters);
			}

			if ($findNewPlugin->findNewRequiresSaving($findNew))
			{
				$findNew->save();

				if ($this->isPost())
				{
					return $this->redirect($this->buildLink('forums/new-posts', null, [
						'f' => $findNew->find_new_id
					]));
				}
			}

			$page = 1;
		}
		else
		{
			$remove = $this->filter('remove', 'str');
			if ($remove)
			{
				$filters = $findNew->filters;
				unset($filters[$remove]);

				$findNew = $findNewPlugin->runFindNewSearch($handler, $filters);
				if ($findNewPlugin->findNewRequiresSaving($findNew))
				{
					$findNew->save();

					return $this->redirect($this->buildLink('forums/new-posts', null, [
						'f' => $findNew->find_new_id
					]));
				}
			}
		}

		if ($findNew->result_count)
		{
			$this->assertValidPage($page, $perPage, $findNew->result_count, 'forums/new-posts');

			$pageIds = $findNew->getPageResultIds($page, $perPage);
			$threads = $handler->getPageResults($pageIds);
		}
		else
		{
			$threads = [];
		}

		$canInlineMod = false;
		foreach ($threads AS $thread)
		{
			if ($thread->canUseInlineModeration())
			{
				$canInlineMod = true;
				break;
			}
		}

		$viewParams = [
			'findNew' => $findNew,
			'originalFindNewId' => $findNewId,
			'page' => $page,
			'perPage' => $perPage,
			'selfRoute' => $selfRoute,

			'threads' => $threads,
			'canInlineMod' => $canInlineMod
		];
		return $this->view('XF:Forum\NewPosts', 'forum_new_posts', $viewParams);
	}

	public function actionForum(ParameterBag $params)
	{
		$this->assertNotEmbeddedImageRequest();

		$forum = $this->assertViewableForum($params->node_id ?: $params->node_name, $this->getForumViewExtraWith());
		$forumTypeHandler = $forum->TypeHandler;

		$overrideReply = $forumTypeHandler->overrideDisplay($forum, $this);
		if ($overrideReply)
		{
			return $overrideReply;
		}

		if ($this->responseType == 'rss')
		{
			$this->assertNotEmbeddedImageRequest();

			return $this->getForumRss($forum);
		}

		$filters = $this->getForumFilterInput($forum);

		$page = $this->filterPage($params->page);
		$perPage = $forumTypeHandler->getThreadsPerPage($forum);

		$this->assertCanonicalUrl($this->buildLink('forums', $forum, ['page' => $page]));

		$threadRepo = $this->getThreadRepo();

		$threadList = $threadRepo->findThreadsForForumView(
			$forum, [
			'allowOwnPending' => $this->hasContentPendingApproval()
		]
		);
		$this->applyForumFilters($forum, $threadList, $filters);
		$forum->TypeHandler->adjustForumThreadListFinder($forum, $threadList, $page, $this->request);

		if ($page == 1)
		{
			$stickyThreadList = clone $threadList;

			/** @var \XF\Entity\Thread[]|\XF\Mvc\Entity\AbstractCollection $stickyThreads */
			$stickyThreads = $stickyThreadList->where('sticky', 1)->fetch();
		}
		else
		{
			$stickyThreads = null;
		}

		$this->applyDateLimitFilters($forum, $threadList, $filters);

		$threadList->where('sticky', 0)
			->limitByPage($page, $perPage);

		/** @var \XF\Entity\Thread[]|\XF\Mvc\Entity\AbstractCollection $threads */
		$threads = $threadList->fetch();
		$totalThreads = $threadList->total();

		$this->assertValidPage($page, $perPage, $totalThreads, 'forums', $forum->Node);

		$nodeRepo = $this->getNodeRepo();
		$nodes = $nodeRepo->getNodeList($forum->Node);
		$nodeTree = count($nodes) ? $nodeRepo->createNodeTree($nodes, $forum->node_id) : null;
		$nodeExtras = $nodeTree ? $nodeRepo->getNodeListExtras($nodeTree) : null;

		$allThreads = $threads;
		if ($stickyThreads)
		{
			$allThreads->merge($stickyThreads);
		}
		$forumTypeHandler->fetchExtraContentForThreadsFullView($forum, $allThreads);

		$canInlineMod = false;
		if ($stickyThreads)
		{
			foreach ($stickyThreads AS $thread)
			{
				if ($thread->canUseInlineModeration())
				{
					$canInlineMod = true;
					break;
				}
			}
		}
		foreach ($threads AS $thread)
		{
			if ($thread->canUseInlineModeration())
			{
				$canInlineMod = true;
				break;
			}
		}

		// if the forum is unread and perhaps it shouldn't be, see if we can mark it AS read
		if (\XF::visitor()->user_id
			&& $page == 1
			&& !$filters
			&& $forum->isUnread()
		)
		{
			$hasNew = false;
			foreach ($threads AS $thread)
			{
				if ($thread->isUnread() && !$thread->isIgnored())
				{
					$hasNew = true;
					break;
				}
			}

			if (!$hasNew)
			{
				$this->getForumRepo()->markForumReadIfPossible($forum);
			}
		}

		if (!empty($filters['starter_id']))
		{
			$starterFilter = $this->em()->find('XF:User', $filters['starter_id']);
		}
		else
		{
			$starterFilter = null;
		}

		if (!empty($filters['thread_type']) && $forum->TypeHandler->isThreadTypeAllowed($filters['thread_type'], $forum))
		{
			$threadTypeFilter = $this->app->threadType($filters['thread_type'], false);
		}
		else
		{
			$threadTypeFilter = null;
		}

		$isDateLimited = (empty($filters['no_date_limit']) && (!empty($filters['last_days']) || $forum->list_date_limit_days));
		$threadEndOffset = ($page - 1) * $perPage + count($threads);
		$showDateLimitDisabler = ($isDateLimited && $threadEndOffset >= $totalThreads);

		$canonicalFilters = [];
		if ($page > 1 && $forum->list_date_limit_days && empty($filters['order']))
		{
			$cutOff = \XF::$time - ($forum->list_date_limit_days * 86400);
			$lastThread = $threads->last();
			if (
				$showDateLimitDisabler
				|| ($lastThread && $lastThread->last_post_date <= $cutOff)
			)
			{
				// we have removed the date limit and the last thread here is only shown because of that
				$canonicalFilters['no_date_limit'] = 1;
			}
		}

		$isPreRegQuickThread = $forum->canCreateThreadPreReg();
		if ($forum->canCreateThread() || $isPreRegQuickThread)
		{
			$quickThreadPrefixes = \XF::asPreRegActionUserIfNeeded(
				$isPreRegQuickThread,
				function() use ($forum) { return $forum->getUsablePrefixes(); }
			);
		}
		else
		{
			$quickThreadPrefixes = [];
		}

		$overrideContext = [
			'page' => $page,
			'filters' => $filters
		];

		$viewParams = [
			'forum' => $forum,

			'canInlineMod' => $canInlineMod,

			'nodeTree' => $nodeTree,
			'nodeExtras' => $nodeExtras,

			'stickyThreads' => $stickyThreads,
			'threads' => $threads,

			'page' => $page,
			'perPage' => $perPage,
			'total' => $totalThreads,

			'filters' => $filters,
			'canonicalFilters' => $canonicalFilters,
			'starterFilter' => $starterFilter,
			'threadTypeFilter' => $threadTypeFilter,
			'showDateLimitDisabler' => $showDateLimitDisabler,

			'sortInfo' => $this->getEffectiveSortInfo($forum, $filters),

			'pendingApproval' => $this->filter('pending_approval', 'bool'),

			'templateOverrides' => $forumTypeHandler->getForumViewTemplateOverrides($forum, $overrideContext),

			'quickThreadPrefixes' => $quickThreadPrefixes
		];

		list($viewClass, $viewTemplate) = $forumTypeHandler->getForumViewAndTemplate($forum);
		$viewParams = $forumTypeHandler->adjustForumViewParams($forum, $viewParams, $this->request);

		return $this->view($viewClass, $viewTemplate, $viewParams);
	}

	protected function getForumViewExtraWith()
	{
		$extraWith = [];
		$userId = \XF::visitor()->user_id;
		if ($userId)
		{
			$extraWith[] = 'Watch|' . $userId;
		}

		return $extraWith;
	}

	protected function getAvailableForumSorts(\XF\Entity\Forum $forum)
	{
		return $forum->TypeHandler->getThreadListSortOptions($forum);
	}

	protected function getAvailableDateLimits(\XF\Entity\Forum $forum)
	{
		return [-1, 7, 14, 30, 60, 90, 182, 365];
	}

	protected function applyForumFilters(\XF\Entity\Forum $forum, \XF\Finder\Thread $threadFinder, array $filters)
	{
		if (!empty($filters['prefix_id']))
		{
			$threadFinder->where('prefix_id', intval($filters['prefix_id']));
		}

		if (!empty($filters['starter_id']))
		{
			$threadFinder->where('user_id', intval($filters['starter_id']));
		}

		if (!empty($filters['thread_type']))
		{
			$threadFinder->where('discussion_type', $filters['thread_type']);
		}

		$sorts = $this->getAvailableForumSorts($forum);

		if (!empty($filters['order']) && isset($sorts[$filters['order']]))
		{
			$threadFinder->order($sorts[$filters['order']], $filters['direction']);
		}
		// else the default order has already been applied

		$forum->TypeHandler->applyForumFilters($forum, $threadFinder, $filters);
	}

	protected function applyDateLimitFilters(\XF\Entity\Forum $forum, \XF\Finder\Thread $threadFinder, array $filters)
	{
		if (!empty($filters['last_days']) && empty($filters['no_date_limit']))
		{
			if ($filters['last_days'] > 0)
			{
				$threadFinder->where('last_post_date', '>=', \XF::$time - ($filters['last_days'] * 86400));
			}
		}
		else if ($forum->list_date_limit_days && empty($filters['no_date_limit']))
		{
			$threadFinder->where('last_post_date', '>=', \XF::$time - ($forum->list_date_limit_days * 86400));
		}
	}

	protected function getForumFilterInput(\XF\Entity\Forum $forum)
	{
		$filters = [];

		$input = $this->filter([
			'prefix_id' => 'uint',
			'starter' => 'str',
			'starter_id' => 'uint',
			'last_days' => 'int',
			'order' => 'str',
			'direction' => 'str',
			'no_date_limit' => 'bool',
			'thread_type' => 'str'
		]);

		if ($input['no_date_limit'])
		{
			$filters['no_date_limit'] = $input['no_date_limit'];
		}

		if ($input['prefix_id'] && $forum->isPrefixValid($input['prefix_id']))
		{
			$filters['prefix_id'] = $input['prefix_id'];
		}

		if ($input['starter_id'])
		{
			$filters['starter_id'] = $input['starter_id'];
		}
		else if ($input['starter'])
		{
			$user = $this->em()->findOne('XF:User', ['username' => $input['starter']]);
			if ($user)
			{
				$filters['starter_id'] = $user->user_id;
			}
		}

		if (
			($input['last_days'] > 0 && $input['last_days'] != $forum->list_date_limit_days)
			|| ($input['last_days'] < 0 && $forum->list_date_limit_days)
		)
		{
			if (in_array($input['last_days'], $this->getAvailableDateLimits($forum)))
			{
				$filters['last_days'] = $input['last_days'];
			}
		}

		$sorts = $this->getAvailableForumSorts($forum);

		if ($input['order'] && isset($sorts[$input['order']]))
		{
			if (!in_array($input['direction'], ['asc', 'desc']))
			{
				$input['direction'] = 'desc';
			}

			if ($input['order'] != $forum->default_sort_order || $input['direction'] != $forum->default_sort_direction)
			{
				$filters['order'] = $input['order'];
				$filters['direction'] = $input['direction'];
			}
		}

		if ($input['thread_type'] && $forum->TypeHandler->isThreadTypeAllowed($input['thread_type'], $forum))
		{
			$filters['thread_type'] = $input['thread_type'];
		}

		$filters = $forum->TypeHandler->getForumFilterInput($forum, $this->request, $filters);

		return $filters;
	}

	public function actionFilters(ParameterBag $params)
	{
		$forum = $this->assertViewableForum($params->node_id ?: $params->node_name);

		$filters = $this->getForumFilterInput($forum);

		if ($this->filter('apply', 'bool'))
		{
			if (!empty($filters['last_days']))
			{
				unset($filters['no_date_limit']);
			}
			return $this->redirect($this->buildLink('forums', $forum, $filters));
		}

		if (!empty($filters['starter_id']))
		{
			$starterFilter = $this->em()->find('XF:User', $filters['starter_id']);
		}
		else
		{
			$starterFilter = null;
		}

		$allowedThreadTypes = [];
		foreach ($forum->TypeHandler->getFilterableThreadTypes($forum) AS $threadType)
		{
			$handler = $this->app->threadType($threadType, false);
			if ($handler)
			{
				$allowedThreadTypes[$threadType] = $handler;
			}
		}

		$viewParams = [
			'forum' => $forum,
			'prefixes' => $forum->prefixes->groupBy('prefix_group_id'),
			'filters' => $filters,
			'starterFilter' => $starterFilter,
			'allowedThreadTypes' => $allowedThreadTypes,
			'sortOptions' => $forum->TypeHandler->getThreadListSortOptions($forum)
		];
		$view = $this->view('XF:Forum\Filters', 'forum_filters', $viewParams);

		return $forum->TypeHandler->adjustForumFiltersPopup($forum, $view);
	}

	public function actionDraft(ParameterBag $params)
	{
		$this->assertDraftsEnabled();

		$forum = $this->assertViewableForum($params->node_id ?: $params->node_name);

		/** @var \XF\Service\Thread\Creator $creator */
		$creator = $this->setupThreadCreate($forum);
		$thread = $creator->getThread();

		$extraData = [
			'prefix_id' => $thread->prefix_id,
			'title' => $thread->title,
			'discussion_type' => $this->filter('discussion_type', 'str'),
			'tags' => $this->filter('tags', 'str'),
			'attachment_hash' => $this->filter('attachment_hash', 'str'),
			'custom_fields' => $thread->custom_fields->getFieldValues()
		];

		$extraData = array_merge(
			$extraData,
			$thread->TypeHandler->getExtraDataForDraft($thread, $this->request)
		);

		/** @var \XF\ControllerPlugin\Draft $draftPlugin */
		$draftPlugin = $this->plugin('XF:Draft');
		$draftReply = $draftPlugin->actionDraftMessage($forum->draft_thread, $extraData, 'message', $draftAction);

		if ($draftAction == 'save')
		{
			$draftPlugin->refreshTempAttachments($extraData['attachment_hash']);
		}

		return $draftReply;
	}

	protected function getPrefixIdIfUsable(\XF\Entity\Forum $forum): int
	{
		$prefixId = $this->filter('prefix_id', 'uint');
		if ($prefixId)
		{
			$isUsable = \XF::asPreRegActionUserIfNeeded(
				$forum->canCreateThreadPreReg(),
				function() use ($forum, $prefixId) { return $forum->isPrefixUsable($prefixId); }
			);
			if ($isUsable)
			{
				return $prefixId;
			}
		}

		return 0;
	}

	/**
	 * @param \XF\Entity\Forum $forum
	 *
	 * @return \XF\Service\Thread\Creator
	 */
	protected function setupThreadCreate(\XF\Entity\Forum $forum)
	{
		$title = $this->filter('title', 'str');
		$message = $this->plugin('XF:Editor')->fromInput('message');

		/** @var \XF\Service\Thread\Creator $creator */
		$creator = $this->service('XF:Thread\Creator', $forum);

		$isPreRegAction = $forum->canCreateThreadPreReg();
		if ($isPreRegAction)
		{
			// only returns true when pre-reg creating is the only option
			$creator->setIsPreRegAction(true);
		}

		$creator->setDiscussionTypeAndData(
			$this->filter('discussion_type', 'str'),
			$this->request
		);

		$creator->setContent($title, $message);

		$prefixId = $this->getPrefixIdIfUsable($forum);
		if ($prefixId)
		{
			$creator->setPrefix($prefixId);
		}

		$canEditTags = \XF::asPreRegActionUserIfNeeded(
			$isPreRegAction,
			function() use ($forum) { return $forum->canEditTags(); }
		);
		if ($canEditTags)
		{
			$creator->setTags($this->filter('tags', 'str'));
		}

		// attachments aren't supported in pre-reg actions
		if ($forum->canUploadAndManageAttachments())
		{
			$creator->setAttachmentHash($this->filter('attachment_hash', 'str'));
		}

		$setOptions = $this->filter('_xfSet', 'array-bool');
		if ($setOptions)
		{
			$thread = $creator->getThread();

			if (isset($setOptions['discussion_open']) && $thread->canLockUnlock())
			{
				$creator->setDiscussionOpen($this->filter('discussion_open', 'bool'));
			}
			if (isset($setOptions['sticky']) && $thread->canStickUnstick())
			{
				$creator->setSticky($this->filter('sticky', 'bool'));
			}
		}

		$customFields = $this->filter('custom_fields', 'array');
		$creator->setCustomFields($customFields);

		return $creator;
	}

	protected function finalizeThreadCreate(\XF\Service\Thread\Creator $creator)
	{
		$creator->sendNotifications();

		$forum = $creator->getForum();
		$thread = $creator->getThread();
		$visitor = \XF::visitor();

		$setOptions = $this->filter('_xfSet', 'array-bool');
		if ($thread->canWatch())
		{
			if (isset($setOptions['watch_thread']))
			{
				$watch = $this->filter('watch_thread', 'bool');
				if ($watch)
				{
					/** @var \XF\Repository\ThreadWatch $threadWatchRepo */
					$threadWatchRepo = $this->repository('XF:ThreadWatch');

					$state = $this->filter('watch_thread_email', 'bool') ? 'watch_email' : 'watch_no_email';
					$threadWatchRepo->setWatchState($thread, $visitor, $state);
				}
			}
			else
			{
				// use user preferences
				$this->repository('XF:ThreadWatch')->autoWatchThread($thread, $visitor, true);
			}
		}

		if ($visitor->user_id)
		{
			$this->getThreadRepo()->markThreadReadByVisitor($thread, $thread->post_date);

			$forum->draft_thread->delete();

			if ($thread->discussion_state == 'moderated')
			{
				$this->session()->setHasContentPendingApproval();
			}
		}
	}

	public function actionCreateThread(ParameterBag $params)
	{
		return $this->rerouteController('XF:Forum', 'postThread', $params);
	}

	public function actionPostThreadChooser()
	{
		$visitor = \XF::visitor();
		if (!$visitor->canCreateThread($error) && !$visitor->canCreateThreadPreReg())
		{
			return $this->noPermission($error);
		}

		$this->assertCanonicalUrl($this->buildLink('forums/post-thread'));

		$nodeRepo = $this->getNodeRepo();
		$nodes = $nodeRepo->getNodeList();

		$canCreateThread = false;
		foreach ($nodes AS $nodeId => $node)
		{
			if ($node->node_type_id != 'Forum')
			{
				continue;
			}

			/** @var \XF\Entity\Forum $forum */
			$forum = $node->Data;
			if ($forum->canCreateThread() || $forum->canCreateThreadPreReg())
			{
				$canCreateThread = true;
				break;
			}
		}

		if (!$canCreateThread)
		{
			return $this->noPermission();
		}

		$nodeTree = $nodeRepo->createNodeTree($nodes);
		$nodeTree = $nodeTree->filter(null, function($id, \XF\Entity\Node $node, $depth, $children, \XF\Tree $tree)
		{
			if ($children)
			{
				return true;
			}
			if (
				$node->node_type_id == 'Forum'
				&& (
					$node->Data->canCreateThread()
					|| $node->Data->canCreateThreadPreReg()
				)
			)
			{
				return true;
			}
			return false;
		});

		$nodeExtras = $nodeRepo->getNodeListExtras($nodeTree);

		$viewParams = [
			'nodeTree' => $nodeTree,
			'nodeExtras' => $nodeExtras
		];
		return $this->view('XF:Forum\PostThreadChooser', 'forum_post_thread_chooser', $viewParams);
	}

	public function actionPostThread(ParameterBag $params)
	{
		if (!$params->node_id && !$params->node_name)
		{
			return $this->rerouteController('XF:Forum', 'postThreadChooser');
		}

		$forum = $this->assertViewableForum($params->node_id ?: $params->node_name, ['DraftThreads|' . \XF::visitor()->user_id]);

		$isPreRegThread = $forum->canCreateThreadPreReg();

		if (!$forum->canCreateThread($error) && !$isPreRegThread)
		{
			return $this->noPermission($error);
		}

		$this->assertCanonicalUrl($this->buildLink('forums/post-thread', $forum));
		$this->assertCaptchaCookieConsent();

		$switches = $this->filter([
			'inline-mode' => 'bool',
			'more-options' => 'bool'
		]);
		if ($switches['more-options'])
		{
			$switches['inline-mode'] = false;
		}

		$creatableThreadTypes = [];
		foreach ($forum->getCreatableThreadTypes() AS $threadType)
		{
			$handler = $this->app->threadType($threadType, false);
			if ($handler)
			{
				$creatableThreadTypes[$threadType] = $handler;
			}
		}

		// inline mode doesn't pull from drafts
		$draftThreadType = $switches['inline-mode'] ? null : $forum->draft_thread['discussion_type'];
		if ($draftThreadType && isset($creatableThreadTypes[$draftThreadType]))
		{
			$defaultThreadType = $draftThreadType;
		}
		else
		{
			$defaultThreadType = key($creatableThreadTypes);
		}

		$thread = null;
		$post = null;
		$tags = null;
		$typeDataDraftOverride = null;

		if ($this->isPost())
		{
			if (!$this->captchaIsValid() && !$isPreRegThread)
			{
				return $this->error(\XF::phrase('did_not_complete_the_captcha_verification_properly'));
			}

			$creator = $this->setupThreadCreate($forum);

			if ($switches['more-options'])
			{
				$thread = $creator->getThread();
				$post = $creator->getPost();
				$tags = $this->filter('tags', 'str');
				$defaultThreadType = $thread->discussion_type;
				$typeDataDraftOverride = $thread->TypeHandler->getExtraDataForDraft($thread, $this->request);
			}
			else
			{
				if (!$isPreRegThread)
				{
					$creator->checkForSpam();
				}

				if (!$creator->validate($errors))
				{
					return $this->error($errors);
				}

				if ($isPreRegThread)
				{
					/** @var \XF\ControllerPlugin\PreRegAction $preRegActionPlugin */
					$preRegActionPlugin = $this->plugin('XF:PreRegAction');
					return $preRegActionPlugin->actionPreRegAction(
						'XF:Thread\Create',
						$forum,
						$this->getPreRegThreadActionData($creator)
					);
				}

				$this->assertNotFlooding('thread', $this->app->options()->floodCheckLengthDiscussion ?: null);

				/** @var \XF\Entity\Thread $thread */
				$thread = $creator->save();
				$this->finalizeThreadCreate($creator);

				if ($switches['inline-mode'])
				{
					$viewParams = [
						'thread' => $thread,
						'forum' => $forum,
						'templateOverrides' => $forum->TypeHandler->getForumViewTemplateOverrides($forum),
						'inlineMode' => true
					];
					return $this->view('XF:Forum\ThreadItem', 'thread_list_item', $viewParams);
				}
				else if (!$thread->canView())
				{
					return $this->redirect($this->buildLink('forums', $forum, ['pending_approval' => 1]));
				}
				else
				{
					return $this->redirect($this->buildLink('threads', $thread));
				}
			}
		}

		if ($forum->canUploadAndManageAttachments())
		{
			/** @var \XF\Repository\Attachment $attachmentRepo */
			$attachmentRepo = $this->repository('XF:Attachment');
			$attachmentData = $attachmentRepo->getEditorData(
				'post',
				$forum,
				$switches['inline-mode'] ? null : $forum->draft_thread['attachment_hash']
			);
		}
		else
		{
			$attachmentData = null;
		}

		$templateName = $switches['inline-mode'] ? 'forum_post_quick_thread' : 'forum_post_thread';

		if (!$thread)
		{
			$thread = $forum->getNewThread();
			$prefixId = $this->getPrefixIdIfUsable($forum);
			if ($prefixId)
			{
				$thread->prefix_id = $prefixId;
			}
			if (!$switches['inline-mode'] && $forum->draft_thread && $forum->draft_thread['custom_fields'])
			{
				/** @var \XF\CustomField\Set $customFields */
				$customFields = $thread->custom_fields;
				$customFields->bulkSet($forum->draft_thread['custom_fields'], null, 'user', true);
			}
		}

		$prefixes = \XF::asPreRegActionUserIfNeeded(
			$isPreRegThread,
			function() use ($forum) { return $forum->getUsablePrefixes(); }
		);
		$canEditTags = \XF::asPreRegActionUserIfNeeded(
			$isPreRegThread,
			function() use ($forum) { return $forum->canEditTags(); }
		);

		$viewParams = [
			'forum' => $forum,
			'thread' => $thread ?: $forum->getNewThread(),
			'post' => $post ?: null,
			'title' => $this->filter('title', 'string'),
			'prefixes' => $prefixes,
			'canEditTags' => $canEditTags,
			'tags' => $tags,
			'typeDataDraftOverride' => $typeDataDraftOverride,

			'creatableThreadTypes' => $creatableThreadTypes,
			'defaultThreadType' => $defaultThreadType,

			'attachmentData' => $attachmentData,
			'inlineMode' => $switches['inline-mode']
		];
		return $this->view('XF:Forum\PostThread', $templateName, $viewParams);
	}

	protected function getPreRegThreadActionData(\XF\Service\Thread\Creator $creator)
	{
		$thread = $creator->getThread();
		$post = $creator->getPost();

		return [
			'title' => $thread->title,
			'message' => $post->message,
			'prefix_id' => $thread->prefix_id,
			'tags' => $this->filter('tags', 'str'),
			'custom_fields' => $thread->custom_fields->getFieldValues(),

			'discussion_type' => $thread->discussion_type,
			'type_input' => $thread->TypeHandler->getExtraDataForPreRegAction($thread, $this->request)
		];
	}

	public function actionThreadPreview(ParameterBag $params)
	{
		$this->assertPostOnly();

		$forum = $this->assertViewableForum($params->node_id ?: $params->node_name);
		if (!$forum->canCreateThread($error) && !$forum->canCreateThreadPreReg())
		{
			return $this->noPermission($error);
		}

		$creator = $this->setupThreadCreate($forum);
		if (!$creator->validate($errors) && isset($errors['message']))
		{
			return $this->error($errors);
		}

		$thread = $creator->getThread();
		$post = $creator->getPost();
		$attachments = null;

		$tempHash = $this->filter('attachment_hash', 'str');
		if ($tempHash && $thread->Forum->canUploadAndManageAttachments())
		{
			$attachRepo = $this->repository('XF:Attachment');
			$attachments = $attachRepo->findAttachmentsByTempHash($tempHash)->fetch();
		}

		return $this->plugin('XF:BbCodePreview')->actionPreview(
			$post->message, 'post', $post->User, $attachments, $thread->canViewAttachments()
		);
	}

	public function actionMarkRead(ParameterBag $params)
	{
		$visitor = \XF::visitor();
		if (!$visitor->user_id)
		{
			return $this->noPermission();
		}

		$markDate = $this->filter('date', 'uint');
		if (!$markDate)
		{
			$markDate = \XF::$time;
		}

		$forumRepo = $this->getForumRepo();

		$lookup = $params->node_id ?: $params->node_name;
		if ($lookup)
		{
			$forum = $this->assertViewableForum($lookup);
		}
		else
		{
			$forum = null;
		}

		if ($this->isPost())
		{
			if ($forum)
			{
				$forumRepo->markForumTreeReadByVisitor($forum, $markDate);

				return $this->redirect(
					$this->buildLink('forums', $forum),
					\XF::phrase('forum_x_marked_as_read', ['forum' => $forum->title])
				);
			}
			else
			{
				$forumRepo->markForumTreeReadByVisitor(null, $markDate);

				return $this->redirect(
					$this->buildLink('forums'),
					\XF::phrase('all_forums_marked_as_read')
				);
			}
		}
		else
		{
			$viewParams = [
				'forum' => $forum,
				'date' => $markDate
			];
			return $this->view('XF:Forum\MarkRead', 'forum_mark_read', $viewParams);
		}
	}

	public function actionWatch(ParameterBag $params)
	{
		$visitor = \XF::visitor();
		if (!$visitor->user_id)
		{
			return $this->noPermission();
		}

		$forum = $this->assertViewableForum($params->node_id ?: $params->node_name);
		if (!$forum->canWatch($error))
		{
			return $this->noPermission($error);
		}

		if ($this->isPost())
		{
			if ($this->filter('stop', 'bool'))
			{
				$notifyType = 'delete';
			}
			else
			{
				$notifyType = $this->filter('notify', 'str');
				if ($notifyType != 'thread' && $notifyType != 'message')
				{
					$notifyType = '';
				}

				if ($forum->allowed_watch_notifications == 'none')
				{
					$notifyType = '';
				}
				else if ($forum->allowed_watch_notifications == 'thread' && $notifyType == 'message')
				{
					$notifyType = 'thread';
				}
			}

			$sendAlert = $this->filter('send_alert', 'bool');
			$sendEmail = $this->filter('send_email', 'bool');

			/** @var \XF\Repository\ForumWatch $watchRepo */
			$watchRepo = $this->repository('XF:ForumWatch');
			$watchRepo->setWatchState($forum, $visitor, $notifyType, $sendAlert, $sendEmail);

			$redirect = $this->redirect($this->buildLink('forums', $forum));
			$redirect->setJsonParam('switchKey', $notifyType == 'delete' ? 'watch' : 'unwatch');
			return $redirect;
		}
		else
		{
			$viewParams = [
				'forum' => $forum,
				'isWatched' => !empty($forum->Watch[$visitor->user_id])
			];
			return $this->view('XF:Forum\Watch', 'forum_watch', $viewParams);
		}
	}

	public function actionPrefixes(ParameterBag $params)
	{
		$this->assertPostOnly();

		$viewParams = [];

		$nodeId = $this->filter('val', 'uint');
		if ($nodeId)
		{
			$forum = $this->assertViewableForum($nodeId);

			$initialPrefix = null;
			$initialPrefixId = $this->filter('initial_prefix_id', 'uint');
			if ($initialPrefixId && isset($forum->prefixes[$initialPrefixId]))
			{
				$initialPrefix = $forum->prefixes[$initialPrefixId];
			}

			$viewParams['forum'] = $forum;
			$viewParams['prefixes'] = $forum->getUsablePrefixes($initialPrefix);
		}

		return $this->view('XF:Forum\Prefixes', 'forum_prefixes', $viewParams);
	}

	public function actionPrefixHelp(ParameterBag $params)
	{
		$this->assertPostOnly();

		$forum = $this->assertViewableForum($params->node_id ?: $params->node_name);

		$prefixId = $this->getPrefixIdIfUsable($forum);
		if ($prefixId)
		{
			$prefix = $this->em()->find('XF:ThreadPrefix', $prefixId);

			return $this->view('XF:Forum\PrefixHelp', 'prefix_usage_help', [
				'prefix' => $prefix,
				'contentType' => 'thread'
			]);
		}

		return $this->notFound();
	}

	protected function getForumRss(\XF\Entity\Forum $forum = null)
	{
		$limit = $this->options()->discussionsPerPage;

		$threadRepo = $this->getThreadRepo();
		$threadList = $threadRepo->findThreadsForRssFeed($forum)->limit($limit * 3);

		if ($forum)
		{
			$prefixId = $this->filter('prefix_id', 'uint');
			if ($prefixId !== 0 && $forum->isPrefixValid($prefixId))
			{
				$threadList->where('prefix_id', $prefixId);
			}
		}

		$order = $this->filter('order', 'str');
		switch ($order)
		{
			case 'post_date':
				break;

			default:
				$order = 'last_post_date';
				break;
		}
		$threadList->order($order, 'DESC');

		$threads = $threadList->fetch()->filterViewable()->slice(0, $limit);

		return $this->view('XF:Forum\Rss', '', [
			'forum' => $forum,
			'order' => $order,
			'threads' => $threads
		]);
	}

	/**
	 * @param string|int $nodeIdOrName
	 * @param array $extraWith
	 *
	 * @return \XF\Entity\Forum
	 *
	 * @throws \XF\Mvc\Reply\Exception
	 */
	protected function assertViewableForum($nodeIdOrName, array $extraWith = [])
	{
		if ($nodeIdOrName === null)
		{
			throw $this->exception($this->notFound(\XF::phrase('requested_forum_not_found')));
		}

		$visitor = \XF::visitor();
		$extraWith[] = 'Node.Permissions|' . $visitor->permission_combination_id;
		if ($visitor->user_id)
		{
			$extraWith[] = 'Read|' . $visitor->user_id;
		}

		$finder = $this->em()->getFinder('XF:Forum');
		$finder->with('Node', true)->with($extraWith);
		if (is_int($nodeIdOrName) || $nodeIdOrName === strval(intval($nodeIdOrName)))
		{
			$finder->where('node_id', $nodeIdOrName);
		}
		else
		{
			$finder->where(['Node.node_name' => $nodeIdOrName, 'Node.node_type_id' => 'Forum']);
		}

		/** @var \XF\Entity\Forum $forum */
		$forum = $finder->fetchOne();
		if (!$forum)
		{
			throw $this->exception($this->notFound(\XF::phrase('requested_forum_not_found')));
		}
		if (!$forum->canView($error))
		{
			throw $this->exception($this->noPermission($error));
		}

		$this->plugin('XF:Node')->applyNodeContext($forum->Node);
		$this->setContentKey('forum-' . $forum->node_id);

		return $forum;
	}

	/**
	 * @return \XF\Repository\Forum
	 */
	protected function getForumRepo()
	{
		return $this->repository('XF:Forum');
	}

	/**
	 * @return \XF\Repository\Node
	 */
	protected function getNodeRepo()
	{
		return $this->repository('XF:Node');
	}

	/**
	 * @return \XF\Repository\Thread
	 */
	protected function getThreadRepo()
	{
		return $this->repository('XF:Thread');
	}

	/**
	 * @param \XF\Entity\Forum $forum
	 * @param array            $filters
	 *
	 * @return array [order, direction]
	 */
	protected function getEffectiveSortInfo(\XF\Entity\Forum $forum, array $filters)
	{
		$sortInfo = [
			'order' => $forum->default_sort_order,
			'direction' => $forum->default_sort_direction
		];

		if (isset($filters['order']))
		{
			$sortInfo['order'] = $filters['order'];
		}

		if (isset($filters['direction']))
		{
			$sortInfo['direction'] = $filters['direction'];
		}

		return $sortInfo;
	}

	/**
	 * @param \XF\Entity\SessionActivity[] $activities
	 */
	public static function getActivityDetails(array $activities)
	{
		return \XF\ControllerPlugin\Node::getNodeActivityDetails(
			$activities,
			'Forum',
			\XF::phrase('viewing_forum'),
			function($activity, $nodeId, $nodeName)
			{
				if ($activity->controller_action == 'NewPosts')
				{
					return \XF::phrase('viewing_latest_content');
				}
				else
				{
					return (!$nodeId && !$nodeName) ? \XF::phrase('viewing_forum_list') : \XF::phrase('viewing_forum');
				}
			}
		);
	}
}