<?php

namespace XF\Service\Style;

use XF\Service\AbstractService;
use XF\Util\File;

use function strlen, strval;

class ArchiveImport extends AbstractService
{
	protected $fileName;

	protected $tempDir;

	protected $rewriteAssetPaths = true;

	protected $extracted = false;

	/**
	 * @var \ZipArchive|null
	 */
	protected $_zip;

	public function __construct(\XF\App $app, $fileName)
	{
		parent::__construct($app);

		$this->fileName = $fileName;
		$this->tempDir = File::createTempDir();
	}

	public function getRewriteAssetPaths(): bool
	{
		return $this->rewriteAssetPaths;
	}

	public function setRewriteAssetPaths(bool $rewriteAssetPaths)
	{
		$this->rewriteAssetPaths = $rewriteAssetPaths;
	}

	public function validateArchive(&$errors = []): bool
	{
		if (!$this->_zip)
		{
			$zip = new \ZipArchive();
			$openResult = $zip->open($this->fileName);
			if ($openResult !== true)
			{
				$errors[] = \XF::phrase('file_could_not_be_opened_as_valid_style_archive_x', ['reason' => $openResult]);
				return false;
			}

			$styleXml = $zip->locateName($this->getXmlFileName());
			if ($styleXml === false)
			{
				$errors[] = \XF::phrase('file_is_not_valid_style_archive');
				return false;
			}

			$this->_zip = $zip;

			if (!$this->validateContents($errors))
			{
				return false;
			}
		}

		return true;
	}

	public function validateContents(&$errors = []): bool
	{
		$zip = $this->zip();
		if (!$zip)
		{
			return false;
		}

		$this->extractFilesToTempDir();

		/** @var \XF\Service\Style\ArchiveValidator $validator */
		$validator = $this->service('XF:Style\ArchiveValidator', $this->tempDir, 'import');
		return $validator->validate($errors);
	}

	protected function zip()
	{
		$this->validateArchive();
		return $this->_zip;
	}

	public function getXmlFile()
	{
		$zip = $this->zip();
		if (!$zip)
		{
			return false;
		}

		$styleXml = $zip->getFromName($this->getXmlFileName());
		if (!$styleXml)
		{
			return false;
		}

		$tempFile = File::getTempFile();
		if (!$tempFile)
		{
			return false;
		}

		$written = File::writeFile($tempFile, $styleXml);
		if (!$written)
		{
			return false;
		}

		return $tempFile;
	}

	protected function getXmlFileName(): string
	{
		return ArchiveExport::XML_FILE_NAME;
	}

	/**
	 * @param \XF\Entity\Style $style Style entity being imported
	 * @param array $assetPaths Asset paths to save back to the style after copying to FS
	 *
	 * @return array Final asset paths (may be moved by this method)
	 */
	public function copyAssetFiles(\XF\Entity\Style $style, array $assetPaths = []): array
	{
		$this->extractFilesToTempDir();

		$tempDir = $this->tempDir;
		$dataUriPrefix = "data://styles/{$style->style_id}/";

		$DS = \XF::$DS;
		$files = File::getRecursiveDirectoryIterator($tempDir);
		foreach ($files AS $file)
		{
			if ($file->isDir())
			{
				continue;
			}

			$pathname = $file->getPathname();
			$stdPath = File::stripRootPathPrefix($pathname, $tempDir);

			if (!$this->isWithinAssetPath($stdPath, $assetPaths))
			{
				continue;
			}

			if ($this->rewriteAssetPaths)
			{
				File::copyFileToAbstractedPath($pathname, $dataUriPrefix . $stdPath);
			}
			else
			{
				$newPathPrefix = \XF::getRootDirectory() . $DS;
				File::copyFile($pathname, $newPathPrefix . $stdPath);
			}
		}

		if ($this->rewriteAssetPaths)
		{
			foreach ($assetPaths AS &$path)
			{
				if (strval($path))
				{
					$path = $dataUriPrefix . $path;
				}
			}
		}

		return $assetPaths;
	}

	protected function isWithinAssetPath($filePath, array $assetPaths)
	{
		$filePath = str_replace('\\', '/', $filePath);

		foreach ($assetPaths AS $path)
		{
			if ($path && preg_match('#^' . preg_quote($path, '#') . '(/|$)#', $filePath))
			{
				return true;
			}
		}

		return false;
	}

	public function extractFilesToTempDir()
	{
		$zip = $this->zip();
		$DS = \XF::$DS;

		if ($this->extracted)
		{
			return;
		}

		for ($i = 0; $i < $zip->numFiles; $i++)
		{
			$zipFileName = $zip->getNameIndex($i);
			$fsFileName = $this->getFsFileNameFromZipName($zipFileName);
			if ($fsFileName === null)
			{
				continue;
			}

			$finalFileName = $this->tempDir . $DS . $fsFileName;

			$dataStream = $zip->getStream($zipFileName);
			@File::writeFile($finalFileName, $dataStream, false);
		}

		$this->extracted = true;
	}

	protected function getFsFileNameFromZipName($fileName)
	{
		if (substr($fileName, -1) === '/')
		{
			// this is a directory we can just skip this
			return null;
		}

		$uploadDir = ArchiveExport::UPLOAD_DIR . '/';

		if (!preg_match("#^" . preg_quote($uploadDir, '#') . ".#", $fileName))
		{
			// file outside of "upload" so we can just skip this
			return null;
		}

		return substr($fileName, strlen($uploadDir)); // remove upload dir prefix
	}
}