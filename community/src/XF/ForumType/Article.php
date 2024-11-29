<?php

namespace XF\ForumType;

use XF\Entity\Forum;
use XF\Entity\Node;
use XF\Http\Request;
use XF\Mvc\Entity\Entity;
use XF\Mvc\FormAction;

class Article extends AbstractHandler
{
	public function getDefaultThreadType(\XF\Entity\Forum $forum): string
	{
		return 'article';
	}

	public function getDisplayOrder(): int
	{
		return 10;
	}

	public function getTypeIconClass(): string
	{
		return 'fa-file-alt';
	}

	public function getDefaultTypeConfig(): array
	{
		return [
			'display_style' => 'full',
			'expanded_snippet' => 500,
			'expanded_per_page' => 0
		];
	}

	protected function getTypeConfigColumnDefinitions(): array
	{
		return [
			'display_style' => ['type' => Entity::STR, 'allowedValues' => ['full', 'preview', 'expanded']],
			'expanded_snippet' => ['type' => Entity::UINT],
			'expanded_per_page' => ['type' => Entity::UINT],
		];
	}

	public function setupTypeConfigEdit(
		\XF\Mvc\Reply\View $reply, Node $node, Forum $forum, array &$typeConfig
	)
	{
		return 'forum_type_config_article';
	}

	public function setupTypeConfigSave(FormAction $form, Node $node, Forum $forum, Request $request)
	{
		$validator = $this->getTypeConfigValidator($forum);

		$validator->bulkSet([
			'display_style' => $request->filter('type_config.display_style', 'str'),
			'expanded_snippet' => $request->filter('type_config.expanded_snippet', 'uint'),
			'expanded_per_page' => $request->filter('type_config.expanded_per_page', 'uint'),
		]);

		return $validator;
	}

	public function setupTypeConfigApiSave(
		FormAction $form, Node $node, Forum $forum, \XF\InputFiltererArray $typeInputFilterer
	)
	{
		$validator = $this->getTypeConfigValidator($forum);

		$displayStyle = $typeInputFilterer->filter('type_config.display_style', '?str');
		if ($displayStyle !== null)
		{
			$validator->display_style = $displayStyle;
		}

		$expandedSnippet = $typeInputFilterer->filter('type_config.expanded_snippet', '?uint');
		if ($expandedSnippet !== null)
		{
			$validator->expanded_snippet = $expandedSnippet;
		}

		$expandedPerPage = $typeInputFilterer->filter('type_config.expanded_per_page', '?uint');
		if ($expandedPerPage !== null)
		{
			$validator->expanded_per_page = $expandedPerPage;
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
		$result->article = [
			'display_style' => $forum->type_config['display_style'],
			'expanded_snippet' => $forum->type_config['expanded_snippet'],
			'expanded_per_page' => $forum->type_config['expanded_per_page'],
		];
	}

	public function getForumViewAndTemplate(Forum $forum): array
	{
		return ['XF:Forum\ViewTypeArticle', 'forum_view_type_article'];
	}

	public function getThreadsPerPage(Forum $forum): int
	{
		$result = 0;

		if ($forum->type_config['display_style'] != 'full')
		{
			$result = $forum->type_config['expanded_per_page'];
		}

		return $result ?: parent::getThreadsPerPage($forum);
	}

	public function adjustForumThreadListFinder(
		Forum $forum,
		\XF\Finder\Thread $threadFinder,
		int $page,
		Request $request
	)
	{
		if ($forum->type_config['display_style'] != 'full')
		{
			$threadFinder
				->with('FirstPost.full')
				->where('discussion_type', '<>', 'redirect');
		}
	}

	public function fetchExtraContentForThreadsFullView(Forum $forum, $threads, array $options = [])
	{
		if ($forum->type_config['display_style'] != 'full')
		{
			$firstPosts = [];
			foreach ($threads AS $thread)
			{
				/** @var \XF\Entity\Thread $thread */
				if ($thread->FirstPost)
				{
					$firstPosts[] = $thread->FirstPost;
				}
			}

			/** @var \XF\Repository\Attachment $attachmentRepo */
			$attachmentRepo = \XF::repository('XF:Attachment');
			$attachmentRepo->addAttachmentsToContent($firstPosts, 'post');
		}
	}
}