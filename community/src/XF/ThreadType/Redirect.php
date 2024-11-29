<?php

namespace XF\ThreadType;

use XF\Entity\Thread;
use XF\Pub\Controller\AbstractController;

class Redirect extends AbstractHandler
{
	public function getTypeIconClass(): string
	{
		return '';
	}

	public function overrideDisplay(Thread $thread, AbstractController $controller)
	{
		if (!$thread->Redirect)
		{
			return $controller->noPermission();
		}

		return $controller->redirectPermanently(
			$controller->request()->convertToAbsoluteUri($thread->Redirect->target_url)
		);
	}

	public function onThreadLeaveType(Thread $thread, array $typeData, bool $isDelete)
	{
		if ($thread->Redirect)
		{
			$thread->Redirect->delete();
		}
	}

	public function allowExternalCreation(): bool
	{
		return false;
	}

	public function canThreadTypeBeChanged(Thread $thread): bool
	{
		return false;
	}

	public function canConvertThreadToType(bool $isBulk): bool
	{
		return false;
	}
}