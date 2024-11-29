<?php

namespace XF\ForumType;

use XF\Entity\Forum;
use XF\Entity\Node;
use XF\Http\Request;
use XF\Mvc\Entity\Entity;
use XF\Mvc\FormAction;

class Question extends AbstractHandler
{
	public function getDefaultThreadType(\XF\Entity\Forum $forum): string
	{
		return 'question';
	}

	public function getDisplayOrder(): int
	{
		return 20;
	}

	public function getTypeIconClass(): string
	{
		return 'fa-question-circle';
	}

	public function getDefaultTypeConfig(): array
	{
		return [
			'allow_answer_voting' => true,
			'allow_downvote' => true
		];
	}

	protected function getTypeConfigColumnDefinitions(): array
	{
		return [
			'allow_answer_voting' => ['type' => Entity::BOOL],
			'allow_downvote' => ['type' => Entity::BOOL]
		];
	}

	public function getForumViewAndTemplate(Forum $forum): array
	{
		return ['XF:Forum\ViewTypeQuestion', 'forum_view_type_question'];
	}

	public function adjustForumViewParams(Forum $forum, array $viewParams, Request $request): array
	{
		$effectiveOrder = $viewParams['sortInfo']['order'];
		$filters = $viewParams['filters'];

		$questionTabs = [
			'latest' => [
				'selected' => ($effectiveOrder == 'last_post_date'),
				'filters' => array_replace($filters, [
					'order' => 'last_post_date',
					'direction' => 'desc',
					'unanswered' => null,
					'unsolved' => null,
					'your_questions' => null,
					'your_answers' => null,
				]),
				'priority' => 1
			],
			'popular' => [
				'selected' => ($effectiveOrder == 'reply_count'),
				'filters' => array_replace($filters, [
					'order' => 'reply_count',
					'direction' => 'desc',
					'unanswered' => null,
					'unsolved' => null,
					'your_questions' => null,
					'your_answers' => null,
				]),
				'priority' => 1
			],
			'newest' => [
				'selected' => ($effectiveOrder == 'post_date'),
				'filters' => array_replace($filters, [
					'order' => 'post_date',
					'direction' => 'desc',
					'unanswered' => null,
					'unsolved' => null,
					'your_questions' => null,
					'your_answers' => null,
				]),
				'priority' => 1
			],
			'unanswered' => [
				'selected' => !empty($filters['unanswered']),
				'filters' => array_replace($filters, [
					'order' => null,
					'direction' => null,
					'unanswered' => 1,
					'unsolved' => null,
					'your_questions' => null,
					'your_answers' => null,
				]),
				'priority' => 5
			],
			'unsolved' => [
				'selected' => !empty($filters['unsolved']),
				'filters' => array_replace($filters, [
					'order' => null,
					'direction' => null,
					'unanswered' => null,
					'unsolved' => 1,
					'your_questions' => null,
					'your_answers' => null,
				]),
				'priority' => 5
			],
			'yourQuestions' => [
				'selected' => !empty($filters['your_questions']),
				'filters' => array_replace($filters, [
					'order' => null,
					'direction' => null,
					'starter_id' => null,
					'unanswered' => null,
					'unsolved' => null,
					'your_questions' => 1,
					'your_answers' => null,
				]),
				'priority' => 10
			],
			'yourAnswers' => [
				'selected' => !empty($filters['your_answers']),
				'filters' => array_replace($filters, [
					'order' => null,
					'direction' => null,
					'unanswered' => null,
					'unsolved' => null,
					'your_questions' => null,
					'your_answers' => 1,
				]),
				'priority' => 10
			]
		];

		if (!\XF::visitor()->user_id)
		{
			unset($questionTabs['yourQuestions'], $questionTabs['yourAnswers']);
		}

		$selectedId = null;
		$selectedPriority = 0;

		foreach ($questionTabs AS $tabId => &$tab)
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
			foreach ($questionTabs AS $tabId => &$tab)
			{
				if ($tab['selected'] && $tabId !== $selectedId)
				{
					$tab['selected'] = false;
				}
			}
		}

		unset($tab);

		$viewParams['questionTabs'] = $questionTabs;

		return $viewParams;
	}

	public function getForumViewTemplateOverrides(Forum $forum, array $extra = []): array
	{
		return [
			'thread_list_macro' => 'thread_list_question_macros::item'
		];
	}

	public function getForumFilterInput(Forum $forum, Request $request, array $filters): array
	{
		$userId = \XF::visitor()->user_id;

		$unanswered = $request->filter('unanswered', 'bool');
		if ($unanswered)
		{
			$filters['unanswered'] = 1;
		}

		$unsolved = $request->filter('unsolved', 'bool');
		if ($unsolved)
		{
			$filters['unsolved'] = 1;
		}

		$yourQuestions = $request->filter('your_questions', 'bool');
		if ($yourQuestions && $userId)
		{
			$filters['your_questions'] = 1;
			unset($filters['starter_id']);
		}
		else if ($userId && !empty($filters['starter_id']) && $filters['starter_id'] == $userId)
		{
			$filters['your_questions'] = 1;
			unset($filters['starter_id']);
		}

		$yourAnswers = $request->filter('your_answers', 'bool');
		if ($yourAnswers && $userId)
		{
			$filters['your_answers'] = 1;
		}

		return $filters;
	}

	public function applyForumFilters(Forum $forum, \XF\Finder\Thread $threadFinder, array $filters): \XF\Finder\Thread
	{
		$userId = \XF::visitor()->user_id;

		if (!empty($filters['unanswered']))
		{
			$threadFinder->where('reply_count', '=', 0);
		}

		if (!empty($filters['unsolved']))
		{
			$threadFinder->where('Question.solution_post_id', '=', 0);
			$threadFinder->indexHint('USE', 'last_post_date');
		}

		if (!empty($filters['your_questions']))
		{
			$threadFinder->where('user_id', $userId);
		}

		if (!empty($filters['your_answers']))
		{
			$threadFinder->exists('UserPosts|' . $userId)
				->where('user_id', '!=', $userId);
		}

		return $threadFinder;
	}

	public function adjustForumFiltersPopup(Forum $forum, \XF\Mvc\Reply\View $filtersView): \XF\Mvc\Reply\AbstractReply
	{
		$filtersView->setTemplateName('forum_filters_type_question');

		$filters = $filtersView->getParam('filters');
		$visitor = \XF::visitor();

		if (!empty($filters['your_questions']) && $visitor->user_id)
		{
			$filtersView->setParam('starterFilter', $visitor);
		}

		return $filtersView;
	}

	public function setupTypeConfigEdit(
		\XF\Mvc\Reply\View $reply, Node $node, Forum $forum, array &$typeConfig
	)
	{
		return 'forum_type_config_question';
	}

	public function setupTypeConfigSave(FormAction $form, Node $node, Forum $forum, Request $request)
	{
		$validator = $this->getTypeConfigValidator($forum);

		$validator->bulkSet([
			'allow_answer_voting' => $request->filter('type_config.allow_answer_voting', 'bool'),
			'allow_downvote' => $request->filter('type_config.allow_downvote', 'bool'),
		]);

		return $validator;
	}

	public function setupTypeConfigApiSave(
		FormAction $form, Node $node, Forum $forum, \XF\InputFiltererArray $typeInputFilterer
	)
	{
		$validator = $this->getTypeConfigValidator($forum);

		$allowVoting = $typeInputFilterer->filter('type_config.allow_answer_voting', '?bool');
		if ($allowVoting !== null)
		{
			$validator->allow_answer_voting = $allowVoting;
		}

		$allowDownvote = $typeInputFilterer->filter('type_config.allow_downvote', '?bool');
		if ($allowDownvote !== null)
		{
			$validator->allow_downvote = $allowDownvote;
		}

		return $validator;
	}

	public function addTypeConfigToApiResult(
		Forum $forum,
		\XF\Api\Result\EntityResult $result,
		int $verbosity = \XF\Mvc\Entity\Entity::VERBOSITY_NORMAL,
		array $options = []
	)
	{
		$result->question = [
			'allow_answer_voting' => $forum->type_config['allow_answer_voting'],
			'allow_downvote' => $forum->type_config['allow_downvote']
		];
	}
}