<?php

namespace XF\Cli\Command\Development;

class ImportAdvertisingPositions extends AbstractImportCommand
{
	protected function getContentTypeDetails()
	{
		return [
			'name' => 'advertising positions',
			'command' => 'advertising-positions',
			'dir' => 'advertising_positions',
			'entity' => 'XF:AdvertisingPosition'
		];
	}

	protected function getTitleIdMap($typeDir, $addOnId)
	{
		return \XF::db()->fetchPairs("
			SELECT position_id, position_id
			FROM xf_advertising_position
			WHERE addon_id = ?
		", $addOnId);
	}
}