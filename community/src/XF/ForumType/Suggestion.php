<?php

namespace XF\ForumType;

use XF\Entity\Forum;
use XF\Entity\Node;
use XF\Http\Request;
use XF\Mvc\Entity\Entity;
use XF\Mvc\FormAction;

use function intval, is_array;

class Suggestion extends AbstractHandler
{
	public function getDefaultThreadType(\XF\Entity\Forum $forum): string
	{
		return 'suggestion';
	}

	public function getDisplayOrder(): int
	{
		return 30;
	}

	public function getTypeIconClass(): string
	{
		return 'fa-lightbulb-on';
	}

	public function getDefaultTypeConfig(): array
	{
		return [
			'allow_downvote' => true,
			'implemented_prefix_ids' => [], // key and value both the prefix ID
			'closed_prefix_ids' => [] // key and value both the prefix ID
		];
	}

	protected function getTypeConfigColumnDefinitions(): array
	{
		$prefixIdsVerifier = function(&$ids)
		{
			$ids = is_array($ids) ? $this->getPrefixIdsForTypeConfig($ids) : [];
			return true;
		};

		return [
			'allow_downvote' => ['type' => Entity::BOOL],
			'implemented_prefix_ids' => [
				'type' => Entity::LIST_ARRAY,
				'verify' => $prefixIdsVerifier
			],
			'closed_prefix_ids' => [
				'type' => Entity::LIST_ARRAY,
				'verify' => $prefixIdsVerifier
			]
		];
	}

	public function getForumViewAndTemplate(Forum $forum): array
	{
		return ['XF:Forum\ViewTypeSuggestion', 'forum_view_type_suggestion'];
	}

	public function adjustForumViewParams(Forum $forum, array $viewParams, Request $request): array
	{
		$effectiveOrder = $viewParams['sortInfo']['order'];
		$filters = $viewParams['filters'];

		$suggestionTabs = [
			'latest' => [
				'selected' => ($effectiveOrder == 'last_post_date'),
				'filters' => array_replace($filters, [
					'order' => 'last_post_date',
					'direction' => 'desc',
					'your_suggestions' => null,
					'your_votes' => null,
					'suggestion_state' => null
				]),
				'priority' => 1
			],
			'popular' => [
				'selected' => ($effectiveOrder == 'vote_score'),
				'filters' => array_replace($filters, [
					'order' => 'vote_score',
					'direction' => 'desc',
					'your_suggestions' => null,
					'your_votes' => null,
					'suggestion_state' => null
				]),
				'priority' => 1
			],
			'newest' => [
				'selected' => ($effectiveOrder == 'post_date'),
				'filters' => array_replace($filters, [
					'order' => 'post_date',
					'direction' => 'desc',
					'your_suggestions' => null,
					'your_votes' => null,
					'suggestion_state' => null
				]),
				'priority' => 1
			],
			'implemented' => [
				'selected' => !empty($filters['suggestion_state']) && $filters['suggestion_state'] == 'implemented',
				'filters' => array_replace($filters, [
					'order' => null,
					'direction' => null,
					'your_suggestions' => null,
					'your_votes' => null,
					'suggestion_state' => 'implemented'
				]),
				'priority' => 5
			],
			'yourSuggestions' => [
				'selected' => !empty($filters['your_suggestions']),
				'filters' => array_replace($filters, [
					'order' => null,
					'direction' => null,
					'starter_id' => null,
					'your_suggestions' => 1,
					'your_votes' => null,
					'suggestion_state' => null
				]),
				'priority' => 10
			],
			'yourVotes' => [
				'selected' => !empty($filters['your_votes']),
				'filters' => array_replace($filters, [
					'order' => null,
					'direction' => null,
					'your_suggestions' => null,
					'your_votes' => 1,
					'suggestion_state' => null
				]),
				'priority' => 10
			]
		];

		if (!$forum->type_config['implemented_prefix_ids'])
		{
			unset($suggestionTabs['implemented']);
		}

		if (!\XF::visitor()->user_id)
		{
			unset($suggestionTabs['yourSuggestions'], $suggestionTabs['yourVotes']);
		}

		$selectedId = null;
		$selectedPriority = 0;

		foreach ($suggestionTabs AS $tabId => &$tab)
		{
			if (
				isset($tab['filters']['order'])
				&& $tab['filters']['order'] == $forum->default_sort_order)
			{
				$tab['filters']['order'] = null;
			}

			if (
				isset($tab['filters']['direction'])
				&& $tab['filters']['direction'] == $forum->default_sort_direction)
			{
				$tab['filters']['direction'] = null;
			}

			// get the highest priority selected tab
			if ($tab['selected'] && $tab['priority'] >= $selectedPriority)
			{
				$selectedId = $tabId;
				$selectedPriority = $tab['priority'];
			}
		}

		// second loop to ensure only one tab is selected
		if ($selectedId)
		{
			foreach ($suggestionTabs AS $tabId => &$tab)
			{
				if ($tab['selected'] && $tabId !== $selectedId)
				{
					$tab['selected'] = false;
				}
			}
		}

		unset($tab);

		$viewParams['suggestionTabs'] = $suggestionTabs;

		return $viewParams;
	}

	public function getForumViewTemplateOverrides(Forum $forum, array $extra = []): array
	{
		return [
			'thread_list_macro' => 'thread_list_suggestion_macros::item',
			'quick_thread_macro' => 'thread_list_suggestion_macros::quick_thread',
		];
	}

	public function getForumFilterInput(Forum $forum, Request $request, array $filters): array
	{
		$userId = \XF::visitor()->user_id;

		$yourSuggestions = $request->filter('your_suggestions', 'bool');
		if ($yourSuggestions && $userId)
		{
			$filters['your_suggestions'] = 1;
			unset($filters['starter_id']);
		}
		else if ($userId && !empty($filters['starter_id']) && $filters['starter_id'] == $userId)
		{
			$filters['your_suggestions'] = 1;
			unset($filters['starter_id']);
		}

		$yourVotes = $request->filter('your_votes', 'bool');
		if ($yourVotes && $userId)
		{
			$filters['your_votes'] = 1;
		}

		$suggestionState = $request->filter('suggestion_state', 'string');
		if ($suggestionState == 'implemented' && $forum->type_config['implemented_prefix_ids'])
		{
			$filters['suggestion_state'] = 'implemented';
		}
		else if ($suggestionState == 'closed' && $forum->type_config['closed_prefix_ids'])
		{
			$filters['suggestion_state'] = 'closed';
		}
		else if (
			$suggestionState == 'open'
			&& ($forum->type_config['closed_prefix_ids'] || $forum->type_config['implemented_prefix_ids'])
		)
		{
			$filters['suggestion_state'] = 'open';
		}

		return $filters;
	}

	public function applyForumFilters(Forum $forum, \XF\Finder\Thread $threadFinder, array $filters): \XF\Finder\Thread
	{
		$userId = \XF::visitor()->user_id;

		if (!empty($filters['your_suggestions']))
		{
			$threadFinder->where('user_id', $userId);
		}

		if (!empty($filters['your_votes']))
		{
			$threadFinder->exists('ContentVotes|' . $userId);
		}

		if (!empty($filters['suggestion_state']))
		{
			$typeConfig = $forum->type_config;

			if ($filters['suggestion_state'] == 'implemented')
			{
				$threadFinder->where('prefix_id', array_values($typeConfig['implemented_prefix_ids']));
			}
			else if ($filters['suggestion_state'] == 'closed')
			{
				$threadFinder->where('prefix_id', array_values($typeConfig['closed_prefix_ids']));
			}
			else if ($filters['suggestion_state'] == 'open')
			{
				$specialPrefixIds = $typeConfig['implemented_prefix_ids'] + $typeConfig['closed_prefix_ids'];
				$threadFinder->where('prefix_id', '<>', array_values($specialPrefixIds));
			}
		}

		return $threadFinder;
	}

	public function adjustForumFiltersPopup(Forum $forum, \XF\Mvc\Reply\View $filtersView): \XF\Mvc\Reply\AbstractReply
	{
		$filtersView->setTemplateName('forum_filters_type_suggestion');

		$filters = $filtersView->getParam('filters');
		$visitor = \XF::visitor();

		if (!empty($filters['your_suggestions']) && $visitor->user_id)
		{
			$filtersView->setParam('starterFilter', $visitor);
		}

		return $filtersView;
	}

	public function getThreadListSortOptions(Forum $forum, bool $forAdminConfig = false): array
	{
		$options = parent::getThreadListSortOptions($forum, $forAdminConfig);
		$options['vote_score'] = 'vote_score';

		return $options;
	}

	public function adjustForumThreadListFinder(
		Forum $forum,
		\XF\Finder\Thread $threadFinder,
		int $page,
		Request $request
	)
	{
		$visitor = \XF::visitor();
		if ($visitor->user_id)
		{
			$threadFinder->with('ContentVotes|' . $visitor->user_id);
		}
	}

	public function setupTypeConfigEdit(
		\XF\Mvc\Reply\View $reply, Node $node, Forum $forum, array &$typeConfig
	)
	{
		return 'forum_type_config_suggestion';
	}

	public function setupTypeConfigSave(FormAction $form, Node $node, Forum $forum, Request $request)
	{
		$validator = $this->getTypeConfigValidator($forum);

		$validator->bulkSet([
			'allow_downvote' => $request->filter('type_config.allow_downvote', 'bool'),
			'implemented_prefix_ids' => $request->filter('type_config.implemented_prefix_ids', 'array-uint'),
			'closed_prefix_ids' => $request->filter('type_config.closed_prefix_ids', 'array-uint'),
		]);

		return $validator;
	}

	public function setupTypeConfigApiSave(
		FormAction $form, Node $node, Forum $forum, \XF\InputFiltererArray $typeInputFilterer
	)
	{
		$validator = $this->getTypeConfigValidator($forum);

		$allowDownote = $typeInputFilterer->filter('type_config.allow_downvote', '?bool');
		if ($allowDownote !== null)
		{
			$validator->allow_downvote = $allowDownote;
		}

		$implementedIds = $typeInputFilterer->filter('type_config.implemented_prefix_ids', '?array-uint');
		if (is_array($implementedIds))
		{
			$validator->implemented_prefix_ids = $implementedIds;
		}

		$closedIds = $typeInputFilterer->filter('type_config.closed_prefix_ids', '?array-uint');
		if (is_array($closedIds))
		{
			$validator->closed_prefix_ids = $closedIds;
		}

		return $validator;
	}

	protected function getPrefixIdsForTypeConfig(array $ids)
	{
		foreach ($ids AS $k => &$v)
		{
			$v = intval($v);
			if ($v <= 0)
			{
				unset($ids[$k]);
			}
		}

		$ids = array_unique($ids);
		sort($ids, SORT_NUMERIC);

		return array_combine($ids, $ids);
	}

	public function addTypeConfigToApiResult(
		Forum $forum,
		\XF\Api\Result\EntityResult $result,
		int $verbosity = \XF\Mvc\Entity\Entity::VERBOSITY_NORMAL,
		array $options = []
	)
	{
		$result->suggestion = [
			'allow_downvote' => $forum->type_config['allow_downvote']
		];
	}
}