<?php

namespace XF\AdminSearch;

class AdminTemplate extends PublicTemplate
{
	protected function getSearchTemplateType()
	{
		return 'admin';
	}

	public function isSearchable()
	{
		/** @var \XF\Repository\Style $styleRepo */
		$styleRepo = $this->app->repository('XF:Style');
		if (!$styleRepo->getMasterStyle()->canEdit())
		{
			return false;
		}

		return parent::isSearchable();
	}
}