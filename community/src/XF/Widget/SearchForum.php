<?php

namespace XF\Widget;

use XF\Entity\Thread;

class SearchForum extends AbstractWidget
{
	/**
	 * @var array
	 */
	protected $defaultOptions = [
		'node_id' => 0,
		'limit' => 5,
		'style' => 'simple',
		'show_expanded_title' => false
	];

	/**
	 * @param string $context
	 *
	 * @return array
	 */
	protected function getDefaultTemplateParams($context)
	{
		$params = parent::getDefaultTemplateParams($context);

		if ($context == 'options')
		{
			$nodeRepo = $this->repository('XF:Node');
			$nodeTree = $nodeRepo->createNodeTree($nodeRepo->getFullNodeList());
			$nodeTree = $nodeTree->filter(
				null,
				function($id, $node, $depth, $children, $tree)
				{
					return ($children || $node->node_type_id == 'SearchForum');
				}
			);

			$params['nodeTree'] = $nodeTree;
		}

		return $params;
	}

	/**
	 * @return \XF\Widget\WidgetRenderer|string
	 */
	public function render()
	{
		$visitor = \XF::visitor();

		/** @var \XF\Entity\SearchForum $searchForum */
		$searchForum = $this->em()->findOne(
			'XF:SearchForum',
			['node_id' => $this->options['node_id']],
			[
				'Node',
				"Node.Permissions|{$visitor->permission_combination_id}",
				'Cache',
				"UserCaches|{$visitor->user_id}"
			]
		);
		if (!$searchForum || !$searchForum->canView())
		{
			return '';
		}

		$searchForumRepo = $this->repository('XF:SearchForum');
		$isRebuildPending = $searchForumRepo->enqueueCacheRebuildIfNeeded(
			$searchForum
		);
		$userCache = $searchForum->getUserCacheForUser(
			$visitor,
			$isRebuildPending
		);
		$threadIds = $userCache->sliceResultsToPage(
			1,
			max($this->options['limit'] * 4, 20)
		);

		$threadFinder = $this->finder('XF:Thread')->whereIds($threadIds);

		switch ($this->options['style'])
		{
			case 'full':
				$threadFinder->with('fullForum');
				break;

			case 'expanded':
				$threadFinder->with('FirstPost');
				break;
		}

		$threads = $threadFinder->fetch()->sortByList($threadIds);
		$threads = $threads->filter(
			function (Thread $thread) use ($visitor)
			{
				if (!$thread->canView() || $thread->isIgnored())
				{
					return false;
				}

				if (
					$this->options['style'] != 'expanded' &&
					$visitor->isIgnoring($thread->last_post_user_id)
				)
				{
					return false;
				}

				return true;
			}
		);

		$threads = $threads->slice(0, $this->options['limit'], true);
		if (!$threads->count())
		{
			return '';
		}

		$viewParams = [
			'title' => $this->getTitle(),
			'style' => $this->options['style'],
			'showExpandedTitle' => $this->options['show_expanded_title'],

			'searchForum' => $searchForum,
			'threads' => $threads
		];
		return $this->renderer('widget_search_forum', $viewParams);
	}

	/**
	 * @param \XF\Http\Request $request
	 * @param array            $options
	 * @param \XF\Phrase|null  $error
	 *
	 * @return bool
	 */
	public function verifyOptions(
		\XF\Http\Request $request,
		array &$options,
		&$error = null
	)
	{
		$options = $request->filter([
			'node_id' => 'uint',
			'limit' => 'posint',
			'style' => 'str',
			'show_expanded_title' => 'bool'
		]);

		$node = $this->em()->find('XF:Node', $options['node_id']);

		if (!$options['node_id'] || !$node || $node->node_type_id !== 'SearchForum')
		{
			$error = \XF::phrase('please_select_valid_search_forum');
			return false;
		}

		if ($options['style'] != 'expanded')
		{
			$options['show_expanded_title'] = false;
		}

		return true;
	}
}