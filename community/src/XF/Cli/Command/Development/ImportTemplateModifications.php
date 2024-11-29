<?php

namespace XF\Cli\Command\Development;

class ImportTemplateModifications extends AbstractImportCommand
{
	protected function getContentTypeDetails()
	{
		return [
			'name' => 'template modifications',
			'command' => 'template-modifications',
			'dir' => 'template_modifications',
			'entity' => 'XF:TemplateModification'
		];
	}

	protected function getTitleIdMap($typeDir, $addOnId)
	{
		return \XF::db()->fetchPairs("
			SELECT CONCAT(type, '/', modification_key), modification_id
			FROM xf_template_modification
			WHERE addon_id = ?
		", $addOnId);
	}
}