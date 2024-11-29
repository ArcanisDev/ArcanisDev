<?php

namespace XF\Filterer;

use XF\Mvc\Entity\Finder;

use function intval, is_array;

class Template extends AbstractFilterer
{
	protected function getFinderType(): string
	{
		return 'XF:TemplateMap';
	}

	protected function initFinder(Finder $finder, array $setupData)
	{
		$styleId = $setupData['style_id'] ?? null;
		if ($styleId === null)
		{
			throw new \LogicException("Must pass a style_id to setup data");
		}

		$finder->where('style_id', intval($styleId))
			->with('Template', true)
			->orderTitle()
			->pluckFrom('Template', 'template_id');
	}

	protected function getFilterTypeMap(): array
	{
		return [
			'type' => 'str',
			'addon_id' => 'str',
			'title' => 'str',
			'template' => 'str',
			'template_cs' => 'bool',
			'state' => 'array-str',
		];
	}

	protected function getLookupTypeList(): array
	{
		return [
			'type',
			'state'
		];
	}

	protected function getFormDefaults(): array
	{
		return [
			'type' => 'public',
			'addon_id' => '_any',
			'state' => ['default', 'inherited', 'custom']
		];
	}

	protected function onFinalize()
	{
		if (empty($this->rawFilters['type']))
		{
			$this->rawFilters['type'] = 'public';
		}

		if (!isset($this->rawFilters['template']))
		{
			unset($this->rawFilters['template_cs']);
		}
	}

	protected function applyFilter(string $filterName, &$value, &$displayValue): bool
	{
		/** @var \XF\Finder\TemplateMap $finder */
		$finder = $this->finder;

		switch ($filterName)
		{
			case 'type':
				$availableTypes = $this->setupData['template_types'] ?? null;
				if (is_array($availableTypes))
				{
					if (!isset($availableTypes[$value]))
					{
						$value = 'public';
					}

					$displayValue = $availableTypes[$value] ?? null;
				}

				$finder->where('type', $value);
				return true;

			case 'addon_id':
				if ($value == '_any')
				{
					return false;
				}

				if ($value === '_none')
				{
					$finder->Template->where('addon_id', '');
					$displayValue = 'val:' . $value;
					return true;
				}

				/** @var \XF\Entity\AddOn|null $addOn */
				$addOn = $this->app()->find('XF:AddOn', $value);
				if (!$addOn)
				{
					return false;
				}
				$displayValue = $addOn->title;

				$finder->Template->where('addon_id', $value);
				return true;

			case 'title':
				$finder->Template->searchTitle($value);
				return true;

			case 'template':
				$caseSensitive = $this->rawFilters['template_cs'] ?? false;
				$finder->Template->searchTemplate($value, $caseSensitive);
				if ($caseSensitive)
				{
					$this->addLinkParam('template_cs', 1);
				}
				return true;

			case 'state':
				$finder->isTemplateStateExtended($value, $allPresent);
				if ($allPresent || empty($value))
				{
					return false;
				}
				return true;

			default:
				return false;
		}
	}
}