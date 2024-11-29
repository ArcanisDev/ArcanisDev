<?php

namespace XF\Pub\View;

use Laminas\Feed\Writer\Entry;
use Laminas\Feed\Writer\Feed;

use function strlen;

class FeedHelper
{
	public static function setupFeed(
		Feed $feed,
		string $title,
		string $description,
		string $feedLink
	)
	{
		$app = \XF::app();
		$options = $app->options();
		$router = $app->router('public');

		$indexUrl = $router->buildLink('canonical:index');
		$title = $title ?: $indexUrl;
		$description = $description ?: $title; // required in rss 2.0 spec

		$feed->setEncoding('utf-8')
			->setTitle($title)
			->setDescription($description)
			->setLink($indexUrl)
			->setFeedLink($feedLink, 'rss')
			->setDateModified(\XF::$time)
			->setLastBuildDate(\XF::$time)
			->setGenerator($options->boardTitle);
	}

	public static function setupEntryForThread(
		Entry $entry,
		\XF\Entity\Thread $thread,
		string $order = 'last_post_date'
	)
	{
		$app = \XF::app();
		$options = $app->options();
		$router = $app->router('public');

		$title = empty($thread->title)
			? \XF::phrase('title:') . ' ' . $thread->title
			: $thread->title;
		$link = $router->buildLink('canonical:threads', $thread);

		switch ($order)
		{
			case 'post_date':
				$date = $thread->post_date;
				break;

			default:
				$date = $thread->last_post_date;
				break;
		}

		$entry
			->setId((string)$thread->thread_id)
			->setTitle($title)
			->setLink($link)
			->setDateCreated($date);

		$authorLink = $router->buildLink('canonical:members', $thread);
		$entry->addAuthor([
			'name' => $thread->username,
			'email' => 'invalid@example.com',
			'uri' => $authorLink
		]);

		$threadForum = $thread->Forum;
		if ($threadForum)
		{
			$threadForumLink = $router->buildLink(
				'canonical:forums',
				$threadForum
			);
			$entry->addCategory([
				'term' => $threadForum->title,
				'scheme' => $threadForumLink
			]);
		}

		$firstPost = $thread->FirstPost;
		$maxLength = $options->discussionRssContentLength;
		if ($maxLength && $firstPost && $firstPost->message)
		{
			$bbCodeParser = $app->bbCode()->parser();
			$bbCodeRules = $app->bbCode()->rules('post:rss');

			$bbCodeCleaner = $app->bbCode()->renderer('bbCodeClean');
			$bbCodeRenderer = $app->bbCode()->renderer('html');

			$stringFormatter = $app->stringFormatter();

			$snippet = $bbCodeCleaner->render(
				$stringFormatter->wholeWordTrimBbCode(
					$firstPost->message,
					$maxLength
				),
				$bbCodeParser,
				$bbCodeRules
			);
			if ($snippet != $firstPost->message)
			{
				$readMore = \XF::phrase('read_more');
				$snippet .= "\n\n[URL='{$link}']{$readMore}[/URL]";
			}

			$renderOptions = $firstPost->getBbCodeRenderOptions(
				'post:rss',
				'html'
			);
			$renderOptions['noProxy'] = true;
			$renderOptions['lightbox'] = false;

			$content = trim($bbCodeRenderer->render(
				$snippet,
				$bbCodeParser,
				$bbCodeRules,
				$renderOptions
			));
			if (strlen($content))
			{
				$entry->setContent($content);
			}
		}

		if ($thread->reply_count)
		{
			$entry->setCommentCount($thread->reply_count);
		}
	}
}
