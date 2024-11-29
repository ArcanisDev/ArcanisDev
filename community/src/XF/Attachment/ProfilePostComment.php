<?php

namespace XF\Attachment;

use XF\Entity\Attachment;
use XF\Mvc\Entity\Entity;

use function intval;

class ProfilePostComment extends AbstractHandler
{
	public function getContainerWith()
	{
		return ['ProfilePost', 'User'];
	}

	public function canView(Attachment $attachment, Entity $container, &$error = null)
	{
		/** @var \XF\Entity\ProfilePostComment $container */
		if (!$container->canView())
		{
			return false;
		}

		return $container->canViewAttachments($error);
	}

	public function canManageAttachments(array $context, &$error = null)
	{
		$profilePost = $this->getProfilePostFromContext($context);
		return ($profilePost && $profilePost->canUploadAndManageAttachments());
	}

	public function onAttachmentDelete(Attachment $attachment, Entity $container = null)
	{
		if (!$container)
		{
			return;
		}

		/** @var \XF\Entity\ProfilePostComment $container */
		$container->attach_count--;
		$container->save();

		// TODO: phrase for attachment_deleted
		\XF::app()->logger()->logModeratorAction($this->contentType, $container, 'attachment_deleted', [], false);
	}

	public function getConstraints(array $context)
	{
		/** @var \XF\Repository\Attachment $attachRepo */
		$attachRepo = \XF::repository('XF:Attachment');

		$constraints = $attachRepo->getDefaultAttachmentConstraints();

		$profilePost = $this->getProfilePostFromContext($context);
		if ($profilePost && $profilePost->canUploadVideos())
		{
			$constraints = $attachRepo->applyVideoAttachmentConstraints($constraints);
		}

		return $constraints;
	}

	public function getContainerIdFromContext(array $context)
	{
		return isset($context['profile_post_comment_id']) ? intval($context['profile_post_comment_id']) : null;
	}

	public function getContext(Entity $entity = null, array $extraContext = [])
	{
		if ($entity instanceof \XF\Entity\ProfilePostComment)
		{
			$extraContext['profile_post_comment_id'] = $entity->profile_post_comment_id;
		}
		else if ($entity instanceof \XF\Entity\ProfilePost)
		{
			$extraContext['profile_post_id'] = $entity->profile_post_id;
		}
		else
		{
			throw new \InvalidArgumentException("Entity must be profile post comment or profile post");
		}

		return $extraContext;
	}

	protected function getProfilePostFromContext(array $context)
	{
		$em = \XF::em();

		if (!empty($context['profile_post_comment_id']))
		{
			/** @var \XF\Entity\ProfilePostComment $profilePostComment */
			$profilePostComment = $em->find('XF:ProfilePostComment', intval($context['profile_post_comment_id']), ['ProfilePost']);
			if (!$profilePostComment || !$profilePostComment->canView() || !$profilePostComment->canEdit())
			{
				return null;
			}

			$profilePost = $profilePostComment->ProfilePost;
		}
		else if (!empty($context['profile_post_id']))
		{
			/** @var \XF\Entity\ProfilePost $profilePost */
			$profilePost = $em->find('XF:ProfilePost', intval($context['profile_post_id']));
			if (!$profilePost)
			{
				return null;
			}
		}

		return $profilePost;
	}
}