<?php

namespace XF\Service\User;

use XF\Service\AbstractService;

class RegistrationComplete extends AbstractService
{
	/**
	 * @var \XF\Entity\User
	 */
	protected $user;

	/**
	 * @var \XF\Mvc\Entity\Entity|null
	 */
	protected $preRegContent;

	public function __construct(\XF\App $app, \XF\Entity\User $user)
	{
		parent::__construct($app);

		$this->user = $user;
	}

	public function triggerCompletionActions()
	{
		/** @var \XF\Service\User\Welcome $userWelcome */
		$userWelcome = $this->service('XF:User\Welcome', $this->user);
		$userWelcome->send();

		$this->repository('XF:PreRegAction')->completeUserAction($this->user, $preRegContent);
		$this->preRegContent = $preRegContent;
	}

	/**
	 * @return \XF\Mvc\Entity\Entity|null
	 */
	public function getPreRegContent()
	{
		return $this->preRegContent;
	}
}