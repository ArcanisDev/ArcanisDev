<?php

namespace XF\Admin\ControllerPlugin;

abstract class AbstractPlugin extends \XF\ControllerPlugin\AbstractPlugin
{
	public function __construct(\XF\Mvc\Controller $controller)
	{
		if (!($controller instanceof \XF\Admin\Controller\AbstractController))
		{
			throw new \LogicException("Admin controller plugins only work with admin controllers");
		}

		parent::__construct($controller);
	}
}