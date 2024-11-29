<?php

namespace XF\Job;

class AddOnDeleteFiles extends AbstractJob
{
	protected $defaultData = [
		'addon_id' => null,
		'addon_files' => [],
	];

	public function run($maxRunTime)
	{
		$timer = new \XF\Timer($maxRunTime);

		if (empty($this->data['addon_files']))
		{
			\XF\Util\File::deleteDirectory(\XF::getAddOnDirectory() . \XF::$DS . $this->prepareAddOnIdForPath());
			return $this->complete();
		}

		foreach ($this->data['addon_files'] AS $key => $file)
		{
			if (is_dir($file))
			{
				continue;
			}

			@unlink(\XF::getRootDirectory() . \XF::$DS . $file);
			unset($this->data['addon_files'][$key]);

			if ($timer->limitExceeded())
			{
				break;
			}
		}

		return $this->resume();
	}

	protected function prepareAddOnIdForPath(): string
	{
		if (strpos($this->data['addon_id'], '/') !== false)
		{
			return str_replace('/', \XF::$DS, $this->data['addon_id']);
		}
		else
		{
			return $this->data['addon_id'];
		}
	}

	public function getStatusMessage()
	{
		return \XF::phrase('deleting_files_for_add_on', ['addOnId' => $this->data['addon_id']]);
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