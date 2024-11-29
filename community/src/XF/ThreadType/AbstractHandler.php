<?php

namespace XF\ThreadType;

use XF\Entity\Post;
use XF\Entity\Thread;
use XF\Http\Request;
use XF\Mvc\Entity\AbstractCollection;
use XF\Pub\Controller\AbstractController;

abstract class AbstractHandler
{
	const BASIC_THREAD_TYPE = 'discussion';

	/**
	 * Thread type ID
	 *
	 * @var string
	 */
	protected $type;

	/**
	 * Generally a Font Awesome class name for an icon to represent this type. This will be shown to end users
	 * when they have to pick a thread type. Return an empty string to specify no icon (though a default icon may be
	 * displayed for consistency).
	 *
	 * @return string
	 */
	abstract public function getTypeIconClass(): string;

	public function __construct(string $type)
	{
		$this->type = $type;
	}

	/**
	 * @return string
	 */
	public function getTypeId(): string
	{
		return $this->type;
	}

	/**
	 * The title of this thread type. This will be displayed to end users when they have to pick a thread type.
	 * Notably, this applies to forums which accept multiple types.
	 *
	 * @return string|\XF\Phrase
	 */
	public function getTypeTitle()
	{
		return \XF::phrase('thread_type.' . $this->type);
	}

	/**
	 * The plural title of this thread type. This may be displayed to end users in certain scenarios.
	 *
	 * @return string|\XF\Phrase
	 */
	public function getTypeTitlePlural()
	{
		return \XF::phrase('thread_type_plural.' . $this->type);
	}

	/**
	 * Allows overriding of the thread view class and template.
	 *
	 * @param Thread $thread
	 *
	 * @return array 2 values: [view class name, template name]
	 */
	public function getThreadViewAndTemplate(Thread $thread): array
	{
		return ['XF:Thread\View', 'thread_view'];
	}

	/**
	 * Returns key-value pairs of template and macro overrides/options for use within the thread view and related templates.
	 * Notably, this includes the macros used for posts.
	 *
	 * Note, this may be used in contexts outside of thread view itself, such as when returning new posts with quick
	 * reply or when editing. Extra data passed in may vary by context and is unlikely to be available outside of
	 * the primary thread view context.
	 *
	 * Keys:
	 * - post_macro
	 * - post_macro_args
	 * - post_deleted_macro
	 * - post_deleted_macro_args
	 * - pinned_first_post_macro
	 * - pinned_first_post_macro_args
	 *
	 * @param Thread $thread
	 * @param array $extra
	 *
	 * @return array
	 */
	public function getThreadViewTemplateOverrides(Thread $thread, array $extra = []): array
	{
		return [];
	}

	/**
	 * Extension point for adjusting or adding to the view params when viewing the specified thread.
	 *
	 * @param Thread $thread
	 * @param array $viewParams
	 * @param Request $request
	 *
	 * @return array Updated view params
	 */
	public function adjustThreadViewParams(Thread $thread, array $viewParams, Request $request): array
	{
		return $viewParams;
	}

	/**
	 * Gets additional type-specific thread view filters. A filter should only be returned if it's actively being applied.
	 *
	 * These will be used in subsequent calls to apply filtering, as well as in the UI via things like page navigation.
	 *
	 * @param Thread $thread
	 * @param Request $request
	 * @param array $filters List of globally applicable filters
	 *
	 * @return array New set of filters (including global ones)
	 */
	public function getPostListFilterInput(Thread $thread, Request $request, array $filters): array
	{
		return $filters;
	}

	/**
	 * Applies additional type-specific thread view post list filters.
	 *
	 * Note that this is called both for the "main" post list query and then for any extra posts, such as
	 * pinned or highlighted posts. For the first case, no $extraFetchIds will be passed in.
	 *
	 * If there is a pinned first post, it must be returned by either the main post list query or the
	 * extra posts query. If neither query returns it, an error will occur when displaying the thread.
	 *
	 * You may wish to consider not applying filters to extra fetch ID calls.
	 *
	 * @param Thread $thread
	 * @param \XF\Finder\Post $postList
	 * @param array $filters
	 * @param int[]|null $extraFetchIds
	 */
	public function applyPostListFilters(
		Thread $thread,
		\XF\Finder\Post $postList,
		array $filters,
		array $extraFetchIds = null
	)
	{
	}

	/**
	 * Gets a list of additional post list sorting options.
	 *
	 * @param Thread $thread
	 *
	 * @return array
	 */
	public function getAdditionalPostListSortOptions(Thread $thread): array
	{
		return [];
	}

	/**
	 * Gets the default sort order for this type.
	 *
	 * @param Thread $thread
	 *
	 * @return string
	 */
	public function getDefaultPostListOrder(Thread $thread): string
	{
		return 'post_date';
	}

	/**
	 * Extension point to add further customizations to the post list finder when viewing a thread.
	 *
	 * Note that this is called both for the "main" post list query and then for any extra posts, such as
	 * pinned or highlighted posts. For the first case, no $extraFetchIds will be passed in.
	 *
	 * If there is a pinned first post, it must be returned by either the main post list query or the
	 * extra posts query. If neither query returns it, an error will occur when displaying the thread.
	 *
	 *
	 * @param Thread $thread
	 * @param \XF\Finder\Post $postFinder
	 * @param int $page
	 * @param Request $request
	 * @param int[]|null $extraFetchIds
	 */
	public function adjustThreadPostListFinder(
		Thread $thread,
		\XF\Finder\Post $postFinder,
		int $page,
		Request $request,
		array $extraFetchIds = null
	)
	{
	}

	/**
	 * This method allows you to bulk preload extra content that might be attached to individual posts.
	 * For example, generally this includes attachments and unfurls within these posts.
	 *
	 * When possible, use adjustThreadPostListFinder to eagerly fetch content with joins.
	 *
	 * @param Thread $thread
	 * @param iterable $posts List of post entity objects (may be an array or collection)
	 * @param array $options Any additional options or context details (generally unused)
	 */
	public function fetchExtraContentForPostsFullView(Thread $thread, $posts, array $options = [])
	{
	}

	/**
	 * Sets up the thread view data object. This is used to centralize some display logic surrounding how
	 * and where posts are displayed when viewing the thread, for purposes of things like determining
	 * what should be considered the latest post, first unread, etc.
	 *
	 * This can be overridden to customize the object's configuration, though this should be avoided if possible.
	 *
	 * @param Thread $thread
	 * @param AbstractCollection|Post[] $posts List of all posts fetched for display (main + extra)
	 * @param int[] $extraFetchedIds List of post IDs that were fetched, outside of the main page flow
	 *
	 * @return \XF\ThreadViewData
	 */
	public function setupThreadViewData(
		Thread $thread,
		AbstractCollection $posts,
		array $extraFetchedIds = []
	): \XF\ThreadViewData
	{
		return new \XF\ThreadViewData($thread, $posts, $extraFetchedIds);
	}

	/**
	 * Extension point to allow fully overriding the controller action when viewing the specified thread.
	 *
	 * @param Thread $thread
	 * @param AbstractController $controller
	 *
	 * @return null|\XF\Mvc\Reply\AbstractReply Returning a reply object will prevent the standard action from running.
	 */
	public function overrideDisplay(Thread $thread, AbstractController $controller)
	{
		return null;
	}

	/**
	 * @param Thread $thread
	 * @param Post   $firstDisplayedPost
	 * @param int    $page
	 * @param array  $extraData
	 *
	 * @return array|null
	 */
	public function getLdStructuredData(Thread $thread, Post $firstDisplayedPost, int $page, array $extraData = [])
	{
		$publicRouter = \XF::app()->router('public');
		$threadLink = $publicRouter->buildLink('canonical:threads', $thread);
		$authorLink = $thread->User
			? $publicRouter->buildLink('canonical:members', $thread->User)
			: null;
		$metadataLogo = $this->getLdMetadataLogo();

		return [
			"@context" => "https://schema.org",
			"@type" => "DiscussionForumPosting",
			"@id" => $threadLink,
			"headline" => \XF::app()->stringFormatter()->snippetString($thread->title, 110),
			"keywords" => implode(', ', array_column($thread->tags, 'tag')),
			"articleBody" => $this->getLdSnippet($firstDisplayedPost->message) ?: $thread->title,
			"articleSection" => $thread->Forum->title,
			"author" => [
				"@type" => "Person",
				"@id" => $authorLink,
				"name" => $thread->User->username ?? $thread->username,
				'url' => $authorLink
			],
			"datePublished" => gmdate('c', $thread->post_date),
			"dateModified" =>  gmdate('c', $thread->last_post_date),
			"image" => $this->getLdImage($thread, $firstDisplayedPost, $extraData) ?: $metadataLogo,
			"interactionStatistic" => [
				"@type" => "InteractionCounter",
				"interactionType" => "https://schema.org/CommentAction",
				"userInteractionCount" => $thread->reply_count
			],
			"publisher" => $this->getLdPublisher($metadataLogo)
		];
	}

	protected function getLdSnippet($message, int $length = null)
	{
		if ($length === null)
		{
			$length = 250;
		}

		return \XF::app()->stringFormatter()->snippetString($message, $length, ['stripBbCode' => true]);
	}

	protected function getLdMetadataLogo()
	{
		$style = \XF::app()->templater()->getStyle();
		if (!$style)
		{
			return null;
		}

		$metadataLogo = $style->getProperty('publicMetadataLogoUrl');
		if ($metadataLogo)
		{
			$pather = \XF::app()['request.pather'];
			$metadataLogo = $pather($metadataLogo, 'canonical');
		}

		return $metadataLogo ?: null;
	}

	protected function getLdPublisher($logo = null)
	{
		$output = [
			"@type" => "Organization",
			"name" => \XF::options()->boardTitle,
			"logo" => [
				"@type" => "ImageObject",
				"url" => $logo
			]
		];

		if (!$logo)
		{
			unset($output['logo']);
		}

		return $output;
	}

	protected function getLdImage(Thread $thread, Post $firstDisplayedPost, array $extraData = [])
	{
		if (!$thread->User)
		{
			return null;
		}

		$user = $thread->User;
		$avatarSize = $user->avatar_highdpi || $user->gravatar ? 'h' : 'l';
		return $user->getAvatarUrl($avatarSize, false, true);
	}

	public function getReplyMicrodataType(Thread $thread): string
	{
		return 'Comment';
	}

	/**
	 * Returns true if the first post of this thread is pinned so it's displayed at the top of all pages.
	 *
	 * @param Thread $thread
	 *
	 * @return bool
	 */
	public function isFirstPostPinned(Thread $thread): bool
	{
		return false;
	}

	/**
	 * Gets a list of post IDs that should be considered highlighted. Information about these will be fetched
	 * on all pages of the thread.
	 *
	 * Note that they will be returned in the order specified here.
	 *
	 * @param Thread $thread
	 * @param array $filters Any filters that may be applied
	 *
	 * @return array
	 */
	public function getHighlightedPostIds(Thread $thread, array $filters = []): array
	{
		return [];
	}

	/**
	 * Returns true if content voting on the specified thread is supported. "Supported" is distinct from a user having
	 * permission to vote. This represents whether the concept is available at all.
	 *
	 * @param Thread $thread
	 *
	 * @return bool
	 */
	public function isThreadVotingSupported(Thread $thread): bool
	{
		return false;
	}

	/**
	 * Returns true if downvoting on the specified thread is supported. This depends on thread voting
	 * being available.
	 *
	 * "Supported" is distinct from a user having permission to vote. This represents whether the concept
	 * is available at all.
	 *
	 * @param Thread $thread
	 *
	 * @return bool
	 */
	public function isThreadDownvoteSupported(Thread $thread): bool
	{
		return true;
	}

	/**
	 * Returns whether the visitor has permission to vote on this thread.
	 *
	 * @param Thread $thread
	 * @param mixed $error
	 *
	 * @return bool
	 */
	public function canVoteOnThread(Thread $thread, &$error = null): bool
	{
		return false;
	}

	/**
	 * Returns whether the visitor has permission to downvote this thread. Requires general voting permission.
	 *
	 * @param Thread $thread
	 * @param mixed $error
	 *
	 * @return bool
	 */
	public function canDownvoteThread(Thread $thread, &$error = null): bool
	{
		return true;
	}

	/**
	 * Returns true if content voting on the specified post is supported. "Supported" is distinct from a user having
	 * permission to vote. This represents whether the concept is available at all.
	 *
	 * @param Thread $thread
	 * @param Post $post
	 *
	 * @return bool
	 */
	public function isPostVotingSupported(Thread $thread, Post $post): bool
	{
		return false;
	}

	/**
	 * Returns true if downvoting on the specified post is supported. This depends on post voting
	 * being available.
	 *
	 * "Supported" is distinct from a user having permission to vote. This represents whether the concept
	 * is available at all.
	 *
	 * @param Thread $thread
	 * @param Post $post
	 *
	 * @return bool
	 */
	public function isPostDownvoteSupported(Thread $thread, Post $post): bool
	{
		return true;
	}

	/**
	 * Returns whether the visitor has permission to vote on this post.
	 *
	 * @param Thread $thread
	 * @param Post $post
	 * @param mixed $error
	 *
	 * @return bool
	 */
	public function canVoteOnPost(Thread $thread, Post $post, &$error = null): bool
	{
		return false;
	}

	/**
	 * Returns whether the visitor has permission to downvote this post. Requires general voting permissions.
	 *
	 * @param Thread $thread
	 * @param Post $post
	 * @param mixed $error
	 *
	 * @return bool
	 */
	public function canDownvotePost(Thread $thread, Post $post, &$error = null): bool
	{
		return true;
	}

	/**
	 * Returns the default type data for this thread type. This default will be merged with any overrides
	 * in the specific thread entity when fetched.
	 *
	 * @return array
	 */
	public function getDefaultTypeData(): array
	{
		return [];
	}

	/**
	 * Gets the type data column definitions to be used within an array validator object. Note that this system
	 * shares much code with entity column validation, so column defs will be similar to entities. However,
	 * "verify" methods must be closures and default values are not supported. All columns should have default values
	 * via getDefaultTypeData.
	 *
	 * @return array
	 */
	protected function getTypeDataColumnDefinitions(): array
	{
		return [];
	}

	/**
	 * Gets the type data validator handler for the specified thread.
	 *
	 * @param Thread $thread
	 *
	 * @return \XF\Mvc\Entity\ArrayValidator
	 */
	public function getTypeDataValidator(Thread $thread): \XF\Mvc\Entity\ArrayValidator
	{
		return \XF::arrayValidator(
			$this->getTypeDataColumnDefinitions(),
			$thread->type_data,
			$thread->exists()
		);
	}

	/**
	 * Only returns the containing forum if its type matches the specified class. This is primarily used to make
	 * it easier to switch on behavior that relies on a forum's type config.
	 *
	 * @param Thread $thread
	 * @param string $class
	 *
	 * @return \XF\Entity\Forum|null
	 */
	protected function getForumIfType(Thread $thread, string $class)
	{
		$forum = $thread->Forum;
		if ($forum)
		{
			$forumTypeHandler = $forum->TypeHandler;
			if ($forumTypeHandler instanceof $class)
			{
				return $forum;
			}
		}

		return null;
	}

	/**
	 * Handles rendering the extra type data form rows for editing. This may be used during thread creation
	 * or specific editing scenarios.
	 *
	 * This makes sure the correct type data is always passed in. Override renderExtraDataEditInternal instead.
	 *
	 * @param Thread $thread
	 * @param string $context Context may be "create" or "edit"
	 * @param string $subContext Sub-context will depend on the main context. For example "quick" and "full" may apply to "create".
	 * @param array $options Additional information may be passed in to aid use in a specific context
	 *
	 * @return string
	 */
	final public function renderExtraDataEdit(
		Thread $thread,
		string $context,
		string $subContext,
		array $options = []
	): string
	{
		if ($thread->discussion_type == $this->type)
		{
			$typeData = $thread->type_data;
		}
		else
		{
			$typeData = $this->getDefaultTypeData();
		}

		return $this->renderExtraDataEditInternal($thread, $typeData, $context, $subContext, $options);
	}

	/**
	 * Internally handles rendering the extra type data form rows for editing. This may be used during thread creation
	 * or specific editing scenarios.
	 *
	 * @param Thread $thread
	 * @param array $typeData The type data that should be used as the current values. May differ from $thread.type_data.
	 * @param string $context Context may be "create" or "edit"
	 * @param string $subContext Sub-context will depend on the main context. For example "quick" and "full" may apply to "create".
	 * @param array $options Additional information may be passed in to aid use in a specific context
	 *
	 * @return string
	 */
	protected function renderExtraDataEditInternal(
		Thread $thread,
		array $typeData,
		string $context,
		string $subContext,
		array $options = []
	): string
	{
		return '';
	}

	/**
	 * Handle processing of extra thread type data. This may be used during thread creation or editing via the standard
	 * UI.
	 *
	 * This method is for simple cases that can return the new type data array. The entire data should be
	 * returned, not just updated parts.
	 *
	 * @param Thread $thread
	 * @param string $context
	 * @param Request $request
	 * @param array $errors Push any errors that occur when validating the input into this.
	 * @param array $options Additional information may be passed in dependent on the context
	 *
	 * @return null|array|\XF\Mvc\Entity\ArrayValidator
	 * 		If an array is returned, this will be the new type data value for the thread.
	 * 		An ArrayValidator consolidates values and errors together (to reduce boilerplate code).
	 * 		Null updates nothing.
	 */
	public function processExtraDataSimple(
		Thread $thread, string $context, Request $request, &$errors = [], array $options = []
	)
	{
		return null;
	}

	/**
	 * Handle processing of extra thread type data. This may be used during thread creation or editing via the standard
	 * UI.
	 *
	 * This method is for situations where an additional service may be required, such as when inserting data into
	 * additional tables (for example, with thread polls).
	 *
	 * @param Thread $thread
	 * @param string $context
	 * @param Request $request
	 * @param array $options Additional information may be passed in dependent on the context
	 *
	 * @return null|\XF\Service\Thread\TypeData\SaverInterface If a saver service is returned, will be integrated with the creation/edit process and saved when needed
	 */
	public function processExtraDataService(
		Thread $thread, string $context, Request $request, array $options = []
	)
	{
		return null;
	}

	/**
	 * Handle processing of extra thread type data. This may be used during thread creation or editing, but is specific
	 * to calls via the API. Therefore, you must be prepared for only partial type data to be passed in.
	 *
	 * Usage is otherwise similar to processExtraDataSimple.
	 *
	 * @param Thread $thread
	 * @param string $context
	 * @param Request $request
	 * @param array $errors Push any errors that occur when validating the input into this.
	 * @param array $options Additional information may be passed in dependent on the context
	 *
	 * @return null|array If an array is returned, this will be the new type data value for the thread; null updates nothing
	 */
	public function processExtraDataForApiSimple(
		Thread $thread, string $context, Request $request, &$errors = [], array $options = []
	)
	{
		return null;
	}

	/**
	 * Handle processing of extra thread type data. This may be used during thread creation or editing, but is specific
	 * to calls via the API. Therefore, you must be prepared for only partial type data to be passed in.
	 *
	 * Usage is otherwise similar to processExtraDataService.
	 *
	 * @param Thread $thread
	 * @param string $context
	 * @param Request $request
	 * @param array $options Additional information may be passed in dependent on the context
	 *
	 * @return null|\XF\Service\Thread\TypeData\SaverInterface If a saver service is returned, will be integrated with the creation/edit process and saved when needed
	 */
	public function processExtraDataForApiService(
		Thread $thread, string $context, Request $request, array $options = []
	)
	{
		return null;
	}

	/**
	 * Handle processing of extra thread type data. This may be used during thread creation and is specific to calls
	 * via the pre-registration actions system.
	 *
	 * Usage is otherwise similar to processExtraDataSimple.
	 *
	 * @param Thread $thread
	 * @param string $context
	 * @param array  $input
	 * @param array  $errors  Push any errors that occur when validating the input into this.
	 * @param array  $options Additional information may be passed in dependent on the context
	 *
	 * @return null|array If an array is returned, this will be the new type data value for the thread; null updates nothing
	 */
	public function processExtraDataForPreRegSimple(
		Thread $thread, string $context, array $input, &$errors = [], array $options = []
	)
	{
		return null;
	}

	/**
	 * Handle processing of extra thread type data. This may be used during thread creation and is specific to calls
	 * via the pre-registration actions system.
	 *
	 * Usage is otherwise similar to processExtraDataService.
	 *
	 * @param Thread $thread
	 * @param string $context
	 * @param array  $input
	 * @param array  $options Additional information may be passed in dependent on the context
	 *
	 * @return null|\XF\Service\Thread\TypeData\SaverInterface If a saver service is returned, will be integrated with the creation process and saved when needed
	 */
	public function processExtraDataForPreRegService(
		Thread $thread, string $context, array $input, array $options = []
	)
	{
		return null;
	}

	/**
	 * Gets extra data to be stored in a draft thread record.
	 *
	 * @param Thread $thread
	 * @param Request $request
	 *
	 * @return array
	 */
	public function getExtraDataForDraft(Thread $thread, Request $request): array
	{
		return [];
	}

	/**
	 * Gets extra data to be stored in a pre-registration action record.
	 *
	 * @param Thread $thread
	 * @param Request $request
	 *
	 * @return array
	 */
	public function getExtraDataForPreRegAction(Thread $thread, Request $request): array
	{
		return [];
	}

	/**
	 * Adds extra thread type data to the API result. Data can be added into the result however wished.
	 * If this is not overridden, no type config data will be present in the result.
	 *
	 * @param Thread $thread
	 * @param \XF\Api\Result\EntityResult $result
	 * @param int $verbosity
	 * @param array $options
	 */
	public function addTypeDataToApiResult(
		Thread $thread,
		\XF\Api\Result\EntityResult $result,
		int $verbosity = \XF\Mvc\Entity\Entity::VERBOSITY_NORMAL,
		array $options = []
	)
	{
	}

	/**
	 * Called during pre-save for a thread of this type. No data should be saved at this point
	 * (as the save may not go ahead).
	 *
	 * @param Thread $thread
	 * @param bool $isTypeEnter True when entering this type (see onThreadEnterType)
	 */
	public function onThreadPreSave(Thread $thread, bool $isTypeEnter)
	{
	}

	/**
	 * Called whenever a thread of this type is saved.
	 *
	 * @param Thread $thread
	 * @param bool $isTypeEnter True when entering this type (see onThreadEnterType)
	 */
	public function onThreadSave(Thread $thread, bool $isTypeEnter)
	{
	}

	/**
	 * Called whenever a thread of this type is hard deleted.
	 * Note that onThreadLeaveType is also called on hard delete.
	 *
	 * @param Thread $thread
	 */
	public function onThreadDelete(Thread $thread)
	{
	}

	/**
	 * Called when a thread becomes visible after previously being in a non-visible state.
	 * Applies only when the thread is updated to become visible.
	 *
	 * @param Thread $thread
	 */
	public function onThreadMadeVisible(Thread $thread)
	{
	}

	/**
	 * Called when a thread leaves a visible state. This may be a move to a non-visible state
	 * or it may be hard deleted.
	 *
	 * @param Thread $thread
	 * @param bool $isDelete True if the thread is being hard deleted
	 */
	public function onThreadHidden(Thread $thread, bool $isDelete)
	{
	}

	/**
	 * Called when a thread enters this type. This may either be due to a type change or
	 * when the thread is created as this type.
	 *
	 * Old type information is provided to make it (theoretically) possible to maintain
	 * some information when thread types are converted. This method is called on the
	 * new type handler before onThreadLeaveType is called on the old handler to
	 * facilitate this.
	 *
	 * @param Thread $thread
	 * @param array $typeData The new type data it's entering with
	 * @param AbstractHandler|null $oldTypeHandler The handler for the previous type; may be null for inserts or cases where the old type is not valid
	 * @param array $oldTypeData The old type data array
	 */
	public function onThreadEnterType(
		Thread $thread,
		array $typeData,
		AbstractHandler $oldTypeHandler = null,
		array $oldTypeData = []
	)
	{
	}

	/**
	 * Called when a thread leaves this type. Note this is also called when a thread of this type is deleted.
	 *
	 * @param Thread $thread
	 * @param array $typeData The type data it's leaving with
	 * @param bool $isDelete True if this is being called when the thread is being hard deleted
	 */
	public function onThreadLeaveType(Thread $thread, array $typeData, bool $isDelete)
	{
	}

	/**
	 * Called when rebuilding counters for a thread of this type. This is called when certain bulk actions
	 * are triggered against a thread, such that normal methods may not be called. For example, when
	 * moving posts to another thread or merging threads. This is also called when rebuilding thread info
	 * via the control panel.
	 *
	 * This can be used as a sanity check to ensure thread type metadata is still valid. For example,
	 * the solution post for a question should be checked to ensure it is still in the thread.
	 *
	 * The thread will be saved after this call.
	 *
	 * @param Thread $thread
	 */
	public function onThreadRebuildCounters(Thread $thread)
	{
	}

	/**
	 * Called when merging threads into a target thread of this type. In some situations,
	 * this may lead to the discussion type of the target being changed, which may cause
	 * a different handler to be called for subsequent lifecycle methods.
	 *
	 * Thread save will be called after this automatically.
	 *
	 * @param Thread $target
	 * @param Thread[] $sourceThreads
	 */
	public function onThreadMergeInto(Thread $target, array $sourceThreads)
	{
	}

	/**
	 * Called when a post is added to a thread of this type. Only applies to visible posts!
	 *
	 * Note that this will be called both for newly inserted posts and posts being made visible.
	 *
	 * Modifications to the thread entity do not need to be explicitly saved. (That will be called automatically.)
	 *
	 * @param Thread $thread
	 * @param Post $post
	 */
	public function onVisiblePostAdded(Thread $thread, Post $post)
	{
	}

	/**
	 * Called when a visible post is removed from a thread of this type, either by being hidden
	 * or by being hard deleted.
	 *
	 * Modifications to the thread entity do not need to be explicitly saved. (That will be called automatically.)
	 *
	 * @param Thread $thread
	 * @param Post $post
	 */
	public function onVisiblePostRemoved(Thread $thread, Post $post)
	{
	}

	/**
	 * Called whenever a post in a thread of this type is saved. This may be for inserts or updates.
	 *
	 * @param Thread $thread
	 * @param Post $post
	 */
	public function onPostSave(Thread $thread, Post $post)
	{
	}

	/**
	 * Called whenever a post in a thread of this type is hard deleted.
	 *
	 * @param Thread $thread
	 * @param Post $post
	 */
	public function onPostDelete(Thread $thread, Post $post)
	{
	}

	/**
	 * Allows elements of the message preparer service to be customized. This is used to setup things like
	 * constraints on message content (length, max images, etc) or the filters it's run through.
	 *
	 * This is applied both during thread and reply creation, but also editing. The post and thread entities
	 * may not be saved yet.
	 *
	 * @param Thread $thread
	 * @param Post $post
	 * @param \XF\Service\Message\Preparer $preparer
	 */
	public function setupMessagePreparer(
		Thread $thread,
		Post $post,
		\XF\Service\Message\Preparer $preparer
	)
	{
	}

	/**
	 * If true, a thread of this type may be created via user-facing systems, notably the standard UI or the REST
	 * API. If false, this locks creation of this thread type to internal methods that more directly set the
	 * thread type. The most common use case for this is when a thread type should only be created in conjunction
	 * with another set of data.
	 *
	 * Note that setting this to false does not prevent this type as being reported as being "creatable" via
	 * the forum type system. A type that returns false should not be exposed to as a creatable type.
	 *
	 * @return bool
	 */
	public function allowExternalCreation(): bool
	{
		return true;
	}

	/**
	 * Controls whether a thread of this type can be changed to another type via manual conversion tools.
	 * This is commonly used when a thread type involves special restrictions on a thread.
	 *
	 * @param Thread $thread
	 *
	 * @return bool
	 */
	public function canThreadTypeBeChanged(Thread $thread): bool
	{
		return true;
	}

	/**
	 * Helper to control whether or not a thread can be converted to this type. Particularly useful to prevent
	 * bulk converting to types that need more specific type data to be useful.
	 *
	 * @param bool $isBulk Whether or not this is a bulk conversion.
	 *
	 * @return bool
	 */
	public function canConvertThreadToType(bool $isBulk): bool
	{
		return true;
	}
}