<?php

namespace XF\Service\Thread\TypeData;

use XF\Entity\Thread;

class PollCreator extends \XF\Service\AbstractService implements SaverInterface
{
	use \XF\Service\ValidateAndSavableTrait;

	/**
	 * @var Thread
	 */
	protected $thread;

	/**
	 * @var \XF\Service\Poll\Creator
	 */
	protected $pollCreator;

	public function __construct(\XF\App $app, Thread $thread)
	{
		parent::__construct($app);
		$this->thread = $thread;
		$this->pollCreator = $this->service('XF:Poll\Creator', 'thread', $thread);
	}

	/**
	 * @return Thread
	 */
	public function getThread()
	{
		return $this->thread;
	}

	/**
	 * @return \XF\Service\Poll\Creator
	 */
	public function getPollCreator()
	{
		return $this->pollCreator;
	}

	protected function _validate()
	{
		if ($this->pollCreator->validate($errors))
		{
			return [];
		}
		else
		{
			return $errors;
		}
	}

	protected function _save()
	{
		return $this->pollCreator->save();
	}
}