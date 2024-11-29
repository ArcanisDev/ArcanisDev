<?php

namespace XF\AddOn\DataType;

use function array_slice;

class Phrase extends AbstractDataType
{
	public function getShortName()
	{
		return 'XF:Phrase';
	}

	public function getContainerTag()
	{
		return 'phrases';
	}

	public function getChildTag()
	{
		return 'phrase';
	}

	public function exportAddOnData($addOnId, \DOMElement $container)
	{
		$entries = $this->finder()
			->where('addon_id', $addOnId)
			->where('language_id', 0)
			->order('title')->fetch();
		foreach ($entries AS $entry)
		{
			$node = $container->ownerDocument->createElement($this->getChildTag());

			$this->exportMappedAttributes($node, $entry);
			if ($entry['global_cache'])
			{
				$node->setAttribute('global_cache', '1');
			}
			$this->exportCdata($node, $entry->phrase_text);

			$container->appendChild($node);
		}

		return $entries->count() ? true : false;
	}

	public function importAddOnData($addOnId, \SimpleXMLElement $container, $start = 0, $maxRunTime = 0)
	{
		$startTime = microtime(true);

		$entries = $this->getEntries($container, $start);
		if (!$entries)
		{
			return false;
		}

		$ids = $this->pluckXmlAttribute($entries, 'title');

		// This chucking approach has been taken due to a MariaDB performance regression with large
		// IN clauses (see #187523). However, this may have benefits on some slower servers as this
		// will reduce the number of times we attempt to instantiate phrase entities that won't be
		// processed in this run.
		$chunkSize = 200;
		$nextFetch = null;

		$i = 0;
		$last = 0;
		foreach ($entries AS $entry)
		{
			$originalI = $i;

			$id = $ids[$i++];

			if ($i <= $start)
			{
				continue;
			}

			if ($nextFetch === null || $originalI >= $nextFetch)
			{
				$slice = array_slice($ids, $originalI, $chunkSize);
				$nextFetch = $originalI + $chunkSize;

				$existing = $this->finder()
					->where('title', $slice)
					->where('language_id', 0)
					->keyedBy('title')
					->fetch();
			}

			$entity = $existing[$id] ?? $this->create();
			$entity->setOption('check_duplicate', false);
			$entity->getBehavior('XF:DevOutputWritable')->setOption('write_dev_output', false);

			$this->importMappedAttributes($entry, $entity);
			$entity->language_id = 0;
			$entity->global_cache = (int)$entry['global_cache'];
			$entity->phrase_text = $this->getCdataValue($entry);
			$entity->addon_id = $addOnId;
			$entity->save(true, false);

			\XF::dequeueRunOnce('styleLastModifiedDate');

			if ($this->resume($maxRunTime, $startTime))
			{
				$last = $i;
				break;
			}
		}

		return ($last ?: false);
	}

	public function deleteOrphanedAddOnData($addOnId, \SimpleXMLElement $container)
	{
		$this->deleteOrphanedSimple($addOnId, $container, 'title');
	}

	protected function getMappedAttributes()
	{
		return [
			'title',
			'version_id',
			'version_string'
		];
	}
}