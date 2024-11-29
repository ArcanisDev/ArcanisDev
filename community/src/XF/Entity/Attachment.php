<?php

namespace XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int|null $attachment_id
 * @property int $data_id
 * @property string $content_type
 * @property int $content_id
 * @property int $attach_date
 * @property string $temp_hash
 * @property bool $unassociated
 * @property int $view_count
 *
 * GETTERS
 * @property Entity|null $Container
 * @property \XF\Attachment\AbstractHandler|null $handler
 * @property string $filename
 * @property string $extension
 * @property int $file_size
 * @property bool $has_thumbnail
 * @property string $thumbnail_url
 * @property mixed $thumbnail_url_full
 * @property bool $is_video
 * @property bool $is_audio
 * @property mixed $icon
 * @property string $direct_url
 * @property string $type_grouping
 * @property int|null $width
 * @property int|null $height
 * @property int|null $thumbnail_width
 * @property int|null $thumbnail_height
 *
 * RELATIONS
 * @property \XF\Entity\AttachmentData $Data
 */
class Attachment extends Entity
{
	public function canView(&$error = null)
	{
		if ($this->temp_hash || !$this->content_type)
		{
			return false;
		}

		/** @var \XF\Repository\Attachment $attachmentRepo */
		$attachmentRepo = $this->repository('XF:Attachment');
		$handler = $attachmentRepo->getAttachmentHandler($this->content_type);
		if (!$handler)
		{
			return false;
		}

		$container = $handler->getContainerEntity($this->content_id);
		if (!$container)
		{
			return false;
		}

		return $handler->canView($this, $container, $error);
	}

	/**
	 * @return string
	 */
	public function getFilename()
	{
		return $this->Data ? $this->Data->filename : '';
	}

	/**
	 * @return string
	 */
	public function getExtension()
	{
		return $this->Data ? $this->Data->extension : '';
	}

	/**
	 * @return int
	 */
	public function getFileSize()
	{
		return $this->Data ? $this->Data->file_size : 0;
	}

	public function getIcon()
	{
		return $this->app()->data('XF:FileType')->getIcon($this->getExtension());
	}

	/**
	 * @return bool
	 */
	public function hasThumbnail()
	{
		return $this->Data ? $this->Data->hasThumbnail() : false;
	}

	/**
	 * @return int|null
	 */
	public function getWidth()
	{
		return $this->Data ? $this->Data->width : null;
	}

	/**
	 * @return int|null
	 */
	public function getHeight()
	{
		return $this->Data ? $this->Data->height : null;
	}

	/**
	 * @return int|null
	 */
	public function getThumbnailWidth()
	{
		return $this->hasThumbnail() ? $this->Data->thumbnail_width : null;
	}

	/**
	 * @return int|null
	 */
	public function getThumbnailHeight()
	{
		return $this->hasThumbnail() ? $this->Data->thumbnail_height : null;
	}

	/**
	 * @return string
	 */
	public function getThumbnailUrl()
	{
		return $this->Data ? $this->Data->getThumbnailUrl() : '';
	}

	public function getThumbnailUrlFull()
	{
		return $this->Data ? $this->Data->getThumbnailUrl(true) : '';
	}

	/**
	 * @return bool
	 */
	public function isVideo(): bool
	{
		return $this->Data ? $this->Data->isVideo() : false;
	}

	/**
	 * @return bool
	 */
	public function isAudio(): bool
	{
		return $this->Data ? $this->Data->isAudio() : false;
	}

	/**
	 * @return string
	 */
	public function getTypeGrouping(): string
	{
		return $this->Data ? $this->Data->getTypeGrouping() : 'file';
	}

	/**
	 * @param bool $canonical
	 *
	 * @return string
	 */
	public function getDirectUrl(bool $canonical = false): string
	{
		if ($this->Data)
		{
			$url = $this->Data->getPublicUrl($canonical);
			if ($url && ($this->temp_hash || $this->canView()))
			{
				return $url;
			}
		}

		return $this->app()->router('public')->buildLink(
			$canonical ? 'canonical:attachments' : 'attachments',
			$this,
			['hash' => $this->temp_hash ?: null]
		);
	}

	public function getContainerLink()
	{
		$handler = $this->handler;
		$container = $this->Container;

		if ($handler && $container)
		{
			return $handler->getContainerLink($container);
		}

		return null;
	}

	public function getContainerTitle()
	{
		$handler = $this->handler;
		$container = $this->Container;

		if ($handler && $container)
		{
			return $handler->getContainerTitle($container);
		}

		return '';
	}

	public function getContentTypePhrase()
	{
		$handler = $this->handler;
		return $handler ? $handler->getContentTypePhrase() : null;
	}

	/**
	 * @return \XF\Attachment\AbstractHandler|null
	 */
	public function getHandler()
	{
		return $this->getAttachmentRepo()->getAttachmentHandler($this->content_type);
	}

	/**
	 * @return Entity|null
	 */
	public function getContainer()
	{
		$handler = $this->handler;
		return $handler ? $handler->getContainerEntity($this->content_id) : null;
	}

	public function setContainer(Entity $content = null)
	{
		$this->_getterCache['Container'] = $content;
	}

	/**
	 * @return Attachment
	 */
	public function createDuplicate()
	{
		$attachment = $this->_em->create('XF:Attachment');
		$attachment->data_id = $this->data_id;
		$attachment->attach_date = $this->attach_date;
		$attachment->temp_hash = $this->temp_hash;
		$attachment->unassociated = $this->unassociated;

		return $attachment;
	}

	protected function _preSave()
	{
		if (!$this->content_id)
		{
			if (!$this->temp_hash && empty($this->_errors['temp_hash']))
			{
				throw new \LogicException('Temp hash must be specified if no content is specified.');
			}
			// If we have an error related to the temp hash, we probably triggered an error
			// when setting it (rather than not trying to set it), so defer to that error.

			$this->unassociated = true;
		}
		else
		{
			$this->temp_hash = '';
			$this->unassociated = false;
		}
	}

	protected function _postSave()
	{
		if ($this->isInsert())
		{
			/** @var AttachmentData $data */
			$data = $this->Data;
			if ($data)
			{
				$data->fastUpdate('attach_count', $data->attach_count + 1);
			}
		}
	}

	protected function _preDelete()
	{
		if ($this->content_id)
		{
			/** @var \XF\Repository\Attachment $attachmentRepo */
			$attachmentRepo = $this->repository('XF:Attachment');
			$handler = $attachmentRepo->getAttachmentHandler($this->content_type);
			if ($handler)
			{
				$container = $handler->getContainerEntity($this->content_id);
				$handler->beforeAttachmentDelete($this, $container);
			}
		}
	}

	protected function _postDelete()
	{
		/** @var AttachmentData $data */
		$data = $this->Data;
		if ($data && $data->attach_count)
		{
			$data->fastUpdate('attach_count', $data->attach_count - 1);
		}

		if ($this->content_id)
		{
			/** @var \XF\Repository\Attachment $attachmentRepo */
			$attachmentRepo = $this->repository('XF:Attachment');
			$handler = $attachmentRepo->getAttachmentHandler($this->content_type);
			if ($handler)
			{
				$container = $handler->getContainerEntity($this->content_id);
				$handler->onAttachmentDelete($this, $container);
			}
		}
	}

	/**
	 * @param \XF\Api\Result\EntityResult $result
	 * @param int $verbosity
	 * @param array $options
	 *
	 * @api-out str $filename
	 * @api-out int $file_size
	 * @api-out int $height
	 * @api-out int $width
	 * @api-out str $thumbnail_url
	 * @api-out str $direct_url
	 * @api-out bool $is_video
	 * @api-out bool $is_audio
	 */
	protected function setupApiResultData(
		\XF\Api\Result\EntityResult $result, $verbosity = self::VERBOSITY_NORMAL, array $options = []
	)
	{
		$result->filename = $this->filename;
		$result->file_size = $this->file_size;
		$result->height = $this->Data->height;
		$result->width = $this->Data->width;
		$result->is_video = $this->is_video;
		$result->is_audio = $this->is_audio;

		if ($this->has_thumbnail)
		{
			$result->thumbnail_url = $this->Data->getThumbnailUrl(true);
		}

		$result->direct_url = $this->getDirectUrl(true);
	}

	public static function getStructure(Structure $structure)
	{
		$structure->table = 'xf_attachment';
		$structure->shortName = 'XF:Attachment';
		$structure->primaryKey = 'attachment_id';
		$structure->columns = [
			'attachment_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true],
			'data_id' => ['type' => self::UINT, 'required' => true],
			'content_type' => ['type' => self::STR, 'maxLength' => 25, 'default' => '', 'api' => true],
			'content_id' => ['type' => self::UINT, 'default' => 0, 'api' => true],
			'attach_date' => ['type' => self::UINT, 'default' => \XF::$time, 'api' => true],
			'temp_hash' => ['type' => self::STR, 'maxLength' => 32, 'default' => ''],
			'unassociated' => ['type' => self::BOOL, 'default' => true],
			'view_count' => ['type' => self::UINT, 'forced' => true, 'default' => 0, 'api' => true]
		];
		$structure->getters = [
			'Container' => true,
			'handler' => true,

			'filename' => ['getter' => 'getFilename', 'cache' => false],
			'extension' => ['getter' => 'getExtension', 'cache' => false],
			'file_size' => ['getter' => 'getFileSize', 'cache' => false],
			'has_thumbnail' => ['getter' => 'hasThumbnail', 'cache' => false],
			'thumbnail_url' => ['getter' => 'getThumbnailUrl', 'cache' => false],
			'thumbnail_url_full' => ['getter' => 'getThumbnailUrlFull', 'cache' => false],
			'is_video' => ['getter' => 'isVideo', 'cache' => false],
			'is_audio' => ['getter' => 'isAudio', 'cache' => false],
			'icon' => ['getter' => 'getIcon', 'cache' => false],
			'direct_url' => ['getter' => 'getDirectUrl', 'cache' => false],
			'type_grouping' => ['getter' => 'getTypeGrouping', 'cache' => false],

			'width' => ['getter' => 'getWidth', 'cache' => false],
			'height' => ['getter' => 'getHeight', 'cache' => false],
			'thumbnail_width' => ['getter' => 'getThumbnailWidth', 'cache' => false],
			'thumbnail_height' => ['getter' => 'getThumbnailHeight', 'cache' => false],
		];
		$structure->relations = [
			'Data' => [
				'entity' => 'XF:AttachmentData',
				'type' => self::TO_ONE,
				'conditions' => 'data_id',
				'primary' => true
			],
		];
		$structure->defaultWith = ['Data'];
		$structure->withAliases = [
			'api' => [],
			'embed' => []
		];

		return $structure;
	}

	/**
	 * @return \XF\Repository\Attachment
	 */
	protected function getAttachmentRepo()
	{
		return $this->repository('XF:Attachment');
	}
}
