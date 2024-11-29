<?php

namespace XF\Cli\Command\Development;

class ImportWidgetPositions extends AbstractImportCommand
{
	protected function getContentTypeDetails()
	{
		return [
			'name' => 'widget positions',
			'command' => 'widget-positions',
			'dir' => 'widget_positions',
			'entity' => 'XF:WidgetPosition'
		];
	}

	protected function getTitleIdMap($typeDir, $addOnId)
	{
		return \XF::db()->fetchPairs("
			SELECT position_id, position_id
			FROM xf_widget_position
			WHERE addon_id = ?
		", $addOnId);
	}
}