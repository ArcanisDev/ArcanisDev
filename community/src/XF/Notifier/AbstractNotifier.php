<?php

namespace XF\Notifier;

abstract class AbstractNotifier
{
	/**
	 * @var \XF\App
	 */
	protected $app;

	public function __construct(\XF\App $app)
	{
		$this->app = $app;
	}

	public function canNotify(\XF\Entity\User $user)
	{
		return true;
	}

	public function sendAlert(\XF\Entity\User $user)
	{
		return false;
	}

	public function sendEmail(\XF\Entity\User $user)
	{
		return false;
	}

	public function getDefaultNotifyData()
	{
		return [];
	}

	public function getUserData(array $userIds)
	{
		$users = \XF::em()->findByIds('XF:User', $userIds, $this->getUserWith());
		return $users->toArray();
	}

	protected function getUserWith()
	{
		// these will generally be used for alerts, ignore
		return ['Profile', 'Option'];
	}

	protected function basicAlert(
		\XF\Entity\User $receiver, $senderId, $senderName,
		$contentType, $contentId, $action, array $extra = [], array $options = []
	)
	{
		// generic alerts default to autoRead=true, but notification alerts normally relate to specific content
		// so we can default them to false
		if (!isset($options['autoRead']))
		{
			$options['autoRead'] = false;
		}

		$alertRepo = $this->app()->repository('XF:UserAlert');
		return $alertRepo->alert(
			$receiver,
			$senderId,
			$senderName,
			$contentType,
			$contentId,
			$action,
			$extra,
			$options
		);
	}

	protected function app()
	{
		return \XF::app();
	}
}