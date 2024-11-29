<?php

namespace XF\EditHistory;

use XF\Mvc\Entity\Entity;

use function get_class;

abstract class AbstractHandler
{
	protected $contentType;

	public function __construct($contentType)
	{
		$this->contentType = $contentType;
	}

	abstract public function canViewHistory(Entity $content);
	abstract public function canRevertContent(Entity $content);

	abstract public function getContentText(Entity $content);
	abstract public function getBreadcrumbs(Entity $content);

	abstract public function revertToVersion(Entity $content, \XF\Entity\EditHistory $history, \XF\Entity\EditHistory $previous = null);

	abstract public function getHtmlFormattedContent($text, Entity $content = null);

	public function getContentLink(Entity $content)
	{
		if ($content instanceof \XF\Entity\LinkableInterface)
		{
			return $content->getContentUrl();
		}

		throw new \LogicException(
			'Implement XF\Entity\LinkableInterface for ' . get_class($content)
			. ' or override ' . get_class($this) . '::getContentLink'
		);
	}

	public function getContentTitle(Entity $content)
	{
		if ($content instanceof \XF\Entity\LinkableInterface)
		{
			return $content->getContentTitle('edit_history');
		}

		throw new \LogicException(
			'Implement XF\Entity\LinkableInterface for ' . get_class($content)
			. ' or override ' . get_class($this) . '::getContentTitle'
		);
	}

	public function getEditCount(Entity $content)
	{
		return $content->edit_count;
	}

	public function getSectionContext()
	{
		return '';
	}

	public function getEntityWith()
	{
		return [];
	}

	public function getContent($id)
	{
		return \XF::app()->findByContentType($this->contentType, $id, $this->getEntityWith());
	}
}