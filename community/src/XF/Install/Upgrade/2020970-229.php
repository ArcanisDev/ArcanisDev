<?php

namespace XF\Install\Upgrade;

class Version2020970 extends AbstractUpgrade
{
	public function getVersionName()
	{
		return '2.2.9';
	}

	public function step1()
	{
		\XF::runOnce('nodeNestedSetRebuild', function()
		{
			/** @var \XF\Service\Node\RebuildNestedSet $service */
			$service = \XF::service('XF:Node\RebuildNestedSet', 'XF:Node', [
				'parentField' => 'parent_node_id'
			]);
			$service->rebuildNestedSetInfo();
		});
	}
}