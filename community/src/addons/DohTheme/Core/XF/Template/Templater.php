<?php

namespace DohTheme\Core\XF\Template;

class Templater extends XFCP_Templater
{
	public function fnAvatar($templater, &$escape, $user, $size, $canonical = false, $attributes = [])
	{
		if(!empty($user['user_id']))
		{
			$user = $this->app->em()->find('XF:User', $user['user_id']);	
		}
		return parent::fnAvatar($templater, $escape, $user, $size, $canonical, $attributes);
		
	}
}