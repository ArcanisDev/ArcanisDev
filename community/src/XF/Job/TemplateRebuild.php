<?php

namespace XF\Job;

class TemplateRebuild extends AbstractJob
{
	protected $defaultData = [
		'steps' => 0,
		'templateId' => 0,
		'batch' => 300,
		'mapped' => false,
		'skipCore' => false
	];

	public function run($maxRunTime)
	{
		$start = microtime(true);

		if (!$this->data['mapped'])
		{
			/** @var \XF\Service\Template\Rebuild $rebuildService */
			$rebuildService = $this->app->service('XF:Template\Rebuild');
			$rebuildService->rebuildFullTemplateMap();

			$this->data['mapped'] = true;
		}

		$this->data['steps']++;

		$db = $this->app->db();
		$em = $this->app->em();
		$app = \XF::app();

		if ($this->data['skipCore'])
		{
			$skipCoreSql = "AND (addon_id <> 'XF' OR style_id > 0)";
		}
		else
		{
			$skipCoreSql = '';
		}

		$templateIds = $db->fetchAllColumn($db->limit(
			"
				SELECT template_id
				FROM xf_template
				WHERE template_id > ?
					{$skipCoreSql}
				ORDER BY template_id
			", $this->data['batch']
		), $this->data['templateId']);
		if (!$templateIds)
		{
			/** @var \XF\Repository\Style $repo */
			$repo = $this->app->repository('XF:Style');
			$repo->updateAllStylesLastModifiedDateLater();

			return $this->complete();
		}

		/** @var \XF\Service\Template\Compile $compileService */
		$compileService = $app->service('XF:Template\Compile');

		$done = 0;

		foreach ($templateIds AS $templateId)
		{
			$this->data['templateId'] = $templateId;

			/** @var \XF\Entity\Template $template */
			$template = $em->find('XF:Template', $templateId);
			if (!$template)
			{
				continue;
			}

			$template->getBehavior('XF:DevOutputWritable')->setOption('write_dev_output', false);

			$needsSave = $template->reparseTemplate(true);
			if ($needsSave)
			{
				// this will recompile
				$template->save();
			}
			else
			{
				$compileService->recompile($template);
			}

			\XF::dequeueRunOnce('styleLastModifiedDate'); // we'll update this later

			$done++;

			if (microtime(true) - $start >= $maxRunTime)
			{
				break;
			}
		}

		// decache to reduce memory usage
		\XF::em()->clearEntityCache('XF:Template');
		\XF::em()->clearEntityCache('XF:TemplateModification');

		$this->data['batch'] = $this->calculateOptimalBatch($this->data['batch'], $done, $start, $maxRunTime, 300);

		return $this->resume();
	}

	public function getStatusMessage()
	{
		$actionPhrase = \XF::phrase('rebuilding');
		$typePhrase = \XF::phrase('templates');
		return sprintf('%s... %s %s', $actionPhrase, $typePhrase, str_repeat('. ', $this->data['steps']));
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