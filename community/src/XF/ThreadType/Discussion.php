<?php

namespace XF\ThreadType;

use XF\Entity\Thread;

class Discussion extends AbstractHandler
{
	public function getTypeIconClass(): string
	{
		return 'fa-comments';
	}

	public function onThreadMergeInto(Thread $target, array $sourceThreads)
	{
		$db = \XF::db();

		$forum = $target->Forum;
		if (!$forum->TypeHandler->isThreadTypeAllowed('poll', $forum))
		{
			return;
		}

		foreach ($sourceThreads AS $sourceThread)
		{
			if ($sourceThread->discussion_type == 'poll')
			{
				$pollMoved = $db->update('xf_poll',
					['content_id' => $target->thread_id],
					"content_type = 'thread' AND content_id = " . $db->quote($sourceThread->thread_id)
				);
				if ($pollMoved)
				{
					$target->discussion_type = 'poll';
					break;
				}
			}
		}
	}
}