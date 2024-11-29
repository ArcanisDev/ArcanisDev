<?php

namespace XF\Cli\Command\Development;

class ImportActivitySummaryDefinitions extends AbstractImportCommand
{
	protected function getContentTypeDetails()
	{
		return [
			'name' => 'activity summary definitions',
			'command' => 'activity-summary-definitions',
			'dir' => 'activity_summary_definitions',
			'entity' => 'XF:ActivitySummaryDefinition'
		];
	}

	protected function getTitleIdMap($typeDir, $addOnId)
	{
		return \XF::db()->fetchPairs("
			SELECT definition_id, definition_id
			FROM xf_activity_summary_definition
			WHERE addon_id = ?
		", $addOnId);
	}
}