<?php

namespace XF\Import\Data;

use function intval, is_string;

class Thread extends AbstractEmulatedData
{
	use HasDeletionLogTrait;

	/**
	 * @var ThreadReplyBan[]
	 */
	protected $replyBans = [];

	/**
	 * @var Poll
	 */
	protected $poll;
	protected $pollOldId;

	protected $watchers = [];

	protected $columnMap = [
		'first_post_likes' => 'first_post_reaction_score'
	];

	public function getImportType()
	{
		return 'thread';
	}

	public function getEntityShortName()
	{
		return 'XF:Thread';
	}

	public function set($field, $value, array $options = [])
	{
		$result = parent::set($field, $value, $options);

		if ($field == 'first_post_likes' && $value >= 1)
		{
			$this->set('first_post_reactions', [1 => intval($value)]);
		}

		return $result;
	}

	public function setCustomFields(array $customFields)
	{
		foreach ($customFields AS &$fieldValue)
		{
			if (is_string($fieldValue))
			{
				$fieldValue = $this->convertToUtf8($fieldValue);
			}
		}

		$this->custom_fields = $customFields;
	}

	public function addReplyBan($oldId, ThreadReplyBan $ban)
	{
		$this->replyBans[$oldId] = $ban;
	}

	public function addPoll($oldId, Poll $poll)
	{
		$this->pollOldId = $oldId;
		$this->poll = $poll;

		$this->discussion_type = 'poll';
	}

	public function addThreadWatcher($userId, $emailSubscribe)
	{
		$this->watchers[$userId] = $emailSubscribe;
	}

	protected function preSave($oldId)
	{
		$this->forceNotEmpty('username', $oldId);
		$this->forceNotEmpty('title', $oldId);

		if (!$this->discussion_type)
		{
			$this->discussion_type = \XF\ThreadType\AbstractHandler::BASIC_THREAD_TYPE;
			$this->type_data = [];
		}
	}

	protected function postSave($oldId, $newId)
	{
		$this->insertStateRecord($this->discussion_state, $this->post_date);

		if ($this->custom_fields)
		{
			$this->insertCustomFieldValues('xf_thread_field_value', 'thread_id', $newId, $this->custom_fields);
		}

		if ($this->replyBans)
		{
			foreach ($this->replyBans AS $oldReplyBanId => $replyBan)
			{
				$replyBan->thread_id = $newId;
				$replyBan->log(false);
				$replyBan->checkExisting(false);
				$replyBan->useTransaction(false);

				$replyBan->save($oldReplyBanId);
			}
		}

		$this->handleDiscussionTypeData($this->discussion_type, $oldId, $newId);

		if ($this->watchers)
		{
			/** @var \XF\Import\DataHelper\Thread $threadHelper */
			$threadHelper = $this->dataManager->helper('XF:Thread');
			$threadHelper->importThreadWatchBulk($newId, $this->watchers);
		}
	}

	protected function handleDiscussionTypeData(string $discussionType, $oldId, $newId)
	{
		if ($discussionType == 'poll' && $this->poll)
		{
			$this->poll->content_type = 'thread';
			$this->poll->content_id = $newId;

			$this->poll->save($this->pollOldId);
		}

		if ($discussionType == 'question')
		{
			$this->db()->insert(
				'xf_thread_question',
				[
					'thread_id' => $newId,
					'solution_post_id' => 0,
					'solution_user_id' => 0
				],
				false,
				false,
				'IGNORE'
			);
			// because of post mapping, we need to import the solution data after posts
		}
	}
}