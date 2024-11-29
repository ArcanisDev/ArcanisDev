<?php

namespace XF\Entity;

use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int|null $prefix_id
 * @property int $prefix_group_id
 * @property int $display_order
 * @property int $materialized_order
 * @property string $css_class
 * @property array $allowed_user_group_ids
 *
 * GETTERS
 * @property string|\XF\Phrase $title
 * @property bool $has_usage_help
 * @property string|\XF\Phrase $description
 * @property string|\XF\Phrase $usage_help
 *
 * RELATIONS
 * @property \XF\Entity\Phrase $MasterTitle
 * @property \XF\Entity\ThreadPrefixGroup $PrefixGroup
 * @property \XF\Entity\Phrase $MasterDescription
 * @property \XF\Entity\Phrase $MasterUsageHelp
 * @property \XF\Mvc\Entity\AbstractCollection|\XF\Entity\ForumPrefix[] $ForumPrefixes
 */
class ThreadPrefix extends AbstractPrefix
{
	protected function getClassIdentifier()
	{
		return 'XF:ThreadPrefix';
	}

	protected static function getContentType()
	{
		return 'thread';
	}

	protected function _postDelete()
	{
		parent::_postDelete();

		$this->repository('XF:ForumPrefix')->removePrefixAssociations($this);
	}

	public static function getStructure(Structure $structure)
	{
		self::setupDefaultStructure($structure, 'xf_thread_prefix', 'XF:ThreadPrefix', [
			'has_description' => true,
			'has_usage_help' => true
		]);

		$structure->relations['ForumPrefixes'] = [
			'entity' => 'XF:ForumPrefix',
			'type' => self::TO_MANY,
			'conditions' => 'prefix_id'
		];

		return $structure;
	}
}
