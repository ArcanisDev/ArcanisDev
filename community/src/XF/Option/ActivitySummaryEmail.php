<?php

namespace XF\Option;

class ActivitySummaryEmail extends AbstractOption
{
	public static function verifyOption(&$value, \XF\Entity\Option $option)
	{
		if (empty($value['enabled']))
		{
			// test emails will not send unless these have values so just
			// force these as defaults when the option is being disabled
			$value['last_activity_min_days'] = 14;
			$value['email_frequency_days'] = 14;
			$value['last_activity_max_days'] = 180;
		}

		return true;
	}
}