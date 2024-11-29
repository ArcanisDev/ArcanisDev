<?php

namespace XF\Admin\Controller;

class Setup extends AbstractController
{
	public function actionIndex()
	{
		return $this->plugin('XF:AdminSection')->actionView('setup');
	}
}