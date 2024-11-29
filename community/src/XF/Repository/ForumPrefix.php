<?php

namespace XF\Repository;

class ForumPrefix extends AbstractPrefixMap
{
	protected function getMapEntityIdentifier()
	{
		return 'XF:ForumPrefix';
	}

	protected function getAssociationsForPrefix(\XF\Entity\AbstractPrefix $prefix)
	{
		return $prefix->getRelation('ForumPrefixes');
	}

	protected function updateAssociationCache(array $cache)
	{
		$nodeIds = array_keys($cache);
		$forums = $this->em->findByIds('XF:Forum', $nodeIds);

		foreach ($forums AS $forum)
		{
			/** @var \XF\Entity\Forum $forum */
			$forum->prefix_cache = $cache[$forum->node_id];
			$forum->saveIfChanged();
		}
	}
}