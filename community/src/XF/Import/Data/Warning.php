<?php

namespace XF\Import\Data;

class Warning extends AbstractEmulatedData
{
	public function getImportType()
	{
		return 'warning';
	}

	public function getEntityShortName()
	{
		return 'XF:Warning';
	}

	protected function preSave($oldId)
	{
		$this->forceNotEmpty('title', $oldId);

		if (!$this->warning_definition_id)
		{
			$this->warning_definition_id = 0;
		}
	}

	protected function postSave($oldId, $newId)
	{
		/** @var \XF\Entity\Warning $warning */
		$warning = $this->em()->find('XF:Warning', $newId);
		if ($warning)
		{
			$content = $warning->Content;
			if ($content)
			{
				$warning->getHandler()->onWarning($content, $warning);
				$this->em()->detachEntity($content);
				$this->em()->detachEntity($warning);
			}
		}

		// note: warning points are recalculated automatically in the User rebuild job
	}
}