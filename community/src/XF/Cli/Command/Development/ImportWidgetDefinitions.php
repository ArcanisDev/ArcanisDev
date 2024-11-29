<?php

namespace XF\Cli\Command\Development;

class ImportWidgetDefinitions extends AbstractImportCommand
{
	protected function getContentTypeDetails()
	{
		return [
			'name' => 'widget definitions',
			'command' => 'widget-definitions',
			'dir' => 'widget_definitions',
			'entity' => 'XF:WidgetDefinition'
		];
	}

	protected function getTitleIdMap($typeDir, $addOnId)
	{
		return \XF::db()->fetchPairs("
			SELECT definition_id, definition_id
			FROM xf_widget_definition
			WHERE addon_id = ?
		", $addOnId);
	}
}