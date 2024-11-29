<?php

namespace XF\BbCode\Helper;

use function intval;

class YouTube
{
	public static function matchCallback($url, $matchedId, \XF\Entity\BbCodeMediaSite $site, $siteId)
	{
		if (preg_match('#(\?|&)(t|time_continue)=(?P<time>[0-9hms]+)#si', $url, $matches))
		{
			$matchedId .= ':' . self::getSecondsFromTimeString($matches['time']);
		}

		if (preg_match('/(?:\?|&)list=(?P<list>[a-z0-9-_]+)/si', $url, $matches))
		{
			$matchedId .= ', list: ' . $matches['list'];
		}

		return $matchedId;
	}

	public static function htmlCallback($mediaKey, array $site, $siteId)
	{
		$params = [
			'siteId' => $siteId
		];

		if (preg_match_all('/(\s*,\s*(?P<param>[a-z0-9]+):\s*(?P<value>[a-z0-9-_]+))/si', $mediaKey, $matches, PREG_SET_ORDER))
		{
			foreach ($matches AS $match)
			{
				$params[$match['param']] = rawurlencode($match['value']);
				$mediaKey = str_replace($match[1], '', $mediaKey);
			}
		}

		$mediaInfo = explode(':', $mediaKey);

		$params['id'] = rawurlencode($mediaInfo[0]);
		$params['start'] = isset($mediaInfo[1]) ? intval($mediaInfo[1]) : 0;

		return \XF::app()->templater()->renderTemplate('public:_media_site_embed_youtube', $params);
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