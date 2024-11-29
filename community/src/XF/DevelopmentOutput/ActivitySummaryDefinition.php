<?php

namespace XF\DevelopmentOutput;

use XF\Mvc\Entity\Entity;
use XF\Util\Json;

class ActivitySummaryDefinition extends AbstractHandler
{
	protected function getTypeDir()
	{
		return 'activity_summary_definitions';
	}

	public function export(Entity $definition)
	{
		if (!$this->isRelevant($definition))
		{
			return true;
		}

		$fileName = $this->getFileName($definition);

		$keys = [
			'definition_class'
		];
		$json = $this->pullEntityKeys($definition, $keys);

		return $this->developmentOutput->writeFile($this->getTypeDir(), $definition->addon_id, $fileName, Json::jsonEncodePretty($json));
	}

	public function import($name, $addOnId, $contents, array $metadata, array $options = [])
	{
		$json = json_decode($contents, true);

		$definition = $this->getEntityForImport($name, $addOnId, $json, $options);

		$definition->bulkSetIgnore($json);
		$definition->definition_id = $name;
		$definition->addon_id = $addOnId;
		$definition->save();
		// this will update the metadata itself

		return $definition;
	}
}