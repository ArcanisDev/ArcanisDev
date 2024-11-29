<?php

namespace XF\Cli\Command\Development;

class ImportRoutes extends AbstractImportCommand
{
	protected function getContentTypeDetails()
	{
		return [
			'name' => 'routes',
			'command' => 'routes',
			'dir' => 'routes',
			'entity' => 'XF:Route'
		];
	}

	protected function getTitleIdMap($typeDir, $addOnId)
	{
		return \XF::db()->fetchPairs("
			SELECT CONCAT(route_type, '/', route_prefix, '/', sub_name), route_id
			FROM xf_route
			WHERE addon_id = ?
		", $addOnId);
	}

	public function importData($typeDir, $fileName, $path, $content, $addOnId, array $metadata)
	{
		$route = \XF::app()->developmentOutput()->import('XF:Route', $fileName, $addOnId, $content, $metadata, [
			'import' => true
		]);

		return "$route->route_type/$route->route_prefix/$route->sub_name";
	}
}