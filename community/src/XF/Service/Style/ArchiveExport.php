<?php

namespace XF\Service\Style;

use League\Flysystem\FileNotFoundException;
use XF\Entity\Style;
use XF\PrintableException;
use XF\Service\AbstractService;
use XF\Util\File;

use function strlen;

class ArchiveExport extends AbstractService
{
	const UPLOAD_DIR = 'upload';
	const XML_FILE_NAME = 'style.xml';

	/**
	 * @var Style
	 */
	protected $style;

	/**
	 * @var \XF\Entity\AddOn|null
	 */
	protected $addOn;

	/**
	 * @var Export
	 */
	protected $xmlExporter;

	/**
	 * @var bool
	 */
	protected $independent = false;

	public function __construct(\XF\App $app, Style $style)
	{
		parent::__construct($app);

		$this->style = $style;
		$this->xmlExporter = $this->service('XF:Style\Export', $style);
	}

	public function getStyle(): Style
	{
		return $this->style;
	}

	public function setAddOn(\XF\Entity\AddOn $addOn = null)
	{
		$this->addOn = $addOn;
		$this->xmlExporter->setAddOn($addOn);
	}

	public function getAddOn()
	{
		return $this->addOn;
	}

	public function setIndependent(bool $independent)
	{
		$this->independent = $independent;
		$this->xmlExporter->setIndependent($independent);
	}

	public function getIndependent(): bool
	{
		return $this->independent;
	}

	protected function prepareFilesToCopy(string $buildRoot)
	{
		$assets = $this->getExportableAssets();
		if (!$assets)
		{
			return;
		}

		$uploadRoot = $buildRoot . \XF::$DS . self::UPLOAD_DIR;
		File::createDirectory($uploadRoot, false);

		$ds = \XF::$DS;
		$rootPath = \XF::getRootDirectory();

		foreach ($assets AS $key => $path)
		{
			if (preg_match('#^(https?://|/|\\\\)#i', $path))
			{
				continue;
			}

			if ($path === '')
			{
				continue;
			}

			if (strpos($path, 'data://') === 0)
			{
				$fs = $this->app->fs();

				try
				{
					$metadata = $fs->getMetadata($path);
				}
				catch (FileNotFoundException $e)
				{
					throw new PrintableException(\XF::phrase('file_or_directory_not_found_at_path_x', ['path' => $path]));
				}

				if (!$metadata)
				{
					continue;
				}

				if ($metadata['type'] == 'dir')
				{
					$contents = $fs->listContents($path, true);

					foreach ($contents AS $file)
					{
						if ($file['type'] == 'dir')
						{
							continue;
						}

						$abstractedPath = 'data://' . $file['path'];

						$filePath = File::copyAbstractedPathToTempFile($abstractedPath);
						$stdPath = $this->stripDataStylesPathPrefix($abstractedPath);
						File::copyFile($filePath, $uploadRoot . $ds . $stdPath, false);
					}
				}
				else
				{
					$filePath = File::copyAbstractedPathToTempFile($path);
					$stdPath = $this->stripDataStylesPathPrefix($path);
					File::copyFile($filePath, $uploadRoot . $ds . $stdPath, false);
				}

				$newAssetPath = $this->stripDataStylesPathPrefix($path);
				if ($newAssetPath !== $path)
				{
					$this->xmlExporter->addChangedAsset($key, $newAssetPath);
				}
			}
			else
			{
				$filePath = $rootPath . $ds . $path;

				if (!file_exists($filePath))
				{
					throw new PrintableException(\XF::phrase('file_or_directory_not_found_at_path_x', ['path' => $path]));
				}

				if (is_dir($filePath))
				{
					$files = File::getRecursiveDirectoryIterator($filePath);
					foreach ($files AS $file)
					{
						$stdPath = File::stripRootPathPrefix($file->getPathname(), $rootPath);
						if (!$file->isDir())
						{
							File::copyFile($file->getPathname(), $uploadRoot . $ds . $stdPath, false);
						}
					}
				}
				else
				{
					$stdPath = File::stripRootPathPrefix($filePath, $rootPath);
					File::copyFile($filePath, $uploadRoot . $ds . $stdPath, false);
				}
			}
		}
	}

	protected function validateContents(string $buildRoot, &$errors = []): bool
	{
		$uploadRoot = $buildRoot . \XF::$DS . self::UPLOAD_DIR;
		if (!file_exists($uploadRoot))
		{
			return true;
		}

		/** @var \XF\Service\Style\ArchiveValidator $validator */
		$validator = $this->service('XF:Style\ArchiveValidator', $uploadRoot, 'export');
		return $validator->validate($errors);
	}

	protected function stripDataStylesPathPrefix(string $abstractedPath): string
	{
		return $this->xmlExporter->stripDataStylesPathPrefix($abstractedPath);
	}

	protected function getExportableAssets(): array
	{
		$style = $this->style;

		if ($this->independent)
		{
			return $style->effective_assets;
		}
		else
		{
			return $style->assets;
		}
	}

	/**
	 * @return string Temp path to zip file (file will be deleted at end of request)
	 *
	 * @throws PrintableException
	 */
	public function build()
	{
		$buildRoot = File::createTempDir();

		$this->prepareFilesToCopy($buildRoot);

		if (!$this->validateContents($buildRoot, $errors))
		{
			throw new PrintableException($errors);
		}

		$zipTargetFile = File::getTempFile();
		$zipArchive = $this->initializeZipFile($zipTargetFile);

		File::writeFile(
			$buildRoot . \XF::$DS . self::XML_FILE_NAME,
			$this->xmlExporter->exportToXml()->saveXML()
		);

		$buildIterator = File::getRecursiveDirectoryIterator($buildRoot);
		foreach ($buildIterator AS $file)
		{
			// skip hidden dot files, e.g. .DS_Store, .gitignore etc.
			if ($this->isExcludedFileName($file->getBasename()))
			{
				continue;
			}

			$localName = str_replace('\\', '/', substr($file->getPathname(), strlen($buildRoot) + 1));

			if ($file->isDir())
			{
				$localName .= '/';
				$zipArchive->addEmptyDir($localName);
				$perm = 040755 << 16; // dir: 0755
			}
			else
			{
				$zipArchive->addFile($file->getPathname(), $localName);
				$perm = 0100644 << 16; // file: 0644
			}

			if (method_exists($zipArchive, 'setExternalAttributesName'))
			{
				$zipArchive->setExternalAttributesName($localName, \ZipArchive::OPSYS_UNIX, $perm);
			}
		}

		if (!$zipArchive->close())
		{
			throw new PrintableException($zipArchive->getStatusString());
		}

		return $zipTargetFile;
	}

	/**
	 * @param string $targetFile
	 *
	 * @return \ZipArchive
	 */
	protected function initializeZipFile(string $targetFile): \ZipArchive
	{
		$zipArchive = new \ZipArchive();
		if (($error = $zipArchive->open($targetFile, \ZipArchive::OVERWRITE)) !== true)
		{
			throw new \RuntimeException(sprintf("Unable to create zip archive, error %d", $error));
		}

		return $zipArchive;
	}

	protected function isExcludedFileName($fileName): bool
	{
		if ($fileName === '' || $fileName === false || $fileName === null)
		{
			return true;
		}

		if ($fileName[0] == '.' && $fileName != '.htaccess')
		{
			return true;
		}

		return false;
	}

	public function getArchiveFileName(): string
	{
		$styleFileName = $this->xmlExporter->getExportFileName();
		return preg_replace('/\.xml$/', '.zip', $styleFileName);
	}
}