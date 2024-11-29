<?php

namespace XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int|null $section_id
 * @property string $definition_id
 * @property int $display_order
 * @property bool $show_value
 * @property array $options
 * @property bool $active
 *
 * GETTERS
 * @property \XF\Phrase|string $title
 * @property \XF\ActivitySummary\AbstractSection|null $handler
 *
 * RELATIONS
 * @property \XF\Entity\Phrase $MasterTitle
 * @property \XF\Entity\ActivitySummaryDefinition $ActivitySummaryDefinition
 */
class ActivitySummarySection extends Entity
{
	public function isActive()
	{
		$activitySummaryDefinition = $this->ActivitySummaryDefinition;
		return $activitySummaryDefinition ? $activitySummaryDefinition->isActive() : false;
	}

	public function renderOptions()
	{
		return $this->handler ? $this->handler->renderOptions() : '';
	}

	/**
	 * @return \XF\Phrase|string
	 */
	public function getTitle()
	{
		$sectionPhrase = \XF::phrase('activity_summary_section.' . $this->section_id);
		$value = $sectionPhrase->render('html', ['nameOnInvalid' => false]);
		if ($value !== '')
		{
			return $value;
		}

		$definition = $this->ActivitySummaryDefinition;
		$handler = $this->handler;
		if ($definition && $handler)
		{
			return $handler->getDefaultTitle($definition);
		}
		else
		{
			return '';
		}
	}

	public function getMasterPhrase()
	{
		$phrase = $this->MasterTitle;
		if (!$phrase)
		{
			$phrase = $this->_em->create('XF:Phrase');
			$phrase->title = $this->_getDeferredValue(function() { return 'activity_summary_section.' . $this->section_id; }, 'save');
			$phrase->language_id = 0;
			$phrase->addon_id = '';
		}

		return $phrase;
	}

	/**
	 * @return \XF\ActivitySummary\AbstractSection|null
	 */
	public function getHandler()
	{
		$activitySummaryDefinition = $this->ActivitySummaryDefinition;
		if (!$activitySummaryDefinition)
		{
			return null;
		}
		$class = \XF::stringToClass($activitySummaryDefinition->definition_class, '%s\ActivitySummary\%s');
		if (!class_exists($class))
		{
			return null;
		}
		$class = \XF::extendClass($class);
		
		return new $class($this->app(), $this);
	}

	protected function _postDelete()
	{
		if ($this->MasterTitle)
		{
			$this->MasterTitle->delete();
		}
	}

	public static function getStructure(Structure $structure)
	{
		$structure->table = 'xf_activity_summary_section';
		$structure->shortName = 'XF:ActivitySummarySection';
		$structure->primaryKey = 'section_id';
		$structure->columns = [
			'section_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true],
			'definition_id' => ['type' => self::STR, 'maxLength' => 50, 'match' => 'alphanumeric', 'required' => true],
			'display_order' => ['type' => self::UINT, 'default' => 0],
			'show_value' => ['type' => self::BOOL, 'default' => true],
			'options' => ['type' => self::JSON_ARRAY, 'default' => []],
			'active' => ['type' => self::BOOL, 'default' => true],
		];
		$structure->getters = [
			'title' => false,
			'handler' => true
		];
		$structure->relations = [
			'MasterTitle' => [
				'entity' => 'XF:Phrase',
				'type' => self::TO_ONE,
				'conditions' => [
					['language_id', '=', 0],
					['title', '=', 'activity_summary_section.', '$section_id']
				]
			],
			'ActivitySummaryDefinition' => [
				'entity' => 'XF:ActivitySummaryDefinition',
				'type' => self::TO_ONE,
				'conditions' => 'definition_id',
				'primary' => true
			]
		];
		$structure->defaultWith = ['ActivitySummaryDefinition'];

		return $structure;
	}
}