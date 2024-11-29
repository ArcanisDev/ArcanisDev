<?php

namespace XF\Api\Controller;

use XF\Mvc\ParameterBag;

/**
 * @api-group Alerts
 */
class Alerts extends AbstractController
{
	protected function preDispatchController($action, ParameterBag $params)
	{
		if (strtolower($action) == 'postmarkall')
		{
			$this->assertApiScope('alert:read');
		}
		else
		{
			$this->assertApiScopeByRequestMethod('alert');
		}

		if (strtolower($action) != 'post')
		{
			$this->assertRegisteredUser();
		}
	}

	/**
	 * @api-desc Gets the API user's list of alerts
	 *
	 * @api-in int $page
	 * @api-in int $cutoff Unix timestamp of oldest alert to include. Note that unread or unviewed alerts are always included.
	 * @api-in bool $unviewed If true, gets only unviewed alerts. Unviewed alerts have not been seen (in the standard UI).
	 * @api-in bool $unread If true, gets only unread alerts. Unread alerts may have been seen but the content they relate to has not been viewed.
	 *
	 * @api-out UserAlert[] $alerts
	 * @api-out pagination $pagination
	 */
	public function actionGet()
	{
		$page = $this->filterPage();
		$perPage = $this->options()->alertsPerPage;

		$alertsFinder = $this->setupAlertsFinder();
		$alerts = $alertsFinder->limitByPage($page, $perPage)->fetch();

		$totalAlerts = $alertsFinder->total();

		$this->assertValidApiPage($page, $perPage, $totalAlerts);

		$this->getAlertRepo()->addContentToAlerts($alerts);
		$alerts = $alerts->filterViewable();

		$alertResults = $alerts->toApiResults();

		$return = [
			'alerts' => $alertResults,
			'pagination' => $this->getPaginationData($alertResults, $page, $perPage, $totalAlerts)
		];
		return $this->apiResult($return);
	}

	/**
	 * @return \XF\Mvc\Entity\Finder
	 */
	protected function setupAlertsFinder()
	{
		$cutOff = $this->filter('cutoff', 'uint');

		$alertsFinder = $this->getAlertRepo()->findAlertsForUser(\XF::visitor()->user_id, $cutOff)
			->with('api');

		$unviewed = $this->filter('unviewed', 'bool');
		if ($unviewed)
		{
			$alertsFinder->where('view_date', 0);
		}

		$unread = $this->filter('unread', 'bool');
		if ($unread)
		{
			$alertsFinder->where('read_date', 0);
		}

		return $alertsFinder;
	}

	/**
	 * @api-desc Sends an alert to the specified user. Only available to super user keys.
	 *
	 * @api-in int $to_user_id <req> ID of the user to receive the alert
	 * @api-in str $alert <req> Text of the alert. May use the placeholder "{link}" to have the link automatically inserted.
	 * @api-in int $from_user_id If provided, the user to send the alert from. Otherwise, uses the current API user. May be 0 for an anonymous alert.
	 * @api-in str $link_url URL user will be taken to when the alert is clicked.
	 * @api-in str $link_title Text of the link URL that will be displayed. If no placeholder is present in the alert, will be automatically appended.
	 *
	 * @api-out true $success
	 */
	public function actionPost()
	{
		$this->assertSuperUserKey();
		$this->assertRequiredApiInput(['to_user_id', 'alert']);

		$input = $this->filter([
			'from_user_id' => '?uint',
			'to_user_id' => 'uint',
			'alert' => 'str',
			'link_url' => 'str',
			'link_title' => 'str'
		]);

		$toUser = $this->assertRecordExists('XF:User', $input['to_user_id']);

		if ($input['from_user_id'] !== null)
		{
			if (!$input['from_user_id'])
			{
				$fromUser = $this->repository('XF:User')->getGuestUser();
			}
			else
			{
				$fromUser = $this->assertRecordExists('XF:User', $input['from_user_id']);
			}
		}
		else
		{
			$fromUser = \XF::visitor();
		}

		$alert = $this->setupAlertFromInput($input);

		$this->getAlertRepo()->alert(
			$toUser,
			$fromUser->user_id, $fromUser->username,
			'user', $toUser->user_id,
			'from_admin', $alert
		);

		return $this->apiSuccess();
	}

	protected function setupAlertFromInput(array $input): array
	{
		$alertText = $input['alert'];

		if ($input['link_url'])
		{
			if (strpos($alertText, '{link}') === false)
			{
				$alertText .= ' {link}';
			}

			$link = '<a href="' . $input['link_url'] . '" class="fauxBlockLink-blockLink">'
				. ($input['link_title'] ? $input['link_title'] : $input['link_url'])
				. '</a>';
			$alertText = str_replace('{link}', $link, $alertText);
		}

		return [
			'alert_text' => $alertText,
			'link_url' => $input['link_url'],
			'link_title' => $input['link_title']
		];
	}

	/**
	 * @api-desc Marks all of the API user's alerts as read or viewed. Must specify "read" or "viewed" parameters.
	 *
	 * @api-in bool $read If specified, marks all alerts as read.
	 * @api-in bool $viewed If specified, marks all alerts as viewed. This will remove the alert counter but keep unactioned alerts highlighted.
	 *
	 * @api-out true $success
	 */
	public function actionPostMarkAll()
	{
		$visitor = \XF::visitor();

		if ($this->filter('viewed', 'bool'))
		{
			$this->getAlertRepo()->markUserAlertsViewed($visitor);
		}
		else if ($this->filter('read', 'bool'))
		{
			$this->getAlertRepo()->markUserAlertsRead($visitor);
		}
		else
		{
			$this->assertRequiredApiInput(['viewed', 'read']);
		}

		return $this->apiSuccess();
	}

	/**
	 * @return \XF\Repository\UserAlert
	 */
	protected function getAlertRepo()
	{
		return $this->repository('XF:UserAlert');
	}
}