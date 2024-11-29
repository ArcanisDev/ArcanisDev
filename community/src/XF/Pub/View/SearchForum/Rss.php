<?php

namespace XF\Pub\View\SearchForum;

class Rss extends \XF\Mvc\View
{
	/**
	 * @return string
	 */
	public function renderRss()
	{
		/** @var \XF\Entity\SearchForum $searchForum */
		$searchForum = $this->params['searchForum'];
		$threads = $this->params['threads'];

		$feed = new \Laminas\Feed\Writer\Feed();

		$router = \XF::app()->router('public');
		$title = $searchForum->title;
		$description = $searchForum->description;
		$feedLink = $router->buildLink(
			'canonical:search-forums/index.rss',
			$searchForum
		);

		\XF\Pub\View\FeedHelper::setupFeed(
			$feed,
			$title,
			$description,
			$feedLink
		);

		foreach ($threads AS $thread)
		{
			$entry = $feed->createEntry();
			\XF\Pub\View\FeedHelper::setupEntryForThread($entry, $thread);
			$feed->addEntry($entry);
		}

		return $feed->orderByDate()->export('rss', true);
	}
}
