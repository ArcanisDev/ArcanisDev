<?php

namespace XF\Cli\Command\Development;

class ImportMemberStats extends AbstractImportCommand
{
	protected function getContentTypeDetails()
	{
		return [
			'name' => 'member stats',
			'command' => 'member-stats',
			'dir' => 'member_stats',
			'entity' => 'XF:MemberStat'
		];
	}

	protected function getTitleIdMap($typeDir, $addOnId)
	{
		return \XF::db()->fetchPairs("
			SELECT member_stat_key, member_stat_id
			FROM xf_member_stat
			WHERE addon_id = ?
		", $addOnId);
	}
}