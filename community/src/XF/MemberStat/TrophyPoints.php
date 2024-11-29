<?php

namespace XF\MemberStat;

class TrophyPoints
{
	public static function isVisible(\XF\Entity\MemberStat $memberStat): bool
	{
		return \XF::options()->enableTrophies;
	}
}