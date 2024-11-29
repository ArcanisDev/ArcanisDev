<?php

namespace XF\ControllerPlugin;

use XF\Mvc\Entity\Entity;

class PreRegAction extends AbstractPlugin
{
	public function actionPreRegAction($actionType, Entity $containerContent, array $actionData)
	{
		if (!\XF::visitor()->canTriggerPreRegAction())
		{
			return $this->noPermission();
		}

		$preRegActionRepo = $this->getPreRegActionRepo();

		/** @var \XF\PreRegAction\AbstractHandler $handler */
		$handler = $preRegActionRepo->getActionHandler($actionType);
		$action = $handler->saveAction($containerContent, $actionData);

		$session = $this->controller->session();

		$existingActionKey = $session->preRegActionKey;
		if ($existingActionKey)
		{
			$preRegActionRepo->deleteActionByKey($existingActionKey);
		}

		$session->preRegActionKey = $action->guest_key;

		return $this->redirect($this->buildLink('register'));
	}

	/**
	 * @return \XF\Mvc\Entity\Repository|\XF\Repository\PreRegAction
	 */
	protected function getPreRegActionRepo()
	{
		return $this->repository('XF:PreRegAction');
	}
}