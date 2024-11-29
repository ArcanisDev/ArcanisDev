<?php

namespace XF\PreRegAction;

use XF\Entity\PreRegAction;
use XF\Entity\User;
use XF\Mvc\Entity\Entity;

abstract class AbstractHandler
{
	protected $actionType;

	public function __construct($actionType)
	{
		$this->actionType = $actionType;
	}

	/**
	 * Returns the content type ID of the container this pre-reg action is attached to.
	 * For example, it might be a node ID for creating a new thread or a thread ID for replying to a thread.
	 *
	 * @return string
	 */
	abstract public function getContainerContentType(): string;

	/**
	 * Returns the default action data. This will be merged with any custom action data passed in.
	 *
	 * This ensures that expected keys in the action data are always present, to avoid situations where errors may
	 * occur if action execution code changes.
	 *
	 * @return array
	 */
	abstract public function getDefaultActionData(): array;

	/**
	 * Determines if the newly created user still has permission to take this action. This method is
	 * called with the new user set as the "visitor" already.
	 *
	 * @param PreRegAction $action
	 * @param Entity $containerContent
	 * @param User $newUser
	 *
	 * @return mixed
	 */
	abstract protected function canCompleteAction(
		PreRegAction $action,
		Entity $containerContent,
		User $newUser
	): bool;

	/**
	 * Triggers the relevant pre-reg action. This method is called with the new user set as the "visitor" already.
	 *
	 * If a falsy value is returned, this will be considered a failure and a failure alert will be sent.
	 *
	 * @param PreRegAction $action
	 * @param Entity $containerContent
	 * @param User $newUser
	 *
	 * @return null|Entity Null on failure, otherwise an entity that points to the created content. Will be passed to sendSuccessAlert
	 */
	abstract protected function executeAction(PreRegAction $action, Entity $containerContent, User $newUser);

	/**
	 * Sends an alert that the pre-reg action has been successfully processed.
	 *
	 * @param PreRegAction $action
	 * @param Entity $containerContent
	 * @param User $newUser
	 * @param Entity $executeContent The content returned from executeAction
	 */
	abstract protected function sendSuccessAlert(
		PreRegAction $action,
		Entity $containerContent,
		User $newUser,
		Entity $executeContent
	);

	public function saveAction(Entity $containerContent, $actionData): PreRegAction
	{
		if ($containerContent->getEntityContentType() !== $this->getContainerContentType())
		{
			throw new \InvalidArgumentException("Passed in container entity does not match the expected content type");
		}

		/** @var \XF\Entity\PreRegAction $action */
		$action = \XF::em()->create('XF:PreRegAction');
		$action->action_class = $this->actionType;
		$action->content_id = $containerContent->getEntityId();
		$action->action_data = $actionData;
		$action->ip_address = \XF\Util\Ip::convertIpStringToBinary(\XF::app()->request()->getIp());

		$this->setupActionEntity($containerContent, $action, $actionData);

		$action->save();

		return $action;
	}

	protected function setupActionEntity(Entity $containerContent, PreRegAction $action, $actionData)
	{
	}

	/**
	 * @param PreRegAction $action
	 * @param User         $newUser
	 *
	 * @return null|Entity
	 */
	public function completeAction(PreRegAction $action, User $newUser)
	{
		if (!$newUser->canCompletePreRegAction())
		{
			$action->delete();
			return null;
		}

		$containerContent = $this->getContainerContent($action->content_id);
		if ($containerContent)
		{
			$executeContent = \XF::asVisitor($newUser, function() use ($action, $containerContent, $newUser)
			{
				if (!$this->canCompleteAction($action, $containerContent, $newUser))
				{
					return null;
				}

				return $this->executeAction($action, $containerContent, $newUser);
			});
		}
		else
		{
			$executeContent = null;
		}

		if ($executeContent)
		{
			$this->sendSuccessAlert($action, $containerContent, $newUser, $executeContent);
		}
		else
		{
			$this->sendFailureAlert($action, $newUser);
		}

		$action->delete();

		return $executeContent;
	}

	protected function sendFailureAlert(PreRegAction $action, User $newUser)
	{
		/** @var \XF\Repository\UserAlert $alertRepo */
		$alertRepo = \XF::repository('XF:UserAlert');

		$alertRepo->alertFromUser(
			$newUser, null,
			'user', $newUser->user_id,
			'pre_reg_failed',
			['welcome' => $action->isForNewUser()]
		);
	}

	public function getContainerEntityWith()
	{
		return [];
	}

	public function getContainerContent($id)
	{
		return \XF::app()->findByContentType($this->getContainerContentType(), $id, $this->getContainerEntityWith());
	}

	public function getActionType()
	{
		return $this->actionType;
	}

	public function renderApprovalQueueInfo(PreRegAction $preRegAction)
	{
		$containerContent = $preRegAction->ContainerContent;
		if (!$containerContent)
		{
			return '';
		}

		$data = $this->getStructuredContentData($preRegAction, $containerContent);
		if (!$data)
		{
			return '';
		}

		$data = array_replace([
			'title' => null,
			'title_link' => null,
			'content_title' => null,
			'text' => null,
			'bb_code' => null
		], $data);

		$templateParams = [
			'preRegAction' => $preRegAction,
			'containerContent' => $containerContent,
			'details' => $data
		];
		return \XF::app()->templater()->renderTemplate($this->getApprovalQueueTemplate(), $templateParams);
	}

	public function getContentForSpamCheck(PreRegAction $preRegAction): string
	{
		$containerContent = $preRegAction->ContainerContent;
		if (!$containerContent)
		{
			return '';
		}

		$data = $this->getStructuredContentData($preRegAction, $containerContent);
		if (!$data)
		{
			return '';
		}

		$data = array_replace([
			'content_title' => null,
			'text' => null,
			'bb_code' => null
		], $data);

		if ($data['content_title'])
		{
			$content = $data['content_title'] . "\n\n";
		}
		else
		{
			$content = '';
		}

		if ($data['text'])
		{
			$content .= $data['text'] . "\n\n";
		}
		if ($data['bb_code'])
		{
			$content .= $data['bb_code'] . "\n\n";
		}

		return trim($content);
	}

	protected function isFlooding($checkAction, User $newUser, $floodingLimit = null): bool
	{
		if ($newUser->hasPermission('general', 'bypassFloodCheck'))
		{
			return false;
		}

		/** @var \XF\Service\FloodCheck $floodChecker */
		$floodChecker = \XF::service('XF:FloodCheck');
		$timeRemaining = $floodChecker->checkFlooding($checkAction, $newUser->user_id, $floodingLimit);
		if ($timeRemaining)
		{
			return true;
		}

		return false;
	}

	protected function getStructuredContentData(PreRegAction $preRegAction, Entity $containerContent): array
	{
		return [];
	}

	protected function getApprovalQueueTemplate(): string
	{
		return 'public:pre_reg_action_approval_queue';
	}
}