<?php

namespace XF\Admin\Controller;

class Content extends AbstractController
{
	public function actionIndex()
	{
		return $this->plugin('XF:AdminSection')->actionView('content');
	}
}