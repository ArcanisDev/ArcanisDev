<?php

namespace XF\Install\Upgrade;

class Version2011070 extends AbstractUpgrade
{
	public function getVersionName()
	{
		return '2.1.10';
	}

	public function step1()
	{
		$this->repromptStatsCollectionOptIn([
			'We would like to collect information about which official XenForo add-ons you have enabled.',
			'We would also like to collect information about the total number of third-party add-ons you have enabled.'
		]);
	}
}