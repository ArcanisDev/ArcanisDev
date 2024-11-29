<?php

namespace XF\Data;

class Robot
{
	public function getRobotUserAgents()
	{
		return [
			'adsbot-google' => 'google-adsbot',
			'ahrefsbot' => 'ahrefs',
			'amazonbot' => 'amazonbot',
			'applebot' => 'applebot',
			'archive.org_bot' => 'archive.org',
			'baiduspider' => 'baidu',
			'bingbot' => 'bing',
			'blexbot' => 'blexbot',
			'dotbot' => 'dotbot',
			'facebookexternalhit' => 'facebookextern',
			'googlebot' => 'google',
			'ia_archiver' => 'alexa',
			'ltx71' => 'ltx71',
			'magpie-crawler' => 'brandwatch',
			'mauibot' => 'mauibot',
			'mediapartners-google' => 'google-adsense',
			'mj12bot' => 'mj12',
			'msnbot' => 'msnbot',
			'petalbot' => 'petalsearch',
			'proximic' => 'proximic',
			'scoutjet' => 'scoutjet',
			'seekport crawler' => 'seekport',
			'semrushbot' => 'semrush',
			'seostar' => 'seostar',
			'seznambot' => 'seznam',
			'sogou web spider' => 'sogou',
			'trendictionbot' => 'trendiction',
			'twitterbot' => 'twitter',
			'yahoo! slurp' => 'yahoo',
			'yandex' => 'yandex',

			/*'crawler',
			'php/',
			'zend_http_client',*/
		];
	}

	public function userAgentMatchesRobot($userAgent)
	{
		$bots = $this->getRobotUserAgents();

		if (preg_match(
			'#(' . implode('|', array_map('preg_quote', array_keys($bots))) . ')#i',
			strtolower($userAgent),
			$match
		))
		{
			return $bots[$match[1]];
		}
		else
		{
			return '';
		}
	}

	public function getRobotList()
	{
		return [
			'ahrefs' => [
				'title' => 'Ahrefs',
				'link' => 'http://ahrefs.com/robot/'
			],
			'alexa' => [
				'title' => 'Alexa',
				'link' => 'http://www.alexa.com/help/webmasters',
			],
			'amazonbot' => [
				'title' => 'Amazon',
				'link' => 'https://developer.amazon.com/support/amazonbot'
			],
			'applebot' => [
				'title' => 'Applebot',
				'link' => 'https://support.apple.com/en-us/HT204683'
			],
			'archive.org' => [
				'title' => 'Internet Archive',
				'link' => 'http://www.archive.org/details/archive.org_bot'
			],
			'baidu' => [
				'title' => 'Baidu',
				'link' => 'http://www.baidu.com/search/spider.htm'
			],
			'bing' => [
				'title' => 'Bing',
				'link' => 'http://www.bing.com/bingbot.htm'
			],
			'blexbot' => [
				'title' => 'BLEXBot',
				'link' => 'http://webmeup-crawler.com/'
			],
			'brandwatch' => [
				'title' => 'Brandwatch',
				'link' => 'http://www.brandwatch.com/how-it-works/gathering-data/'
			],
			'dotbot' => [
				'title' => 'Moz Dotbot',
				'link' => 'https://moz.com/help/moz-procedures/crawlers/dotbot'
			],
			'facebookextern' => [
				'title' => 'Facebook',
				'link' => 'http://www.facebook.com/externalhit_uatext.php'
			],
			'google' => [
				'title' => 'Google',
				'link' => 'https://support.google.com/webmasters/answer/182072'
			],
			'google-adsbot' => [
				'title' => 'Google Ads',
				'link' => 'http://www.google.com/adsbot.html'
			],
			'google-adsense' => [
				'title' => 'Google AdSense',
				'link' => 'https://support.google.com/webmasters/answer/182072'
			],
			'ltx71' => [
				'title' => 'LTX71',
				'link' => 'http://ltx71.com/'
			],
			'mauibot' => [
				'title' => 'MauiBot',
				'link' => ''
			],
			'mj12' => [
				'title' => 'Majestic-12',
				'link' => 'http://majestic12.co.uk/bot.php',
			],
			'msnbot' => [
				'title' => 'MSN',
				'link' => 'http://search.msn.com/msnbot.htm'
			],
			'petalsearch' => [
				'title' => 'Petal Search',
				'link' => 'https://webmaster.petalsearch.com/site/petalbot'
			],
			'proximic' => [
				'title' => 'Proximic',
				'link' => 'http://www.proximic.com/info/spider.php'
			],
			'scoutjet' => [
				'title' => 'Blekko',
				'link' => 'http://www.scoutjet.com/',
			],
			'seekport' => [
				'title' => 'Seekport',
				'link' => 'http://seekport.com/',
			],
			'semrush' => [
				'title' => 'SEMRush',
				'link' => 'http://www.semrush.com/bot.html'
			],
			'seostar' => [
				'title' => 'Seostar',
				'link' => 'https://seostar.co/robot/',
			],
			'seznam' => [
				'title' => 'Seznam',
				'link' => 'https://napoveda.seznam.cz/en/seznamcz-web-search/'
			],
			'sogou' => [
				'title' => 'Sogou',
				'link' => 'http://www.sogou.com/docs/help/webmasters.htm#07'
			],
			'trendiction' => [
				'title' => 'Trendiction',
				'link' => 'https://www.trendiction.com/bot',
			],
			'twitter' => [
				'title' => 'Twitter',
				'link' => 'https://developer.twitter.com/en/docs/twitter-for-websites/cards/guides/getting-started',
			],
			'unknown' => [
				'title' => 'Unknown',
				'link' => ''
			],
			'yahoo' => [
				'title' => 'Yahoo',
				'link' => 'http://help.yahoo.com/help/us/ysearch/slurp'
			],
			'yandex' => [
				'title' => 'Yandex',
				'link' => 'http://help.yandex.com/search/?id=1112030'
			]
		];
	}

	public function getRobotInfo($robot)
	{
		$list = $this->getRobotList();
		return $list[$robot] ?? null;
	}
}