<?php

namespace XF\Import\DataHelper;

class ProfileBanner extends AbstractHelper
{
	public function copyFinalBannerFile($sourceFile, $size, \XF\Entity\UserProfile $profile)
	{
		$targetPath = $profile->getAbstractedBannerPath($size);
		return \XF\Util\File::copyFileToAbstractedPath($sourceFile, $targetPath);
	}

	public function copyFinalBannerFiles(array $sourceFileMap, \XF\Entity\UserProfile $profile)
	{
		$success = true;
		foreach ($sourceFileMap AS $size => $sourceFile)
		{
			if (!$this->copyFinalBannerFile($sourceFile, $size, $profile))
			{
				$success = false;
				break;
			}
		}

		return $success;
	}

	public function setBannerFromFile($sourceFile, \XF\Entity\User $user)
	{
		/** @var \XF\Service\User\ProfileBanner $bannerService */
		$bannerService = $this->dataManager->app()->service('XF:User\ProfileBanner', $user);
		$bannerService->logIp(false);
		$bannerService->logChange(false);
		$bannerService->silentRunning(true);

		if ($bannerService->setImage($sourceFile))
		{
			$bannerService->updateBanner();
			return true;
		}

		return false;
	}
}