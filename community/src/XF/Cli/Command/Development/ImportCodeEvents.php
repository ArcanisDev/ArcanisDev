<?php

namespace XF\Cli\Command\Development;

class ImportCodeEvents extends AbstractImportCommand
{
	protected function getContentTypeDetails()
	{
		return [
			'name' => 'code events',
			'command' => 'code-events',
			'dir' => 'code_events',
			'entity' => 'XF:CodeEvent'
		];
	}

	protected function getTitleIdMap($typeDir, $addOnId)
	{
		return \XF::db()->fetchPairs("
			SELECT event_id, event_id
			FROM xf_code_event
			WHERE addon_id = ?
		", $addOnId);
	}
}