<?php

namespace XF\Admin\Controller;

use function array_key_exists;

class Asset extends AbstractController
{
	public function actionUpload()
	{
		$this->assertPostOnly();

		$type = $this->filter('type', 'str');

		$assetPermissionMap = $this->getAssetPermissionMap();
		$permissionId = array_key_exists($type, $assetPermissionMap) ?
			$assetPermissionMap[$type] : 'style';

		if (!\XF::visitor()->hasAdminPermission($permissionId))
		{
			return $this->noPermission();
		}

		$asset = $this->request->getFile('upload');
		if (!$asset)
		{
			// the JS would normally block this from being submitted so this shouldn't normally be seen
			return $this->error(\XF::phrase('please_complete_required_fields'));
		}

		if (!\XF\Service\Asset\Upload::validateAssetType($type))
		{
			// again, shouldn't happen unless a request is manually modified
			return $this->error(\XF::phrase('asset_type_names_may_only_contain_alphanumeric_dash_underscore'));
		}

		/** @var \XF\Service\Asset\Upload $assetService */
		$assetService = $this->service('XF:Asset\Upload', $type);
		if (!$assetService->setImageFromUpload($asset))
		{
			return $this->error($assetService->getError());
		}

		if (!$assetService->copyImage())
		{
			return $this->error(\XF::phrase('new_asset_could_not_be_processed'));
		}

		$message = $this->message(\XF::phrase('asset_uploaded_successfully'));
		$message->setJsonParam('path', $assetService->getImageUrl());
		return $message;
	}

	protected function getAssetPermissionMap(): array
	{
		// asset type => admin permission
		return [
			'logo' => 'style',
			'style_properties' => 'style',
			'smilies' => 'bbCodeSmilie',
			'editor_icons' => 'bbCodeSmilie',
			'reactions' => 'reaction',
			'notice_images' => 'notice'
		];
	}
}