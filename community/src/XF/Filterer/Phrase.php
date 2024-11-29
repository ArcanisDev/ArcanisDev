<?php

namespace XF\Filterer;

use XF\Mvc\Entity\Finder;

use function intval;

class Phrase extends AbstractFilterer
{
	protected function getFinderType(): string
	{
		return 'XF:PhraseMap';
	}

	protected function initFinder(Finder $finder, array $setupData)
	{
		$languageId = $setupData['language_id'] ?? null;
		if ($languageId === null)
		{
			throw new \LogicException("Must pass a language_id to setup data");
		}

		$finder->where('language_id', intval($languageId))
			->with('Phrase', true)
			->orderTitle()
			->pluckFrom('Phrase', 'phrase_id');
	}

	protected function getFilterTypeMap(): array
	{
		return [
			'addon_id' => 'str',
			'title' => 'str',
			'text' => 'str',
			'text_cs' => 'bool',
			'state' => 'array-str'
		];
	}

	protected function getLookupTypeList(): array
	{
		return [
			'state'
		];
	}

	protected function getFormDefaults(): array
	{
		return [
			'addon_id' => '_any',
			'state' => ['default', 'inherited', 'custom']
		];
	}

	protected function applyFilter(string $filterName, &$value, &$displayValue): bool
	{
		/** @var \XF\Finder\PhraseMap $finder */
		$finder = $this->finder;

		switch ($filterName)
		{
			case 'addon_id':
				if ($value == '_any')
				{
					return false;
				}

				if ($value === '_none')
				{
					$finder->Phrase->where('addon_id', '');
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

				$finder->Phrase->where('addon_id', $value);
				return true;

			case 'title':
				$this->finder->Phrase->searchTitle($value);
				return true;

			case 'text':
				$caseSensitive = $this->rawFilters['text_cs'] ?? false;
				$finder->Phrase->searchText($value, $caseSensitive);
				if ($caseSensitive)
				{
					$this->addLinkParam('text_cs', 1);
				}
				return true;

			case 'state':
				$finder->isPhraseStateExtended($value, $allPresent);
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