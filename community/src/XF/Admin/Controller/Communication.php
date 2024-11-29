<?php

namespace XF\Admin\Controller;

class Communication extends AbstractController
{
	public function actionIndex()
	{
		return $this->plugin('XF:AdminSection')->actionView('communication');
	}
}