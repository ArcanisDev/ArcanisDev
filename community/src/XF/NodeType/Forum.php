<?php

namespace XF\NodeType;

class Forum extends AbstractHandler
{
	public function setupApiTypeDataEdit(
		\XF\Entity\Node $node, \XF\Entity\AbstractNode $data, \XF\InputFiltererArray $inputFilterer, \XF\Mvc\FormAction $form
	)
	{
		/** @var \XF\Entity\Forum $data */

		$forumInput = $inputFilterer->filter([
			'allow_posting' => '?bool',
			'moderate_threads' => '?bool',
			'moderate_replies' => '?bool',
			'count_messages' => '?bool',
			'find_new' => '?bool',
			'allowed_watch_notifications' => '?str',
			'default_sort_order' => '?str',
			'default_sort_direction' => '?str',
			'list_date_limit_days' => '?uint',
			'default_prefix_id' => '?uint',
			'require_prefix' => '?bool',
			'min_tags' => '?uint',
			'allow_index' => '?str',
			'index_criteria' => [
				'max_days_post' => '?uint',
				'max_days_last_post' => '?uint',
				'min_replies' => '?uint',
				'min_reaction_score' => '?int'
			]
		]);
		$forumInput = \XF\Util\Arr::filterNull($forumInput);

		/** @var \XF\Entity\Forum $data */
		$data->bulkSet($forumInput);

		if (!$node->exists())
		{
			$forumTypeId = $inputFilterer->filter('forum_type_id', 'str');
			if (!$forumTypeId)
			{
				$forumTypeId = 'discussion';
			}

			$forumTypeHandler = \XF::app()->forumType($forumTypeId, false);
			if ($forumTypeHandler)
			{
				$data->forum_type_id = $forumTypeId;
			}
			else
			{
				$form->logError(\XF::phrase('forum_type_handler_not_found'), 'forum_type_id');
			}
		}
		else
		{
			$forumTypeHandler = $data->getTypeHandler();
		}

		if ($forumTypeHandler)
		{
			$typeConfig = $forumTypeHandler->setupTypeConfigApiSave($form, $node, $data, $inputFilterer);
			if ($typeConfig instanceof \XF\Mvc\Entity\ArrayValidator)
			{
				if ($typeConfig->hasErrors())
				{
					$form->logErrors($typeConfig->getErrors());
				}
				$typeConfig = $typeConfig->getValuesForced();
			}
			$data->type_config = $typeConfig;
		}
	}
}