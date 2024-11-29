<?php

namespace XF\PreRegAction\Thread;

use XF\PreRegAction\AbstractHandler;
use XF\Entity\PreRegAction;
use XF\Entity\User;
use XF\Mvc\Entity\Entity;

class Create extends AbstractHandler
{
	public function getContainerContentType(): string
	{
		return 'forum';
	}

	public function getDefaultActionData(): array
	{
		return [
			'title' => '',
			'message' => '',
			'prefix_id' => 0,
			'custom_fields' => [],
			'tags' => '', // string is correct
			'discussion_type' => '',
			'type_input' => []
		];
	}

	protected function canCompleteAction(PreRegAction $action, Entity $containerContent, User $newUser): bool
	{
		/** @var \XF\Entity\Forum $containerContent */
		return $containerContent->canCreateThread()
			&& !$this->isFlooding('thread', $newUser, \XF::options()->floodCheckLengthDiscussion ?: null);
	}

	protected function executeAction(PreRegAction $action, Entity $containerContent, User $newUser)
	{
		/** @var \XF\Entity\Forum $containerContent */

		$creator = $this->setupThreadCreate($action, $containerContent);
		$creator->checkForSpam();

		if (!$creator->validate())
		{
			return null;
		}

		$thread = $creator->save();

		\XF::repository('XF:ThreadWatch')->autoWatchThread($thread, $newUser, true);

		$creator->sendNotifications();

		return $thread;
	}

	protected function setupThreadCreate(
		PreRegAction $action,
		\XF\Entity\Forum $forum
	): \XF\Service\Thread\Creator
	{
		/** @var \XF\Service\Thread\Creator $creator */
		$creator = \XF::app()->service('XF:Thread\Creator', $forum);
		$creator->setContent($action->action_data['title'], $action->action_data['message']);
		$creator->setCustomFields($action->action_data['custom_fields']);

		$prefixId = $action->action_data['prefix_id'];
		if ($prefixId && $forum->isPrefixUsable($prefixId))
		{
			$creator->setPrefix($prefixId);
		}

		if ($forum->canEditTags())
		{
			$creator->setTags($action->action_data['tags']);
		}

		$creator->setDiscussionTypeAndDataForPreReg(
			$action->action_data['discussion_type'],
			$action->action_data['type_input']
		);

		$creator->logIp($action->ip_address);

		return $creator;
	}

	protected function sendSuccessAlert(
		PreRegAction $action,
		Entity $containerContent,
		User $newUser,
		Entity $executeContent
	)
	{
		if (!($executeContent instanceof \XF\Entity\Thread))
		{
			return;
		}

		/** @var \XF\Entity\Thread $thread */
		$thread = $executeContent;

		/** @var \XF\Repository\UserAlert $alertRepo */
		$alertRepo = \XF::repository('XF:UserAlert');

		$alertRepo->alertFromUser(
			$newUser, null,
			'post', $thread->first_post_id,
			'pre_reg',
			['welcome' => $action->isForNewUser()],
			['autoRead' => false]
		);
	}

	protected function getStructuredContentData(PreRegAction $preRegAction, Entity $containerContent): array
	{
		/** @var \XF\Entity\Forum $containerContent */

		return [
			'title' => \XF::phrase('thread_x_in_forum_y', [
				'threadTitle' => $preRegAction->action_data['title'],
				'forumTitle' => $containerContent->title
			]),
			'title_link' => $containerContent->getContentUrl(),
			'content_title' => $preRegAction->action_data['title'],
			'bb_code' => $preRegAction->action_data['message']
		];
	}
}