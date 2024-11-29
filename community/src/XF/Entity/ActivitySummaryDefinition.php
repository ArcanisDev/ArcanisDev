<?php

namespace XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property string $definition_id
 * @property string $definition_class
 * @property string $addon_id
 *
 * GETTERS
 * @property \XF\Phrase $title
 * @property \XF\Phrase $description
 *
 * RELATIONS
 * @property \XF\Entity\AddOn $AddOn
 * @property \XF\Entity\Phrase $MasterTitle
 * @property \XF\Entity\Phrase $MasterDescription
 */
class ActivitySummaryDefinition extends Entity
{
	public function isActive()
	{
		$addOn = $this->AddOn;
		return $addOn ? $addOn->active : false;
	}

	public function getTitlePhraseName()
	{
		return 'activity_summary_def.' . $this->definition_id;
	}

	public function getDescriptionPhraseName()
	{
		return 'activity_summary_def_desc.' . $this->definition_id;
	}

	/**
	 * @return \XF\Phrase
	 */
	public function getTitle()
	{
		return \XF::phrase($this->getTitlePhraseName());
	}

	/**
	 * @return \XF\Phrase
	 */
	public function getDescription()
	{
		return \XF::phrase($this->getDescriptionPhraseName());
	}

	public function getMasterTitlePhrase()
	{
		$phrase = $this->MasterTitle;
		if (!$phrase)
		{
			$phrase = $this->_em->create('XF:Phrase');
			$phrase->title = $this->_getDeferredValue(function() { return $this->getTitlePhraseName(); });
			$phrase->language_id = 0;
			$phrase->addon_id = $this->_getDeferredValue(function() { return $this->addon_id; });
		}

		return $phrase;
	}

	public function getMasterDescriptionPhrase()
	{
		$phrase = $this->MasterDescription;
		if (!$phrase)
		{
			$phrase = $this->_em->create('XF:Phrase');
			$phrase->title = $this->_getDeferredValue(function() { return $this->getDescriptionPhraseName(); });
			$phrase->language_id = 0;
			$phrase->addon_id = $this->_getDeferredValue(function() { return $this->addon_id; });
		}

		return $phrase;
	}

	protected function _preSave()
	{
		$definitionClass = \XF::stringToClass($this->definition_class, '%s\ActivitySummary\%s');
		if (!class_exists($definitionClass))
		{
			$this->error(\XF::phrase('invalid_class_x', ['class' => $definitionClass]), 'definition_class');
		}
	}

	protected function _postSave()
	{
		if ($this->isUpdate())
		{
			if ($this->isChanged('addon_id') || $this->isChanged('definition_id'))
			{
				$writeDevOutput = $this->getBehavior('XF:DevOutputWritable')->getOption('write_dev_output');

				/** @var Phrase $titlePhrase */
				$titlePhrase = $this->getExistingRelation('MasterTitle');
				if ($titlePhrase)
				{
					$titlePhrase->getBehavior('XF:DevOutputWritable')->setOption('write_dev_output', $writeDevOutput);

					$titlePhrase->addon_id = $this->addon_id;
					$titlePhrase->title = $this->getTitlePhraseName();
					$titlePhrase->save();
				}

				/** @var Phrase $descriptionPhrase */
				$descriptionPhrase = $this->getExistingRelation('MasterDescription');
				if ($descriptionPhrase)
				{
					$descriptionPhrase->getBehavior('XF:DevOutputWritable')->setOption('write_dev_output', $writeDevOutput);

					$descriptionPhrase->addon_id = $this->addon_id;
					$descriptionPhrase->title = $this->getDescriptionPhraseName();
					$descriptionPhrase->save();
				}
			}

			if ($this->isChanged('definition_id'))
			{
				$finder = $this->finder('XF:ActivitySummarySection')->where('definition_id', $this->getExistingValue('definition_id'));

				foreach ($finder->fetch() AS $activitySummary)
				{
					$activitySummary->definition_id = $this->definition_id;
					$activitySummary->save();
				}
			}
		}
	}

	protected function _postDelete()
	{
		$writeDevOutput = $this->getBehavior('XF:DevOutputWritable')->getOption('write_dev_output');

		$titlePhrase = $this->MasterTitle;
		if ($titlePhrase)
		{
			$titlePhrase->getBehavior('XF:DevOutputWritable')->setOption('write_dev_output', $writeDevOutput);

			$titlePhrase->delete();
		}
		$descriptionPhrase = $this->MasterDescription;
		if ($descriptionPhrase)
		{
			$descriptionPhrase->getBehavior('XF:DevOutputWritable')->setOption('write_dev_output', $writeDevOutput);

			$descriptionPhrase->delete();
		}

		$finder = $this->finder('XF:ActivitySummarySection')->where('definition_id', $this->definition_id);

		foreach ($finder->fetch() AS $activitySummary)
		{
			$activitySummary->delete();
		}
	}

	protected function _setupDefaults()
	{
		/** @var \XF\Repository\AddOn $addOnRepo */
		$addOnRepo = $this->_em->getRepository('XF:AddOn');
		$this->addon_id = $addOnRepo->getDefaultAddOnId();
	}

	public static function getStructure(Structure $structure)
	{
		$structure->table = 'xf_activity_summary_definition';
		$structure->shortName = 'XF:ActivitySummaryDefinition';
		$structure->primaryKey = 'definition_id';
		$structure->columns = [
			'definition_id' => ['type' => self::STR, 'maxLength' => 50, 'match' => 'alphanumeric', 'required' => true],
			'definition_class' => ['type' => self::STR, 'maxLength' => 100, 'required' => true],
			'addon_id' => ['type' => self::BINARY, 'maxLength' => 50, 'default' => '']
		];
		$structure->behaviors = [
			'XF:DevOutputWritable' => []
		];
		$structure->getters = [
			'title' => false,
			'description' => false
		];
		$structure->relations = [
			'AddOn' => [
				'entity' => 'XF:AddOn',
				'type' => self::TO_ONE,
				'conditions' => 'addon_id',
				'primary' => true
			],
			'MasterTitle' => [
				'entity' => 'XF:Phrase',
				'type' => self::TO_ONE,
				'conditions' => [
					['language_id', '=', 0],
					['title', '=', 'activity_summary_def.', '$definition_id']
				]
			],
			'MasterDescription' => [
				'entity' => 'XF:Phrase',
				'type' => self::TO_ONE,
				'conditions' => [
					['language_id', '=', 0],
					['title', '=', 'activity_summary_def_desc.', '$definition_id']
				]
			]
		];
		$structure->options = [];

		return $structure;
	}

	/**
	 * @return \XF\Repository\ActivitySummary
	 */
	protected function getActivitySummaryRepo()
	{
		return $this->repository('XF:ActivitySummary');
	}
}