<?php

namespace XF\Api\Controller;

/**
 * @api-group Stats
 */
class Stats extends AbstractController
{
	/**
	 * @api-desc Gets site statistics and general activity information
	 *
	 * @api-out int $totals[threads]
	 * @api-out int $totals[messages]
	 * @api-out int $totals[users]
	 * @api-out int $latest_user[user_id]
	 * @api-out str $latest_user[username]
	 * @api-out int $latest_user[register_date]
	 * @api-out int $online[total]
	 * @api-out int $online[members]
	 * @api-out int $online[guests]
	 *
	 */
	public function actionGet()
	{
		$totals = $this->getStatTotals();
		$latestUser = $this->getLatestUser();
		$online = $this->getOnlineStats();

		return $this->apiResult([
			'totals' => $totals,
			'latest_user' => $latestUser,
			'online' => $online
		]);
	}

	protected function getStatTotals(): array
	{
		$forumStats = $this->app()->forumStatistics;

		return [
			'threads' => $forumStats['threads'] ?? 0,
			'messages' => $forumStats['messages'] ?? 0,
			'users' => $forumStats['users'] ?? 0,
		];
	}

	protected function getLatestUser(): array
	{
		$forumStats = $this->app()->forumStatistics;
		if (empty($forumStats['latestUser']))
		{
			return [
				'user_id' => 0,
				'username' => '',
				'register_date' => 0
			];
		}

		$latestUser = $forumStats['latestUser'];

		return [
			'user_id' => $latestUser['user_id'],
			'username' => $latestUser['username'],
			'register_date' => $latestUser['register_date']
		];
	}

	protected function getOnlineStats(): array
	{
		/** @var \XF\Repository\SessionActivity $activityRepo */
		$activityRepo = $this->repository('XF:SessionActivity');

		$counts = $activityRepo->getOnlineCounts();

		return [
			'total' => $counts['total'] ?? 0,
			'members' => $counts['members'] ?? 0,
			'guests' => $counts['guests'] ?? 0,
		];
	}
}