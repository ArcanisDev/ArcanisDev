<?php

namespace XF\Finder;

use XF\Mvc\Entity\Finder;

class ActivitySummarySection extends Finder
{
	public function definitionActive(): Finder
	{
		$this->with('ActivitySummaryDefinition', true)
			->whereAddOnActive([
				'relation' => 'ActivitySummaryDefinition.AddOn',
				'column' => 'ActivitySummaryDefinition.addon_id'
			]);

		return $this;
	}

	public function activeOnly(): Finder
	{
		$this->definitionActive();

		$this->where('active', 1);

		return $this;
	}
}