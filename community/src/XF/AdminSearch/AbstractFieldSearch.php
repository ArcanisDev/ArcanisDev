<?php

namespace XF\AdminSearch;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Router;

abstract class AbstractFieldSearch extends AbstractHandler
{
	abstract protected function getFinderName();
	abstract protected function getContentIdName();
	abstract protected function getRouteName();

	/**
	 * @var array Fields to be searched for $text. The first field here is assumed to be the title field.
	 */
	protected $searchFields = ['title'];

	/**
	 * Use this to set any default conditions on the search finder, such as visible=1 etc.
	 *
	 * @param \XF\Mvc\Entity\Finder $finder
	 */
	protected function getFinderConditions(\XF\Mvc\Entity\Finder &$finder)
	{
	}

	public function search($text, $limit, array $previousMatchIds = [])
	{
		$finder = $this->app->finder($this->getFinderName());
		$this->getFinderConditions($finder);

		$conditions = [];
		$escapedLike = $finder->escapeLike($text, '%?%');

		foreach ($this->searchFields AS $index => $searchField)
		{
			if (!is_numeric($index))
			{
				// in this instance, $searchField is a regex
				if (!preg_match($searchField, $text))
				{
					// didn't match, so don't bother searching the DB for this field
					continue;
				}

				// put the actual search text into place for the DB search
				$searchField = $index;
			}

			$conditions[] = [$searchField, 'like', $escapedLike];
		}

		if (empty($conditions))
		{
			return false;
		}

		$conditions = $this->getConditions($conditions, $text, $escapedLike);

		if ($previousMatchIds)
		{
			$conditions[] = [$this->getContentIdName(), $previousMatchIds];
		}

		if (isset($this->searchFields[0]))
		{
			$order = $this->searchFields[0];
		}
		else if (function_exists('array_key_first'))
		{
			$order = array_key_first($this->searchFields);
		}
		else
		{
			$order = $this->arrayKeyFirst($this->searchFields);
		}

		$finder
			->whereOr($conditions)
			->setDefaultOrder($order)
			->limit($limit);

		return $finder->fetch();
	}

	protected function getConditions(array $conditions, $text, $escapedLike)
	{
		return $conditions;
	}

	public function getTemplateData(Entity $record)
	{
		/** @var \XF\Mvc\Router $router */
		$router = $this->app->container('router.admin');

		return $this->getTemplateParams($router, $record, [
			'link' => $router->buildLink($this->getRouteName(), $record),
			'title' => $record->{$this->searchFields[0]}
		]);
	}

	/**
	 * @param Router $router
	 * @param Entity $record
	 * @param array  $templateParams
	 *
	 * @return array
	 */
	protected function getTemplateParams(Router $router, Entity $record, array $templateParams)
	{
		return $templateParams;
	}

	protected function arrayKeyFirst(array $arr)
	{
		foreach($arr as $key => $unused)
		{
			return $key;
		}
		return null;
	}
}