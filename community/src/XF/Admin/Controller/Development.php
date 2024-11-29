<?php

namespace XF\Admin\Controller;

use XF\Mvc\ParameterBag;

class Development extends AbstractController
{
	/**
	 * @param $action
	 * @param ParameterBag $params
	 * @throws \XF\Mvc\Reply\Exception
	 */
	protected function preDispatchController($action, ParameterBag $params)
	{
		$this->assertDevelopmentMode();
	}

	public function actionIndex()
	{
		return $this->plugin('XF:AdminSection')->actionView('development');
	}
}