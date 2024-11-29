<?php

namespace XF\Behavior;

use XF\Mvc\Entity\Behavior;

class DevOutputWritable extends Behavior
{
	protected function getDefaultConfig()
	{
		return [
			'checkForUpdates' => null
		];
	}

	protected function getDefaultOptions()
	{
		return [
			'write_dev_output' => true
		];
	}

	protected function verifyConfig()
	{
		$checkForUpdates = $this->config['checkForUpdates'];
		if ($checkForUpdates !== null && !($checkForUpdates instanceof \Closure))
		{
			throw new \LogicException("Check_for_updates must be a closure if specified");
		}
	}

	public function postSave()
	{
		if (!$this->isDevOutputWritable())
		{
			return;
		}

		if (!$this->isDevOutputUpdateNeeded())
		{
			return;
		}

		$devOutput = \XF::app()->developmentOutput();
		$entity = $this->entity;

		if ($devOutput->hasNameChange($entity))
		{
			$devOutput->delete($entity, false);
		}

		$devOutput->export($entity);
	}

	protected function isDevOutputUpdateNeeded()
	{
		if ($this->entity->getNewValues())
		{
			return true;
		}

		/** @var \Closure|null $checkForUpdates */
		$checkForUpdates = $this->config['checkForUpdates'];
		if ($checkForUpdates && $checkForUpdates($this->entity))
		{
			return true;
		}

		return false;
	}

	public function postDelete()
	{
		if (!$this->isDevOutputWritable())
		{
			return;
		}

		\XF::app()->developmentOutput()->delete($this->entity);
	}

	public function isDevOutputWritable()
	{
		return (
			$this->options['write_dev_output']
			&& \XF::app()->developmentOutput()->isEnabled()
		);
	}
}