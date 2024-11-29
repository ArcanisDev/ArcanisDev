<?php

namespace XF\Job;

use function count;

class ForumChangeThreadTypes extends AbstractJob
{
	protected $defaultData = [
		'node_id' => null,
		'old_default_type' => null,

		'count' => 0,
		'last' => 0,
		'total' => null
	];

	public function run($maxRunTime)
	{
		$s = microtime(true);

		if (!$this->data['node_id'])
		{
			throw new \InvalidArgumentException('Cannot change forum thread types without a node_id.');
		}

		/** @var \XF\Entity\Forum $forum */
		$forum = $this->app->find('XF:Forum', $this->data['node_id']);
		if (!$forum)
		{
			return $this->complete();
		}

		$typeHandler = $forum->TypeHandler;
		$newDefaultType = $typeHandler->getDefaultThreadType($forum);

		$allowedThreadTypes = $typeHandler->getExtraAllowedThreadTypes($forum);
		$allowedThreadTypes[] = $newDefaultType;
		$allowedThreadTypes[] = 'redirect'; // redirects are always allowed, so never change them

		$threadFinder = $this->app->finder('XF:Thread')
			->where('node_id', $this->data['node_id'])
			->where('discussion_type', '<>', $allowedThreadTypes)
			->order('thread_id');

		if ($this->data['total'] === null)
		{
			$this->data['total'] = $threadFinder->total();
			if (!$this->data['total'])
			{
				return $this->complete();
			}
		}

		$threadFinder->where('thread_id', '>', $this->data['last']);

		$maxFetch = 1000;

		$threadIds = $threadFinder->pluckFrom('thread_id')->fetch($maxFetch)->toArray();
		if (!$threadIds)
		{
			return $this->complete();
		}

		$continue = count($threadIds) < $maxFetch ? false : true;

		foreach ($threadIds AS $threadId)
		{
			$this->data['count']++;
			$this->data['last'] = $threadId;

			$thread = $this->app->find('XF:Thread', $threadId);
			if (!$thread)
			{
				continue;
			}

			$thread->discussion_type = $newDefaultType;
			$thread->saveIfChanged();

			if ($maxRunTime && microtime(true) - $s > $maxRunTime)
			{
				$continue = true;
				break;
			}
		}

		return $continue ? $this->resume() : $this->complete();
	}

	public function getStatusMessage()
	{
		$actionPhrase = \XF::phrase('changing_thread_types');
		return sprintf('%s... (%s/%s)', $actionPhrase,
			\XF::language()->numberFormat($this->data['count']), \XF::language()->numberFormat($this->data['total'])
		);
	}

	public function canCancel()
	{
		return false;
	}

	public function canTriggerByChoice()
	{
		return false;
	}
}