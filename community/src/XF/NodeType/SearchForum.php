<?php

namespace XF\NodeType;

class SearchForum extends AbstractHandler
{
	public function setupApiTypeDataEdit(
		\XF\Entity\Node $node,
		\XF\Entity\AbstractNode $data,
		\XF\InputFiltererArray $inputFilterer,
		\XF\Mvc\FormAction $form
	)
	{
		$input = $inputFilterer->filter([
			'sort_order' => '?str',
			'sort_direction' => '?str',
			'max_results' => '?posint',
			'cache_ttl' => '?uint'
		]);
		$input = \XF\Util\Arr::filterNull($input);
		$data->bulkSet($input);

		$criteria = $inputFilterer->filter('criteria', '?array');
		if ($criteria)
		{
			$searcher = \XF::app()->searcher('XF:Thread', $criteria);
			/** @var \XF\Entity\SearchForum $data */
			$data->search_criteria = $searcher->getFilteredCriteria();
		}
	}
}