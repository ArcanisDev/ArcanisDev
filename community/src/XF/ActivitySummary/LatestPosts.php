<?php

namespace XF\ActivitySummary;

use XF\Mvc\Entity\Finder;

use function in_array;

class LatestPosts extends AbstractSection
{
	protected $defaultOptions = [
		'limit' => 5,
		'node_ids' => [0],
		'min_reaction_score' => null,
		'order' => 'post_date',
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
		return $this->finder('XF:Post')
			->with(['Thread', 'Thread.Forum', 'User', 'User.PermissionCombination'])
			->setDefaultOrder($this->options['order'], $this->options['direction']);
	}

	protected function findDataForFetch(Finder $postFinder): Finder
	{
		$options = $this->options;

		$limit = $options['limit'];
		$nodeIds = $options['node_ids'];
		$minReactionScore = $options['min_reaction_score'];

		$postFinder
			->where('message_state', 'visible')
			->where('Thread.discussion_state', 'visible')
			->limit(max($limit * 5, 25));

		if ($nodeIds && !in_array(0, $nodeIds))
		{
			$postFinder->where('Thread.node_id', $nodeIds);
		}
		else
		{
			$postFinder->where('Thread.Forum.find_new', true);
		}

		if ($minReactionScore !== null)
		{
			$postFinder->where('reaction_score', '>=', $minReactionScore);
		}

		$postFinder->where('post_date', '>', $this->getActivityCutOff());

		return $postFinder;
	}

	protected function renderInternal(Instance $instance): string
	{
		/** @var \XF\Mvc\Entity\ArrayCollection|\XF\Entity\Post[] $posts */
		$posts = $this->fetchData();

		$nodeIds = $posts->pluck(
			function(\XF\Entity\Post $post)
			{
				return $post->Thread ? [$post->post_id, $post->Thread->node_id] : null;
			},
			false
		);
		$instance->getUser()->cacheNodePermissions(array_unique($nodeIds));

		foreach ($posts AS $postId => $post)
		{
			if (!$post->canView() || $post->isIgnored())
			{
				unset($posts[$postId]);
				continue;
			}

			if ($instance->hasSeen('post', $postId))
			{
				unset($posts[$postId]);
				continue;
			}

			if ($post->isFirstPost() && $instance->hasSeen('thread', $post->thread_id))
			{
				unset($posts[$postId]);
				continue;
			}
		}

		if (!$posts->count())
		{
			return '';
		}

		$posts = $posts->slice(0, $this->options['limit']);

		foreach ($posts AS $post)
		{
			$instance->addSeen('post', $post->post_id);

			if ($post->isFirstPost())
			{
				$instance->addSeen('thread', $post->thread_id);
			}
		}

		$viewParams = [
			'posts' => $posts
		];
		return $this->renderSectionTemplate($instance, 'activity_summary_latest_posts', $viewParams);
	}

	protected function getDefaultOrderOptions()
	{
		return [
			'post_date' => \XF::phrase('post_date'),
			'reaction_score' => \XF::phrase('reaction_score'),
			'vote_score' => \XF::phrase('vote_score')
		];
	}

	public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
	{
		$options = $request->filter([
			'limit' => 'uint',
			'node_ids' => 'array-uint',
			'min_reaction_score' => '?int',
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

		$orders = $this->getDefaultOrderOptions();
		if (!isset($orders[$options['order']]))
		{
			$options['order'] = 'post_date';
		}

		$options['direction'] = strtoupper($options['direction']);
		if (!in_array($options['direction'], ['ASC', 'DESC']))
		{
			$options['direction'] = 'DESC';
		}

		return true;
	}
}