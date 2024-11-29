<?php

namespace XF;

class SimpleCacheSet implements \ArrayAccess
{
	/**
	 * @var SimpleCache
	 */
	protected $simpleCache;

	/**
	 * @var string
	 */
	protected $addOnId;

	public function __construct(SimpleCache $simpleCache, $addOnId)
	{
		$this->simpleCache = $simpleCache;
		$this->addOnId = $addOnId;
	}

	public function getValue($key)
	{
		$simpleCache = $this->simpleCache;
		$addOnId = $this->addOnId;
		return $simpleCache->getValue($addOnId, $key);
	}

	public function keyExists($key)
	{
		$simpleCache = $this->simpleCache;
		$addOnId = $this->addOnId;
		return $simpleCache->keyExists($addOnId, $key);
	}

	public function setValue($key, $value)
	{
		$simpleCache = $this->simpleCache;
		$addOnId = $this->addOnId;
		$simpleCache->setValue($addOnId, $key, $value);
	}

	public function deleteValue($key)
	{
		$simpleCache = $this->simpleCache;
		$addOnId = $this->addOnId;
		$simpleCache->deleteValue($addOnId, $key);
	}

	#[\ReturnTypeWillChange]
	public function offsetExists($key)
	{
		return $this->keyExists($key);
	}

	public function __get($key)
	{
		return $this->offsetGet($key);
	}

	#[\ReturnTypeWillChange]
	public function offsetGet($key)
	{
		return $this->getValue($key);
	}

	public function __set($key, $value)
	{
		$this->setValue($key, $value);
	}

	#[\ReturnTypeWillChange]
	public function offsetSet($key, $value)
	{
		$this->setValue($key, $value);
	}

	#[\ReturnTypeWillChange]
	public function offsetUnset($key)
	{
		$this->deleteValue($key);
	}
}