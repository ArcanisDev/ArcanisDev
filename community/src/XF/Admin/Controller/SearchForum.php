<?php

namespace XF\Admin\Controller;

use XF\Mvc\FormAction;

class SearchForum extends AbstractNode
{
	/**
	 * @return string
	 */
	protected function getNodeTypeId()
	{
		return 'SearchForum';
	}

	/**
	 * @return string
	 */
	protected function getDataParamName()
	{
		return 'searchForum';
	}

	/**
	 * @return string
	 */
	protected function getTemplatePrefix()
	{
		return 'search_forum';
	}

	/**
	 * @return string
	 */
	protected function getViewClassPrefix()
	{
		return 'XF:SearchForum';
	}

	/**
	 * @return \XF\Mvc\Reply\AbstractReply
	 */
	protected function nodeAddEdit(\XF\Entity\Node $node)
	{
		$reply = parent::nodeAddEdit($node);

		if ($reply instanceof \XF\Mvc\Reply\View)
		{
			/** @var \XF\Entity\SearchForum $searchForum */
			$searchForum = $node->Data;
			$searcher = $this->searcher(
				'XF:Thread',
				$searchForum->exists() ? $searchForum->search_criteria : $searchForum->getDefaultSearchCriteria()
			);
			$criteria = $searcher->getFormCriteria();

			if ($searchForum->exists())
			{
				// add in the form defaults for criteria we don't have as we're saving the filtered criteria
				// and this may lead to things not being checked (which behaves the same but is confusing from
				// a UI perspective)
				$criteria += $searcher->getFormDefaults();
			}

			$params = [
				'criteria' => $criteria
			];
			$params += $searcher->getFormData();
			$reply->setParams($params);
		}

		return $reply;
	}

	protected function saveTypeData(
		FormAction $form,
		\XF\Entity\Node $node,
		\XF\Entity\AbstractNode $data
	)
	{
		$input = $this->filter([
			'sort_order' => 'str',
			'sort_direction' => 'str',
			'max_results' => 'posint',
			'cache_ttl' => 'uint'
		]);
		$data->bulkSet($input);

		$criteria = $this->filter('criteria', 'array');
		$searcher = $this->searcher('XF:Thread', $criteria);
		/** @var \XF\Entity\SearchForum $data */
		$data->search_criteria = $searcher->getFilteredCriteria();
	}
}