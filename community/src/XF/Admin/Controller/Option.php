<?php

namespace XF\Admin\Controller;

use XF\Entity\OptionGroup;
use XF\Mvc\FormAction;
use XF\Mvc\ParameterBag;
use XF\Util\Arr;

use XF\Util\File;

use function count, is_array;

class Option extends AbstractController
{
	protected function preDispatchController($action, ParameterBag $params)
	{
		$this->assertAdminPermission('option');
	}

	public function actionIndex()
	{
		$optionRepo = $this->getOptionRepo();

		$viewParams = [
			'groups' => $optionRepo->findOptionGroupList()->fetch(),
			'canAdd' => $optionRepo->canAddOption()
		];
		return $this->view('XF:Option\GroupList', 'option_group_list', $viewParams);
	}

	public function actionMenu()
	{
		$optionRepo = $this->getOptionRepo();

		$viewParams = [
			'groups' => $optionRepo->findOptionGroupList()->fetch()
		];
		return $this->view('XF:Option\GroupMenu', 'option_group_menu', $viewParams);
	}

	public function actionGroup(ParameterBag $params)
	{
		$group = $this->assertGroupExists($params['group_id']);

		if ($group->AddOn && !$group->AddOn->active)
		{
			return $this->error(\XF::phrase('option_group_belongs_to_disabled_addon', [
				'addon' => $group->AddOn->title,
				'link' => $this->buildLink('add-ons')
			]));
		}

		$optionRepo = $this->getOptionRepo();

		$viewParams = [
			'group' => $group,
			'groups' => $optionRepo->findOptionGroupList()->fetch(),
			'canAdd' => $optionRepo->canAddOption()
		];
		return $this->view('XF:Option\Listing', 'option_list', $viewParams);
	}

	public function actionUpdate()
	{
		$this->assertPostOnly();

		$input = $this->filter([
			'options_listed' => 'array-str',
			'options' => 'array'
		]);

		$options = [];
		foreach ($input['options_listed'] AS $optionId)
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

		return $this->redirect($this->getDynamicRedirect());
	}

	protected function groupAddEdit(OptionGroup $group)
	{
		$viewParams = [
			'group' => $group
		];

		return $this->view('XF:Option\GroupEdit', 'option_group_edit', $viewParams);
	}

	public function actionGroupAdd()
	{
		if (!$this->getOptionRepo()->canAddOption())
		{
			return $this->noPermission();
		}

		$group = $this->em()->create('XF:OptionGroup');
		return $this->groupAddEdit($group);
	}

	public function actionGroupEdit(ParameterBag $params)
	{
		$group = $this->assertGroupExists($params['group_id'], ['MasterTitle', 'MasterDescription']);
		if (!$group->canEdit())
		{
			return $this->noPermission();
		}

		return $this->groupAddEdit($group);
	}

	protected function groupSaveProcess(OptionGroup $group)
	{
		$entityInput = $this->filter([
			'group_id' => 'str',
			'icon' => 'str',
			'display_order' => 'uint',
			'debug_only' => 'bool',
			'advanced' => 'bool',
			'addon_id' => 'str'
		]);

		$form = $this->formAction();
		$form->basicEntitySave($group, $entityInput);

		$phraseInput = $this->filter([
			'title' => 'str',
			'description' => 'str'
		]);
		$form->validate(function(FormAction $form) use ($phraseInput)
		{
			if ($phraseInput['title'] === '')
			{
				$form->logError(\XF::phrase('please_enter_valid_title'), 'title');
			}
		});
		$form->apply(function() use ($phraseInput, $group)
		{
			$title = $group->getMasterPhrase(true);
			$title->phrase_text = $phraseInput['title'];
			$title->save();

			$description = $group->getMasterPhrase(false);
			$description->phrase_text = $phraseInput['description'];
			$description->save();
		});

		return $form;
	}

	public function actionGroupSave(ParameterBag $params)
	{
		$this->assertPostOnly();

		if ($params['group_id'])
		{
			$group = $this->assertGroupExists($params['group_id']);
			if (!$group->canEdit())
			{
				return $this->noPermission();
			}
		}
		else
		{
			if (!$this->getOptionRepo()->canAddOption())
			{
				return $this->noPermission();
			}

			$group = $this->em()->create('XF:OptionGroup');
		}

		$form = $this->groupSaveProcess($group);
		$form->run();

		return $this->redirect($this->buildLink('options/groups', $group) . $this->buildLinkHash($group->group_id));
	}

	public function actionGroupDelete(ParameterBag $params)
	{
		$group = $this->assertGroupExists($params['group_id']);
		if (!$group->canEdit())
		{
			return $this->noPermission();
		}

		/** @var \XF\ControllerPlugin\Delete $plugin */
		$plugin = $this->plugin('XF:Delete');
		return $plugin->actionDelete(
			$group,
			$this->buildLink('options/groups/delete', $group),
			$this->buildLink('options/groups/edit', $group),
			$this->buildLink('options'),
			$group->title
		);
	}

	protected function optionAddEdit(\XF\Entity\Option $option, $baseRelations = [])
	{
		$relations = $baseRelations;
		$group = null;
		if ($option->exists() && $option->Relations)
		{
			foreach ($option->Relations AS $relation)
			{
				$relations[$relation->group_id] = $relation->display_order;
			}
			$groupId = $this->filter('group_id', 'str');
			if (isset($option->Relations[$groupId]))
			{
				$group = $option->Relations[$groupId]->OptionGroup;
			}
			else
			{
				$group = $option->Relations->first()->OptionGroup;
			}
		}

		$optionRepo = $this->getOptionRepo();

		$viewParams = [
			'option' => $option,
			'group' => $group,
			'groups' => $optionRepo->findAllGroups()->fetch(),
			'relations' => $relations,
			'redirect' => $this->app->getDynamicRedirect()
		];

		return $this->view('XF:Option\Edit', 'option_edit', $viewParams);
	}

	public function actionAdd()
	{
		if (!$this->getOptionRepo()->canAddOption())
		{
			return $this->noPermission();
		}

		$option = $this->em()->create('XF:Option');

		$baseRelations = [];
		$groupId = $this->filter('group_id', 'str');
		if ($groupId)
		{
			$baseRelations[$groupId] = 1;
		}

		return $this->optionAddEdit($option, $baseRelations);
	}

	public function actionEdit(ParameterBag $params)
	{
		$option = $this->assertOptionExists($params['option_id']);
		if (!$option->canEdit())
		{
			return $this->noPermission();
		}

		return $this->optionAddEdit($option);
	}

	protected function optionSaveProcess(\XF\Entity\Option $option)
	{
		$entityInput = $this->filter([
			'option_id' => 'str',
			'default_value' => 'str',
			'edit_format' => 'str',
			'edit_format_params' => 'str',
			'data_type' => 'str',
			'validation_class' => 'str',
			'validation_method' => 'str',
			'advanced' => 'bool',
			'addon_id' => 'str'
		]);
		$subOptions = Arr::stringToArray($this->filter('sub_options', 'str'),'/\r?\n/');

		$form = $this->formAction();

		$form->basicEntitySave($option, $entityInput)
			->setup(function() use ($option, $subOptions)
			{
				$option->sub_options = $subOptions;
			});

		$phraseInput = $this->filter([
			'title' => 'str',
			'explain' => 'str'
		]);
		$form->validate(function(FormAction $form) use ($phraseInput)
		{
			if ($phraseInput['title'] === '')
			{
				$form->logError(\XF::phrase('please_enter_valid_title'), 'title');
			}
		});
		$form->apply(function() use ($phraseInput, $option)
		{
			$title = $option->getMasterPhrase(true);
			$title->phrase_text = $phraseInput['title'];
			$title->save();

			$explain = $option->getMasterPhrase(false);
			$explain->phrase_text = $phraseInput['explain'];
			$explain->save();
		});

		$groups = $this->getOptionRepo()->findAllGroups()->fetch();
		$relationMap = [];

		foreach ($this->filter('relations', 'array') AS $groupId => $relation)
		{
			if (is_array($relation)
				&& !empty($relation['selected'])
				&& isset($relation['display_order'])
				&& isset($groups[$groupId])
			)
			{
				$relationMap[$groupId] = $this->app->inputFilterer()->filter($relation['display_order'], 'uint');
			}
		}

		$form->validate(function(FormAction $form) use ($option, $groups, $relationMap)
		{
			if (!count($relationMap))
			{
				$form->logError(\XF::phrase('this_option_must_belong_to_at_least_one_group'), 'relations');
			}
		});
		$form->apply(function() use ($option, $relationMap)
		{
			$option->updateRelations($relationMap);
		});

		return $form;
	}

	public function actionSave(ParameterBag $params)
	{
		$this->assertPostOnly();

		if ($params['option_id'])
		{
			$option = $this->assertOptionExists($params['option_id']);
			if (!$option->canEdit())
			{
				return $this->noPermission();
			}
		}
		else
		{
			if (!$this->getOptionRepo()->canAddOption())
			{
				return $this->noPermission();
			}

			$option = $this->em()->create('XF:Option');
		}

		$this->optionSaveProcess($option)->run();

		return $this->redirect(
			$this->getDynamicRedirect($this->buildLink('options'), false)
		);
	}

	public function actionDelete(ParameterBag $params)
	{
		$option = $this->assertOptionExists($params['option_id']);
		if (!$option->canEdit())
		{
			return $this->noPermission();
		}

		$returnUrl = $this->getDynamicRedirect(
			$this->buildLink('options'), false
		);
		$confirmUrl = $this->buildLink('options/delete', $option, [
			'_xfRedirect' => $returnUrl
		]);

		/** @var \XF\ControllerPlugin\Delete $plugin */
		$plugin = $this->plugin('XF:Delete');
		return $plugin->actionDelete(
			$option,
			$confirmUrl,
			$this->buildLink('options/edit', $option),
			$returnUrl,
			$option->title
		);
	}

	public function actionView(ParameterBag $params)
	{
		$option = $this->assertOptionExists($params['option_id']);
		$relation = $option->Relations->first();
		$group = $relation ? $relation->OptionGroup : null;

		return $this->redirect(
			$group ? $this->buildLink('options/groups', $group) . '#' . $option->option_id : $this->buildLink('options')
		);
	}

	public function actionEmailHandlerSetup(ParameterBag $params)
	{
		$option = $this->assertEmailHandlerOption($params->option_id);

		if ($this->isPost())
		{
			$newType = $this->filter('new_type', 'str');

			switch ($newType)
			{
				case 'pop3':
				case 'imap':
					$transports = stream_get_transports();
					$viewParams = [
						'option' => $option,
						'type' => $newType,
						'transports' => $transports
					];
					return $this->view('XF:Option\EmailHandlerServer', 'option_email_handler_server', $viewParams);

				case 'google':
					$viewParams = [
						'option' => $option,
						'redirectUri' => $this->buildLink('canonical:misc/email-oauth-setup')
					];
					return $this->view('XF:Option\EmailHandlerGoogle', 'option_email_handler_google', $viewParams);

				case 'microsoft':
					$viewParams = [
						'option' => $option,
						'redirectUri' => $this->buildLink('canonical:misc/email-oauth-setup')
					];
					return $this->view('XF:Option\EmailHandlerMicrosoft', 'option_email_handler_microsoft', $viewParams);

				case 'disabled':
					$optionValue = ['enabled' => false];
					$this->getOptionRepo()->updateOption($option->option_id, $optionValue);
					// break missing intentionally
				case 'unchanged':
				default:
					return $this->redirect($this->getDynamicRedirect());
			}
		}

		$viewParams = [
			'option' => $option
		];

		return $this->view('XF:Option\EmailHandlerSetup', 'option_email_handler_setup', $viewParams);
	}

	public function actionEmailHandlerServer(ParameterBag $params)
	{
		$this->assertPostOnly();

		$option = $this->assertEmailHandlerOption($params->option_id);

		$optionValue = $this->filter([
			'type' => 'str',
			'host' => 'str',
			'port' => 'uint',
			'username' => 'str',
			'password' => 'str',
			'encryption' => 'str'
		]);
		$optionValue['enabled'] = true;

		$this->getOptionRepo()->updateOption($option->option_id, $optionValue);

		return $this->redirect($this->getDynamicRedirect());
	}

	public function actionEmailHandlerOAuth(ParameterBag $params)
	{
		$option = $this->assertEmailHandlerOption($params->option_id);

		/** @var \XF\Admin\ControllerPlugin\EmailOAuth $oAuthPlugin */
		$oAuthPlugin = $this->plugin('XF:Admin:EmailOAuth');

		if ($this->isPost())
		{
			$input = $this->filter([
				'oauth_provider' => 'str',
				'username' => 'str',
				'client_id' => 'str',
				'client_secret' => 'str',
				'type' => 'str'
			]);

			switch ($input['oauth_provider'])
			{
				case 'google':
				default:
					$oAuthEmailSetup = $oAuthPlugin->getGoogleOAuthEmailSetupConfig(
						$input['client_id'],
						$input['client_secret'],
						$this->buildLink('canonical:options/email-handler-oauth', $option),
						[
							'username' => $input['username'],
							'type' => $input['type']
						]
					);
					break;

				case 'microsoft':
					$oAuthEmailSetup = $oAuthPlugin->getMicrosoftOAuthEmailSetupConfig(
						$input['client_id'],
						$input['client_secret'],
						$this->buildLink('canonical:options/email-handler-oauth', $option),
						[
							'username' => $input['username'],
							'type' => $input['type']
						]
					);
					break;
			}

			return $oAuthPlugin->actionTriggerOAuthRequest($oAuthEmailSetup);
		}

		$oAuthEmailSetup = $oAuthPlugin->assertOAuthEmailSetupData(true);

		$optionValue = array_merge($oAuthEmailSetup['input'], [
			'enabled' => true,
			'password' => $oAuthEmailSetup['tokenData']['token'],
			'oauth' => $oAuthPlugin->getOAuthEmailOptionData($oAuthEmailSetup)
		]);

		if (empty($optionValue['host']))
		{
			$defaultConnection = $oAuthPlugin->getDefaultProviderConnectionData(
				$oAuthEmailSetup['provider'],
				$optionValue['type']
			);
			if ($defaultConnection)
			{
				$optionValue['host'] = $defaultConnection['host'];
				$optionValue['port'] = $defaultConnection['port'];
				$optionValue['encryption'] = $defaultConnection['encryption'];
			}
		}

		if (empty($optionValue['username']) && !empty($oAuthEmailSetup['loginUserName']))
		{
			$optionValue['username'] = $oAuthEmailSetup['loginUserName'];
		}

		$this->getOptionRepo()->updateOption($option->option_id, $optionValue);

		return $this->redirect($this->buildLink('options/view', $option));
	}

	public function actionEmailTransportSetup(ParameterBag $params)
	{
		$option = $this->assertEmailTransportOption($params->option_id);

		if ($this->isPost())
		{
			$newType = $this->filter('new_type', 'str');

			switch ($newType)
			{
				case 'smtp':
					$transports = stream_get_transports();
					$viewParams = [
						'option' => $option,
						'type' => $newType,
						'transports' => $transports
					];
					return $this->view('XF:Option\EmailTransportServer', 'option_email_transport_server', $viewParams);

				case 'google':
					$viewParams = [
						'option' => $option,
						'redirectUri' => $this->buildLink('canonical:misc/email-oauth-setup')
					];
					return $this->view('XF:Option\EmailTransportGoogle', 'option_email_transport_google', $viewParams);

				case 'microsoft':
					$viewParams = [
						'option' => $option,
						'redirectUri' => $this->buildLink('canonical:misc/email-oauth-setup')
					];
					return $this->view('XF:Option\EmailTransportMicrosoft', 'option_email_transport_microsoft', $viewParams);

				case 'sendmail':
					$optionValue = ['emailTransport' => 'sendmail'];
					$this->getOptionRepo()->updateOption($option->option_id, $optionValue);
					// break missing intentionally
				case 'unchanged':
				default:
					return $this->redirect($this->getDynamicRedirect());
			}
		}

		$viewParams = [
			'option' => $option
		];

		return $this->view('XF:Option\EmailTransportSetup', 'option_email_transport_setup', $viewParams);
	}

	public function actionEmailTransportServer(ParameterBag $params)
	{
		$this->assertPostOnly();

		$option = $this->assertEmailTransportOption($params->option_id);

		$optionValue = $this->filter([
			'emailTransport' => 'str',
			'smtpHost' => 'str',
			'smtpPort' => 'uint',
			'smtpAuth' => 'str',
			'smtpLoginUsername' => 'str',
			'smtpLoginPassword' => 'str',
			'smtpEncrypt' => 'str'
		]);

		$this->getOptionRepo()->updateOption($option->option_id, $optionValue);

		return $this->redirect($this->getDynamicRedirect());
	}

	public function actionEmailTransportOAuth(ParameterBag $params)
	{
		$option = $this->assertEmailTransportOption($params->option_id);

		/** @var \XF\Admin\ControllerPlugin\EmailOAuth $oAuthPlugin */
		$oAuthPlugin = $this->plugin('XF:Admin:EmailOAuth');

		if ($this->isPost())
		{
			$input = $this->filter([
				'oauth_provider' => 'str',
				'smtpLoginUsername' => 'str',
				'client_id' => 'str',
				'client_secret' => 'str'
			]);

			switch ($input['oauth_provider'])
			{
				case 'google':
				default:
					$oAuthEmailSetup = $oAuthPlugin->getGoogleOAuthEmailSetupConfig(
						$input['client_id'],
						$input['client_secret'],
						$this->buildLink('canonical:options/email-transport-oauth', $option),
						[
							'smtpLoginUsername' => $input['smtpLoginUsername']
						]
					);
					break;

				case 'microsoft':
					$oAuthEmailSetup = $oAuthPlugin->getMicrosoftOAuthEmailSetupConfig(
						$input['client_id'],
						$input['client_secret'],
						$this->buildLink('canonical:options/email-transport-oauth', $option),
						[
							'smtpLoginUsername' => $input['smtpLoginUsername']
						]
					);
					break;
			}

			return $oAuthPlugin->actionTriggerOAuthRequest($oAuthEmailSetup);
		}

		$oAuthEmailSetup = $oAuthPlugin->assertOAuthEmailSetupData(true);

		$optionValue = array_merge($oAuthEmailSetup['input'], [
			'emailTransport' => 'smtp',
			'smtpAuth' => 'login',
			'smtpLoginPassword' => $oAuthEmailSetup['tokenData']['token'],
			'oauth' => $oAuthPlugin->getOAuthEmailOptionData($oAuthEmailSetup)
		]);

		if (empty($optionValue['smtpHost']))
		{
			$defaultConnection = $oAuthPlugin->getDefaultProviderConnectionData(
				$oAuthEmailSetup['provider'],
				$optionValue['emailTransport']
			);
			if ($defaultConnection)
			{
				$optionValue['smtpHost'] = $defaultConnection['host'];
				$optionValue['smtpPort'] = $defaultConnection['port'];
				$optionValue['smtpEncrypt'] = $defaultConnection['encryption'];
			}
		}

		if (empty($optionValue['smtpLoginUsername']) && !empty($oAuthEmailSetup['loginUserName']))
		{
			$optionValue['smtpLoginUsername'] = $oAuthEmailSetup['loginUserName'];
		}

		$this->getOptionRepo()->updateOption($option->option_id, $optionValue);

		return $this->redirect($this->buildLink('options/view', $option));
	}

	public function actionEmailDkimSetup(ParameterBag $params)
	{
		$option = $this->assertOptionExists($params->option_id);

		if ($this->isPost())
		{
			/** @var \XF\Repository\EmailDkim $emailDkimRepo */
			$emailDkimRepo = $this->repository('XF:EmailDkim');

			$existingKey = $option->option_value['privateKey'] ?? null;

			if ($existingKey)
			{
				File::deleteFromAbstractedPath(
					$emailDkimRepo->getAbstractedKeyPath($existingKey)
				);
			}

			$privateKeyFileName = $emailDkimRepo->generateAndSaveNewKey();

			$optionValue['privateKey'] = $privateKeyFileName;
			$optionValue['domain'] = $this->filter('domain', 'str');
			$optionValue['enabled'] = true;

			$this->getOptionRepo()->updateOption($option->option_id, $optionValue);

			$viewParams = [
				'option' => $option,
				'dnsKey' => $emailDkimRepo->getDnsRecordName(),
				'dnsValue' => $emailDkimRepo->getDnsRecordValueFromPrivateKey($privateKeyFileName)
			];

			return $this->view('XF:Option\EmailDkimConfirm', 'option_email_dkim_confirm', $viewParams);
		}

		$domain = substr(strrchr($this->options()->defaultEmailAddress, '@'), 1);

		$viewParams = [
			'option' => $option,
			'domain' => $domain
		];

		return $this->view('XF:Option\EmailDkimSetup', 'option_email_dkim_setup', $viewParams);
	}

	public function actionEmailDkimVerify(ParameterBag $params)
	{
		$this->assertPostOnly();

		$option = $this->assertOptionExists($params->option_id);

		/** @var \XF\Repository\EmailDkim $emailDkimRepo */
		$emailDkimRepo = $this->repository('XF:EmailDkim');

		$verified = $emailDkimRepo->verifyDnsRecordForDomain(
			$option->option_value['domain'],
			$option->option_value['privateKey']
		);

		if (!$verified)
		{
			$this->app()->jobManager()->enqueueUnique('dkimVerify', 'XF:VerifyEmailDkim', [], false);
		}

		$optionValue = $option->option_value;
		$optionValue['verified'] = $verified;

		$this->getOptionRepo()->updateOption($option->option_id, $optionValue);

		return $this->redirect($this->buildLink('options/view', $option));
	}

	public function actionEmailDkimDisable(ParameterBag $params)
	{
		$option = $this->assertOptionExists($params->option_id);

		$existingKey = $option->option_value['privateKey'] ?? null;

		if ($existingKey)
		{
			File::deleteFromAbstractedPath('internal-data://keys/' . $existingKey);
		}

		$optionValue = ['enabled' => false];
		$this->getOptionRepo()->updateOption($option->option_id, $optionValue);

		return $this->redirect($this->getDynamicRedirect());
	}

	protected function assertEmailHandlerOption($optionId)
	{
		$option = $this->assertOptionExists($optionId);

		if (
			$option->edit_format !== 'template'
			|| $option->edit_format_params !== 'option_template_advancedEmailHandler'
		)
		{
			throw $this->exception($this->noPermission());
		}

		return $option;
	}

	protected function assertEmailTransportOption($optionId)
	{
		$option = $this->assertOptionExists($optionId);

		if (
			$option->edit_format !== 'template'
			|| $option->edit_format_params !== 'option_template_advancedEmailTransport'
		)
		{
			throw $this->exception($this->noPermission());
		}

		return $option;
	}

	/**
	 * @param string $groupId
	 * @param array|string|null $with
	 * @param null|string $phraseKey
	 *
	 * @return OptionGroup
	 */
	protected function assertGroupExists($groupId, $with = null, $phraseKey = null)
	{
		return $this->assertRecordExists('XF:OptionGroup', $groupId, $with, $phraseKey);
	}

	/**
	 * @param string $optionId
	 * @param array|string|null $with
	 * @param null|string $phraseKey
	 *
	 * @return \XF\Entity\Option
	 */
	protected function assertOptionExists($optionId, $with = null, $phraseKey = null)
	{
		return $this->assertRecordExists('XF:Option', $optionId, $with, $phraseKey);
	}

	/**
	 * @return \XF\Repository\Option
	 */
	protected function getOptionRepo()
	{
		return $this->repository('XF:Option');
	}
}
