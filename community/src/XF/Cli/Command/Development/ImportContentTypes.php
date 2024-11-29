<?php

namespace XF\Cli\Command\Development;

class ImportContentTypes extends AbstractImportCommand
{
	protected function getContentTypeDetails()
	{
		return [
			'name' => 'content types',
			'command' => 'content-types',
			'dir' => 'content_type_fields',
			'entity' => 'XF:ContentTypeField'
		];
	}

	protected function getTitleIdMap($typeDir, $addOnId)
	{
		return \XF::db()->fetchPairs("
			SELECT CONCAT(content_type, '-', field_name), CONCAT(content_type, '-', field_name)
			FROM xf_content_type_field
			WHERE addon_id = ?
		", $addOnId);
	}

	protected function deleteRemaining($typeDir, array $map, $entity)
	{
		if ($map && $typeDir == 'content_type_fields')
		{
			$map = array_map(function ($v)
			{
				list($groupId, $permissionId) = explode('-', $v);
				return [$groupId, $permissionId];
			}, $map);
		}

		parent::deleteRemaining($typeDir, $map, $entity);
	}
}