<?php

namespace XF\ForumType;

use XF\Entity\Forum;
use XF\Entity\Node;
use XF\Http\Request;
use XF\Mvc\FormAction;
use XF\Pub\Controller\AbstractController;

use function in_array;

abstract class AbstractHandler
{
	/**
	 * ID of this forum type
	 *
	 * @var string
	 */
	protected $type;

	/**
	 * Returns the thread type ID that will be used when a thread doesn't have an explicit type.
	 *
	 * @param Forum $forum
	 *
	 * @return string
	 */
	abstract public function getDefaultThreadType(\XF\Entity\Forum $forum): string;

	/**
	 * Returns the ordering value for this forum type. Used when displaying forum type options. Lower values
	 * will be returned first. Ties are returned in an undefined order.
	 *
	 * @return int
	 */
	abstract public function getDisplayOrder(): int;

	/**
	 * Generally a Font Awesome class name for an icon to represent this type. This will be shown on the node list,
	 * to distinguish forum/node types more easily.
	 *
	 * @return string
	 */
	abstract public function getTypeIconClass(): string;

	public function __construct(string $type)
	{
		$this->type = $type;
	}

	/**
	 * @return string ID of this forum type
	 */
	public function getTypeId(): string
	{
		return $this->type;
	}

	/**
	 * The title of this forum type. Used in the control panel when displaying forum type options or individual
	 * forum info.
	 *
	 * @return string|\XF\Phrase
	 */
	public function getTypeTitle()
	{
		return \XF::phrase('forum_type.' . $this->type);
	}

	/**
	 * The description of this forum type. Used in the control panel when displaying forum type options or individual
	 * forum info.
	 *
	 * @return string|\XF\Phrase
	 */
	public function getTypeDescription()
	{
		return \XF::phrase('forum_type_desc.' . $this->type);
	}

	/**
	 * Returns additional thread type IDs that are allowed in the specified forum. The default type is always allowed.
	 * Note that this list should include every thread type option that applies, even if they aren't creatable via the
	 * UI.
	 *
	 * @param Forum $forum
	 *
	 * @return array
	 */
	public function getExtraAllowedThreadTypes(Forum $forum): array
	{
		return [];
	}

	/**
	 * Returns the list of thread type IDs that can be created via the UI/normal interfaces. Types not listed here
	 * can only be created via custom code (provided the type is valid in the specified forum).
	 *
	 * @param Forum $forum
	 *
	 * @return array
	 */
	public function getCreatableThreadTypes(Forum $forum): array
	{
		$types = $this->getExtraAllowedThreadTypes($forum);
		array_unshift($types, $this->getDefaultThreadType($forum));

		return $types;
	}

	/**
	 * Helper to determine if a given thread type is creatable in the specified forum. Refers specifically
	 * to UI-creatable threads.
	 *
	 * @param string $type
	 * @param Forum $forum
	 *
	 * @return bool
	 */
	public function isThreadTypeCreatable(string $type, Forum $forum): bool
	{
		return in_array($type, $this->getCreatableThreadTypes($forum));
	}

	/**
	 * Returns the list of thread type IDs that may exist within the specified forum.
	 *
	 * @param Forum $forum
	 *
	 * @return array
	 */
	public function getFilterableThreadTypes(Forum $forum): array
	{
		$types = $this->getExtraAllowedThreadTypes($forum);
		array_unshift($types, $this->getDefaultThreadType($forum));

		return $types;
	}

	/**
	 * Helper to determine if a given thread type is allowed in the specified forum. This differs from
	 * isThreadTypeCreatable by returning true for any valid thread type in the forum, even if not UI creatable.
	 *
	 * Note redirect threads are always allowed.
	 *
	 * @param string $type
	 * @param Forum $forum
	 *
	 * @return bool
	 */
	public function isThreadTypeAllowed(string $type, Forum $forum): bool
	{
		if ($type === 'redirect')
		{
			// special cases that are always allowed
			return true;
		}

		if ($type === $this->getDefaultThreadType($forum))
		{
			return true;
		}

		return in_array($type, $this->getExtraAllowedThreadTypes($forum));
	}

	/**
	 * Returns the default type config data for this forum type. This default will be merged with any overrides
	 * in the specific forum entity when fetched.
	 *
	 * @return array
	 */
	public function getDefaultTypeConfig(): array
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
	protected function getTypeConfigColumnDefinitions(): array
	{
		return [];
	}

	/**
	 * Gets the type config validator handler for the specified forum.
	 *
	 * @param Forum $forum
	 *
	 * @return \XF\Mvc\Entity\ArrayValidator
	 */
	public function getTypeConfigValidator(Forum $forum): \XF\Mvc\Entity\ArrayValidator
	{
		return \XF::arrayValidator(
			$this->getTypeConfigColumnDefinitions(),
			$forum->type_config,
			$forum->exists()
		);
	}

	/**
	 * Extension point to allow fully overriding the controller action when viewing the specified forum.
	 *
	 * @param Forum $forum
	 * @param AbstractController $controller
	 *
	 * @return null|\XF\Mvc\Reply\AbstractReply Returning a reply object will prevent the standard action from running.
	 */
	public function overrideDisplay(Forum $forum, AbstractController $controller)
	{
		return null;
	}

	/**
	 * Allows overriding of the forum view class and template.
	 *
	 * @param Forum $forum
	 *
	 * @return array 2 values: [view class name, template name]
	 */
	public function getForumViewAndTemplate(Forum $forum): array
	{
		return ['XF:Forum\View', 'forum_view'];
	}

	/**
	 * Returns key-value pairs of template and macro overrides/options for use within the forum view and related templates.
	 * Notably, this includes the macros used for thread list items and quick thread.
	 *
	 * Note, this may be used in contexts outside of forum view itself, such as when returning a thread list item
	 * via quick edit or quick thread. Extra data passed in may vary by context and is unlikely to be available outside of
	 * the primary forum view context.
	 *
	 * Keys:
	 * - thread_list_macro
	 * - thread_list_macro_args
	 * - quick_thread_macro
	 * - quick_thread_macro_args
	 *
	 * @param Forum $forum
	 * @param array $extra
	 *
	 * @return array
	 */
	public function getForumViewTemplateOverrides(Forum $forum, array $extra = []): array
	{
		return [];
	}

	/**
	 * Extension point for adjusting or adding to the view params when viewing the specified forum.
	 *
	 * @param Forum $forum
	 * @param array $viewParams
	 * @param Request $request
	 *
	 * @return array Updated view params
	 */
	public function adjustForumViewParams(Forum $forum, array $viewParams, Request $request): array
	{
		return $viewParams;
	}

	/**
	 * Gets additional type-specific forum view filters. A filter should only be returned if it's actively being applied.
	 *
	 * These will be used in subsequent calls to apply filtering, as well as in the UI via things like page navigation.
	 *
	 * @param Forum $forum
	 * @param Request $request
	 * @param array $filters List of globally applicable filters
	 *
	 * @return array New set of filters (including global ones)
	 */
	public function getForumFilterInput(Forum $forum, Request $request, array $filters): array
	{
		return $filters;
	}

	/**
	 * Applies additional type-specific forum view filters. Note that these filters will apply to both sticky and
	 * non-sticky thread fetches.
	 *
	 * @param Forum $forum
	 * @param \XF\Finder\Thread $threadFinder
	 * @param array $filters
	 */
	public function applyForumFilters(Forum $forum, \XF\Finder\Thread $threadFinder, array $filters)
	{
	}

	/**
	 * Returns the threads per page value to use when viewing this forum. This should primarily be used
	 * in cases where you are changing the thread display significantly from a basic list.
	 *
	 * @param Forum $forum
	 *
	 * @return int
	 */
	public function getThreadsPerPage(Forum $forum): int
	{
		return \XF::options()->discussionsPerPage;
	}

	/**
	 * Extension point to add further customizations to the thread list finder when viewing a forum. For conditions
	 * that are based on filters, use getForumFilterInput and applyForumFilters.
	 *
	 * @param Forum $forum
	 * @param \XF\Finder\Thread $threadFinder
	 * @param int $page
	 * @param Request $request
	 */
	public function adjustForumThreadListFinder(
		Forum $forum,
		\XF\Finder\Thread $threadFinder,
		int $page,
		Request $request
	)
	{
	}

	/**
	 * This method allows you to bulk preload extra content that might be attached to individual threads.
	 * For example, this might be the attachments in the first post.
	 *
	 * When possible, use adjustForumThreadListFinder to eagerly fetch content via joins.
	 *
	 * @param Forum $forum
	 * @param iterable $threads List of post entity objects (may be an array or collection)
	 * @param array $options Any additional options or context details (generally unused)
	 */
	public function fetchExtraContentForThreadsFullView(Forum $forum, $threads, array $options = [])
	{
	}

	/**
	 * Extension point to customize the results of the forum filter popup menu. The view class, template and
	 * params can be accessed via the view object and changed.
	 *
	 * @param Forum $forum
	 * @param \XF\Mvc\Reply\View $filtersView
	 *
	 * @return \XF\Mvc\Reply\AbstractReply
	 */
	public function adjustForumFiltersPopup(Forum $forum, \XF\Mvc\Reply\View $filtersView): \XF\Mvc\Reply\AbstractReply
	{
		return $filtersView;
	}

	/**
	 * Gets the list of available thread list sorting options.
	 *
	 * @param Forum $forum
	 * @param bool $forAdminConfig If true, this is called in the context of the admin configuring a forum default sort
	 *
	 * @return array See \XF\Repository\Thread::getDefaultThreadListSortOptions for details
	 */
	public function getThreadListSortOptions(Forum $forum, bool $forAdminConfig = false): array
	{
		return \XF::repository('XF:Thread')->getDefaultThreadListSortOptions($forAdminConfig);
	}

	/**
	 * Called to setup display changes when editing/creating a forum of this type.
	 *
	 * Note that $typeConfig differs from $forum->type_config in some scenarios. For example, this method is called
	 * when preparing to change a forum's type. In this case, the forum is not this forum type yet, so $typeConfig
	 * will be the default data of this type.
	 *
	 * @param \XF\Mvc\Reply\View $reply
	 * @param Node $node
	 * @param Forum $forum
	 * @param array $typeConfig The type config data for the forum, as it relates to this forum type. Can be modified as available to template via $typeConfig.
	 *
	 * @return null|string Name of the admin template that contains form rows to setup the type config values.
	 */
	public function setupTypeConfigEdit(
		\XF\Mvc\Reply\View $reply, Node $node, Forum $forum, array &$typeConfig
	)
	{
		return null;
	}

	/**
	 * Called to prepare saving the type config data for a forum.
	 *
	 * Errors can be passed into the $form.
	 *
	 * @param FormAction $form
	 * @param Node $node
	 * @param Forum $forum
	 * @param Request $request
	 *
	 * @return array|\XF\Mvc\Entity\ArrayValidator The new type_config data to save in the forum record or array validator
	 */
	public function setupTypeConfigSave(FormAction $form, Node $node, Forum $forum, Request $request)
	{
		return [];
	}

	/**
	 * Called to prepare saving the type config data for a forum via an API request. This logic may differ
	 * from setupTypeConfigSave as not all elements of the type config may be present in the request. Only elements
	 * present should be updated.
	 *
	 * @param FormAction $form
	 * @param Node $node
	 * @param Forum $forum
	 * @param \XF\InputFiltererArray $typeInputFilterer
	 *
	 * @return array|\XF\Mvc\Entity\ArrayValidator The new type_config data to save in the forum record or array validator
	 */
	public function setupTypeConfigApiSave(
		FormAction $form, Node $node, Forum $forum, \XF\InputFiltererArray $typeInputFilterer
	)
	{
		return $forum->type_config;
	}

	/**
	 * Adds the type config data to the forum's API result object. Data can be added into the result however wished.
	 * If this is not overridden, no type config data will be present in the result.
	 *
	 * @param Forum $forum
	 * @param \XF\Api\Result\EntityResult $result
	 * @param int $verbosity
	 * @param array $options
	 */
	public function addTypeConfigToApiResult(
		Forum $forum,
		\XF\Api\Result\EntityResult $result,
		int $verbosity = \XF\Mvc\Entity\Entity::VERBOSITY_NORMAL,
		array $options = []
	)
	{
	}

	/**
	 * Returns true if an admin can manually create a forum of this type via the nodes section. If false,
	 * a forum of this type can still be created but it must be done programmatically.
	 *
	 * @return bool
	 */
	public function canManuallyCreateForum(): bool
	{
		return true;
	}

	/**
	 * Returns true if a forum of this type can be changed to another type.
	 *
	 * @param Forum $forum
	 *
	 * @return bool
	 */
	public function canChangeForumType(Forum $forum): bool
	{
		return true;
	}
}