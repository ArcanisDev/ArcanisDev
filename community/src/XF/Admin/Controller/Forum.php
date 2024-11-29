<?php

namespace XF\Admin\Controller;

use XF\Mvc\FormAction;
use XF\Mvc\ParameterBag;

use function in_array;

class Forum extends AbstractNode
{
	protected function preDispatchController($action, ParameterBag $params)
	{
		switch (strtolower($action))
		{
			case 'index':
				break;

			default:
				parent::preDispatchController($action, $params);
		}
	}

	public function actionIndex()
	{
		$this->setSectionContext('forums');

		return $this->plugin('XF:AdminSection')->actionView('forums');
	}

	protected function getNodeTypeId()
	{
		return 'Forum';
	}

	protected function getDataParamName()
	{
		return 'forum';
	}

	protected function getTemplatePrefix()
	{
		return 'forum';
	}

	protected function getViewClassPrefix()
	{
		return 'XF:Forum';
	}

	protected function nodeAddEdit(\XF\Entity\Node $node)
	{
		$forumType = $this->getForumTypeHandlerForAddEdit($node);
		if (!$forumType)
		{
			if ($node->exists())
			{
				return $this->error(\XF::phrase('forum_type_handler_not_found'));
			}
			else
			{
				$params = [
					'node_type_id' => 'Forum',
					'parent_node_id' => $node->parent_node_id
				];
				return $this->redirect($this->buildLink('nodes/add', null, $params));
			}
		}

		if (!$node->exists() && !$forumType->canManuallyCreateForum())
		{
			return $this->error(\XF::phrase('forums_of_this_type_cannot_be_manually_created'));
		}

		$reply = parent::nodeAddEdit($node);

		if ($reply instanceof \XF\Mvc\Reply\View)
		{
			/** @var \XF\Repository\ThreadField $fieldRepo */
			$fieldRepo = $this->repository('XF:ThreadField');
			$availableFields = $fieldRepo->findFieldsForList()->fetch();

			/** @var \XF\Repository\ThreadPrefix $prefixRepo */
			$prefixRepo = $this->repository('XF:ThreadPrefix');
			$availablePrefixes = $prefixRepo->findPrefixesForList()->fetch()->pluckNamed('title', 'prefix_id');
			$prefixListData = $prefixRepo->getPrefixListData();

			/** @var \XF\Repository\ThreadPrompt $promptRepo */
			$promptRepo = $this->repository('XF:ThreadPrompt');
			$availablePrompts = $promptRepo->findPromptsForList()->fetch()->pluckNamed('title', 'prompt_id');
			$promptListData = $promptRepo->getPromptListData();

			/** @var \XF\Entity\Forum $forum */
			$forum = $node->getDataRelationOrDefault(false);
			if (!$forum->exists())
			{
				$forum->forum_type_id = $forumType->getTypeId();
			}

			$reply->setParams([
				'availableFields' => $availableFields,

				'availablePrefixes' => $availablePrefixes,

				'availablePrompts' => $availablePrompts,

				'prefixGroups' => $prefixListData['prefixGroups'],
				'prefixesGrouped' => $prefixListData['prefixesGrouped'],

				'promptGroups' => $promptListData['promptGroups'],
				'promptsGrouped' => $promptListData['promptsGrouped'],

				'sortOptions' => $forumType->getThreadListSortOptions($forum, true),

				'forumType' => $forumType,
				'forumTypeId' => $forumType->getTypeId(),
				'forumTypeTitle' => $forumType->getTypeTitle(),
				'forumTypeDesc' => $forumType->getTypeDescription(),
				'canChangeForumType' => $forumType->canChangeForumType($forum)
			]);

			$typeConfig = $forum->type_config;
			$typeConfigTemplate = $forumType->setupTypeConfigEdit($reply, $node, $forum, $typeConfig);

			$reply->setParam('typeConfig', $typeConfig);
			if ($typeConfigTemplate)
			{
				$reply->setParam('typeConfigTemplate', $typeConfigTemplate);
			}
		}

		return $reply;
	}

	protected function saveTypeData(FormAction $form, \XF\Entity\Node $node, \XF\Entity\AbstractNode $data)
	{
		$forumType = $this->getForumTypeHandlerForAddEdit($node);
		if (!$forumType)
		{
			$form->logError(\XF::phrase('forum_type_handler_not_found'), 'forum_type_id');
			return;
		}

		$forumInput = $this->filter([
			'allow_posting' => 'bool',
			'moderate_threads' => 'bool',
			'moderate_replies' => 'bool',
			'count_messages' => 'bool',
			'find_new' => 'bool',
			'allowed_watch_notifications' => 'str',
			'default_sort_order' => 'str',
			'default_sort_direction' => 'str',
			'list_date_limit_days' => 'uint',
			'default_prefix_id' => 'uint',
			'require_prefix' => 'bool',
			'min_tags' => 'uint',
			'allow_index' => 'str'
		]);

		$forumInput['index_criteria'] = $this->filterIndexCriteria();

		/** @var \XF\Entity\Forum $data */
		$data->bulkSet($forumInput);
		$data->forum_type_id = $forumType->getTypeId();

		$typeConfig = $forumType->setupTypeConfigSave($form, $node, $data, $this->request);
		if ($typeConfig instanceof \XF\Mvc\Entity\ArrayValidator)
		{
			if ($typeConfig->hasErrors())
			{
				$form->logErrors($typeConfig->getErrors());
			}
			$typeConfig = $typeConfig->getValuesForced();
		}

		$data->type_config = $typeConfig;

		$prefixIds = $this->filter('available_prefixes', 'array-uint');
		$form->complete(function() use($data, $prefixIds)
		{
			/** @var \XF\Repository\ForumPrefix $repo */
			$repo = $this->repository('XF:ForumPrefix');
			$repo->updateContentAssociations($data->node_id, $prefixIds);
		});

		if (!in_array($data->default_prefix_id, $prefixIds))
		{
			$data->default_prefix_id = 0;
		}

		$fieldIds = $this->filter('available_fields', 'array-str');
		$form->complete(function () use ($data, $fieldIds)
		{
			/** @var \XF\Repository\ForumField $repo */
			$repo = $this->repository('XF:ForumField');
			$repo->updateContentAssociations($data->node_id, $fieldIds);
		});

		$promptIds = $this->filter('available_prompts', 'array-uint');
		$form->complete(function() use($data, $promptIds)
		{
			/** @var \XF\Repository\ForumPrompt $repo */
			$repo = $this->repository('XF:ForumPrompt');
			$repo->updateContentAssociations($data->node_id, $promptIds);
		});
	}

	/**
	 * @return array
	 */
	protected function filterIndexCriteria()
	{
		$criteria = [];

		$input = $this->filterArray(
			$this->filter('index_criteria', 'array'),
			[
				'max_days_post' => [
					'enabled' => 'bool',
					'value' => 'posint'
				],
				'max_days_last_post' => [
					'enabled' => 'bool',
					'value' => 'posint'
				],
				'min_replies' => [
					'enabled' => 'bool',
					'value' => 'posint'
				],
				'min_reaction_score' => [
					'enabled' => 'bool',
					'value' => 'int'
				]
			]
		);

		foreach ($input AS $rule => $criterion)
		{
			if (!$criterion['enabled'])
			{
				continue;
			}

			$criteria[$rule] = $criterion['value'];
		}

		return $criteria;
	}

	/**
	 * @param \XF\Entity\Node $node
	 *
	 * @return \XF\ForumType\AbstractHandler|null
	 */
	protected function getForumTypeHandlerForAddEdit(\XF\Entity\Node $node)
	{
		/** @var \XF\Entity\Forum $forum */
		$forum = $node->getDataRelationOrDefault(false);

		if (!$node->exists())
		{
			$forumTypeId = $this->filter('forum_type_id', 'str');
			return $this->app->forumType($forumTypeId, false);
		}
		else
		{
			return $forum->TypeHandler;
		}
	}

	public function actionPrefixes(ParameterBag $params)
	{
		$this->assertPostOnly();

		$viewParams = [];

		$nodeId = $this->filter('val', 'uint');
		if ($nodeId)
		{
			/** @var \XF\Entity\Forum $forum */
			$node = $this->assertNodeExists($nodeId);
			$forum = $node->getDataRelationOrDefault(false);

			$viewParams['forum'] = $forum;
			$viewParams['prefixes'] = $forum->getPrefixesGrouped();
		}

		return $this->view('XF:Forum\Prefixes', 'public:forum_prefixes', $viewParams);
	}

	public function actionChangeType(ParameterBag $params)
	{
		$node = $this->assertNodeExists($params->node_id);

		/** @var \XF\Entity\Forum $forum */
		$forum = $node->Data;

		$newForumTypeId = $this->filter('new_forum_type_id', 'str');
		$newForumType = $newForumTypeId ? $this->app->forumType($newForumTypeId, false) : null;

		$currentForumType = $forum->TypeHandler;

		if (!$currentForumType->canChangeForumType($forum))
		{
			return $this->error(\XF::phrase('this_forums_type_cannot_be_changed'));
		}

		if ($newForumType && $newForumType->getTypeId() == $currentForumType->getTypeId())
		{
			return $this->error(\XF::phrase('forum_is_already_that_type'));
		}

		if ($newForumType && !$newForumType->canManuallyCreateForum())
		{
			return $this->error(\XF::phrase('forums_of_this_type_cannot_be_manually_created'));
		}

		$viewParams = [
			'node' => $node,
			'forum' => $forum,

			'currentForumTypeId' => $currentForumType->getTypeId(),
			'currentForumTypeTitle' => $currentForumType->getTypeTitle(),
			'currentForumTypeDesc' => $currentForumType->getTypeDescription()
		];

		if ($newForumType && $this->isPost() && $this->filter('confirm', 'bool'))
		{
			// actually change the type
			$currentDefaultThreadType = $currentForumType->getDefaultThreadType($forum);

			$form = $this->formAction();

			$typeConfig = $newForumType->setupTypeConfigSave($form, $node, $forum, $this->request);
			if ($typeConfig instanceof \XF\Mvc\Entity\ArrayValidator)
			{
				if ($typeConfig->hasErrors())
				{
					$form->logErrors($typeConfig->getErrors());
				}
				$typeConfig = $typeConfig->getValuesForced();
			}

			$form->basicEntitySave($forum, [
				'forum_type_id' => $newForumType->getTypeId(),
				'type_config' => $typeConfig
			]);
			$form->run();

			$this->app->jobManager()->enqueueUnique(
				"changeForumType{$forum->node_id}{$newForumTypeId}",
				'XF:ForumChangeThreadTypes',
				[
					'node_id' => $forum->node_id,
					'old_default_type' => $currentDefaultThreadType
				]
			);

			return $this->redirect($this->buildLink('nodes') . $this->buildLinkHash($node->node_id));
		}
		else if ($newForumType)
		{
			// display the type config form
			$viewParams += [
				'isTypeChange' => true,
				'newForumTypeId' => $newForumType->getTypeId(),
				'newForumTypeTitle' => $newForumType->getTypeTitle(),
				'newForumTypeDesc' => $newForumType->getTypeDescription()
			];
			$reply = $this->view('XF:Forum\ChangeType', 'forum_change_type', $viewParams);

			$typeConfig = $newForumType->getDefaultTypeConfig();
			$typeConfigTemplate = $newForumType->setupTypeConfigEdit($reply, $node, $forum, $typeConfig);

			$reply->setParam('typeConfig', $typeConfig);
			if ($typeConfigTemplate)
			{
				$reply->setParam('typeConfigTemplate', $typeConfigTemplate);
			}

			return $reply;
		}
		else
		{
			// display the type selection
			$viewParams['forumTypesInfo'] = $this->repository('XF:ForumType')->getForumTypesList(
				\XF\Repository\ForumType::FILTER_MANUAL_CREATE
			);

			return $this->view('XF:Forum\ChangeType', 'forum_change_type', $viewParams);
		}
	}

	public function actionSuggestionConvertReactions(ParameterBag $params)
	{
		$node = $this->assertNodeExists($params->node_id);

		/** @var \XF\Entity\Forum $forum */
		$forum = $node->Data;

		if (!($forum->TypeHandler instanceof \XF\ForumType\Suggestion))
		{
			return $this->notFound();
		}

		if ($this->isPost())
		{
			$this->app->jobManager()->enqueueUnique(
				"suggestionConvertReactions{$node->node_id}",
				'XF:SuggestionConvertReactions',
				['node_id' => $node->node_id]
			);

			return $this->redirect($this->buildLink('nodes') . $this->buildLinkHash($node->node_id));
		}
		else
		{
			$viewParams = [
				'node' => $node,
				'forum' => $forum,
			];
			return $this->view(
				'XF:Forum\SuggestionConvertReactions', 'forum_suggestion_convert_reactions', $viewParams
			);
		}
	}
}
