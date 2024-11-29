<?php

namespace XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int $thread_id
 * @property int $solution_post_id
 * @property int $solution_user_id
 *
 * RELATIONS
 * @property \XF\Entity\Thread $Thread
 * @property \XF\Entity\Post $Solution
 * @property \XF\Entity\User $User
 */
class ThreadQuestion extends Entity
{
	public function threadHidden()
	{
		// thread will be hidden by this time, so need to ignore state
		$this->adjustUserSolutionCountIfNeeded(-1, $this->solution_user_id, false);
	}

	public function threadMadeVisible()
	{
		// we know the thread is visible (and wasn't before), so no need to check state
		$this->adjustUserSolutionCountIfNeeded(1, $this->solution_user_id, false);
	}

	protected function adjustUserSolutionCountIfNeeded($amount, $userId, $checkThreadState = true)
	{
		if (!$userId)
		{
			return;
		}

		if ($checkThreadState)
		{
			$thread = $this->Thread;
			if (!$thread || !$thread->isVisible() || empty($thread->Forum->count_messages))
			{
				return;
			}
		}

		$this->db()->query("
			UPDATE xf_user
			SET question_solution_count = GREATEST(0, CAST(question_solution_count AS SIGNED) + ?)
			WHERE user_id = ?
		", [$amount, $userId]);
	}

	protected function _preSave()
	{
		if ($this->isChanged('solution_post_id') && $this->solution_post_id)
		{
			$solution = $this->Solution;
			if (!$solution || $solution->thread_id != $this->thread_id)
			{
				throw new \LogicException("Solution must be part of this thread");
			}
		}
	}

	protected function _postSave()
	{
		if ($this->isInsert() && $this->solution_post_id && $this->solution_user_id)
		{
			$this->adjustUserSolutionCountIfNeeded(1, $this->solution_user_id);
		}
		else if ($this->isUpdate() && $this->isChanged('solution_post_id'))
		{
			if ($this->getExistingValue('solution_post_id'))
			{
				$this->adjustUserSolutionCountIfNeeded(-1, $this->getExistingValue('solution_user_id'));
			}
			if ($this->solution_post_id)
			{
				$this->adjustUserSolutionCountIfNeeded(1, $this->solution_user_id);
			}
		}
	}

	protected function _postDelete()
	{
		$this->adjustUserSolutionCountIfNeeded(-1, $this->solution_user_id);
	}

	public static function getStructure(Structure $structure)
	{
		$structure->table = 'xf_thread_question';
		$structure->shortName = 'XF:ThreadQuestion';
		$structure->primaryKey = 'thread_id';
		$structure->columns = [
			'thread_id' => ['type' => self::UINT, 'required' => true],
			'solution_post_id' => ['type' => self::UINT, 'default' => 0],
			'solution_user_id' => ['type' => self::UINT, 'default' => 0],
		];
		$structure->getters = [];
		$structure->relations = [
			'Thread' => [
				'entity' => 'XF:Thread',
				'type' => self::TO_ONE,
				'conditions' => 'thread_id',
				'primary' => true
			],
			'Solution' => [
				'entity' => 'XF:Post',
				'type' => self::TO_ONE,
				'conditions' => [
					['post_id', '=', '$solution_post_id']
				],
				'primary' => true
			],
			'User' => [
				'entity' => 'XF:User',
				'type' => self::TO_ONE,
				'conditions' => [
					['user_id', '=', '$solution_user_id']
				],
				'primary' => true
			]
		];

		return $structure;
	}
}