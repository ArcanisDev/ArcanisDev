<?php

namespace XF\Service\Attachment;

use XF\Util\File;

class Preparer extends \XF\Service\AbstractService
{
	/**
	 * @var string
	 */
	const INLINE_VIDEO_PATH = 'data://video/%FLOOR%/%DATA_ID%-%HASH%.%EXTENSION%';

	/**
	 * @var string
	 */
	const INLINE_AUDIO_PATH = 'data://audio/%FLOOR%/%DATA_ID%-%HASH%.%EXTENSION%';

	public function insertAttachment(
		\XF\Attachment\AbstractHandler $handler, \XF\FileWrapper $file, \XF\Entity\User $user, $hash
	)
	{
		$extra = [];

		$extension = strtolower($file->getExtension());

		if (File::isVideoInlineDisplaySafe($extension))
		{
			$extra['file_path'] = strtr(static::INLINE_VIDEO_PATH, ['%EXTENSION%' => $extension]);
		}
		else if (File::isAudioInlineDisplaySafe($extension))
		{
			$extra['file_path'] = strtr(static::INLINE_AUDIO_PATH, ['%EXTENSION%' => $extension]);
		}

		$handler->beforeNewAttachment($file, $extra);

		$data = $this->insertDataFromFile($file, $user->user_id, $extra);
		return $this->insertTemporaryAttachment($handler, $data, $hash, $file);
	}

	public function insertDataFromFile(\XF\FileWrapper $file, $userId, array $extra = [])
	{
		$data = $this->setupDataInsertFromFile($file, $userId, $extra);
		if (!$data->preSave())
		{
			throw new \XF\PrintableException($data->getErrors());
		}

		$sourceFile = $file->getFilePath();
		$width = $data->width;
		$height = $data->height;

		if ($width && $height && $this->app->imageManager()->canResize($width, $height))
		{
			$tempThumbFile = $this->generateAttachmentThumbnail($sourceFile, $thumbWidth, $thumbHeight);
			if ($tempThumbFile)
			{
				$data->set('thumbnail_width', $thumbWidth, ['forceSet' => true]);
				$data->set('thumbnail_height', $thumbHeight, ['forceSet' => true]);
			}
		}
		else
		{
			$tempThumbFile = null;
		}

		$this->db()->beginTransaction();

		$data->save(true, false);

		$dataPath = $data->getAbstractedDataPath();
		$thumbnailPath = $data->getAbstractedThumbnailPath();

		// if one of the writes fail, remove the data record
		try
		{
			\XF\Util\File::copyFileToAbstractedPath($sourceFile, $dataPath);

			if ($tempThumbFile)
			{
				\XF\Util\File::copyFileToAbstractedPath($tempThumbFile, $thumbnailPath);
			}
		}
		catch (\Exception $e)
		{
			$this->db()->rollback();
			$this->app->em()->detachEntity($data);

			\XF\Util\File::deleteFromAbstractedPath($dataPath);

			if ($tempThumbFile)
			{
				\XF\Util\File::deleteFromAbstractedPath($thumbnailPath);
				@unlink($tempThumbFile);
			}

			throw $e;
		}

		$this->db()->commit();

		return $data;
	}

	/**
	 * @param \XF\FileWrapper $file
	 * @param int             $userId
	 * @param array           $extra
	 *
	 * @return \XF\Entity\AttachmentData
	 */
	protected function setupDataInsertFromFile(
		\XF\FileWrapper $file,
		$userId,
		array $extra = []
	)
	{
		$extra = array_replace([
			'file_path' => '',
			'upload_date' => null
		], $extra);

		/** @var \XF\Entity\AttachmentData $data */
		$data = $this->app->em()->create('XF:AttachmentData');
		$data->user_id = $userId;
		$data->set('filename', $file->getFileName(), ['forceConstraint' => true]);
		$data->file_size = $file->getFileSize();
		$data->file_hash = md5_file($file->getFilePath());
		$data->file_path = $extra['file_path'];
		$data->width = $file->getImageWidth();
		$data->height = $file->getImageHeight();

		if ($extra['upload_date'])
		{
			$data->upload_date = $extra['upload_date'];
		}

		return $data;
	}

	public function updateDataFromFile(\XF\Entity\AttachmentData $data, \XF\FileWrapper $file, array $extra = [])
	{
		$this->setupDataUpdateFromFile($data, $file, $extra);
		if (!$data->preSave())
		{
			throw new \XF\PrintableException($data->getErrors());
		}

		$sourceFile = $file->getFilePath();
		$width = $data->width;
		$height = $data->height;

		$tempThumbFile = false;
		if ($data->isChanged('file_hash'))
		{
			if ($width && $height && $this->app->imageManager()->canResize($width, $height))
			{
				$tempThumbFile = $this->generateAttachmentThumbnail($sourceFile, $thumbWidth, $thumbHeight);
				if ($tempThumbFile)
				{
					$data->set('thumbnail_width', $thumbWidth, ['forceSet' => true]);
					$data->set('thumbnail_height', $thumbHeight, ['forceSet' => true]);
				}
			}
		}

		$this->db()->beginTransaction();

		$previousDataPath = null;
		$previousThumbnailPath = null;

		$fileIsChanged = $data->isChanged(['file_hash', 'file_path']);
		if ($fileIsChanged)
		{
			$previousDataPath = $data->getExistingAbstractedDataPath();
			$previousThumbnailPath = $data->getExistingAbstractedThumbnailPath();
		}

		$data->saveIfChanged($dataChanged, true, false);

		if ($fileIsChanged && $dataChanged)
		{
			$dataPath = $data->getAbstractedDataPath();
			$thumbnailPath = $data->getAbstractedThumbnailPath();

			try
			{
				File::copyFileToAbstractedPath($sourceFile, $dataPath);

				if ($tempThumbFile)
				{
					File::copyFileToAbstractedPath($tempThumbFile, $thumbnailPath);
				}
			}
			catch (\Exception $e)
			{
				$this->db()->rollback();
				$this->app->em()->detachEntity($data);

				throw $e;
			}

			File::deleteFromAbstractedPath($previousDataPath);
			File::deleteFromAbstractedPath($previousThumbnailPath);
		}

		$this->db()->commit();

		return $data;
	}

	/**
	 * @param \XF\Entity\AttachmentData $data
	 * @param \XF\FileWrapper           $file
	 * @param array                     $extra
	 */
	protected function setupDataUpdateFromFile(
		\XF\Entity\AttachmentData $data,
		\XF\FileWrapper $file,
		array $extra = []
	)
	{
		$data->file_size = $file->getFileSize();
		$data->file_hash = md5_file($file->getFilePath());
		$data->width = $file->getImageWidth();
		$data->height = $file->getImageHeight();

		if (isset($extra['file_path']))
		{
			$data->file_path = $extra['file_path'];
		}
	}

	public function generateAttachmentThumbnail($sourceFile, &$width = null, &$height = null)
	{
		$image = $this->app->imageManager()->imageFromFile($sourceFile);
		if (!$image)
		{
			return null;
		}

		// Core thumbnails will always be the size.
		// Content specific thumbs can be generated by handlers using onAttachment.
		$thumbSize = $this->app->options()->attachmentThumbnailDimensions;

		// XF 2.2 - we will be showing square previews, so optimise for the short side
		$image->resizeShortEdge($thumbSize);

		$newTempFile = File::getTempFile();
		if ($newTempFile && $image->save($newTempFile))
		{
			$width = $image->getWidth();
			$height = $image->getHeight();

			return $newTempFile;
		}
		else
		{
			return null;
		}
	}

	public function insertTemporaryAttachment(
		\XF\Attachment\AbstractHandler $handler,
		\XF\Entity\AttachmentData $data,
		$tempHash,
		\XF\FileWrapper $file
	)
	{
		/** @var \XF\Entity\Attachment $attachment */
		$attachment = $this->app->em()->create('XF:Attachment');

		$attachment->data_id = $data->data_id;
		$attachment->content_type = $handler->getContentType();
		$attachment->temp_hash = $tempHash;
		$attachment->save();

		$handler->onNewAttachment($attachment, $file);

		return $attachment;
	}

	public function associateAttachmentsWithContent($tempHash, $contentType, $contentId)
	{
		$associated = 0;

		$attachmentFinder = $this->finder('XF:Attachment')
			->where('temp_hash', $tempHash);

		/** @var \XF\Entity\Attachment $attachment */
		foreach ($attachmentFinder->fetch() AS $attachment)
		{
			$attachment->content_type = $contentType;
			$attachment->content_id = $contentId;
			$attachment->temp_hash = '';
			$attachment->unassociated = 0;

			$attachment->save();

			$container = $attachment->getContainer();
			$attachment->getHandler()->onAssociation($attachment, $container);

			$associated++;
		}

		return $associated;
	}
}