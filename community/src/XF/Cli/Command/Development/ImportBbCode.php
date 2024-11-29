<?php

namespace XF\Cli\Command\Development;

class ImportBbCode extends AbstractImportCommand
{
	protected function getContentTypeDetails()
	{
		return [
			'name' => 'bb codes',
			'command' => 'bb-codes',
			'dir' => 'bb_codes',
			'entity' => 'XF:BbCode'
		];
	}

	protected function getTitleIdMap($typeDir, $addOnId)
	{
		return \XF::db()->fetchPairs("
			SELECT bb_code_id, bb_code_id
			FROM xf_bb_code
			WHERE addon_id = ?
		", $addOnId);
	}
}