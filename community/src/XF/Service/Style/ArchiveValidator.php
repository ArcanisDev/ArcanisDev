<?php

namespace XF\Service\Style;

use XF\Service\AbstractService;
use XF\Util\File;

use function count, in_array;

class ArchiveValidator extends AbstractService
{
	protected $filePath;
	protected $archiveAction;

	/**
	 * @var array|null
	 */
	protected $knownFileHashes;

	// all paths in lower case
	const DIR_BLACKLIST = [
		'data',
		'install',
		'internal_data',
		'library',
		'src',

		'js/vendor',
		'js/xf',
		'js/xf*',
		'styles/default/xenforo',
		'styles/default/xf*',
		'styles/fonts/fa'
	];

	// all extensions in lower case
	const EXTENSION_WHITELIST = [
		'avi', 'eot', 'gif',
		'html', 'ico', 'jpg',
		'jpeg', 'jpe', 'js',
		'json', 'map', 'md',
		'mov', 'mp4', 'png',
		'svg', 'ttf', 'txt',
		'woff', 'woff2', 'zip'
	];

	public function __construct(\XF\App $app, string $filePath, string $archiveAction)
	{
		parent::__construct($app);

		if (!file_exists($filePath) || !is_dir($filePath))
		{
			throw new \InvalidArgumentException("Invalid file path passed in ($filePath)");
		}

		$this->filePath = $filePath;

		switch ($archiveAction)
		{
			case 'import':
			case 'export':
				break;
			default:
				throw new \InvalidArgumentException('Only archive actions of \'import\' or \'export\' are valid.');
		}
		$this->archiveAction = $archiveAction;
	}

	public function validate(&$errors = []): bool
	{
		$errors = [];

		$rootPath = $this->filePath;

		$files = File::getRecursiveDirectoryIterator($rootPath);
		foreach ($files AS $file)
		{
			if ($file->isDir())
			{
				continue;
			}

			$pathname = $file->getPathname();
			$basename = $file->getBasename();

			if ($basename === '' || $basename === false || $basename === null)
			{
				continue;
			}

			if ($basename == '.DS_Store')
			{
				// skip this but no error
				continue;
			}

			if ($basename[0] == '.' && $basename != '.htaccess')
			{
				if (!isset($errors['dot_file']))
				{
					$errors['dot_file'] = \XF::phrase('one_or_more_files_in_style_archive_disallowed_dot_files');
				}
				continue;
			}

			$stdPath = File::stripRootPathPrefix($pathname, $rootPath);
			$stdPath = $this->standardizePathForValidation($stdPath);

			if ($this->isFileInRootDirectory($stdPath))
			{
				if (!isset($errors['root_dir']))
				{
					$errors['root_dir'] = \XF::phrase('one_or_more_files_in_style_archive_contained_within_root');
				}
				continue;
			}

			if ($this->isFileInBlacklistedDirectory($stdPath))
			{
				if (!isset($errors['blacklisted_dir']))
				{
					$errors['blacklisted_dir'] = \XF::phrase('one_or_more_files_in_style_archive_within_unsupported_directory_x', ['disallowed' => implode(', ', self::DIR_BLACKLIST)]);
				}
				continue;
			}

			$extension = $file->getExtension();
			if (!$this->isFileWithWhitelistedExtension($extension))
			{
				if (!isset($errors['whitelisted_ext']))
				{
					$errors['whitelisted_ext'] = \XF::phrase('one_or_more_files_do_not_have_allowed_extension_x', ['allowed' => implode(', ', self::EXTENSION_WHITELIST)]);
				}
				continue;
			}

			if ($this->isCoreFile($stdPath))
			{
				if (!isset($errors['core_file']))
				{
					$errors['core_file'] = \XF::phrase('one_or_more_files_not_permitted_as_they_belong_to_xenforo_or_add_on');
				}
				continue;
			}
		}

		return count($errors) == 0;
	}

	protected function standardizePathForValidation(string $path): string
	{
		// standardize on forward slashes for paths only
		$path = str_replace('\\', '/', $path);

		// avoid case sensitivity issues (as FS settings may vary)
		$path = strtolower($path);

		return $path;
	}

	protected function isFileInRootDirectory(string $path): bool
	{
		return strpos($path, '/') === false;
	}

	protected function isFileInBlacklistedDirectory(string $path): bool
	{
		foreach (self::DIR_BLACKLIST AS $dir)
		{
			$suffix = '/';
			if (substr($dir, -1) === '*')
			{
				$suffix = '';
				$dir = rtrim($dir, '*');
			}

			if (strpos($path, $dir . $suffix) === 0)
			{
				return true;
			}
		}

		return false;
	}

	protected function isFileWithWhitelistedExtension(string $extension): bool
	{
		return (
			$extension === ''
			|| in_array(strtolower($extension), self::EXTENSION_WHITELIST)
		);
	}

	protected function isCoreFile(string $path): bool
	{
		switch ($path)
		{
			case '.htaccess':
			case 'htaccess.txt':
				// core files that shouldn't be overwritten, as people may change them manually
				return true;
		}

		$hashes = $this->getKnownFileHashes();
		return isset($hashes[$path]);
	}

	protected function getKnownFileHashes()
	{
		if ($this->knownFileHashes === null)
		{
			$jsonPath = \XF::getAddOnDirectory() . \XF::$DS . 'XF' . \XF::$DS . 'hashes.json';
			if (file_exists($jsonPath))
			{
				$hashes = json_decode(file_get_contents($jsonPath), true);
			}
			else
			{
				$hashes = [];
			}

			$addOns = $this->app->addOnManager()->getAllAddOns();
			foreach ($addOns AS $addOn)
			{
				$path = $addOn->getHashesPath();
				if ($path && file_exists($path))
				{
					$decodedHashes = json_decode(file_get_contents($path), true) ?? [];
					$hashes += $decodedHashes;
				}
			}

			$this->knownFileHashes = $hashes;
		}

		return $this->knownFileHashes;
	}
}