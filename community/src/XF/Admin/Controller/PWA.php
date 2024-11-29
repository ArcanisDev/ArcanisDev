<?php

namespace XF\Admin\Controller;

use XF\Entity\Language;
use XF\Entity\OptionGroup;
use XF\Entity\Style;
use XF\Mvc\FormAction;
use XF\Mvc\Reply\AbstractReply;

class PWA extends AbstractController
{
	public function actionIndex(): AbstractReply
	{
		$this->assertPWASetupPermissions();

		$pwaRepo = $this->getPWARepo();
		$isInstallable = $pwaRepo->isInstallable();

		$optionGroup = $this->em()->find('XF:OptionGroup', 'pwa');

		$options = $this->options();

		$language = $this->em()->find('XF:Language', $options->defaultLanguageId);
		$languageLocales = $this->data('XF:Language')->getLocaleList();

		$style = $this->em()->find('XF:Style', $options->defaultStyleId);
		$stylePropertyMaps = $pwaRepo->getApplicableStylePropertyMaps($style);
		$styleColorData = $this->getStylePropertyRepo()->getStyleColorData($style);

		if ($this->isPost())
		{
			$this->setupSaveProcess($optionGroup, $language, $style)->run();
			return $this->redirect($this->buildLink('pwa'));
		}

		$viewParams = [
			'isInstallable' => $isInstallable,

			'optionGroup' => $optionGroup,

			'language' => $language,
			'languageLocales' => $languageLocales,

			'style' => $style,
			'stylePropertyMaps' => $stylePropertyMaps,
			'styleColorData' => $styleColorData
		];
		return $this->view(
			'XF:PWA\Setup',
			'pwa_setup',
			$viewParams
		);
	}

	protected function setupSaveProcess(
		OptionGroup $optionGroup,
		Language $language,
		Style $style
	): FormAction
	{
		$form = $this->formAction();

		$input = $this->filter([
			'options' => 'array',

			'language' => [
				'language_code' => 'str',
				'text_direction' => 'str'
			],

			'properties' => 'array',
			'properties_listed' => 'array-str'
		]);

		$form->apply(function() use ($optionGroup, $input)
		{
			$options = [];

			$optionsListed = $optionGroup->Options->pluckNamed('option_id');
			foreach ($optionsListed AS $optionId)
			{
				if (!isset($input['options'][$optionId]))
				{
					$options[$optionId] = false;
				}
				else
				{
					$options[$optionId] = $input['options'][$optionId];
				}
			}

			$this->getOptionRepo()->updateOptions($options);
		});

		$form->basicEntitySave($language, $input['language']);

		$form->apply(function() use ($style, $input)
		{
			$properties = [];

			$stylePropertiesListed = $this->getPWARepo()->getApplicableStylePropertyNames();
			foreach ($stylePropertiesListed AS $propertyName)
			{
				if (!isset($input['properties'][$propertyName]))
				{
					$properties[$propertyName] = null;
				}
				else
				{
					$properties[$propertyName] = $input['properties'][$propertyName];
				}
			}

			$this->getStylePropertyRepo()->updatePropertyValues($style, $properties);
		});

		return $form;
	}

	protected function assertPWASetupPermissions()
	{
		$visitor = \XF::visitor();

		if (
			!$visitor->hasAdminPermission('option') ||
			!$visitor->hasAdminPermission('language') ||
			!$visitor->hasAdminPermission('style')
		)
		{
			throw $this->exception($this->noPermission(
				\XF::phrase('you_must_have_permission_to_manage_options_languages_and_styles_to_view')
			));
		}
	}

	protected function getPWARepo(): \XF\Repository\PWA
	{
		return $this->repository('XF:PWA');
	}

	protected function getOptionRepo(): \XF\Repository\Option
	{
		return $this->repository('XF:Option');
	}

	protected function getStylePropertyRepo(): \XF\Repository\StyleProperty
	{
		return $this->repository('XF:StyleProperty');
	}
}
