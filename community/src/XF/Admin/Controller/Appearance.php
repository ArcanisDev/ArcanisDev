<?php

namespace XF\Admin\Controller;

class Appearance extends AbstractController
{
	public function actionIndex()
	{
		return $this->plugin('XF:AdminSection')->actionView('appearance');
	}
}