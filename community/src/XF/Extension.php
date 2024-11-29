<?php

namespace XF;

use function call_user_func_array, get_class, is_object;

class Extension
{
	protected $listeners = [];

	/**
	 * @var array<class-string, class-string[]>
	 */
	protected $classExtensions = [];

	/**
	 * @var array<class-string, class-string>
	 */
	protected $extensionMap = [];

	/**
	 * @var array<class-string, class-string>
	 */
	protected $inverseExtensionMap = [];

	public function __construct(array $listeners = [], array $classExtensions = [])
	{
		$this->listeners = $listeners;
		$this->classExtensions = $classExtensions;
	}

	public function fire($event, array $args = [], $hint = null)
	{
		$listeners = $this->listeners;

		if (empty($listeners[$event]))
		{
			return true;
		}

		if ($hint !== null)
		{
			if (!empty($listeners[$event]['_']))
			{
				foreach ($listeners[$event]['_'] AS $callback)
				{
					if (is_callable($callback))
					{
						$return = call_user_func_array($callback, $args);
						if ($return === false)
						{
							return false;
						}
					}
				}
			}

			if ($hint !== '_' && !empty($listeners[$event][$hint]))
			{
				foreach ($listeners[$event][$hint] AS $callback)
				{
					if (is_callable($callback))
					{
						$return = call_user_func_array($callback, $args);
						if ($return === false)
						{
							return false;
						}
					}
				}
			}
		}
		else
		{
			foreach ($listeners[$event] AS $callbacks)
			{
				foreach ($callbacks AS $callback)
				{
					if (is_callable($callback))
					{
						$return = call_user_func_array($callback, $args);
						if ($return === false)
						{
							return false;
						}
					}
				}
			}
		}

		return true;
	}

	public function getListeners($event)
	{
		return $this->listeners[$event] ?? [];
	}

	public function addListener($event, $callback, $hint = '_')
	{
		$this->listeners[$event][$hint][] = $callback;
	}

	public function setListeners(array $listeners)
	{
		$this->listeners = $listeners;
	}

	public function removeListeners($event = null)
	{
		if ($event !== null)
		{
			unset($this->listeners[$event]);
		}
		else
		{
			$this->listeners = [];
		}
	}

	/**
	 * @template TBase
	 * @template TFakeBase
	 * @template TSubclass of TBase
	 *
	 * @param class-string<TBase>          $class
	 * @param class-string<TFakeBase>|null $fakeBaseClass
	 *
	 * @return class-string<TSubclass>
	 */
	public function extendClass($class, $fakeBaseClass = null)
	{
		$class = ltrim($class, '\\');

		if (isset($this->extensionMap[$class]))
		{
			return $this->extensionMap[$class];
		}

		if (!$class)
		{
			return $class;
		}

		$extensions = !empty($this->classExtensions[$class]) ? $this->classExtensions[$class] : [];
		if (!$extensions)
		{
			$this->extensionMap[$class] = $class;
			$this->inverseExtensionMap[$class] = $class;
			return $class;
		}

		if (!class_exists($class))
		{
			if ($fakeBaseClass)
			{
				$fakeBaseClass = ltrim($fakeBaseClass, '\\');
				class_alias($fakeBaseClass, $class);
			}
			else
			{
				$this->extensionMap[$class] = $class;
				$this->inverseExtensionMap[$class] = $class;
				return $class;
			}
		}

		$finalClass = $class;

		try
		{
			foreach ($extensions AS $extendClass)
			{
				if (preg_match('/[;,$\/#"\'.()]/', $extendClass))
				{
					continue;
				}

				// XFCP = XenForo Class Proxy, in case you're wondering

				$nsSplit = strrpos($extendClass, '\\');
				if ($nsSplit !== false && $ns = substr($extendClass, 0, $nsSplit))
				{
					$proxyClass = $ns . '\\XFCP_' . substr($extendClass, $nsSplit + 1);
				}
				else
				{
					$proxyClass = 'XFCP_' . $extendClass;
				}

				// TODO: there may be a situation where this fails. If we've changed the extensions after classes have
				// been loaded, it's possible these classes will already be loaded with a different config. Figure out
				// how to handle that if possible. Remains to be seen if it comes up (mostly relating to add-on imports).

				class_alias($finalClass, $proxyClass);
				$finalClass = $extendClass;

				if (!class_exists($extendClass))
				{
					throw new \Exception("Could not find class $extendClass when attempting to extend $class");
				}
			}
		}
		catch (\Exception $e)
		{
			$this->extensionMap[$class] = $class;
			$this->inverseExtensionMap[$class] = $class;
			throw $e;
		}

		$this->extensionMap[$class] = $finalClass;
		$this->inverseExtensionMap[$finalClass] = $class;

		return $finalClass;
	}

	/**
	 * @template TBase
	 * @template TSubclass of TBase
	 *
	 * @param class-string<TBase>     $class
	 * @param class-string<TSubclass> $extension
	 *
	 * @return void
	 */
	public function addClassExtension($class, $extension)
	{
		$class = ltrim($class, '\\');
		$extension = ltrim($extension, '\\');

		$this->classExtensions[$class][] = $extension;
		$this->inverseExtensionMap[$extension] = $class;

		// TODO: if the class has already been loaded, we need to override the cache add our extension for the future
	}

	/**
	 * @param array<class-string, class-string[]> $extensions
	 *
	 * @return void
	 */
	public function setClassExtensions(array $extensions)
	{
		$this->classExtensions = $extensions;
		$this->extensionMap = [];
		$this->inverseExtensionMap = [];
	}

	/**
	 * @param class-string $class
	 *
	 * @return void
	 */
	public function removeClassExtensions($class = null)
	{
		if ($class !== null)
		{
			foreach ($this->classExtensions[$class] AS $subclass)
			{
				unset($this->inverseExtensionMap[$subclass]);
			}

			unset($this->classExtensions[$class]);
			unset($this->extensionMap[$class]);
		}
		else
		{
			$this->classExtensions = [];
			$this->extensionMap = [];
			$this->inverseExtensionMap = [];
		}
	}

	/**
	 * Takes a class that may be dynamically extended and resolves it
	 * back to the root.
	 *
	 * @template TBase
	 * @template TSubclass of TBase
	 *
	 * @param class-string<TSubclass>|TSubclass $class Class name or object
	 *
	 * @return class-string<TBase>
	 *
	 * @throws \LogicException in debug mode if extendClass hasn't been called on the base class
	 */
	public function resolveExtendedClassToRoot($class)
	{
		if (is_object($class))
		{
			$class = get_class($class);
		}
		else if (($class[0] ?? null) === '\\')
		{
			$class = substr($class, 1);
		}

		if (!isset($this->inverseExtensionMap[$class]))
		{
			if (\XF::$debugMode)
			{
				throw new \LogicException(
					'Tried to call ' . __METHOD__ . " on {$class}, but extendClass was never called on the base class"
				);
			}

			return $class;
		}

		return $this->inverseExtensionMap[$class];
	}
}