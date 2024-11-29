<?php

namespace XF\Admin\Controller;

class GroupAndPermission extends AbstractController
{
	public function actionIndex()
	{
		return $this->plugin('XF:AdminSection')->actionView('groupsAndPermissions');
	}
}