<?php

namespace XF\Cli\Command\Development;

class ImportNavigation extends AbstractImportCommand
{
	protected function getContentTypeDetails()
	{
		return [
			'name' => 'navigation',
			'command' => 'navigation',
			'dir' => 'navigation',
			'entity' => 'XF:Navigation'
		];
	}

	protected function getTitleIdMap($typeDir, $addOnId)
	{
		return \XF::db()->fetchPairs("
			SELECT navigation_id, navigation_id
			FROM xf_navigation
			WHERE addon_id = ?
		", $addOnId);
	}
}