<?php

namespace XF\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\AbstractReply;

class ServiceWorker extends AbstractController
{
	/**
	 * @return \XF\Mvc\Reply\AbstractReply
	 */
	public function actionCache()
	{
		$viewParams = [
			'files' => $this->getCacheFiles()
		];
		$view = $this->view(
			'XF:ServiceWorker\Cache',
			'',
			$viewParams
		);
		$view->setViewOption('skipDefaultJsonParams', true);
		return $view;
	}

	/**
	 * @return string[]
	 */
	protected function getCacheFiles()
	{
		return [];
	}

	/**
	 * @return \XF\Mvc\Reply\AbstractReply
	 */
	public function actionOffline()
	{
		$viewParams = [
			'cssTemplates' => $this->getOfflineCssTemplates()
		];
		return $this->view(
			'XF:ServiceWorker\Offline',
			'service_worker_offline',
			$viewParams
		);
	}

	public function getOfflineCssTemplates()
	{
		return ['public:offline.less'];
	}

	/**
	 * @param string $action
	 */
	public function checkCsrfIfNeeded($action, ParameterBag $params)
	{
		if (strtolower($action) == 'cache')
		{
			return;
		}

		parent::checkCsrfIfNeeded($action, $params);
	}

	public function updateSessionActivity($action, ParameterBag $params, AbstractReply &$reply) {}

	public function assertCorrectVersion($action) {}
	public function assertIpNotBanned() {}
	public function assertNotBanned() {}
	public function assertNotRejected($action) {}
	public function assertNotDisabled($action) {}
	public function assertViewingPermissions($action) {}
	public function assertBoardActive($action) {}
	public function assertTfaRequirement($action) {}
	public function assertNotSecurityLocked($action) {}
	public function assertPolicyAcceptance($action) {}
}