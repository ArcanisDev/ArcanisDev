<?php

namespace XF\ApprovalQueue;

use XF\Entity\ApprovalQueue;
use XF\Mvc\Entity\Entity;

class UsernameChange extends AbstractHandler
{
	protected function canViewContent(Entity $content, &$error = null)
	{
		return true;
	}

	protected function canActionContent(Entity $content, &$error = null)
	{
		return \XF::visitor()->canApproveRejectUsernameChange();
	}

	public function getEntityWith()
	{
		return ['User'];
	}

	public function getTemplateData(ApprovalQueue $unapprovedItem)
	{
		$templateData = parent::getTemplateData($unapprovedItem);

		/** @var \XF\Entity\UsernameChange $change */
		$change = $unapprovedItem->Content;

		/** @var \XF\Repository\UsernameChange $usernameChangeRepo */
		$usernameChangeRepo = \XF::repository('XF:UsernameChange');
		$changeFinder = $usernameChangeRepo->findUsernameChangesForList();

		$changes = $changeFinder
			->where('user_id', $change->user_id)
			->where('change_id', '<>', $change->change_id)
			->fetch(5);

		$templateData['previousChanges'] = $changes;

		return $templateData;
	}

	public function actionApprove(\XF\Entity\UsernameChange $usernameChange)
	{
		if (!$this->validateUsernameChangeForAction($usernameChange))
		{
			return;
		}

		$notify = $this->getInput('notify', $usernameChange->change_id);

		/** @var \XF\Service\User\UsernameChange $changeService */
		$changeService = \XF::app()->service('XF:User\UsernameChange', $usernameChange);
		$changeService->setModeratorApproval($notify);
		$changeService->save();
	}

	public function actionReject(\XF\Entity\UsernameChange $usernameChange)
	{
		if (!$this->validateUsernameChangeForAction($usernameChange))
		{
			return;
		}

		$notify = $this->getInput('notify', $usernameChange->change_id);
		$reason = $this->getInput('reason', $usernameChange->change_id);

		/** @var \XF\Service\User\UsernameChange $changeService */
		$changeService = \XF::app()->service('XF:User\UsernameChange', $usernameChange);
		$changeService->setModeratorRejection($notify, $reason);
		$changeService->save();
	}

	protected function validateUsernameChangeForAction(\XF\Entity\UsernameChange $usernameChange)
	{
		if ($usernameChange->change_state != 'moderated')
		{
			return false;
		}

		$user = $usernameChange->User;
		if (!$user)
		{
			// no user so we need to just get rid of this change log
			$usernameChange->delete();
			return false;
		}

		return true;
	}
}