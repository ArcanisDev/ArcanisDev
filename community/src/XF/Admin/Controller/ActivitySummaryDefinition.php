<?php

namespace XF\Admin\Controller;

use XF\Mvc\FormAction;
use XF\Mvc\ParameterBag;

class ActivitySummaryDefinition extends AbstractController
{
	/**
	 * @param $action
	 * @param ParameterBag $params
	 * @throws \XF\Mvc\Reply\Exception
	 */
	protected function preDispatchController($action, ParameterBag $params)
	{
		$this->assertDevelopmentMode();
	}

	public function actionIndex()
	{
		$activitySummaryRepo = $this->getActivitySummaryRepo();
		$definitionsFinder = $activitySummaryRepo->findActivitySummaryDefinitionsForList();

		$viewParams = [
			'definitions' => $definitionsFinder->fetch()
		];
		return $this->view('XF:ActivitySummary\Definition\Listing', 'activity_summary_definition_list', $viewParams);
	}

	protected function definitionAddEdit(\XF\Entity\ActivitySummaryDefinition $definition)
	{
		$viewParams = [
			'definition' => $definition
		];
		return $this->view('XF:ActivitySummary\Definition\Edit', 'activity_summary_definition_edit', $viewParams);
	}

	public function actionEdit(ParameterBag $params)
	{
		$definition = $this->assertDefinitionExists($params->definition_id);
		return $this->definitionAddEdit($definition);
	}

	public function actionAdd()
	{
		$definition = $this->em()->create('XF:ActivitySummaryDefinition');
		return $this->definitionAddEdit($definition);
	}

	protected function definitionSaveProcess(\XF\Entity\ActivitySummaryDefinition $definition)
	{
		$form = $this->formAction();

		$input = $this->filter([
			'definition_id' => 'str',
			'definition_class' => 'str',
			'addon_id' => 'str'
		]);

		$form->basicEntitySave($definition, $input);

		$extraInput = $this->filter([
			'title' => 'str',
			'description' => 'str'
		]);
		$form->validate(function(FormAction $form) use ($extraInput)
		{
			if ($extraInput['title'] === '')
			{
				$form->logError(\XF::phrase('please_enter_valid_title'), 'title');
			}
		});
		$form->apply(function(FormAction $form) use ($extraInput, $definition)
		{
			$title = $definition->getMasterTitlePhrase();
			$title->phrase_text = $extraInput['title'];
			$title->save();

			$description = $definition->getMasterDescriptionPhrase();
			$description->phrase_text = $extraInput['description'];
			$description->save();
		});

		return $form;
	}

	public function actionSave(ParameterBag $params)
	{
		if ($params->definition_id)
		{
			$definition = $this->assertDefinitionExists($params->definition_id);
		}
		else
		{
			$definition = $this->em()->create('XF:ActivitySummaryDefinition');
		}

		$this->definitionSaveProcess($definition)->run();

		return $this->redirect($this->buildLink('activity-summary/definitions') . $this->buildLinkHash($definition->definition_id));
	}

	public function actionDelete(ParameterBag $params)
	{
		$definition = $this->assertDefinitionExists($params->definition_id);

		/** @var \XF\ControllerPlugin\Delete $plugin */
		$plugin = $this->plugin('XF:Delete');
		return $plugin->actionDelete(
			$definition,
			$this->buildLink('activity-summary/definitions/delete', $definition),
			$this->buildLink('activity-summary/definitions/edit', $definition),
			$this->buildLink('activity-summary/definitions'),
			$definition->title
		);
	}

	/**
	 * @param string $id
	 * @param array|string|null $with
	 * @param null|string $phraseKey
	 *
	 * @return \XF\Entity\ActivitySummaryDefinition
	 */
	protected function assertDefinitionExists($id, $with = null, $phraseKey = null)
	{
		return $this->assertRecordExists('XF:ActivitySummaryDefinition', $id, $with, $phraseKey);
	}

	/**
	 * @return \XF\Repository\ActivitySummary
	 */
	protected function getActivitySummaryRepo()
	{
		return $this->repository('XF:ActivitySummary');
	}
}