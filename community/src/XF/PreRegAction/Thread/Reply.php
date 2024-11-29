<?php

namespace XF\PreRegAction\Thread;

use XF\PreRegAction\AbstractHandler;
use XF\Entity\PreRegAction;
use XF\Entity\User;
use XF\Mvc\Entity\Entity;

class Reply extends AbstractHandler
{
	public function getContainerContentType(): string
	{
		return 'thread';
	}

	public function getDefaultActionData(): array
	{
		return [
			'message' => ''
		];
	}

	protected function canCompleteAction(PreRegAction $action, Entity $containerContent, User $newUser): bool
	{
		/** @var \XF\Entity\Thread $containerContent */
		return $containerContent->canReply()
			&& !$this->isFlooding('post', $newUser);
	}

	protected function executeAction(PreRegAction $action, Entity $containerContent, User $newUser)
	{
		/** @var \XF\Entity\Thread $containerContent */

		$replier = $this->setupThreadReply($action, $containerContent);
		$replier->checkForSpam();

		if (!$replier->validate())
		{
			return null;
		}

		$post = $replier->save();

		\XF::repository('XF:ThreadWatch')->autoWatchThread($containerContent, $newUser, false);

		$replier->sendNotifications();

		return $post;
	}

	protected function setupThreadReply(
		PreRegAction $action,
		\XF\Entity\Thread $thread
	): \XF\Service\Thread\Replier
	{
		/** @var \XF\Service\Thread\Replier $replier */
		$replier = \XF::app()->service('XF:Thread\Replier', $thread);
		$replier->setMessage($action->action_data['message']);
		$replier->logIp($action->ip_address);

		return $replier;
	}

	protected function sendSuccessAlert(
		PreRegAction $action,
		Entity $containerContent,
		User $newUser,
		Entity $executeContent
	)
	{
		if (!($executeContent instanceof \XF\Entity\Post))
		{
			return;
		}

		/** @var \XF\Entity\Post $post */
		$post = $executeContent;

		/** @var \XF\Repository\UserAlert $alertRepo */
		$alertRepo = \XF::repository('XF:UserAlert');

		$alertRepo->alertFromUser(
			$newUser, null,
			'post', $post->post_id,
			'pre_reg',
			['welcome' => $action->isForNewUser()],
			['autoRead' => false]
		);
	}

	protected function getStructuredContentData(PreRegAction $preRegAction, Entity $containerContent): array
	{
		/** @var \XF\Entity\Thread $containerContent */

		return [
			'title' => \XF::phrase('post_in_thread_x', ['title' => $containerContent->title]),
			'title_link' => $containerContent->getContentUrl(),
			'bb_code' => $preRegAction->action_data['message']
		];
	}
}