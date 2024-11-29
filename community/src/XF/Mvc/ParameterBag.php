<?php

namespace XF\Mvc;

use function array_key_exists;

class ParameterBag implements \ArrayAccess
{
	protected $params;

	public function __construct(array $params = [])
	{
		$this->params = $params;
	}

	#[\ReturnTypeWillChange]
	public function offsetGet($key)
	{
		return $this->params[$key] ?? null;
	}

	public function __get($key)
	{
		return $this->offsetGet($key);
	}

	public function get($key, $fallback = null)
	{
		return array_key_exists($key, $this->params) ? $this->params[$key] : $fallback;
	}

	#[\ReturnTypeWillChange]
	public function offsetSet($key, $value)
	{
		$this->params[$key] = $value;
	}

	public function __set($key, $value)
	{
		$this->offsetSet($key, $value);
	}

	#[\ReturnTypeWillChange]
	public function offsetExists($key)
	{
		return array_key_exists($key, $this->params);
	}

	#[\ReturnTypeWillChange]
	public function offsetUnset($key)
	{
		unset($this->params[$key]);
	}

	public function params()
	{
		return $this->params;
	}
}