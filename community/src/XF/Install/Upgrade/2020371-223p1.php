<?php

namespace XF\Install\Upgrade;

class Version2020371 extends AbstractUpgrade
{
	public function getVersionName()
	{
		return '2.2.3 Patch 1';
	}

	public function step1()
	{
		$this->insertUpgradeJob('upgradePatch223', 'XF:Upgrade\\Patch223', []);
	}
}