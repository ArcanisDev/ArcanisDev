<?php

namespace XF\Attachment;

use XF\Entity\Attachment;

use function count;

class Manipulator
{
	/**
	 * @var AbstractHandler
	 */
	protected $handler;

	/**
	 * @var \XF\Repository\Attachment
	 */
	protected $repo;

	protected $context;
	protected $hash;
	protected $constraints = [];
	protected $unassociatedLimit;

	protected $container;

	protected $unassociatedAttachmentCount;

	/**
	 * @var Attachment[]
	 */
	protected $existingAttachments = [];

	/**
	 * @var Attachment[]
	 */
	protected $newAttachments = [];

	public function __construct(AbstractHandler $handler, \XF\Repository\Attachment $repo, array $context, $hash)
	{
		$this->handler = $handler;
		$this->repo = $repo;

		$this->setContext($context);
		$this->setHash($hash);
		$this->setConstraints($handler->getConstraints($context));
		$this->setUnassociatedLimits();
	}

	public function getContext()
	{
		return $this->context;
	}

	public function setContext(array $context)
	{
		$this->context = $context;

		$this->container = $this->handler->getContainerFromContext($context);
		if ($this->container)
		{
			$existing = $this->repo->findAttachmentsByContent(
				$this->handler->getContentType(),
				$this->handler->getContainerIdFromContext($context)
			)->fetch();
			$this->existingAttachments = $existing->toArray();
		}
	}

	public function getContainer()
	{
		return $this->container;
	}

	public function getHash()
	{
		return $this->hash;
	}

	public function setHash($hash)
	{
		if (!$hash)
		{
			throw new \InvalidArgumentException("Hash must be specified");
		}

		$this->hash = $hash;

		$attachments = $this->repo->findAttachmentsByTempHash($hash)->fetch();
		$this->newAttachments = $attachments->toArray();
	}

	public function getConstraints()
	{
		return $this->constraints;
	}

	public function setConstraints(array $constraints)
	{
		$this->constraints = $constraints;
	}

	public function setUnassociatedLimits()
	{
		$this->unassociatedLimit = \XF::config('unassociatedAttachmentLimit');

		if ($this->unassociatedLimit && $this->unassociatedAttachmentCount === null)
		{
			$repo = $this->repo;
			$this->unassociatedAttachmentCount = $repo->countUnassociatedAttachmentsForUser();
		}
	}

	public function canUpload(&$error = null)
	{
		$constraints = $this->constraints;

		if (isset($constraints['count']) && $constraints['count'] > 0)
		{
			$uploaded = count($this->existingAttachments) + count($this->newAttachments);
			$allowed = ($uploaded < $constraints['count']);

			if (!$allowed)
			{
				$error = \XF::phraseDeferred('you_may_only_attach_x_files', ['count' => $constraints['count']]);
				return false;
			}
		}

		$unassociatedLimit = $this->unassociatedLimit;
		$unassociatedAttachmentCount = $this->unassociatedAttachmentCount;

		if ($unassociatedLimit)
		{
			$uploaded = $unassociatedAttachmentCount + count($this->newAttachments);
			$allowed = ($uploaded < $unassociatedLimit);

			if (!$allowed)
			{
				$error = \XF::phraseDeferred('you_have_reached_the_maximum_limit_for_attachment_uploads');
				return false;
			}
		}

		return true;
	}

	public function getExistingAttachments()
	{
		return $this->existingAttachments;
	}

	public function getNewAttachments()
	{
		return $this->newAttachments;
	}

	public function deleteAttachment($id)
	{
		if (isset($this->existingAttachments[$id]))
		{
			$this->existingAttachments[$id]->delete();
			unset($this->existingAttachments[$id]);
			return true;
		}
		else if (isset($this->newAttachments[$id]))
		{
			$this->newAttachments[$id]->delete();
			unset($this->newAttachments[$id]);
			return true;
		}
		else
		{
			return false;
		}
	}

	public function insertAttachmentFromUpload(\XF\Http\Upload $upload, &$error = null)
	{
		$upload->applyConstraints($this->constraints);

		$handler = $this->handler;
		$handler->validateAttachmentUpload($upload, $this);

		if (!$upload->isValid($errors))
		{
			$error = reset($errors);
			return null;
		}

		/** @var \XF\Service\Attachment\Preparer $inserter */
		$inserter = \XF::app()->service('XF:Attachment\Preparer');

		return $inserter->insertAttachment(
			$handler,
			$upload->getFileWrapper(),
			\XF::visitor(),
			$this->hash
		);
	}
}