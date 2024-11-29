<?php

namespace XF\MemberStat;

use function boolval;

class Solutions
{
	public static function isVisible(\XF\Entity\MemberStat $memberStat): bool
	{
		return boolval(\XF::db()->fetchOne("
			SELECT user_id
			FROM xf_user
			WHERE question_solution_count > 0
			LIMIT 1
		"));
	}
}