<?php

namespace XF\Cron;

class SearchForum
{
	public static function triggerSearchForumCacheRebuild()
	{
		\XF::app()->jobManager()->enqueueUnique(
			'searchForumExpired',
			'XF:SearchForum',
			[],
			false
		);
	}
}
