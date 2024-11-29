<?php

namespace XF\Cli\Command\Development;

class ExportActivitySummaryDefinitions extends AbstractExportCommand
{
	protected function getContentTypeDetails()
	{
		return [
			'name' => 'activity summary definitions',
			'command' => 'activity-summary-definitions',
			'entity' => 'XF:ActivitySummaryDefinition'
		];
	}
}