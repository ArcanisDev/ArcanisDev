<?php

namespace XF\Data;

class FileType
{
	const WORD = 'word';
	const POWERPOINT = 'powerpoint';
	const PDF = 'pdf';
	const MUSIC = 'music';
	const AUDIO = 'audio';
	const CODE = 'code';
	const ARCHIVE = 'archive';
	const EXCEL = 'excel';
	const CSV = 'csv';
	const TSV = 'spreadsheet';
	const VIDEO = 'video';
	const IMAGE = 'image';
	const DOWNLOAD = 'download';
	const TEXT = 'alt'; // because FA doesn't have `fa-file-text`

	public function getExtensionMap(): array
	{
		return [
			'7z' => self::ARCHIVE,
			'aac' => self::MUSIC,
			'afdesign' => self::IMAGE,
			'afphoto' => self::IMAGE,
			'ai' => self::IMAGE,
			'aif' => self::AUDIO,
			'avi' => self::VIDEO,
			'bat' => self::CODE,
			'bmp' => self::IMAGE,
			'c' => self::CODE,
			'cnf' => self::CODE,
			'conf' => self::CODE,
			'cpp' => self::CODE,
			'cs' => self::CODE,
			'css' => self::CODE,
			'csv' => self::CSV,
			'diff' => self::TEXT,
			'doc' => self::WORD,
			'docx' => self::WORD,
			'dot' => self::WORD,
			'dotx' => self::WORD,
			'eps' => self::IMAGE,
			'fla' => self::MUSIC,
			'flac' => self::MUSIC,
			'flv' => self::VIDEO,
			'gif' => self::IMAGE,
			'gz' => self::ARCHIVE,
			'h' => self::CODE,
			'htm' => self::CODE,
			'html' => self::CODE,
			'iff' => self::IMAGE,
			'ini' => self::CODE,
			'java' => self::CODE,
			'jpe' => self::IMAGE,
			'jpeg' => self::IMAGE,
			'jpg' => self::IMAGE,
			'js' => self::CODE,
			'json' => self::CODE,
			'less' => self::CODE,
			'lha' => self::ARCHIVE,
			'log' => self::TEXT,
			'm' => self::CODE,
			'm4a' => self::MUSIC,
			'm4v' => self::VIDEO,
			'mid' => self::MUSIC,
			'midi' => self::MUSIC,
			'mkv' => self::VIDEO,
			'mov' => self::VIDEO,
			'mp3' => self::MUSIC,
			'mp4' => self::VIDEO,
			'mpeg' => self::VIDEO,
			'mpg' => self::VIDEO,
			'ogg' => self::MUSIC,
			'part' => self::DOWNLOAD,
			'patch' => self::TEXT,
			'pdf' => self::PDF,
			'php' => self::CODE,
			'pkg' => self::ARCHIVE,
			'pl' => self::CODE,
			'png' => self::IMAGE,
			'pps' => self::POWERPOINT,
			'ppsx' => self::POWERPOINT,
			'ppt' => self::POWERPOINT,
			'pptx' => self::POWERPOINT,
			'psd' => self::IMAGE,
			'py' => self::CODE,
			'rar' => self::ARCHIVE,
			'rtf' => self::TEXT,
			'sh' => self::CODE,
			'spreadsheet' => self::TSV,
			'sql' => self::CODE,
			'svg' => self::IMAGE,
			'swift' => self::CODE,
			'tar' => self::ARCHIVE,
			'tga' => self::IMAGE,
			'tgz' => self::ARCHIVE,
			'tif' => self::IMAGE,
			'tiff' => self::IMAGE,
			'torrent' => self::DOWNLOAD,
			'txt' => self::TEXT,
			'vb' => self::CODE,
			'vob' => self::VIDEO,
			'wav' => self::AUDIO,
			'wma' => self::MUSIC,
			'wmv' => self::VIDEO,
			'xls' => self::EXCEL,
			'xlsx' => self::EXCEL,
			'xlt' => self::EXCEL,
			'xltx' => self::EXCEL,
			'xml' => self::CODE,
			'zip' => self::ARCHIVE,
		];
	}

	/**
	 * @param string $extension
	 *
	 * @return string
	 */
	public function getFileType(string $extension)
	{
		$extension = strtolower($extension);
		$map = $this->getExtensionMap();

		return $map[$extension] ?? '';
	}

	/**
	 * Get a FontAwesome icon (name) for the given file extension
	 *
	 * @param string $extension
	 *
	 * @return string
	 */
	public function getIcon(string $extension): string
	{
		$icon = 'fa-file';

		if ($type = $this->getFileType($extension))
		{
			$icon .= '-' . $type;
		}

		return $icon;
	}
}