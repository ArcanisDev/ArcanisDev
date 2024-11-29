<?php

namespace XF\Cli\Command\Development;

class ImportAdminPermissions extends AbstractImportCommand
{
	protected function getContentTypeDetails()
	{
		return [
			'name' => 'admin permissions',
			'command' => 'admin-permissions',
			'dir' => 'admin_permissions',
			'entity' => 'XF:AdminPermission'
		];
	}

	protected function getTitleIdMap($typeDir, $addOnId)
	{
		return \XF::db()->fetchPairs("
			SELECT admin_permission_id, admin_permission_id
			FROM xf_admin_permission
			WHERE addon_id = ?
		", $addOnId);
	}
}