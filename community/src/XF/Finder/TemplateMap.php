<?php

namespace XF\Finder;

use XF\Mvc\Entity\Finder;

use function in_array, is_array;

class TemplateMap extends Finder
{
	public function isTemplateState($states)
	{
		return $this->isTemplateStateExtended($states);
	}

	public function isTemplateStateExtended($states, &$allPresent = false)
	{
		if (!is_array($states))
		{
			$states = [$states];
		}

		if ($states)
		{
			$allPresent = in_array('default', $states) && in_array('custom', $states) && in_array('inherited', $states);
			if (!$allPresent)
			{
				$expression = $this->expression(
					'IF(%1$s = 0, \'default\', IF(%1$s = %2$s, \'custom\', \'inherited\'))',
					'Template.style_id', 'style_id'
				);
				$this->where($expression, $states);
			}
		}

		return $this;
	}

	public function orderTitle($direction = 'ASC')
	{
		$expression = $this->columnUtf8('title');
		$this->order($expression, $direction);

		return $this;
	}
}