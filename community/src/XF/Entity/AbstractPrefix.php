<?php

namespace XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * Class AbstractPrefix
 *
 * @package XF\Entity
 *
 * COLUMNS
 * @property int|null                       prefix_id
 * @property int                            prefix_group_id
 * @property int                            display_order
 * @property int                            materialized_order
 * @property string                         css_class
 * @property array                          allowed_user_group_ids
 *
 * GETTERS
 * @property \XF\Phrase|string              title
 * @property \XF\Phrase|string              description
 * @property \XF\Phrase|string              usage_help
 * @property bool                           has_description
 * @property bool                           has_usage_help
 *
 * RELATIONS
 * @property \XF\Phrase                     MasterTitle
 * @property \XF\Phrase                     $MasterUsageHelp
 * @property \XF\Phrase                     MasterDescription
 * @property \XF\Entity\AbstractPrefixGroup PrefixGroup
 */
abstract class AbstractPrefix extends Entity
{
	const PHRASE_TYPE_TITLE = '_prefix.';
	const PHRASE_TYPE_DESCRIPTION = '_prefix_desc.';
	const PHRASE_TYPE_USAGE_HELP = '_prefix_help.';

	abstract protected function getClassIdentifier();

	protected static function getContentType()
	{
		throw new \LogicException('The phrase group must be overridden.');
	}

	public function isUsableByUser(\XF\Entity\User $user = null)
	{
		$user = $user ?: \XF::visitor();

		foreach ($this->allowed_user_group_ids AS $userGroupId)
		{
			if ($userGroupId == -1 || $user->isMemberOf($userGroupId))
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * @return string|\XF\Phrase
	 */
	public function getTitle()
	{
		return $this->getPhraseValueByType(self::PHRASE_TYPE_TITLE, false);
	}

	/**
	 * @return string|\XF\Phrase
	 */
	public function getDescription()
	{
		if (!$this->hasRelation('MasterDescription'))
		{
			return '';
		}

		return $this->getPhraseValueByType(self::PHRASE_TYPE_DESCRIPTION, true);
	}

	/**
	 * @return string|\XF\Phrase
	 */
	public function getUsageHelp()
	{
		if (!$this->hasRelation('MasterUsageHelp'))
		{
			return '';
		}

		return $this->getPhraseValueByType(self::PHRASE_TYPE_USAGE_HELP, true);
	}

	/**
	 * @return bool
	 */
	public function getHasUsageHelp(): bool
	{
		if (!$this->hasRelation('MasterUsageHelp'))
		{
			return false;
		}

		$help = (string)$this->usage_help;
		return (trim($help) !== '');
	}

	/**
	 * @return Phrase|null
	 */
	public function getMasterPhrase()
	{
		return $this->getMasterPhraseByType('MasterTitle', self::PHRASE_TYPE_TITLE);
	}

	/**
	 * @return Phrase|null
	 */
	public function getDescriptionMasterPhrase()
	{
		return $this->getMasterPhraseByType('MasterDescription', self::PHRASE_TYPE_DESCRIPTION);
	}

	/**
	 * @return Phrase|null
	 */
	public function getUsageHelpMasterPhrase()
	{
		return $this->getMasterPhraseByType('MasterUsageHelp', self::PHRASE_TYPE_USAGE_HELP);
	}

	/**
	 * @return string
	 */
	public function getPhraseName()
	{
		return $this->getPhraseNameByType(self::PHRASE_TYPE_TITLE);
	}

	/**
	 * @return string
	 */
	public function getDescriptionPhraseName()
	{
		if (!$this->hasRelation('MasterDescription'))
		{
			return '';
		}

		return $this->getPhraseNameByType(self::PHRASE_TYPE_DESCRIPTION);
	}

	/**
	 * @return string
	 */
	public function getUsageHelpPhraseName()
	{
		if (!$this->hasRelation('MasterUsageHelp'))
		{
			return '';
		}

		return $this->getPhraseNameByType(self::PHRASE_TYPE_USAGE_HELP);
	}

	/**
	 * @param string $phraseType
	 * @param bool $allowHtml
	 *
	 * @return string|\XF\Phrase
	 */
	protected function getPhraseValueByType(string $phraseType, bool $allowHtml)
	{
		if (!$this->prefix_id)
		{
			return '';
		}

		$phrase = \XF::phrase($this->getPhraseNameByType($phraseType), [], $allowHtml);
		$phrase->fallback('');

		return $phrase;
	}

	/**
	 * @param string $phraseType
	 *
	 * @return string
	 */
	protected function getPhraseNameByType(string $phraseType)
	{
		return $this->getContentType() . $phraseType . $this->prefix_id;
	}

	/**
	 * Gets the master phrase for a particular type. If that type isn't supported, returns null.
	 *
	 * @param string $relationName
	 * @param string $phraseType
	 *
	 * @return null|Phrase
	 */
	protected function getMasterPhraseByType(string $relationName, string $phraseType)
	{
		if (!$this->hasRelation($relationName))
		{
			return null;
		}

		$phrase = $this->getRelation($relationName);
		if (!$phrase)
		{
			$titleClosure = function() use ($phraseType)
			{
				return $this->getPhraseNameByType($phraseType);
			};

			$phrase = $this->_em->create('XF:Phrase');
			$phrase->title = $this->_getDeferredValue($titleClosure, 'save');
			$phrase->language_id = 0;
			$phrase->addon_id = '';
		}

		return $phrase;
	}

	protected function _postSave()
	{
		$this->rebuildPrefixCaches();
	}

	protected function _postDelete()
	{
		if ($this->MasterTitle)
		{
			$this->MasterTitle->delete();
		}

		if ($this->hasRelation('MasterUsageHelp') && $this->MasterUsageHelp)
		{
			$this->MasterUsageHelp->delete();
		}

		if ($this->hasRelation('MasterDescription') && $this->MasterDescription)
		{
			$this->MasterDescription->delete();
		}

		$this->rebuildPrefixCaches();
	}

	protected function rebuildPrefixCaches()
	{
		$repo = $this->getPrefixRepo();

		\XF::runOnce($this->getContentType() . 'PrefixCaches', function() use ($repo)
		{
			$repo->rebuildPrefixMaterializedOrder();
			$repo->rebuildPrefixCache();
		});
	}

	/**
	 * @param \XF\Api\Result\EntityResult $result
	 * @param int $verbosity
	 * @param array $options
	 *
	 * @api-out int $prefix_id
	 * @api-out str $title
	 * @api-out str $description
	 * @api-out str $usage_help
	 * @api-out bool $is_usable True if the acting user can use (select) this prefix.
	 * @api-out int $prefix_group_id
	 * @api-out int $display_order
	 * @api-out int $materialized_order Effective order, taking group ordering into account.
	 */
	protected function setupApiResultData(
		\XF\Api\Result\EntityResult $result, $verbosity = self::VERBOSITY_NORMAL, array $options = []
	)
	{
		$result->title = $this->title;

		if ($this->hasRelation('MasterDescription'))
		{
			$result->description = $this->description;
		}
		if ($this->hasRelation('MasterUsageHelp'))
		{
			$result->usage_help = $this->usage_help;
		}

		$result->is_usable = $this->isUsableByUser();
	}

	protected static function setupDefaultStructure(Structure $structure, $table, $shortName, array $options = [])
	{
		$options = array_replace([
			'has_description' => false,
			'has_usage_help' => false
		], $options);

		$structure->table = $table;
		$structure->shortName = $shortName;
		$structure->primaryKey = 'prefix_id';
		$structure->columns = [
			'prefix_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true, 'api' => true],
			'prefix_group_id' => ['type' => self::UINT, 'default' => 0, 'api' => true],
			'display_order' => ['type' => self::UINT, 'forced' => true, 'default' => 1, 'api' => true],
			'materialized_order' => ['type' => self::UINT, 'forced' => true, 'default' => 0, 'api' => true],
			'css_class' => ['type' => self::STR, 'maxLength' => 50, 'default' => 'label label--primary'],
			'allowed_user_group_ids' => ['type' => self::LIST_COMMA, 'default' => [-1]]
		];
		$structure->getters = [
			'title' => true,
			'has_usage_help' => true // this is always defined as there are some generic templates that check it
		];
		$structure->relations = [
			'MasterTitle' => [
				'entity' => 'XF:Phrase',
				'type' => self::TO_ONE,
				'conditions' => [
					['language_id', '=', 0],
					['title', '=', static::getContentType() . '_prefix.', '$prefix_id']
				]
			],
			'PrefixGroup' => [
				'entity' => $shortName . 'Group',
				'type' => self::TO_ONE,
				'conditions' => 'prefix_group_id',
				'primary' => true
			]
		];

		if ($options['has_description'])
		{
			$structure->getters['description'] = true;

			$structure->relations['MasterDescription'] = [
				'entity' => 'XF:Phrase',
				'type' => self::TO_ONE,
				'conditions' => [
					['language_id', '=', 0],
					['title', '=', static::getContentType() . self::PHRASE_TYPE_DESCRIPTION, '$prefix_id']
				]
			];
		}

		if ($options['has_usage_help'])
		{
			$structure->getters['usage_help'] = true;

			$structure->relations['MasterUsageHelp'] = [
				'entity' => 'XF:Phrase',
				'type' => self::TO_ONE,
				'conditions' => [
					['language_id', '=', 0],
					['title', '=', static::getContentType() . self::PHRASE_TYPE_USAGE_HELP, '$prefix_id']
				]
			];
		}
	}

	/**
	 * @return \XF\Repository\AbstractPrefix
	 */
	protected function getPrefixRepo()
	{
		return $this->repository($this->getClassIdentifier());
	}
}