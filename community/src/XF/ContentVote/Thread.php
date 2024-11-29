<?php

namespace XF\ContentVote;

use XF\Mvc\Entity\Entity;

class Thread extends AbstractHandler
{
	public function isCountedForContentUser(Entity $entity)
	{
		return false;
	}

	public function getEntityWith()
	{
		$visitor = \XF::visitor();
		return ['Forum', 'Forum.Node.Permissions|' . $visitor->permission_combination_id];
	}
}