<?php

namespace XF\Mvc\Entity;

use function array_key_exists, count, is_array, is_object, is_string;

class ArrayValidator implements \ArrayAccess
{
	/**
	 * @var array
	 */
	protected $columns;

	/**
	 * @var ValueFormatter
	 */
	protected $valueFormatter;

	/**
	 * @var array
	 */
	protected $existingValues;

	/**
	 * @var array
	 */
	protected $newValues = [];

	/**
	 * True if this is considered an update. In this case, requirements will only be checked for columns
	 * that have changed.
	 *
	 * @var bool
	 */
	protected $isUpdating;

	/**
	 * @var array
	 */
	protected $errors = [];

	/**
	 * @var bool
	 */
	protected $requirementsChecked = false;

	public function __construct(
		array $columns,
		ValueFormatter $valueFormatter,
		array $existingValues = [],
		bool $isUpdating = false
	)
	{
		$this->columns = $columns;
		$this->valueFormatter = $valueFormatter;
		$this->existingValues = $existingValues;
		$this->isUpdating = $isUpdating;
	}

	public function __isset($key): bool
	{
		return isset($this->columns[$key]);
	}

	#[\ReturnTypeWillChange]
	public function offsetExists($offset): bool
	{
		return $this->__isset($offset);
	}

	public function get($key)
	{
		if (!isset($this->columns[$key]))
		{
			throw new \InvalidArgumentException("Unknown column $key");
		}

		if (array_key_exists($key, $this->newValues))
		{
			return $this->newValues[$key];
		}
		else if (array_key_exists($key, $this->existingValues))
		{
			return $this->existingValues[$key];
		}
		else
		{
			return null;
		}
	}

	public function __get($key)
	{
		return $this->get($key);
	}

	#[\ReturnTypeWillChange]
	public function offsetGet($offset)
	{
		return $this->get($offset);
	}

	public function set($key, $value, array $options = []): bool
	{
		if (!isset($this->columns[$key]))
		{
			throw new \InvalidArgumentException("Unknown column $key");
		}

		$column = $this->columns[$key];
		$type = $column['type'];

		if (!$this->verifyValueCustom($value, $key, $type, $column))
		{
			return false;
		}

		try
		{
			$value = $this->valueFormatter->castValueToType($value, $type, $column);
		}
		catch (\Exception $e)
		{
			throw new \InvalidArgumentException($e->getMessage() . " [$key]", $e->getCode(), $e);
		}

		if (!$this->valueFormatter->applyValueConstraints(
			$value, $type, $column, $constraintError, !empty($options['forceConstraint'])
		))
		{
			if ($constraintError)
			{
				$this->errors[$key] = $constraintError;
			}

			return false;
		}

		if (array_key_exists($key, $this->newValues))
		{
			$isDifferent = ($value !== $this->newValues[$key]);
		}
		else if (array_key_exists($key, $this->existingValues))
		{
			$isDifferent = ($value !== $this->existingValues[$key]);
		}
		else
		{
			$isDifferent = true;
		}

		if ($isDifferent)
		{
			$this->newValues[$key] = $value;
			$this->requirementsChecked = false;
		}

		return true;
	}

	protected function verifyValueCustom(&$value, $key, $type, array $columnOptions)
	{
		$success = true;

		if (!empty($columnOptions['verify']))
		{
			$verifier = $columnOptions['verify'];
			if (!($verifier instanceof \Closure))
			{
				throw new \LogicException("Verifier for $key must be closure");
			}

			$success = $verifier($value, $key, $type, $columnOptions, $this);
			if ($success !== true && $success !== false)
			{
				throw new \LogicException("Verification method of $key did not return a valid indicator (true/false)");
			}
		}

		return $success;
	}

	public function bulkSet(array $values, array $options = []): array
	{
		$results = [];
		foreach ($values AS $key => $value)
		{
			$results[$key] = $this->set($key, $value, $options);
		}

		return $results;
	}

	public function __set($key, $value)
	{
		$this->set($key, $value);
	}

	#[\ReturnTypeWillChange]
	public function offsetSet($offset, $value)
	{
		$this->set($offset, $value);
	}

	#[\ReturnTypeWillChange]
	public function offsetUnset($offset)
	{
		throw new \LogicException('Entity offsets may not be unset');
	}

	public function getValues(): array
	{
		if ($this->hasErrors())
		{
			throw new \LogicException("Can't get values while having errors; call getValuesForced if you want to ignore errors");
		}

		return array_replace($this->existingValues, $this->newValues);
	}

	public function getValuesForced(): array
	{
		return array_replace($this->existingValues, $this->newValues);
	}

	public function getExistingValues(): array
	{
		return $this->existingValues;
	}

	public function getNewValues(): array
	{
		return $this->newValues;
	}

	public function hasChanges(): bool
	{
		return count($this->newValues) > 0;
	}

	public function error($message, $key = null)
	{
		if ($key !== null)
		{
			$this->errors[$key] = $message;
		}
		else
		{
			$this->errors[] = $message;
		}
	}

	public function hasErrors($withRequirementsCheck = true): bool
	{
		if (!$this->requirementsChecked && $withRequirementsCheck)
		{
			$this->checkRequirements();
			$this->requirementsChecked = true;
		}

		return count($this->errors) > 0;
	}

	public function getErrors(): array
	{
		$this->hasErrors(); // to run the requirements check

		return $this->errors;
	}

	protected function checkRequirements()
	{
		foreach ($this->columns AS $key => $column)
		{
			if (empty($column['required']))
			{
				continue;
			}

			if (isset($this->errors[$key]))
			{
				// already have a more specific error
				continue;
			}

			if ($this->isUpdating && !array_key_exists($key, $this->newValues))
			{
				// for updates, ignore required fields that haven't been changed
				continue;
			}

			$value = $this->get($key);
			$exists = array_key_exists($key, $this->newValues) || array_key_exists($key, $this->existingValues);

			if (!$exists || $value === '' || $value === [] || $value === null)
			{
				if (is_string($column['required']))
				{
					$this->error(\XF::phrase($column['required']), $key);
				}
				else
				{
					$this->error(\XF::phrase('please_enter_value_for_required_field_x', ['field' => $key]), $key);
				}
			}
		}
	}

	public function appendErrors(&$target)
	{
		$errors = $this->getErrors();

		if (!is_array($target))
		{
			if (is_string($target) || is_object($target))
			{
				$target = [$target];
			}
			else
			{
				$target = [];
			}
		}

		if ($errors)
		{
			$target += $errors;
		}
	}
}