<?php

namespace XF\Filterer;

use XF\InputFilterer;
use XF\Mvc\Entity\Finder;

use XF\Mvc\ParameterBag;

use function in_array, is_array, is_string;

abstract class AbstractFilterer
{
	/**
	 * @var string
	 */
	protected $finderType;

	/**
	 * @var Finder
	 */
	protected $finder;

	/**
	 * @var array
	 */
	protected $setupData;

	protected $finalized = false;
	protected $applied = false;

	/**
	 * @var array
	 */
	protected $lookupMap;

	protected $rawFilters = [];
	protected $linkParams = [];
	protected $displayValues = [];

	const ORDER_PARAM = 'order';

	public function __construct(array $setupData = [])
	{
		$this->finderType = $this->getFinderType();
		$this->finder = $this->setupFinder($setupData);
		$this->setupData = $setupData;

		$lookupTypes = $this->getLookupTypeList();
		$this->lookupMap = array_fill_keys($lookupTypes, true);
	}

	/**
	 * The short name of the finder that will be used by this filterer.
	 *
	 * @return string
	 */
	abstract protected function getFinderType(): string;

	/**
	 * Mapping of filter names to expected input types. Value should be a type that
	 * can be used by the input filterer.
	 *
	 * @return array
	 */
	abstract protected function getFilterTypeMap(): array;

	/**
	 * A list of filter names whose values should be looked up before being displayed.
	 * This lookup is provided by the display template in the form of
	 * - key:$filterName for name look-ups (available without listing here)
	 * - val:$value for value look-ups
	 *
	 * @return array
	 */
	abstract protected function getLookupTypeList(): array;

	/**
	 * Applies the specified filter to the finder if needed. Returns true if applied and false otherwise.
	 *
	 *
	 * @param string $filterName
	 * @param mixed $value Value to apply to the filter. Output value will be used as the link param value.
	 * @param mixed $displayValue Value to display for this filter. If unmodified, uses the $value
	 *
	 * @return bool
	 */
	abstract protected function applyFilter(string $filterName, &$value, &$displayValue): bool;

	/**
	 * Sets up the finder. Extensions are better done via initFinder.
	 *
	 * @param array $setupData
	 *
	 * @return Finder
	 */
	protected function setupFinder(array $setupData): Finder
	{
		$finder = $this->app()->finder($this->finderType);
		$this->initFinder($finder, $setupData);

		return $finder;
	}

	/**
	 * Ideal place to setup the default elements of the finder (such as order) and to apply
	 * any setup-based constraints or validations (such as template filtering requiring a style_id).
	 *
	 * @param Finder $finder
	 * @param array  $setupData
	 */
	protected function initFinder(Finder $finder, array $setupData)
	{
	}

	/**
	 * Gets default values for filters for the purposes of filling out a form. Most commonly,
	 * this will be a reasonable default for radio or checkbox options.
	 *
	 * @return array
	 */
	protected function getFormDefaults(): array
	{
		return [];
	}

	/**
	 * Adds the specified filters and immediately applies them. (No further changes possible.)
	 *
	 * @param array|\XF\Http\Request $input
	 * @param array|string|null $skip Any number of filters that should be disregarded
	 *
	 * @return Finder
	 */
	public function applyFilters($input, $skip = null): Finder
	{
		$this->addFilters($input, $skip);
		$this->addOrder($input);
		$this->apply();

		return $this->finder;
	}

	/**
	 * Adds specified filters from input. Input values that are null, 0, empty strings or empty arrays
	 * will be disregarded.
	 *
	 * @param array|\XF\Http\Request $input
	 * @param array|string|null $skip Any number of filters that should be disregarded
	 */
	public function addFilters($input, $skip = null)
	{
		if ($this->finalized)
		{
			throw new \LogicException("Filters have already been finalized, cannot change");
		}

		$typeMap = $this->getFilterTypeMap();

		if ($input instanceof \XF\Http\Request)
		{
			$input = $input->filter($typeMap);
		}
		if (!is_array($input))
		{
			throw new \LogicException("Input must either be array or Request object");
		}

		$inputFilterer = $this->app()->inputFilterer();

		if ($skip)
		{
			$skip = (array)$skip;
		}

		if (!$skip || !in_array(self::ORDER_PARAM, $skip))
		{
			$this->addOrder($input);
		}

		foreach ($typeMap AS $filterName => $inputType)
		{
			if (!isset($input[$filterName]))
			{
				continue;
			}

			if ($skip && in_array($filterName, $skip))
			{
				continue;
			}

			$inputValue = $inputFilterer->filter($input[$filterName], $inputType);
			if (!$this->hasFilterableValue($filterName, $inputValue))
			{
				continue;
			}

			$this->rawFilters[$filterName] = $inputValue;
		}
	}

	/**
	 * If an 'order' parameter exists in $input, add it to rawFilters for later use in applyOrder()
	 *
	 * @param mixed $input
	 *
	 * @return void
	 */
	public function addOrder($input)
	{
		if (is_array($input))
		{
			if (!isset($input[self::ORDER_PARAM]))
			{
				return;
			}

			$input = $this->app()->inputFilterer()->filter($input[self::ORDER_PARAM], 'str');
		}

		if (!is_string($input) || !$input)
		{
			return;
		}

		$this->rawFilters[self::ORDER_PARAM] = $input;
	}

	/**
	 * Allows customized actions to be applied based on the value of the 'order' parameter,
	 * so that filterers can control the order of returned results without allowing raw access
	 * to the finder->order() method, while also passing the 'order' parameter to linkParams
	 *
	 * @param string $order Instruction to sort
	 * @param mixed $displayValue Value to display, if unmodified, uses $order
	 *
	 * @return bool
	 */
	protected function applyOrder(string $order, &$displayValue): bool
	{
		return false;
	}

	protected function hasFilterableValue(string $filterName, $inputValue): bool
	{
		$noValue = (
			$inputValue === null
			|| $inputValue === ''
			|| $inputValue === 0
			|| (is_array($inputValue) && !$inputValue)
		);
		return !$noValue;
	}

	public function removeFilter(string $filterName)
	{
		if ($this->finalized)
		{
			throw new \LogicException("Filters have already been finalized, cannot change");
		}

		unset($this->rawFilters[$filterName]);
	}

	protected function finalize()
	{
		if ($this->finalized)
		{
			return;
		}
		$this->finalized = true;

		$this->onFinalize();
	}

	/**
	 * Run when the applicable filters have been locked in. Can be used to ensure that certain
	 * filters are always present or to manipulate the finder in special ways.
	 */
	protected function onFinalize()
	{
	}

	/**
	 * Applies the specified filters.
	 *
	 * @return Finder
	 */
	public function apply(): Finder
	{
		if ($this->applied)
		{
			throw new \LogicException("Filters already applied");
		}
		$this->applied = true;

		$this->finalize();

		foreach ($this->rawFilters AS $filterName => $inputValue)
		{
			$displayValue = null;
			$addParams = false;

			if ($filterName == self::ORDER_PARAM)
			{
				$addParams = $this->applyOrder($inputValue, $displayValue);
			}
			else
			{
				$addParams = $this->applyFilter($filterName, $inputValue, $displayValue);
			}

			if ($addParams)
			{
				$this->addLinkParam($filterName, $inputValue);
				$this->addDisplayValue($filterName, $displayValue ?? $inputValue);
			}
		}

		return $this->finder;
	}

	protected function addLinkParam(string $name, $value)
	{
		if ($value === true)
		{
			$value = 1;
		}
		else if ($value === false)
		{
			$value = 0;
		}

		$this->linkParams[$name] = $value;
	}

	protected function addDisplayValue(string $name, $value)
	{
		$isLookup = $this->lookupMap[$name] ?? false;
		if ($isLookup)
		{
			if (is_string($value))
			{
				$value = "val:$value";
			}
			else if (is_array($value))
			{
				// TODO: ermmm??
				foreach ($value AS &$v)
				{
					$v = "val:$v";
				}
			}
		}
		else if ($name == self::ORDER_PARAM)
		{
			$value = "val:{$name}={$value}";
		}

		$this->displayValues[$name] = $value;
	}

	public function getFinder(): Finder
	{
		if (!$this->applied)
		{
			throw new \LogicException("Can only get finder after filters are applied");
		}

		return $this->finder;
	}

	public function getRawFilters(): array
	{
		return $this->rawFilters;
	}

	public function getRawFilter(string $filterName)
	{
		return $this->rawFilters[$filterName] ?? null;
	}

	public function getFiltersForForm(): array
	{
		$this->finalize();

		return array_replace($this->getFormDefaults(), $this->rawFilters);
	}

	public function getLinkParams(): array
	{
		return $this->linkParams;
	}

	public function getDisplayValues(): array
	{
		return $this->displayValues;
	}

	protected function app(): \XF\App
	{
		return \XF::app();
	}
}