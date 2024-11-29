<?php

namespace XF\Cron;

class ActivitySummary
{
	public static function triggerActivitySummaryEmail()
	{
		$activitySummaryEmail = \XF::options()->activitySummaryEmail;
		if (empty($activitySummaryEmail['enabled']))
		{
			return;
		}

		if (\XF::app()->import()->manager()->isImportRunning())
		{
			// do not allow activity summary email to be sent while an import is in progress
			return;
		}

		/** @var \XF\Repository\ActivitySummary $repo */
		$repo = \XF::repository('XF:ActivitySummary');

		$sections = $repo->findActivitySummarySectionsForDisplay()->fetch();

		if (!$sections->count())
		{
			return;
		}

		$userIds = $repo->getActivitySummaryRecipientIds();

		\XF::app()->jobManager()->enqueueUnique('activitySummaryEmail', 'XF:ActivitySummaryEmail', [
			'user_ids' => $userIds,
			'section_ids' => $sections->keys()
		], false);
	}
}