<?php

namespace XF\BbCode\Helper;

use function intval;

class Vimeo
{
	public static function matchCallback($url, $matchedId, \XF\Entity\BbCodeMediaSite $site, $siteId)
	{
		if (preg_match("/\/{$matchedId}\/(?P<key>[0-9a-f]+)/si", $url, $matches))
		{
			$matchedId .= ':' . $matches['key'];
		}
		if (preg_match('/#t=(?P<time>(([0-9]+h)?([0-9]+m)?([0-9]+s)?))/si', $url, $matches))
		{
			$matchedId .= ':' . self::getSecondsFromTimeString($matches['time']);
		}

		return $matchedId;
	}

	public static function htmlCallback($mediaKey, array $site, $siteId)
	{
		$mediaInfo = explode(':', $mediaKey);

		$id = null;
		$start = null;
		$key = null;

		foreach ($mediaInfo AS $index => $info)
		{
			if ($index === 0)
			{
				$id = $info;
				continue;
			}

			if (preg_match('/[0-9]+/', $info))
			{
				$start = $info;
			}
			else if (preg_match('/[0-9a-f]+/', $info))
			{
				$key = $info;
			}
		}

		return \XF::app()->templater()->renderTemplate('public:_media_site_embed_vimeo', [
			'siteId' => $siteId,
			'id' => rawurlencode($id),
			'start' => $start,
			'key' => $key
		]);
	}

	/**
	 * @param $startTime String in the format 00h00m00s, larger components optional
	 *
	 * @return int
	 */
	public static function getSecondsFromTimeString($timeString)
	{
		$seconds = 0;

		if (preg_match('#^(?P<hours>\d+h)?(?P<minutes>\d+m)?(?P<seconds>\d+s?)$#si', $timeString, $time))
		{
			$seconds = intval($time['seconds']);
			$seconds += 60 * intval($time['minutes']);
			$seconds += 3600 * intval($time['hours']);
		}

		return $seconds;
	}
}