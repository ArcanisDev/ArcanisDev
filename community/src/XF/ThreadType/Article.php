<?php

namespace XF\ThreadType;

use XF\Entity\Post;
use XF\Entity\Thread;

use function intval;

class Article extends AbstractHandler
{
	public function getTypeIconClass(): string
	{
		return 'fa-file-alt';
	}

	public function getThreadViewAndTemplate(Thread $thread): array
	{
		return ['XF:Thread\ViewTypeArticle', 'thread_view_type_article'];
	}

	public function getThreadViewTemplateOverrides(Thread $thread, array $extra = []): array
	{
		$isExpanded = isset($extra['page'])
			? ($extra['page'] == 1)
			: true;

		return [
			'pinned_first_post_macro' => 'post_article_macros::article',
			'pinned_first_post_macro_args' => ['isExpanded' => $isExpanded]
		];
	}

	public function getLdStructuredData(Thread $thread, Post $firstDisplayedPost, int $page, array $extraData = [])
	{
		$output = parent::getLdStructuredData($thread, $firstDisplayedPost, $page, $extraData);

		$output['@type'] = 'Article';

		return $output;
	}

	public function isFirstPostPinned(Thread $thread): bool
	{
		return true;
	}

	public function setupMessagePreparer(
		Thread $thread,
		Post $post,
		\XF\Service\Message\Preparer $preparer
	)
	{
		if (!$post->isFirstPost())
		{
			return;
		}

		// articles are significant content, so give them more relaxed constraints than an average post
		$relaxFactor = 3;

		$maxLength = intval($preparer->getConstraint('maxLength'));
		if ($maxLength > 0)
		{
			$preparer->setConstraint('maxLength', $relaxFactor * $maxLength);
		}

		$maxImages = intval($preparer->getConstraint('maxImages'));
		if ($maxImages > 0)
		{
			$preparer->setConstraint('maxImages', $relaxFactor * $maxImages);
		}

		$maxMedia = intval($preparer->getConstraint('maxMedia'));
		if ($maxMedia > 0)
		{
			$preparer->setConstraint('maxMedia', $relaxFactor * $maxMedia);
		}
	}

	protected function renderExtraDataEditInternal(Thread $thread, array $typeData, string $context, string $subContext, array $options = []): string
	{
		$params = [
			'thread' => $thread,
			'typeData' => $typeData,
			'context' => $context,
			'subContext' => $subContext,
			'draft' => $options['draft'] ?? []
		];

		return \XF::app()->templater()->renderTemplate('public:thread_type_fields_article', $params);
	}
}