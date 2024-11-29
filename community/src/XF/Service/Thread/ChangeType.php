<?php

namespace XF\Service\Thread;

use XF\Entity\Thread;
use XF\Entity\Forum;
use XF\Entity\User;

use function is_array;

class ChangeType extends \XF\Service\AbstractService
{
	use \XF\Service\ValidateAndSavableTrait;

	/**
	 * @var Thread
	 */
	protected $thread;

	/**
	 * @var Forum
	 */
	protected $forum;

	/**
	 * @var User
	 */
	protected $user;

	/** @var TypeData\SaverInterface|null */
	protected $typeDataSaver;

	public function __construct(\XF\App $app, Thread $thread)
	{
		parent::__construct($app);

		$this->thread = $thread;
		$this->forum = $thread->Forum;
		$this->user = \XF::visitor();
	}

	public function getThread()
	{
		return $this->thread;
	}

	public function getUser()
	{
		return $this->user;
	}

	public function setTypeDataSaver(TypeData\SaverInterface $saver = null)
	{
		$this->typeDataSaver = $saver;
	}

	public function getTypeDataSaver()
	{
		return $this->typeDataSaver;
	}

	public function setDiscussionTypeForBulkChange(
		string $type,
		bool $allowUncreatable = false
	): bool
	{
		return $this->setDiscussionTypeInternal($type, true, $allowUncreatable);
	}

	protected function setDiscussionTypeInternal(
		string $type,
		bool $isBulk,
		bool $allowUncreatable = false
	): bool
	{
		$thread = $this->thread;
		$forum = $this->forum;
		$forumTypeHandler = $forum->TypeHandler;

		$type = $type ?: $forumTypeHandler->getDefaultThreadType($forum);

		$isAllowed = $allowUncreatable
			? $forumTypeHandler->isThreadTypeAllowed($type, $forum)
			: $forum->isThreadTypeCreatable($type);

		$typeHandler = $this->app->threadType($type, false);

		if (!$isAllowed || !$typeHandler || !$typeHandler->canConvertThreadToType($isBulk))
		{
			$thread->error(\XF::phrase('please_select_valid_thread_type'), 'discussion_type');
			return false;
		}

		$thread->discussion_type = $type;

		return true;
	}

	public function setDiscussionTypeAndData(
		string $type,
		\XF\Http\Request $request,
		array $typeOptions = []
	): bool
	{
		return $this->setDiscussionTypeAndDataInternal($type, $request, $typeOptions);
	}

	public function setDiscussionTypeAndDataForApi(
		string $type,
		\XF\Http\Request $request,
		array $typeOptions = [],
		bool $allowUncreatable = false
	): bool
	{
		return $this->setDiscussionTypeAndDataInternal($type, $request, $typeOptions, 'api', $allowUncreatable);
	}

	protected function setDiscussionTypeAndDataInternal(
		string $type,
		\XF\Http\Request $request,
		array $typeOptions,
		$callType = '',
		bool $allowUncreatable = false
	): bool
	{
		$thread = $this->thread;

		$this->setDiscussionTypeInternal($type, false, $allowUncreatable);
		$typeHandler = $thread->TypeHandler;

		$typeOptions['changer'] = $this;
		$isApi = ($callType == 'api');

		if ($isApi)
		{
			$extraData = $typeHandler->processExtraDataForApiSimple(
				$thread, 'convert', $request, $typeErrors, $typeOptions
			);
		}
		else
		{
			$extraData = $typeHandler->processExtraDataSimple(
				$thread, 'convert', $request, $typeErrors, $typeOptions
			);
		}

		if ($extraData instanceof \XF\Mvc\Entity\ArrayValidator)
		{
			$extraData->appendErrors($typeErrors);
			$extraData = $extraData->getValuesForced();
		}

		if (is_array($extraData))
		{
			$thread->type_data = $extraData;
		}
		if ($typeErrors)
		{
			foreach ($typeErrors AS $error)
			{
				$thread->error($error);
			}
		}

		if ($isApi)
		{
			$extraDataService = $typeHandler->processExtraDataForApiService(
				$thread, 'convert', $request, $typeOptions
			);
		}
		else
		{
			$extraDataService = $typeHandler->processExtraDataService(
				$thread, 'convert', $request, $typeOptions
			);
		}

		if ($extraDataService)
		{
			$this->setTypeDataSaver($extraDataService);
		}

		return true;
	}

	public function setDiscussionTypeDataRaw(array $typeData)
	{
		$this->thread->type_data = $typeData;
	}

	protected function finalSetup()
	{
	}

	protected function _validate()
	{
		$this->finalSetup();

		$thread = $this->thread;

		$thread->preSave();
		$errors = $thread->getErrors();

		if ($this->typeDataSaver)
		{
			if (!$this->typeDataSaver->validate($typeErrors))
			{
				$errors = array_merge($errors, $typeErrors);
			}
		}

		return $errors;
	}

	protected function _save()
	{
		$thread = $this->thread;

		$db = $this->db();
		$db->beginTransaction();

		$thread->save(true, false);

		if ($this->typeDataSaver)
		{
			$this->typeDataSaver->save();
		}

		$db->commit();

		return $thread;
	}
}