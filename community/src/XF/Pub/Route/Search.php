<?php

namespace XF\Pub\Route;

class Search
{
	/**
	 * @return \XF\Mvc\RouteBuiltLink|null
	 */
    public static function build(
        string &$prefix,
        array &$route,
        string &$action,
        &$data,
        array &$params,
        \XF\Mvc\Router $router
    )
	{
		if ($data instanceof \XF\Entity\Search)
		{
			$params['q'] = $data->search_query;
			$params['t'] = $data->search_type;
			$params['c'] = $data->search_constraints;
			$params['o'] = $data->search_order;
			if ($data->search_grouping)
			{
				$params['g'] = 1;
			}

			$params = array_filter($params, function ($param)
			{
				return (
					$param !== null &&
					$param !== 0 &&
					$param !== '' &&
					$param !== []
				);
			});
		}

		return null; // default processing otherwise
	}
}