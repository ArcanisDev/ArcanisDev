<?php

namespace XF\ActivitySummary;

use XF\Mvc\Entity\Finder;

use function in_array;

class LatestThreads extends AbstractSection
{
	protected $defaultOptions = [
		'limit' => 5,
		'node_ids' => [0],
		'condition' => 'last_post_date',
		'min_replies' => null,
		'min_reaction_score' => null,
		'order' => 'last_post_date',
		'direction' => 'DESC',
	];

	protected function getDefaultTemplateParams($context)
	{
		$params = parent::getDefaultTemplateParams($context);
		if ($context == 'options')
		{
			$nodeRepo = $this->repository('XF:Node');
			$params['nodeTree'] = $nodeRepo->createNodeTree($nodeRepo->getFullNodeList());

			$params['sortOrders'] = $this->getDefaultOrderOptions();
		}
		return $params;
	}

	protected function getBaseFinderForFetch(): Finder
	{
		return $this->finder('XF:Thread')
			->with(['FirstPost', 'Forum', 'User', 'User.PermissionCombination'])
			->setDefaultOrder($this->options['order'], $this->options['direction']);
	}

	protected function findDataForFetch(Finder $threadFinder): Finder
	{
		$options = $this->options;

		$limit = $options['limit'];
		$nodeIds = $options['node_ids'];
		$condition = $options['condition'];
		$minReplies = $options['min_replies'];
		$minReactionScore = $options['min_reaction_score'];

		$threadFinder
			->where('discussion_state', 'visible')
			->where('discussion_type', '<>', 'redirect')
			->limit(max($limit * 5, 25));

		if ($nodeIds && !in_array(0, $nodeIds))
		{
			$threadFinder->where('node_id', $nodeIds);
		}
		else
		{
			$threadFinder->where('Forum.find_new', true);
		}

		$threadFinder->where($condition, '>', $this->getActivityCutOff());

		if ($minReplies !== null)
		{
			$threadFinder->where('reply_count', '>=', $minReplies);
		}

		if ($minReactionScore !== null)
		{
			$threadFinder->where('first_post_reaction_score', '>=', $minReactionScore);
		}

		return $threadFinder;
	}

	protected function renderInternal(Instance $instance): string
	{
		/** @var \XF\Mvc\Entity\ArrayCollection|\XF\Entity\Thread[] $threads */
		$threads = $this->fetchData();

		$nodeIds = $threads->pluckNamed('node_id');
		$instance->getUser()->cacheNodePermissions(array_unique($nodeIds));

		foreach ($threads AS $threadId => $thread)
		{
			if (!$thread->canView() || $thread->isIgnored())
			{
				unset($threads[$threadId]);
				continue;
			}

			if ($instance->hasSeen('thread', $threadId))
			{
				unset($threads[$threadId]);
				continue;
			}

			if ($instance->hasSeen('post', $thread->first_post_id))
			{
				unset($threads[$threadId]);
				continue;
			}
		}

		if (!$threads->count())
		{
			return '';
		}

		$threads = $threads->slice(0, $this->options['limit']);

		foreach ($threads AS $thread)
		{
			$instance->addSeen('thread', $thread->thread_id);
			$instance->addSeen('post', $thread->first_post_id);
		}

		$viewParams = [
			'threads' => $threads
		];
		return $this->renderSectionTemplate($instance, 'activity_summary_latest_threads', $viewParams);
	}

	protected function getDefaultOrderOptions()
	{
		return [
			'last_post_date' => \XF::phrase('last_message'),
			'post_date' => \XF::phrase('start_date'),
			'reply_count' => \XF::phrase('replies'),
			'view_count' => \XF::phrase('views'),
			'first_post_reaction_score' => \XF::phrase('first_message_reaction_score'),
			'vote_score' => \XF::phrase('vote_score')
		];
	}

	public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
	{
		$options = $request->filter([
			'limit' => 'uint',
			'node_ids' => 'array-uint',
			'condition' => 'str',
			'min_replies' => '?uint',
			'min_reaction_score' => '?int',
			'min_last_reply_days' => '?uint',
			'order' => 'str',
			'direction' => 'str',
		]);

		if (in_array(0, $options['node_ids']))
		{
			$options['node_ids'] = [0];
		}

		if ($options['limit'] < 1)
		{
			$options['limit'] = 1;
		}

		if (!in_array($options['condition'], ['post_date', 'last_post_date']))
		{
			$options['condition'] = 'last_post_date';
		}

		$orders = $this->getDefaultOrderOptions();
		if (!isset($orders[$options['order']]))
		{
			$options['order'] = 'last_post_date';
		}

		$options['direction'] = strtoupper($options['direction']);
		if (!in_array($options['direction'], ['ASC', 'DESC']))
		{
			$options['direction'] = 'DESC';
		}

		return true;
	}
}