<?php

namespace XF\Spam\Checker;

class PreRegAction extends AbstractProvider implements UserCheckerInterface
{
	protected function getType()
	{
		return 'PreRegAction';
	}

	public function check(\XF\Entity\User $user, array $extraParams = [])
	{
		if (empty($extraParams['preRegActionKey']))
		{
			$this->logDecision('allowed');
			return;
		}

		$action = $this->app->repository('XF:PreRegAction')->getActionByKey($extraParams['preRegActionKey']);
		if (!$action || !$action->Handler)
		{
			$this->logDecision('allowed');
			return;
		}

		$message = $action->Handler->getContentForSpamCheck($action);
		if (!$message)
		{
			$this->logDecision('allowed');
			return;
		}

		$checker = $this->app->spam()->contentChecker();
		$checker->check($user, $message);

		$decision = $checker->getFinalDecision();
		switch ($decision)
		{
			case 'moderated':
			case 'denied':
				$details = [];

				foreach ($checker->getDetails() AS $detail)
				{
					if (!empty($detail['phrase']))
					{
						$details[] = \XF::phrase($detail['phrase'], $detail['data'] ?? [])->render();
					}
				}

				$this->logDetail('pre_reg_action_content_matched_x', [
					'details' => implode(', ', $details)
				]);

				$this->logDecision('moderated');
				break;

			default:
				$this->logDecision('allowed');
		}
	}

	public function submit(\XF\Entity\User $user, array $extraParams = [])
	{
	}
}