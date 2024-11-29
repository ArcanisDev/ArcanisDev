<?php

namespace XF;

class ComposerAutoload
{
	/**
	 * @var App
	 */
	protected $app;

	protected $pathPrefix;

	protected $checkPaths = true;

	public function __construct(\XF\App $app, $pathPrefix)
	{
		$this->app = $app;
		$this->pathPrefix = rtrim($pathPrefix, '\/') . \XF::$DS;
	}

	public function checkPaths(bool $check)
	{
		$this->checkPaths = $check;
	}

	public function autoloadAll($prepend = false)
	{
		$this->autoloadNamespaces($prepend);
		$this->autoloadPsr4($prepend);
		$this->autoloadClassmap();
		$this->autoloadFiles();
	}

	public function autoloadNamespaces($prepend = false)
	{
		$namespaces = $this->pathPrefix . 'autoload_namespaces.php';

		if ($this->checkPaths && !file_exists($namespaces))
		{
			throw new \InvalidArgumentException(
				'Missing autoload_namespaces.php at ' . $this->getPathForError($namespaces)
			);
		}
		else
		{
			$map = require $namespaces;

			foreach ($map AS $namespace => $path)
			{
				\XF::$autoLoader->add($namespace, $path, $prepend);
			}
		}
	}

	public function autoloadPsr4($prepend = false)
	{
		$psr4 = $this->pathPrefix . 'autoload_psr4.php';

		if ($this->checkPaths && !file_exists($psr4))
		{
			throw new \InvalidArgumentException(
				'Missing autoload_psr4.php at ' . $this->getPathForError($psr4)
			);
		}
		else
		{
			$map = require $psr4;

			foreach ($map AS $namespace => $path)
			{
				\XF::$autoLoader->addPsr4($namespace, $path, $prepend);
			}
		}
	}

	public function autoloadClassmap()
	{
		$classmap = $this->pathPrefix . 'autoload_classmap.php';

		if ($this->checkPaths && !file_exists($classmap))
		{
			throw new \InvalidArgumentException(
				'Missing autoload_classmap.php at ' . $this->getPathForError($classmap)
			);
		}
		else
		{
			$map = require $classmap;

			if ($map)
			{
				\XF::$autoLoader->addClassMap($map);
			}
		}
	}

	public function autoloadFiles()
	{
		$files = $this->pathPrefix . 'autoload_files.php';

		if ($this->checkPaths)
		{
			$exists = file_exists($files);
		}
		else
		{
			$exists = true;
		}

		// note that autoload_files.php is only generated if there is actually a 'files' directive somewhere in the dependency chain
		if ($exists)
		{
			$includeFiles = require $files;

			foreach ($includeFiles AS $fileIdentifier => $file)
			{
				if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier]))
				{
					require $file;

					$GLOBALS['__composer_autoload_files'][$fileIdentifier] = true;
				}
			}
		}
	}

	protected function getPathForError($path)
	{
		return \XF\Util\File::stripRootPathPrefix($path);
	}
}