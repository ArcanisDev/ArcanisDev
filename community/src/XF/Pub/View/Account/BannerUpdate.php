<?php

namespace XF\Pub\View\Account;

class BannerUpdate extends \XF\Mvc\View
{
	public function renderJson()
	{
		$visitor = \XF::visitor();

		$banners = [];
		$bannerCodes = array_keys(\XF::app()->container('profileBannerSizeMap'));
		foreach ($bannerCodes AS $code)
		{
			$bannerUrl = $visitor->Profile->getBannerUrl($code);
			if (!$bannerUrl)
			{
				$banners = [];
				break;
			}
			$banners[$code] = $bannerUrl;
		}

		return [
			'userId' => $visitor->user_id,
			'position' => $visitor->Profile->banner_position_y,
			'banners' => $banners
		];
	}
}