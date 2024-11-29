<?php

namespace XF\Service\Thread;

use XF\Entity\Forum;
use XF\Entity\Post;
use XF\Entity\Thread;
use XF\Entity\User;

use function is_array;

class Creator extends \XF\Service\AbstractService
{
	use \XF\Service\ValidateAndSavableTrait;

	/**
	 * @var Forum
	 */
	protected $forum;

	/**
	 * @var Thread
	 */
	protected $thread;

	/**
	 * @var Post
	 */
	protected $post;

	/**
	 * @var User
	 */
	protected $user;

	/**
	 * @var \XF\Service\Post\Preparer
	 */
	protected $postPreparer;

	/**
	 * @var \XF\Service\Tag\Changer
	 */
	protected $tagChanger;

	/** @var TypeData\SaverInterface|null */
	protected $typeDataSaver;

	protected $performValidations = true;

	protected $isPreRegAction = false;

	public function __construct(\XF\App $app, Forum $forum)
	{
		parent::__construct($app);
		$this->forum = $forum;
		$this->setupDefaults();
	}

	protected function setupDefaults()
	{
		$this->thread = $this->forum->getNewThread();
		$this->post = $this->thread->getNewPost();

		$this->postPreparer = $this->service('XF:Post\Preparer', $this->post);

		$this->thread->addCascadedSave($this->post);
		$this->post->hydrateRelation('Thread', $this->thread);

		$this->tagChanger = $this->service('XF:Tag\Changer', 'thread', $this->forum);

		$user = \XF::visitor();
		$this->setUser($user);

		$this->thread->discussion_state = $this->forum->getNewContentState();
		$this->post->message_state = 'visible';
	}

	public function getForum()
	{
		return $this->forum;
	}

	public function getThread()
	{
		return $this->thread;
	}

	public function getPost()
	{
		return $this->post;
	}

	public function getUser()
	{
		return $this->user;
	}

	public function getPostPreparer()
	{
		return $this->postPreparer;
	}

	protected function setUser(\XF\Entity\User $user)
	{
		$this->user = $user;

		$this->thread->user_id = $user->user_id;
		$this->thread->username = $user->username;

		$this->post->user_id = $user->user_id;
		$this->post->username = $user->username;
	}

	public function setPerformValidations($perform)
	{
		$this->performValidations = (bool)$perform;
	}

	public function getPerformValidations()
	{
		return $this->performValidations;
	}

	public function setIsAutomated()
	{
		$this->logIp(false);
		$this->setPerformValidations(false);
	}

	public function setIsPreRegAction(bool $isPreRegAction)
	{
		$this->isPreRegAction = $isPreRegAction;
	}

	public function setTypeDataSaver(TypeData\SaverInterface $saver = null)
	{
		$this->typeDataSaver = $saver;
	}

	public function getTypeDataSaver()
	{
		return $this->typeDataSaver;
	}

	public function logIp($logIp)
	{
		$this->postPreparer->logIp($logIp);
	}

	public function setContent($title, $message, $format = true)
	{
		$this->thread->set('title', $title,
			['forceConstraint' => $this->performValidations ? false : true]
		);

		return $this->postPreparer->setMessage($message, $format, $this->performValidations);
	}

	public function setPrefix($prefixId)
	{
		$this->thread->prefix_id = $prefixId;
	}

	public function setTags($tags)
	{
		if ($this->tagChanger->canEdit())
		{
			$this->tagChanger->setEditableTags($tags);
		}
	}

	public function setAttachmentHash($hash)
	{
		$this->postPreparer->setAttachmentHash($hash);
	}

	public function setDiscussionOpen($discussionOpen)
	{
		$this->thread->discussion_open = $discussionOpen;
	}

	public function setDiscussionState($discussionState)
	{
		$this->thread->discussion_state = $discussionState;
	}

	/**
	 * Sets the thread type and related data. This is called for "external" creation, such as a user selecting
	 * a thread type during thread creation. Thread types that are not creatable will error.
	 *
	 * If you want to create a thread with a specific type and data internally, use
	 * setDiscussionTypeAndDataRaw.
	 *
	 * @param string $type
	 * @param \XF\Http\Request $request
	 * @param array $typeOptions
	 *
	 * @return bool
	 */
	public function setDiscussionTypeAndData(
		string $type,
		\XF\Http\Request $request,
		array $typeOptions = []
	): bool
	{
		return $this->setDiscussionTypeAndDataInternal($type, $request, $typeOptions);
	}

	/**
	 * Sets the thread type and related data for a REST API call (which expects the input in a different
	 * location from the normal UI). Note that the type must be user creatable in the forum
	 * or this will prevent the thread from being created (unless $allowUncreatable is set).
	 *
	 * @param string $type
	 * @param \XF\Http\Request $request
	 * @param array $typeOptions
	 * @param bool $allowUncreatable If true, only checks the type is allowed
	 *
	 * @return bool
	 */
	public function setDiscussionTypeAndDataForApi(
		string $type,
		\XF\Http\Request $request,
		array $typeOptions = [],
		bool $allowUncreatable = false
	): bool
	{
		return $this->setDiscussionTypeAndDataInternal($type, $request, $typeOptions, 'api', $allowUncreatable);
	}

	/**
	 * Sets the thread type and related data for a pre-registration action. Note that the type must
	 * be user creatable in the forum or the thread will not be created and the user will receive
	 * a failure notification.
	 *
	 * @param string $type
	 * @param array  $typeInput
	 * @param array  $typeOptions
	 *
	 * @return bool
	 */
	public function setDiscussionTypeAndDataForPreReg(string $type, array $typeInput, array $typeOptions = []): bool
	{
		return $this->setDiscussionTypeAndDataInternal($type, $typeInput, $typeOptions, 'preReg');
	}

	protected function setDiscussionTypeAndDataInternal(
		string $type,
		$requestOrInput,
		array $typeOptions = [],
		string $callType = '',
		bool $allowUncreatable = false
	): bool
	{
		$thread = $this->thread;
		$forum = $this->forum;
		$isApi = ($callType == 'api');
		$isPreReg = ($callType == 'preReg');
		$forumTypeHandler = $forum->TypeHandler;

		$type = $type ?: $forumTypeHandler->getDefaultThreadType($forum);

		$isAllowed = $allowUncreatable
			? $forumTypeHandler->isThreadTypeAllowed($type, $forum)
			: $forum->isThreadTypeCreatable($type);

		if (!$isAllowed || !$this->app->threadType($type, false))
		{
			$thread->error(\XF::phrase('please_select_valid_thread_type'), 'discussion_type');
			return false;
		}

		$thread->discussion_type = $type;
		$typeHandler = $thread->TypeHandler;

		if (!$typeHandler->allowExternalCreation())
		{
			// this might be an allowed thread type but we opted out of external creation
			$thread->error(\XF::phrase('please_select_valid_thread_type'), 'discussion_type');
			return false;
		}

		$typeOptions['creator'] = $this;

		if ($isApi)
		{
			$extraData = $typeHandler->processExtraDataForApiSimple(
				$thread, 'create', $requestOrInput, $typeErrors, $typeOptions
			);
		}
		elseif ($isPreReg)
		{
			$extraData = $typeHandler->processExtraDataForPreRegSimple(
				$thread, 'create', $requestOrInput, $typeErrors, $typeOptions
			);
		}
		else
		{
			$extraData = $typeHandler->processExtraDataSimple(
				$thread, 'create', $requestOrInput, $typeErrors, $typeOptions
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
				$thread, 'create', $requestOrInput, $typeOptions
			);
		}
		elseif ($isPreReg)
		{
			$extraDataService = $typeHandler->processExtraDataForPreRegService(
				$thread, 'create', $requestOrInput, $typeOptions
			);
		}
		else
		{
			$extraDataService = $typeHandler->processExtraDataService(
				$thread, 'create', $requestOrInput, $typeOptions
			);
		}

		if ($extraDataService)
		{
			$this->setTypeDataSaver($extraDataService);
		}

		return true;
	}

	/**
	 * Sets the discussion type and data directly. This can be set to any type that is allowed in the
	 * forum. This should be used when creating a thread of a particular type internally.
	 *
	 * @param string $type
	 * @param array $typeData
	 *
	 * @return bool
	 */
	public function setDiscussionTypeAndDataRaw(string $type, array $typeData = []): bool
	{
		$forum = $this->forum;
		$forumTypeHandler = $forum->TypeHandler;

		$type = $type ?: $forumTypeHandler->getDefaultThreadType($forum);
		if (!$forumTypeHandler->isThreadTypeAllowed($type, $forum) || !$this->app->threadType($type, false))
		{
			$this->thread->error(\XF::phrase('please_select_valid_thread_type'), 'discussion_type');
			return false;
		}

		$this->thread->discussion_type = $type;
		$this->thread->type_data = $typeData;

		return true;
	}

	public function setSticky($sticky)
	{
		$this->thread->sticky = $sticky;
	}

	public function setCustomFields(array $customFields)
	{
		$editMode = $this->isPreRegAction ? 'user_pre_reg' : 'user';

		/** @var \XF\CustomField\Set $fieldSet */
		$fieldSet = $this->thread->custom_fields;
		$fieldDefinition = $fieldSet->getDefinitionSet()
			->filterEditable($fieldSet, $editMode)
			->filterOnly($this->forum->field_cache);

		$customFieldsShown = array_keys($fieldDefinition->getFieldDefinitions());

		if ($customFieldsShown)
		{
			$fieldSet->bulkSet($customFields, $customFieldsShown, $editMode);
		}
	}

	public function checkForSpam()
	{
		if ($this->thread->discussion_state == 'visible' && $this->user->isSpamCheckRequired())
		{
			$this->postPreparer->checkForSpam();
		}
	}

	protected function finalSetup()
	{
		$date = time();

		$this->thread->post_date = $date;
		$this->thread->last_post_date = $date;
		$this->thread->last_post_user_id = $this->thread->user_id;
		$this->thread->last_post_username = $this->thread->username;

		$this->post->post_date = $date;
		$this->post->position = 0;
	}

	protected function _validate()
	{
		$thread = $this->thread;

		if (!$thread->user_id && !$this->isPreRegAction)
		{
			/** @var \XF\Validator\Username $validator */
			$validator = $this->app->validator('Username');
			$thread->username = $validator->coerceValue($thread->username);
			$this->post->username = $thread->username;

			if ($this->performValidations && !$validator->isValid($thread->username, $error))
			{
				return [
					$validator->getPrintableErrorValue($error)
				];
			}
		}
		else if ($this->isPreRegAction && !$thread->username)
		{
			// need to force a value here to avoid a presave error
			$thread->username = 'preRegAction-' . \XF::$time;
			$this->post->username = $thread->username;
		}

		$this->finalSetup();

		$thread->preSave();
		$errors = $thread->getErrors();

		if ($this->performValidations)
		{
			if (!$thread->prefix_id
				&& $this->forum->require_prefix
				&& $this->forum->getUsablePrefixes()
			)
			{
				$errors[] = \XF::phraseDeferred('please_select_a_prefix');
			}

			if ($this->tagChanger->canEdit())
			{
				$tagErrors = $this->tagChanger->getErrors();
				if ($tagErrors)
				{
					$errors = array_merge($errors, $tagErrors);
				}
			}
		}

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
		if ($this->isPreRegAction)
		{
			throw new \LogicException("Pre-reg action threads cannot be saved");
		}

		$thread = $this->thread;

		$db = $this->db();
		$db->beginTransaction();

		$thread->save(true, false);
		// post will also be saved now

		$this->postPreparer->afterInsert();

		if ($this->tagChanger->canEdit())
		{
			$this->tagChanger
				->setContentId($thread->thread_id, true)
				->save($this->performValidations);
		}

		if ($this->typeDataSaver)
		{
			$this->typeDataSaver->save();
		}

		$db->commit();

		return $thread;
	}

	public function sendNotifications()
	{
		if ($this->thread->isVisible())
		{
			/** @var \XF\Service\Post\Notifier $notifier */
			$notifier = $this->service('XF:Post\Notifier', $this->post, 'thread');
			$notifier->setMentionedUserIds($this->postPreparer->getMentionedUserIds());
			$notifier->setQuotedUserIds($this->postPreparer->getQuotedUserIds());
			$notifier->notifyAndEnqueue(3);
		}
	}
}