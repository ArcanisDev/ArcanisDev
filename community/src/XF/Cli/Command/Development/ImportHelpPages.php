<?php

namespace XF\Cli\Command\Development;

class ImportHelpPages extends AbstractImportCommand
{
	protected function getContentTypeDetails()
	{
		return [
			'name' => 'help pages',
			'command' => 'help-pages',
			'dir' => 'help_pages',
			'entity' => 'XF:HelpPage'
		];
	}

	protected function getTitleIdMap($typeDir, $addOnId)
	{
		return \XF::db()->fetchPairs("
			SELECT page_id, page_id
			FROM xf_help_page
			WHERE addon_id = ?
		", $addOnId);
	}
}