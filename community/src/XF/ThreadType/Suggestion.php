<?php

namespace XF\ThreadType;

use XF\Entity\Thread;
use XF\Mvc\Entity\Entity as Entity;
use XF\Http\Request;

class Suggestion extends AbstractHandler
{
	public function getTypeIconClass(): string
	{
		return 'fa-lightbulb-on';
	}

	public function getThreadViewAndTemplate(Thread $thread): array
	{
		return ['XF:Thread\ViewTypeSuggestion', 'thread_view_type_suggestion'];
	}

	public function getThreadViewTemplateOverrides(Thread $thread, array $extra = []): array
	{
		return [
			'pinned_first_post_macro' => 'post_suggestion_macros::suggestion'
		];
	}

	public function adjustThreadViewParams(Thread $thread, array $viewParams, Request $request): array
	{
		$suggestionInfo = [
			'implemented' => false,
			'closed' => false
		];

		$forum = $this->getForumIfSuggestionType($thread);
		if ($forum && $thread->prefix_id)
		{
			$prefixId = $thread->prefix_id;
			$forumTypeConfig = $forum->type_config;

			$suggestionInfo['implemented'] = isset($forumTypeConfig['implemented_prefix_ids'][$prefixId]);
			$suggestionInfo['closed'] = isset($forumTypeConfig['closed_prefix_ids'][$prefixId]);
		}

		$viewParams['suggestionInfo'] = $suggestionInfo;

		return $viewParams;
	}

	public function isFirstPostPinned(Thread $thread): bool
	{
		return true;
	}

	public function isThreadVotingSupported(Thread $thread): bool
	{
		if ($thread->type_data['allow_voting'] === 'no')
		{
			return false;
		}

		return true;
	}

	public function isThreadDownvoteSupported(Thread $thread): bool
	{
		$forum = $this->getForumIfSuggestionType($thread);
		if (!$forum)
		{
			return true;
		}

		return $forum->type_config['allow_downvote'];
	}

	public function canVoteOnThread(Thread $thread, &$error = null): bool
	{
		if ($thread->type_data['allow_voting'] !== 'yes')
		{
			return false;
		}

		if (!\XF::visitor()->hasNodePermission($thread->node_id, 'contentVote'))
		{
			return false;
		}

		$forum = $this->getForumIfSuggestionType($thread);
		if ($forum && $thread->prefix_id)
		{
			// only apply these limits to suggestions in suggestion forums
			$prefixId = $thread->prefix_id;
			$forumTypeConfig = $forum->type_config;

			if (
				isset($forumTypeConfig['implemented_prefix_ids'][$prefixId])
				|| isset($forumTypeConfig['closed_prefix_ids'][$prefixId])
			)
			{
				// can't vote on implemented or closed suggestions
				 return false;
			}
		}

		if (!$thread->discussion_open && !$thread->canLockUnlock())
		{
			$error = \XF::phraseDeferred('you_may_not_perform_this_action_because_discussion_is_closed');
			return false;
		}

		return true;
	}

	/**
	 * Only returns the containing forum if it's a suggestion forum. This is primarily used to make
	 * it easier to switch on behavior that relies on the suggestion forum's type config.
	 *
	 * @param Thread $thread
	 *
	 * @return \XF\Entity\Forum|null
	 */
	protected function getForumIfSuggestionType(Thread $thread)
	{
		return $this->getForumIfType($thread, \XF\ForumType\Suggestion::class);
	}

	public function getDefaultTypeData(): array
	{
		return [
			'allow_voting' => 'yes'
		];
	}

	protected function getTypeDataColumnDefinitions(): array
	{
		return [
			'allow_voting' => ['type' => Entity::STR, 'allowedValues' => ['yes', 'no', 'paused']]
		];
	}

	protected function renderExtraDataEditInternal(
		Thread $thread,
		array $typeData,
		string $context,
		string $subContext,
		array $options = []
	): string
	{
		$params = [
			'thread' => $thread,
			'typeData' => $typeData,
			'context' => $context,
			'subContext' => $subContext,
			'draft' => $options['draft'] ?? []
		];

		return \XF::app()->templater()->renderTemplate('public:thread_type_fields_suggestion', $params);
	}

	public function processExtraDataSimple(
		Thread $thread, string $context, Request $request, &$errors = [], array $options = []
	)
	{
		$validator = $this->getTypeDataValidator($thread);

		if ($thread->canEditModeratorFields())
		{
			$validator->allow_voting = $request->filter('suggestion.allow_voting', 'str');
		}

		return $validator;
	}

	public function processExtraDataForApiSimple(
		Thread $thread, string $context, Request $request, &$errors = [], array $options = []
	)
	{
		$validator = $this->getTypeDataValidator($thread);

		if ($thread->canEditModeratorFields() || \XF::isApiBypassingPermissions())
		{
			$allowVoting = $request->filter('suggestion.allow_voting', '?str');
			if ($allowVoting !== null)
			{
				$validator->allow_voting = $allowVoting;
			}
		}

		return $validator;
	}

	public function addTypeDataToApiResult(
		Thread $thread,
		\XF\Api\Result\EntityResult $result,
		int $verbosity = \XF\Mvc\Entity\Entity::VERBOSITY_NORMAL,
		array $options = []
	)
	{
		$result->suggestion = [
			'allow_voting' => $thread->type_data['allow_voting']
		];
	}

	public function onThreadLeaveType(Thread $thread, array $typeData, bool $isDelete)
	{
		if (!$isDelete)
		{
			// these will be cleaned up on delete already so don't need to do that
			\XF::repository('XF:ContentVote')->fastDeleteVotesForContent('thread', $thread->thread_id);

			$thread->fastUpdate([
				'vote_score' => 0,
				'vote_count' => 0
			]);
		}
	}
}