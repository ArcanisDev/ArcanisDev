<?php

namespace XF\Job;

class PermissionRebuild extends AbstractRebuildJob
{
	protected $defaultData = [
		'cleaned' => false
	];

	/**
	 * @param float $maxRunTime
	 */
	public function run($maxRunTime)
	{
		if (!$this->data['cleaned'])
		{
			/** @var \XF\Repository\PermissionCombination $combinationRepo */
			$combinationRepo = $this->app->repository('XF:PermissionCombination');
			$combinationRepo->deleteUnusedPermissionCombinations();

			$this->data['cleaned'] = true;
		}

		return parent::run($maxRunTime);
	}

	/**
	 * @param int $start
	 * @param int $batch
	 *
	 * @return int[]
	 */
	protected function getNextIds($start, $batch): array
	{
		$db = $this->app->db();

		$nextIds = $db->fetchAllColumn(
			$db->limit(
				'SELECT permission_combination_id
					FROM xf_permission_combination
					WHERE permission_combination_id > ?
					ORDER BY permission_combination_id',
				$batch
			),
			$start
		);
		if (!$nextIds)
		{
			// there are situations where we run this job but not with this unique key, so this is unnecessary
			$this->app->jobManager()->cancelUniqueJob('permissionRebuild');
		}

		return $nextIds;
	}

	/**
	 * @param int $id
	 */
	protected function rebuildById($id): void
	{
		/** @var \XF\Entity\PermissionCombination $combination */
		$combination = $this->app->find('XF:PermissionCombination', $id);
		if (!$combination)
		{
			return;
		}

		$this->app->permissionBuilder()->rebuildCombination($combination);
	}

	protected function getStatusType(): \XF\Phrase
	{
		return \XF::phrase('permissions');
	}

	/**
	 * @return bool
	 */
	public function canCancel()
	{
		return false;
	}

	/**
	 * @return bool
	 */
	public function canTriggerByChoice()
	{
		return false;
	}
}