<?php

namespace XF\Finder;

use XF\Mvc\Entity\Finder;

class UsernameChange extends Finder
{
	public function visibleOnly()
	{
		$this->where('visible', 1);

		return $this;
	}

	public function recentOnly($cutOff = null)
	{
		if ($cutOff === null)
		{
			$cutOff = \XF::$time - 86400 * $this->app()->options()->usernameChangeRecentLimit;
		}

		$this->where('change_date', '>=', $cutOff);

		return $this;
	}
}