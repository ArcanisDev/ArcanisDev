<?php

namespace XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;
use XF\Util\Arr;

use function is_int, strlen;

/**
 * COLUMNS
 * @property int|null $thread_id
 * @property int $node_id
 * @property string $title
 * @property int $reply_count
 * @property int $view_count
 * @property int $user_id
 * @property string $username
 * @property int $post_date
 * @property bool $sticky
 * @property string $discussion_state
 * @property bool $discussion_open
 * @property string $discussion_type
 * @property array $type_data_
 * @property int $first_post_id
 * @property int $last_post_date
 * @property int $last_post_id
 * @property int $last_post_user_id
 * @property string $last_post_username
 * @property int $first_post_reaction_score
 * @property array|null $first_post_reactions
 * @property int $prefix_id
 * @property array $custom_fields_
 * @property array $tags
 * @property int $vote_score
 * @property int $vote_count
 *
 * GETTERS
 * @property \XF\Draft $draft_reply
 * @property array $post_ids
 * @property array $last_post_cache
 * @property \XF\CustomField\Set $custom_fields
 * @property string|null $cover_image
 * @property \XF\ThreadType\AbstractHandler|null $TypeHandler
 * @property array $type_data
 * @property mixed $vote_score_short
 *
 * RELATIONS
 * @property \XF\Entity\Forum $Forum
 * @property \XF\Entity\User $User
 * @property \XF\Entity\Post $FirstPost
 * @property \XF\Entity\Post $LastPost
 * @property \XF\Entity\User $LastPoster
 * @property \XF\Entity\ThreadPrefix $Prefix
 * @property \XF\Mvc\Entity\AbstractCollection|\XF\Entity\ThreadRead[] $Read
 * @property \XF\Mvc\Entity\AbstractCollection|\XF\Entity\ThreadWatch[] $Watch
 * @property \XF\Mvc\Entity\AbstractCollection|\XF\Entity\ThreadUserPost[] $UserPosts
 * @property \XF\Entity\DeletionLog $DeletionLog
 * @property \XF\Mvc\Entity\AbstractCollection|\XF\Entity\Draft[] $DraftReplies
 * @property \XF\Entity\ApprovalQueue $ApprovalQueue
 * @property \XF\Entity\ThreadRedirect $Redirect
 * @property \XF\Mvc\Entity\AbstractCollection|\XF\Entity\ThreadReplyBan[] $ReplyBans
 * @property \XF\Entity\Poll $Poll
 * @property \XF\Mvc\Entity\AbstractCollection|\XF\Entity\ThreadFieldValue[] $CustomFields
 * @property \XF\Entity\ThreadQuestion $Question
 * @property \XF\Mvc\Entity\AbstractCollection|\XF\Entity\TagContent[] $Tags
 * @property \XF\Mvc\Entity\AbstractCollection|\XF\Entity\ContentVote[] $ContentVotes
 */
class Thread extends Entity implements LinkableInterface
{
	use ContentVoteTrait;

	public function canView(&$error = null)
	{
		if (!$this->Forum || !$this->Forum->canView())
		{
			return false;
		}

		$visitor = \XF::visitor();
		$nodeId = $this->node_id;

		if (!$visitor->hasNodePermission($nodeId, 'view'))
		{
			return false;
		}
		if (!$visitor->hasNodePermission($nodeId, 'viewOthers')
			&& (!$visitor->user_id || $visitor->user_id != $this->user_id)
		)
		{
			return false;
		}
		if (!$visitor->hasNodePermission($nodeId, 'viewContent'))
		{
			return false;
		}

		if ($this->discussion_state == 'moderated')
		{
			if (
				!$visitor->hasNodePermission($nodeId, 'viewModerated')
				&& (!$visitor->user_id || $visitor->user_id != $this->user_id)
			)
			{
				$error = \XF::phraseDeferred('requested_thread_not_found');
				return false;
			}
		}
		else if ($this->discussion_state == 'deleted')
		{
			if (!$visitor->hasNodePermission($nodeId, 'viewDeleted'))
			{
				$error = \XF::phraseDeferred('requested_thread_not_found');
				return false;
			}
		}

		return true;
	}

	public function canPreview(&$error = null)
	{
		// assumes view check has already been run
		$visitor = \XF::visitor();
		$nodeId = $this->node_id;

		return (
			$this->discussion_type != 'redirect'
			&& $this->first_post_id
			&& $this->app()->options()->discussionPreview
			&& $visitor->hasNodePermission($nodeId, 'viewContent')
		);
	}

	public function canEdit(&$error = null)
	{
		$visitor = \XF::visitor();
		if (!$visitor->user_id)
		{
			return false;
		}

		$nodeId = $this->node_id;

		if ($visitor->hasNodePermission($nodeId, 'manageAnyThread'))
		{
			return true;
		}

		if (!$this->discussion_open && !$this->canLockUnlock())
		{
			$error = \XF::phraseDeferred('you_may_not_perform_this_action_because_discussion_is_closed');
			return false;
		}

		if ($this->user_id == $visitor->user_id && $visitor->hasNodePermission($nodeId, 'editOwnPost'))
		{
			$editLimit = $visitor->hasNodePermission($nodeId, 'editOwnPostTimeLimit');
			if ($editLimit != -1 && (!$editLimit || $this->post_date < \XF::$time - 60 * $editLimit))
			{
				$error = \XF::phraseDeferred('message_edit_time_limit_expired', ['minutes' => $editLimit]);
				return false;
			}

			if (!$this->Forum || !$this->Forum->allow_posting)
			{
				$error = \XF::phraseDeferred('you_may_not_perform_this_action_because_forum_does_not_allow_posting');
				return false;
			}

			return $visitor->hasNodePermission($nodeId, 'editOwnThreadTitle');
		}

		return false;
	}

	/**
	 * Returns true if the visitor can edit moderator-level fields. These are fields/options that regular users
	 * usually can't control, even on their own threads. Only applies to fields that don't have other dedicated
	 * permissions or checks (such as thread locking/stickying).
	 *
	 * @param mixed $error Returned error message if a specific value is requested
	 *
	 * @return bool
	 */
	public function canEditModeratorFields(&$error = null): bool
	{
		$visitor = \XF::visitor();
		return $visitor->user_id && $visitor->hasNodePermission($this->node_id, 'manageAnyThread');
	}

	public function canCleanSpam()
	{
		return (\XF::visitor()->canCleanSpam() && $this->User && $this->User->isPossibleSpammer());
	}

	public function isPrefixEditable()
	{
		$prefixId = $this->prefix_id;

		if (!$prefixId || !$this->Forum->isPrefixValid($prefixId))
		{
			return true;
		}

		return $this->Forum->isPrefixUsable($prefixId);
	}

	public function canCreatePoll(&$error = null)
	{
		if ($this->discussion_type != \XF\ThreadType\AbstractHandler::BASIC_THREAD_TYPE)
		{
			return false;
		}

		if (!$this->Forum->canCreatePoll())
		{
			return false;
		}

		$visitor = \XF::visitor();
		if (!$visitor->user_id)
		{
			return false;
		}

		if (!$this->discussion_open && !$this->canLockUnlock())
		{
			$error = \XF::phraseDeferred('you_may_not_perform_this_action_because_discussion_is_closed');
			return false;
		}

		$nodeId = $this->node_id;

		if ($visitor->hasNodePermission($nodeId, 'manageAnyThread'))
		{
			return true;
		}

		if ($this->user_id == $visitor->user_id && $visitor->hasNodePermission($nodeId, 'editOwnPost'))
		{
			$editLimit = $visitor->hasNodePermission($nodeId, 'editOwnPostTimeLimit');
			if ($editLimit != -1 && (!$editLimit || $this->post_date < \XF::$time - 60 * $editLimit))
			{
				$error = \XF::phraseDeferred('message_edit_time_limit_expired', ['minutes' => $editLimit]);
				return false;
			}

			if (!$this->Forum || !$this->Forum->allow_posting)
			{
				$error = \XF::phraseDeferred('you_may_not_perform_this_action_because_forum_does_not_allow_posting');
				return false;
			}

			return true;
		}

		return false;
	}

	public function isContentVotingSupported(): bool
	{
		return $this->TypeHandler->isThreadVotingSupported($this);
	}

	public function isContentDownvoteSupported(): bool
	{
		return $this->TypeHandler->isThreadDownvoteSupported($this);
	}

	protected function canVoteOnContentInternal(&$error = null): bool
	{
		if (!$this->isVisible())
		{
			return false;
		}

		return $this->TypeHandler->canVoteOnThread($this, $error);
	}

	public function canDownvoteContent(&$error = null): bool
	{
		return $this->TypeHandler->canDownvoteThread($this, $error);
	}

	public function canReply(&$error = null)
	{
		if ($this->discussion_type == 'redirect' || $this->discussion_state == 'deleted')
		{
			return false;
		}

		if (!$this->discussion_open && !$this->canLockUnlock())
		{
			$error = \XF::phraseDeferred('you_may_not_perform_this_action_because_discussion_is_closed');
			return false;
		}

		if (!$this->Forum || !$this->Forum->allow_posting)
		{
			$error = \XF::phraseDeferred('you_may_not_perform_this_action_because_forum_does_not_allow_posting');
			return false;
		}

		$visitor = \XF::visitor();
		$nodeId = $this->node_id;

		if (!$visitor->hasNodePermission($nodeId, 'postReply'))
		{
			return false;
		}

		if ($visitor->user_id)
		{
			$replyBans = $this->ReplyBans;
			if ($replyBans)
			{
				if (isset($replyBans[$visitor->user_id]))
				{
					$replyBan = $replyBans[$visitor->user_id];
					$isBanned = ($replyBan && (!$replyBan->expiry_date || $replyBan->expiry_date > time()));
					if ($isBanned)
					{
						return false;
					}
				}
			}
		}

		return true;
	}

	public function canReplyPreReg()
	{
		if (\XF::visitor()->user_id || $this->canReply())
		{
			// quick bypass with the user ID check, then ensure that this can only return true if the visitor
			// can't take the "normal" action
			return false;
		}

		return \XF::canPerformPreRegAction(
			function() { return $this->canReply(); }
		);
	}

	public function canEditTags(&$error = null)
	{
		/** @var Forum $forum */
		$forum = $this->Forum;
		return $forum ? $forum->canEditTags($this, $error) : false;
	}

	public function canUseInlineModeration(&$error = null)
	{
		$visitor = \XF::visitor();
		return ($visitor->user_id && $visitor->hasNodePermission($this->node_id, 'inlineMod'));
	}

	public function canDelete($type = 'soft', &$error = null)
	{
		$visitor = \XF::visitor();
		if (!$visitor->user_id)
		{
			return false;
		}

		$nodeId = $this->node_id;

		if ($type != 'soft' && !$visitor->hasNodePermission($nodeId, 'hardDeleteAnyThread'))
		{
			return false;
		}

		if (!$this->discussion_open && !$this->canLockUnlock())
		{
			$error = \XF::phraseDeferred('you_may_not_perform_this_action_because_discussion_is_closed');
			return false;
		}

		if ($visitor->hasNodePermission($nodeId, 'deleteAnyThread'))
		{
			return true;
		}

		if ($this->user_id == $visitor->user_id && $visitor->hasNodePermission($nodeId, 'deleteOwnThread'))
		{
			$editLimit = $visitor->hasNodePermission($nodeId, 'editOwnPostTimeLimit');
			if ($editLimit != -1 && (!$editLimit || $this->post_date < \XF::$time - 60 * $editLimit))
			{
				$error = \XF::phraseDeferred('message_edit_time_limit_expired', ['minutes' => $editLimit]);
				return false;
			}

			if (!$this->Forum || !$this->Forum->allow_posting)
			{
				$error = \XF::phraseDeferred('you_may_not_perform_this_action_because_forum_does_not_allow_posting');
				return false;
			}

			return true;
		}

		return false;
	}

	public function canUndelete(&$error = null)
	{
		$visitor = \XF::visitor();
		return $visitor->user_id && $visitor->hasNodePermission($this->node_id, 'undelete');
	}

	public function canLockUnlock(&$error = null)
	{
		$visitor = \XF::visitor();
		return ($visitor->user_id && $visitor->hasNodePermission($this->node_id, 'lockUnlockThread'));
	}

	public function canViewDeletedPosts()
	{
		return \XF::visitor()->hasNodePermission($this->node_id, 'viewDeleted');
	}

	public function canViewModeratedPosts()
	{
		return \XF::visitor()->hasNodePermission($this->node_id, 'viewModerated');
	}

	public function canApproveUnapprove(&$error = null)
	{
		$visitor = \XF::visitor();
		return $visitor->user_id && $visitor->hasNodePermission($this->node_id, 'approveUnapprove');
	}

	public function canStickUnstick(&$error = null)
	{
		$visitor = \XF::visitor();
		return $visitor->user_id && $visitor->hasNodePermission($this->node_id, 'stickUnstickThread');
	}

	public function canMove(&$error = null)
	{
		$visitor = \XF::visitor();
		return $visitor->user_id && $visitor->hasNodePermission($this->node_id, 'manageAnyThread');
	}

	public function canCopy(&$error = null)
	{
		$visitor = \XF::visitor();
		return $visitor->user_id && $visitor->hasNodePermission($this->node_id, 'manageAnyThread');
	}

	public function canMerge(&$error = null)
	{
		$visitor = \XF::visitor();
		return $visitor->user_id && $visitor->hasNodePermission($this->node_id, 'manageAnyThread');
	}

	public function canChangeType(&$error = null): bool
	{
		$visitor = \XF::visitor();
		if (!$visitor->user_id || !$visitor->hasNodePermission($this->node_id, 'manageAnyThread'))
		{
			return false;
		}

		if (!$this->TypeHandler->canThreadTypeBeChanged($this))
		{
			$error = \XF::phraseDeferred('threads_type_not_changeable');
			return false;
		}

		return true;
	}

	public function canViewAttachments(&$error = null)
	{
		return \XF::visitor()->hasNodePermission($this->node_id, 'viewAttachment');
	}

	public function canWatch(&$error = null)
	{
		return \XF::visitor()->user_id ? true : false;
	}

	public function canReplyBan(&$error = null)
	{
		if (!$this->discussion_open)
		{
			$error = \XF::phraseDeferred('you_may_not_perform_this_action_because_discussion_is_closed');
			return false;
		}

		$visitor = \XF::visitor();
		return $visitor->user_id && $visitor->hasNodePermission($this->node_id, 'threadReplyBan');
	}

	public function canSendModeratorActionAlert()
	{
		return $this->FirstPost && $this->FirstPost->canSendModeratorActionAlert();
	}

	public function canViewModeratorLogs(&$error = null)
	{
		$visitor = \XF::visitor();
		return $visitor->user_id && $visitor->hasNodePermission($this->node_id, 'manageAnyThread');
	}

	public function isVisible()
	{
		return ($this->discussion_state == 'visible');
	}

	public function isSearchEngineIndexable(): bool
	{
		$forum = $this->Forum;
		if (!$forum)
		{
			return false;
		}

		if ($forum->allow_index == 'criteria')
		{
			$criteria = $forum->index_criteria;

			if (
				!empty($criteria['max_days_post']) &&
				$this->post_date < \XF::$time - $criteria['max_days_post'] * 86400
			)
			{
				return false;
			}

			if (
				!empty($criteria['max_days_last_post']) &&
				$this->last_post_date < \XF::$time - $criteria['max_days_last_post'] * 86400
			)
			{
				return false;
			}

			if (
				!empty($criteria['min_replies']) &&
				$this->reply_count < $criteria['min_replies']
			)
			{
				return false;
			}

			if (
				isset($criteria['min_reaction_score']) &&
				$this->first_post_reaction_score < $criteria['min_reaction_score']
			)
			{
				return false;
			}

			return true;
		}

		return ($forum->allow_index == 'allow');
	}

	public function isUnread()
	{
		if ($this->discussion_state == 'deleted')
		{
			return false;
		}

		if ($this->discussion_type == 'redirect')
		{
			return false;
		}

		$readDate = $this->getVisitorReadDate();
		if ($readDate === null)
		{
			return false;
		}

		return $readDate < $this->last_post_date;
	}

	public function isIgnored()
	{
		return \XF::visitor()->isIgnoring($this->user_id);
	}

	public function isWatched()
	{
		return isset($this->Watch[\XF::visitor()->user_id]);
	}

	public function getUserPostCount($user = null)
	{
		if ($user === null)
		{
			$userId = \XF::visitor()->user_id;
		}
		else if (is_int($user))
		{
			$userId = $user;
		}
		else if ($user instanceof User)
		{
			$userId = $user->user_id;
		}
		else
		{
			throw new \InvalidArgumentException("User must be provided as null, ID, or entity");
		}

		if (!$userId)
		{
			return 0;
		}

		return isset($this->UserPosts[$userId]) ? $this->UserPosts[$userId]->post_count : 0;
	}

	public function getUserReadDate(\XF\Entity\User $user)
	{
		$threadRead = $this->Read[$user->user_id];
		$forumRead = $this->Forum ? $this->Forum->Read[$user->user_id] : null;

		$dates = [\XF::$time - $this->app()->options()->readMarkingDataLifetime * 86400];
		if ($threadRead)
		{
			$dates[] = $threadRead->thread_read_date;
		}
		if ($forumRead)
		{
			$dates[] = $forumRead->forum_read_date;
		}

		return max($dates);
	}

	public function getVisitorReadDate()
	{
		$visitor = \XF::visitor();
		if (!$visitor->user_id)
		{
			return null;
		}

		return $this->getUserReadDate($visitor);
	}

	/**
	 * @return \XF\Draft
	 */
	public function getDraftReply()
	{
		return \XF\Draft::createFromEntity($this, 'DraftReplies');
	}

	/**
	 * @return string|null
	 */
	public function getCoverImage()
	{
		$firstPost = $this->FirstPost;
		if (!$firstPost)
		{
			return null;
		}

		if ($firstPost->attach_count)
		{
			$attachments = $firstPost->Attachments;
		}
		else
		{
			$attachments = $this->_em->getEmptyCollection();
		}

		$canViewAttachments = $this->canViewAttachments();

		$attachments = $attachments->filter(function(Attachment $attachment) use ($canViewAttachments)
		{
			if ($attachment->type_grouping != 'image')
			{
				return false;
			}

			return $canViewAttachments || $attachment->hasThumbnail();
		});

		$embeddedAttachmentIds = $firstPost->embed_metadata['attachments'] ?? [];
		$embeddedAttachments = $attachments->sortByList(array_keys($embeddedAttachmentIds));

		$coverImageUrl = null;

		if ($embeddedAttachments->count())
		{
			foreach ($embeddedAttachments AS $attachment)
			{
				/** @var Attachment $attachment */

				$coverImageUrl = $canViewAttachments
					? $attachment->getDirectUrl(true)
					: $attachment->getThumbnailUrlFull();

				if ($coverImageUrl)
				{
					break;
				}
			}
		}
		else if (preg_match('#\[img.*\](https?://.+)\[/img]#iU', $this->FirstPost->message, $match))
		{
			$url = $match[1];

			$strFormatter = $this->app()->stringFormatter();

			$linkInfo = $strFormatter->getLinkClassTarget($url);
			if ($linkInfo['local'])
			{
				$coverImageUrl = $url;
			}
			else
			{
				$coverImageUrl = $this->app()->stringFormatter()->getProxiedUrlIfActive('image', $url);
				if ($coverImageUrl)
				{
					$paths = \XF::app()->container('request.paths');
					$pather = \XF::app()->container('request.pather');

					if (strpos($coverImageUrl, $paths['base']) === 0)
					{
						$coverImageUrl = substr($coverImageUrl, strlen($paths['base']));
					}

					$coverImageUrl = $pather($coverImageUrl, 'canonical');
				}
				else
				{
					$coverImageUrl = $url;
				}
			}
		}
		else
		{
			foreach ($attachments AS $attachment)
			{
				/** @var Attachment $attachment */

				if (isset($embeddedAttachments[$attachment->attachment_id]))
				{
					continue;
				}

				$coverImageUrl = $canViewAttachments
					? $attachment->getDirectUrl(true)
					: $attachment->getThumbnailUrlFull();

				if ($coverImageUrl)
				{
					break;
				}
			}
		}

		return $coverImageUrl ?: null;
	}

	public function getNewPost()
	{
		$post = $this->_em->create('XF:Post');

		$post->thread_id = $this->_getDeferredValue(function()
		{
			return $this->thread_id;
		}, 'save');

		return $post;
	}

	public function getFieldEditMode($allowPreReg = false)
	{
		$visitor = \XF::visitor();

		$isSelf = ($visitor->user_id == $this->user_id || !$this->thread_id);
		$isMod = ($visitor->user_id && $visitor->hasNodePermission($this->node_id, 'manageAnyThread'));

		if ($isMod || !$isSelf)
		{
			return $isSelf ? 'moderator_user' : 'moderator';
		}
		else
		{
			if ($allowPreReg && !$this->thread_id && $this->Forum->canCreateThreadPreReg())
			{
				// creating a new thread and in a pre-reg action situation so apply the correct group limits
				return 'user_pre_reg';
			}

			return 'user';
		}
	}

	/**
	 * @return \XF\CustomField\Set
	 */
	public function getCustomFields()
	{
		$class = 'XF\CustomField\Set';
		$class = $this->app()->extendClass($class);

		$fieldDefinitions = $this->app()->container('customFields.threads');

		return new $class($fieldDefinitions, $this);
	}

	/**
	 * @param bool $current If true, gets the current value; else gets the previous value
	 * @param bool $fallback If true, falls back to the basic thread type if the type is invalid
	 *
	 * @return \XF\ThreadType\AbstractHandler|null Null if getting the previous type on an insert
	 */
	public function getTypeHandler(bool $current = true, bool $fallback = true)
	{
		if (!$current && $this->isInsert())
		{
			return null;
		}

		if ($current)
		{
			$type = $this->discussion_type;

			if (!$type && $this->Forum)
			{
				// This would generally only happen if called before explicitly setting the type.
				// preSave will resolve that and most common cases will setup the type early.
				$forum = $this->Forum;
				$type = $forum->TypeHandler->getDefaultThreadType($forum);
			}
		}
		else
		{
			$type = $this->getExistingValue('discussion_type');
			// Existing threads should essentially always have a type. We accept a basic type fallback
			// if something has gone wrong.
		}

		$handler = $this->app()->threadType($type, false);
		if (!$handler && $fallback)
		{
			$handler = $this->app()->threadType(\XF\ThreadType\AbstractHandler::BASIC_THREAD_TYPE);
		}

		return $handler;
	}

	/**
	 * @param bool $current If true, gets the current value; else gets the previous value
	 *
	 * @return array
	 */
	public function getTypeData($current = true)
	{
		if ($current)
		{
			$defaultData = $this->TypeHandler->getDefaultTypeData();
			$data = $this->getValue('type_data');
		}
		else
		{
			$previousTypeHandler = $this->getTypeHandler(false, false);
			if (!$previousTypeHandler)
			{
				// if we don't have a previous type, just ignore the data
				return [];
			}

			$defaultData = $previousTypeHandler->getDefaultTypeData();
			$data = $this->getExistingValue('type_data');
		}

		return array_replace($defaultData, $data);
	}

	/**
	 * @return array
	 */
	public function getPostIds()
	{
		return $this->db()->fetchAllColumn("
			SELECT post_id
			FROM xf_post
			WHERE thread_id = ?
			ORDER BY post_date
		", $this->thread_id);
	}

	/**
	 * @return array
	 */
	public function getLastPostCache()
	{
		return [
			'post_id' => $this->last_post_id,
			'user_id' => $this->last_post_user_id,
			'username' => $this->last_post_username,
			'post_date' => $this->last_post_date
		];
	}

	public function getBreadcrumbs($includeSelf = true)
	{
		$breadcrumbs = $this->Forum ? $this->Forum->getBreadcrumbs() : [];
		if ($includeSelf)
		{
			$breadcrumbs[] = [
				'href' => $this->app()->router('public')->buildLink('threads', $this),
				'value' => $this->title
			];
		}

		return $breadcrumbs;
	}

	public function getLdStructuredData(Post $firstDisplayedPost, int $page = 1, array $extraData = [])
	{
		$output = $this->TypeHandler->getLdStructuredData($this, $firstDisplayedPost, $page, $extraData);

		return Arr::filterNull($output, true);
	}

	public function getReplyMicrodataType(): string
	{
		return $this->TypeHandler->getReplyMicrodataType($this);
	}

	public function rebuildCounters()
	{
		$this->rebuildFirstPostInfo();
		$this->rebuildLastPostInfo();
		$this->rebuildReplyCount();

		$this->TypeHandler->onThreadRebuildCounters($this);
	}

	public function rebuildFirstPostInfo()
	{
		$firstPost = $this->db()->fetchRow("
			SELECT post_id, post_date, user_id, username, reaction_score, reactions
			FROM xf_post USE INDEX (thread_id_post_date)
			WHERE thread_id = ?
			ORDER BY post_date
			LIMIT 1
		", $this->thread_id);
		if (!$firstPost)
		{
			return false;
		}

		// TODO: sanity check first post to make sure it's visible and force it? Might break other counters though

		$this->first_post_id = $firstPost['post_id'];
		$this->post_date = $firstPost['post_date'];
		$this->user_id = $firstPost['user_id'];
		$this->username = $firstPost['username'] ?: '-';
		$this->first_post_reaction_score = $firstPost['reaction_score'];
		$this->first_post_reactions = $firstPost['reactions'] ? json_decode($firstPost['reactions'], true) : [];

		return true;
	}

	public function rebuildLastPostInfo()
	{
		$lastPost = $this->db()->fetchRow("
			SELECT post_id, post_date, user_id, username
			FROM xf_post USE INDEX (thread_id_post_date)
			WHERE thread_id = ?
				AND message_state = 'visible'
			ORDER BY post_date DESC
			LIMIT 1
		", $this->thread_id);
		if (!$lastPost)
		{
			return false;
		}

		$this->last_post_id = $lastPost['post_id'];
		$this->last_post_date = $lastPost['post_date'];
		$this->last_post_user_id = $lastPost['user_id'];
		$this->last_post_username = $lastPost['username'] ?: '-';

		return true;
	}

	public function rebuildReplyCount()
	{
		$visiblePosts = $this->db()->fetchOne("
			SELECT COUNT(*)
			FROM xf_post
			WHERE thread_id = ?
				AND message_state = 'visible'
		", $this->thread_id);
		$this->reply_count = max(0, $visiblePosts - 1);

		return $this->reply_count;
	}

	public function postAdded(Post $post)
	{
		if (!$this->first_post_id)
		{
			$this->first_post_id = $post->post_id;
		}
		else
		{
			$this->reply_count++;
		}

		if ($post->post_date >= $this->last_post_date)
		{
			$this->last_post_date = $post->post_date;
			$this->last_post_id = $post->post_id;
			$this->last_post_user_id = $post->user_id;
			$this->last_post_username = $post->username;
		}

		unset($this->_getterCache['post_ids']);

		$this->TypeHandler->onVisiblePostAdded($this, $post);
	}

	public function postRemoved(Post $post)
	{
		$this->reply_count--;

		if ($post->post_id == $this->first_post_id)
		{
			$this->rebuildFirstPostInfo();
		}

		if ($post->post_id == $this->last_post_id)
		{
			$this->rebuildLastPostInfo();
		}

		unset($this->_getterCache['post_ids']);

		$this->TypeHandler->onVisiblePostRemoved($this, $post);
	}

	protected function verifyDiscussionType(&$value)
	{
		if ($value === '')
		{
			$forum = $this->Forum;
			if ($forum)
			{
				$value = $forum->TypeHandler->getDefaultThreadType($forum);
			}
			else
			{
				$value = \XF\ThreadType\AbstractHandler::BASIC_THREAD_TYPE;
			}
		}

		if ($value !== $this->getExistingValue('discussion_type'))
		{
			// type has been changed so wipe out the old data
			$this->type_data = [];
		}

		return true;
	}

	protected function _preSave()
	{
		$forum = $this->Forum;

		if ($forum)
		{
			if ($this->prefix_id && ($this->isChanged(['prefix_id', 'node_id'])))
			{
				if (!$forum->isPrefixValid($this->prefix_id))
				{
					$this->prefix_id = 0;
				}
			}

			$forumTypeHandler = $forum ? $forum->TypeHandler : null;

			if (!$this->discussion_type)
			{
				// never been explicitly set, so go with the default
				$this->discussion_type = $forumTypeHandler->getDefaultThreadType($forum);
			}
			else if ($this->isUpdate() && $this->isChanged('node_id') && !$this->isChanged('discussion_type'))
			{
				// Forum move with implicit type change checks
				if (!$forumTypeHandler->isThreadTypeAllowed($this->discussion_type, $forum))
				{
					$this->discussion_type = $forumTypeHandler->getDefaultThreadType($forum);
				}
			}
			else if ($this->isChanged('discussion_type'))
			{
				// Explicit type change, just validate that the type is allowed
				if (!$forumTypeHandler->isThreadTypeAllowed($this->discussion_type, $forum))
				{
					$this->discussion_type = $forumTypeHandler->getDefaultThreadType($forum);
				}
			}
		}

		if ($this->isChanged('discussion_type') && !$this->app()->threadType($this->discussion_type, false))
		{
			// account for the type not being known, but only if changing it
			$this->error(\XF::phrase('please_select_valid_thread_type'), 'discussion_type');
		}

		$isTypeEntered = ($this->isInsert() || $this->isChanged('discussion_type'));
		$this->TypeHandler->onThreadPreSave($this, $isTypeEntered);
	}

	protected function _postSave()
	{
		$visibilityChange = $this->isStateChanged('discussion_state', 'visible');
		$approvalChange = $this->isStateChanged('discussion_state', 'moderated');
		$deletionChange = $this->isStateChanged('discussion_state', 'deleted');

		if ($this->isUpdate())
		{
			if ($visibilityChange == 'enter')
			{
				$this->threadMadeVisible();

				if ($approvalChange)
				{
					$this->submitHamData();
				}
			}
			else if ($visibilityChange == 'leave')
			{
				$this->threadHidden();
			}

			if ($this->isChanged('node_id'))
			{
				$oldForum = $this->getExistingRelation('Forum');
				if ($oldForum && $this->Forum)
				{
					$this->threadMoved($oldForum, $this->Forum);
				}
			}

			if ($deletionChange == 'leave' && $this->DeletionLog)
			{
				$this->DeletionLog->delete();
			}

			if ($approvalChange == 'leave' && $this->ApprovalQueue)
			{
				$this->ApprovalQueue->delete();
			}
		}

		if ($approvalChange == 'enter')
		{
			$approvalQueue = $this->getRelationOrDefault('ApprovalQueue', false);
			$approvalQueue->content_date = $this->post_date;
			$approvalQueue->save();
		}
		else if ($deletionChange == 'enter' && !$this->DeletionLog)
		{
			$delLog = $this->getRelationOrDefault('DeletionLog', false);
			$delLog->setFromVisitor();
			$delLog->save();
		}

		$this->updateForumRecord();

		$isTypeEntered = ($this->isInsert() || $this->isChanged('discussion_type'));
		if ($isTypeEntered)
		{
			if ($this->isUpdate())
			{
				$oldTypeHandler = $this->getTypeHandler(false, false);
				$oldTypeData = $oldTypeHandler ? $this->getTypeData(false) : [];

				$this->TypeHandler->onThreadEnterType($this, $this->type_data, $oldTypeHandler, $oldTypeData);

				if ($oldTypeHandler)
				{
					$oldTypeHandler->onThreadLeaveType($this, $oldTypeData, false);
				}
			}
			else
			{
				$this->TypeHandler->onThreadEnterType($this, $this->type_data);
			}
		}

		$this->TypeHandler->onThreadSave($this, $isTypeEntered);

		if ($this->isUpdate() && $this->getOption('log_moderator'))
		{
			$this->app()->logger()->logModeratorChanges('thread', $this);
		}
	}

	protected function threadMadeVisible()
	{
		// TODO: this may need a different process with big threads
		$this->adjustUserMessageCountIfNeeded(1);

		/** @var \XF\Repository\Reaction $reactionRepo */
		$reactionRepo = $this->repository('XF:Reaction');
		$reactionRepo->recalculateReactionIsCounted('post', $this->post_ids);

		$this->TypeHandler->onThreadMadeVisible($this);
	}

	protected function threadHidden($hardDelete = false)
	{
		$this->adjustUserMessageCountIfNeeded(-1);

		if (!$hardDelete)
		{
			// hard delete will remove the reactions, so skip that here

			/** @var \XF\Repository\Reaction $reactionRepo */
			$reactionRepo = $this->repository('XF:Reaction');
			$reactionRepo->fastUpdateReactionIsCounted('post', $this->post_ids, false);
		}

		/** @var \XF\Repository\UserAlert $alertRepo */
		$alertRepo = $this->repository('XF:UserAlert');
		$alertRepo->fastDeleteAlertsForContent('post', $this->post_ids);

		if ($hardDelete)
		{
			$alertRepo->fastDeleteAlertsForContent('thread', $this->thread_id);
		}

		if ($this->discussion_type != 'redirect')
		{
			/** @var \XF\Repository\ThreadRedirect $redirectRepo */
			$redirectRepo = $this->repository('XF:ThreadRedirect');
			$redirectRepo->deleteRedirectsToThread($this);
		}

		$this->TypeHandler->onThreadHidden($this, $hardDelete);
	}

	protected function submitHamData()
	{
		/** @var \XF\Spam\ContentChecker $submitter */
		$submitter = $this->app()->container('spam.contentHamSubmitter');
		$submitter->submitHam('thread', $this->thread_id);
	}

	protected function threadMoved(Forum $from, Forum $to)
	{
		if (!$this->isStateChanged('discussion_state', 'visible')
			&& $this->discussion_state == 'visible'
		)
		{
			$newCounts = $to->count_messages;
			$oldCounts = $from->count_messages;
			if ($newCounts != $oldCounts)
			{
				$this->adjustUserMessageCountIfNeeded($newCounts ? 1 : -1, true);
			}
		}

		/** @var \XF\Repository\ThreadRedirect $redirectRepo */
		$redirectRepo = $this->repository('XF:ThreadRedirect');

		if ($this->discussion_type == 'redirect')
		{
			$redirectRepo->rebuildThreadRedirectKey($this);
		}
		else
		{
			if ($this->Forum)
			{
				$redirectRepo->deleteRedirectsToThreadInForum($this, $to);
			}
		}
	}

	protected function adjustUserMessageCountIfNeeded($direction, $forceChange = false)
	{
		if ($this->discussion_type == 'redirect')
		{
			return;
		}

		if ($forceChange || !empty($this->Forum->count_messages))
		{
			$updates = $this->db()->fetchPairs("
				SELECT user_id, COUNT(*)
				FROM xf_post
				WHERE thread_id = ?
					AND user_id > 0
					AND message_state = 'visible'
				GROUP BY user_id
			", $this->thread_id);

			$operator = $direction > 0 ? '+' : '-';
			foreach ($updates AS $userId => $adjust)
			{
				$this->db()->query("
					UPDATE xf_user
					SET message_count = GREATEST(0, CAST(message_count AS SIGNED) {$operator} ?)
					WHERE user_id = ?
				", [$adjust, $userId]);

				/** @var \XF\Entity\User $userEntity */
				$userEntity = $this->em()->findCached('XF:User', $userId);
				if ($userEntity)
				{
					$userEntity->setAsSaved('message_count', max(0, $userEntity->message_count + ($direction > 0 ? $adjust : -$adjust) ));
				}
			}
		}
	}

	protected function updateForumRecord()
	{
		if (!$this->Forum)
		{
			return;
		}

		/** @var \XF\Entity\Forum $forum */
		$forum = $this->Forum;

		if ($this->isUpdate() && $this->isChanged('node_id'))
		{
			// thread moved, trumps the rest
			if ($this->discussion_state == 'visible')
			{
				$forum->threadAdded($this);
				$forum->save();
			}

			if ($this->getExistingValue('discussion_state') == 'visible')
			{
				/** @var Forum $oldForum */
				$oldForum = $this->getExistingRelation('Forum');
				if ($oldForum)
				{
					$oldForum->threadRemoved($this);
					$oldForum->save();
				}
			}

			return;
		}

		// check for thread entering/leaving visible
		$visibilityChange = $this->isStateChanged('discussion_state', 'visible');
		if ($visibilityChange == 'enter' && $this->Forum)
		{
			$forum->threadAdded($this);
			$forum->save();
			return;
		}
		else if ($visibilityChange == 'leave' && $this->Forum)
		{
			$forum->threadRemoved($this);
			$forum->save();
			return;
		}

		// general data changes
		if ($this->discussion_state == 'visible'
			&& $this->isChanged(['last_post_date', 'reply_count', 'title', 'discussion_type'])
		)
		{
			$forum->threadDataChanged($this);
			$forum->save();
		}
	}

	protected function _postDelete()
	{
		if ($this->discussion_state == 'visible')
		{
			$this->threadHidden(true);
		}

		if ($this->Forum && $this->discussion_state == 'visible')
		{
			$this->Forum->threadRemoved($this);
			$this->Forum->save();
		}

		if ($this->discussion_state == 'deleted' && $this->DeletionLog)
		{
			$this->DeletionLog->delete();
		}

		if ($this->discussion_state == 'moderated' && $this->ApprovalQueue)
		{
			$this->ApprovalQueue->delete();
		}

		$this->TypeHandler->onThreadLeaveType($this, $this->type_data, true);
		$this->TypeHandler->onThreadDelete($this);

		if ($this->getOption('log_moderator'))
		{
			$this->app()->logger()->logModeratorAction('thread', $this, 'delete_hard');
		}

		$db = $this->db();

		$postIds = $this->post_ids;
		if ($postIds)
		{
			$this->_postDeletePosts($postIds);
		}

		$db->delete('xf_thread_read', 'thread_id = ?', $this->thread_id);
		$db->delete('xf_thread_view', 'thread_id = ?', $this->thread_id);
		$db->delete('xf_thread_watch', 'thread_id = ?', $this->thread_id);
		$db->delete('xf_thread_reply_ban', 'thread_id = ?', $this->thread_id);
		$db->delete('xf_thread_user_post', 'thread_id = ?', $this->thread_id);
		$db->delete('xf_thread_field_value', 'thread_id = ?', $this->thread_id);
	}

	protected function _postDeletePosts(array $postIds)
	{
		$db = $this->db();

		/** @var \XF\Repository\Attachment $attachRepo */
		$attachRepo = $this->repository('XF:Attachment');
		$attachRepo->fastDeleteContentAttachments('post', $postIds);

		/** @var \XF\Repository\Reaction $reactionRepo */
		$reactionRepo = $this->repository('XF:Reaction');
		$reactionRepo->fastDeleteReactions('post', $postIds);

		$db->delete('xf_post', 'post_id IN (' . $db->quote($postIds) . ')');

		$db->delete('xf_approval_queue', 'content_id IN (' . $db->quote($postIds) . ') AND content_type = ?', 'post');
		$db->delete('xf_deletion_log', 'content_id IN (' . $db->quote($postIds) . ') AND content_type = ?', 'post');
		$db->delete('xf_edit_history', 'content_id IN (' . $db->quote($postIds) . ') AND content_type = ?', 'post');
		$db->delete('xf_news_feed', 'content_id IN (' . $db->quote($postIds) . ') AND content_type = ?', 'post');
	}

	public function softDelete($reason = '', User $byUser = null)
	{
		$byUser = $byUser ?: \XF::visitor();

		$db = $this->db();
		$db->beginTransaction();

		$rawThread = $db->fetchRow("
			SELECT *
			FROM xf_thread
			WHERE thread_id = ?
			FOR UPDATE
		", $this->thread_id);

		if ($rawThread['discussion_state'] == 'deleted')
		{
			$db->commit();
			return false;
		}

		$this->discussion_state = 'deleted';

		/** @var \XF\Entity\DeletionLog $deletionLog */
		$deletionLog = $this->getRelationOrDefault('DeletionLog');
		$deletionLog->setFromUser($byUser);
		$deletionLog->delete_reason = $reason;

		$this->save(true, false);

		$db->commit();

		return true;
	}

	public function rebuildThreadFieldValuesCache()
	{
		$this->repository('XF:ThreadField')->rebuildThreadFieldValuesCache($this->thread_id);
	}

	/**
	 * @param \XF\Api\Result\EntityResult $result
	 * @param int $verbosity
	 * @param array $options
	 *
	 * @api-out str $username
	 * @api-out bool $is_watching <cond> If accessing as a user, true if they are watching this thread
	 * @api-out int $visitor_post_count <cond> If accessing as a user, the number of posts they have made in this thread
	 * @api-out bool $is_unread <cond> If accessing as a user, true if this thread is unread
	 * @api-out object $custom_fields Key-value pairs of custom field values for this thread
	 * @api-out array $tags
	 * @api-out str $prefix <cond> Present if this thread has a prefix. Printable name of the prefix.
	 * @api-out bool $can_edit
	 * @api-out bool $can_edit_tags
	 * @api-out bool $can_reply
	 * @api-out bool $can_soft_delete
	 * @api-out bool $can_hard_delete
	 * @api-out bool $can_view_attachments
	 * @api-out string $view_url
	 * @api-out bool $is_first_post_pinned
	 * @api-out array $highlighted_post_ids
	 * @api-out Node $Forum <cond> If requested by context, the forum this thread was posted in.
	 * @api-see XF\Entity\ContentVoteTrait::addContentVoteToApiResult
	 */
	protected function setupApiResultData(
		\XF\Api\Result\EntityResult $result, $verbosity = self::VERBOSITY_NORMAL, array $options = []
	)
	{
		$result->username = $this->User ? $this->User->username : $this->username;

		$visitor = \XF::visitor();

		if ($visitor->user_id)
		{
			$result->is_watching = isset($this->Watch[$visitor->user_id]);
			$result->visitor_post_count = $this->getUserPostCount();

			$result->is_unread = $this->isUnread();
		}

		if (!empty($options['skip_forum']))
		{
			$result->skipRelation('Forum');
		}
		// TODO: option for first and last post? last poster?

		$result->custom_fields = (object)$this->custom_fields->getNamedFieldValues($this->Forum->field_cache);
		$result->tags = array_column($this->tags, 'tag');

		if ($this->prefix_id)
		{
			$result->prefix = \XF::phrase('thread_prefix.' . $this->prefix_id);
		}

		$this->TypeHandler->addTypeDataToApiResult($this, $result, $verbosity, $options);
		$this->addContentVoteToApiResult($result);

		$result->can_edit = $this->canEdit();
		$result->can_edit_tags = $this->canEditTags();
		$result->can_reply = $this->canReply();
		$result->can_soft_delete = $this->canDelete();
		$result->can_hard_delete = $this->canDelete('hard');
		$result->can_view_attachments = $this->canViewAttachments();

		$result->view_url = $this->getContentUrl(true);

		$result->is_first_post_pinned = $this->TypeHandler->isFirstPostPinned($this);
		$result->highlighted_post_ids = $this->TypeHandler->getHighlightedPostIds($this);
	}

	public function getContentUrl(bool $canonical = false, array $extraParams = [], $hash = null)
	{
		$route = $canonical ? 'canonical:threads' : 'threads';
		return $this->app()->router('public')->buildLink($route, $this, $extraParams, $hash);
	}

	public function getContentPublicRoute()
	{
		return 'threads';
	}

	public function getContentTitle(string $context = '')
	{
		return \XF::phrase('thread_x', ['title' => $this->title]);
	}

	public static function getStructure(Structure $structure)
	{
		$structure->table = 'xf_thread';
		$structure->shortName = 'XF:Thread';
		$structure->contentType = 'thread';
		$structure->primaryKey = 'thread_id';
		$structure->columns = [
			'thread_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true],
			'node_id' => ['type' => self::UINT, 'required' => true, 'api' => true],
			'title' => ['type' => self::STR, 'maxLength' => 150,
				'required' => 'please_enter_valid_title',
				'censor' => true,
				'api' => true
			],
			'reply_count' => ['type' => self::UINT, 'forced' => true, 'default' => 0, 'api' => true],
			'view_count' => ['type' => self::UINT, 'forced' => true, 'default' => 0, 'api' => true],
			'user_id' => ['type' => self::UINT, 'required' => true, 'api' => true],
			'username' => ['type' => self::STR, 'maxLength' => 50, 'required' => true, 'api' => true],
			'post_date' => ['type' => self::UINT, 'default' => 0, 'api' => true],
			'sticky' => ['type' => self::BOOL, 'default' => false, 'api' => true],
			'discussion_state' => ['type' => self::STR, 'default' => 'visible',
				'allowedValues' => ['visible', 'moderated', 'deleted'], 'api' => true
			],
			'discussion_open' => ['type' => self::BOOL, 'default' => true, 'api' => true],
			'discussion_type' => ['type' => self::STR, 'maxLength' => 50, 'default' => '', 'api' => true],
			'type_data' => ['type' => self::JSON_ARRAY, 'default' => []],
			'first_post_id' => ['type' => self::UINT, 'default' => 0, 'api' => true],
			'last_post_date' => ['type' => self::UINT, 'default' => 0, 'api' => true],
			'last_post_id' => ['type' => self::UINT, 'default' => 0, 'api' => true],
			'last_post_user_id' => ['type' => self::UINT, 'default' => 0, 'api' => true],
			'last_post_username' => ['type' => self::STR, 'maxLength' => 50, 'default' => '', 'api' => true],
			'first_post_reaction_score' => ['type' => self::INT, 'default' => 0, 'api' => true],
			'first_post_reactions' => ['type' => self::JSON_ARRAY, 'default' => [], 'nullable' => true],
			'prefix_id' => ['type' => self::UINT, 'default' => 0, 'api' => true],
			'custom_fields' => ['type' => self::JSON_ARRAY, 'default' => []],
			'tags' => ['type' => self::JSON_ARRAY, 'default' => []]
		];
		$structure->behaviors = [
			'XF:ContentVotable' => ['stateField' => 'discussion_state'],
			'XF:ContentVotableContainer' => [
				'childContentType' => 'post',
				'childIds' => function($thread) { return $thread->post_ids; },
				'stateField' => 'discussion_state'
			],
			'XF:Taggable' => ['stateField' => 'discussion_state'],
			'XF:Indexable' => [
				'checkForUpdates' => ['title', 'node_id', 'user_id', 'prefix_id', 'tags', 'discussion_state', 'first_post_id']
			],
			'XF:IndexableContainer' => [
				'childContentType' => 'post',
				'childIds' => function($thread) { return $thread->post_ids; },
				'checkForUpdates' => ['node_id', 'discussion_state', 'prefix_id']
			],
			'XF:NewsFeedPublishable' => [
				'usernameField' => 'username',
				'dateField' => 'post_date'
			],
			'XF:CustomFieldsHolder' => [
				'valueTable' => 'xf_thread_field_value',
				'checkForUpdates' => ['node_id'],
				'getAllowedFields' => function($thread) { return $thread->Forum ? $thread->Forum->field_cache : []; }
			]
		];
		$structure->getters = [
			'draft_reply' => true,
			'post_ids' => true,
			'last_post_cache' => true,
			'custom_fields' => true,
			'cover_image' => true,
			'TypeHandler' => [
				'cache' => true,
				'getter' => 'getTypeHandler',
				'invalidate' => ['discussion_type', 'node_id']
			],
			'type_data' => [
				'cache' => true,
				'getter' => 'getTypeData',
				'invalidate' => ['discussion_type', 'node_id']
			]
		];
		$structure->relations = [
			'Forum' => [
				'entity' => 'XF:Forum',
				'type' => self::TO_ONE,
				'conditions' => 'node_id',
				'primary' => true,
				'with' => 'Node',
				'api' => true
			],
			'User' => [
				'entity' => 'XF:User',
				'type' => self::TO_ONE,
				'conditions' => 'user_id',
				'primary' => true,
				'api' => true
			],
			'FirstPost' => [
				'entity' => 'XF:Post',
				'type' => self::TO_ONE,
				'conditions' => [['post_id', '=', '$first_post_id']],
				'primary' => true
			],
			'LastPost' => [
				'entity' => 'XF:Post',
				'type' => self::TO_ONE,
				'conditions' => [['post_id', '=', '$last_post_id']],
				'primary' => true
			],
			'LastPoster' => [
				'entity' => 'XF:User',
				'type' => self::TO_ONE,
				'conditions' => [['user_id', '=', '$last_post_user_id']],
				'primary' => true
			],
			'Prefix' => [
				'entity' => 'XF:ThreadPrefix',
				'type' => self::TO_ONE,
				'conditions' => 'prefix_id',
				'primary' => true
			],
			'Read' => [
				'entity' => 'XF:ThreadRead',
				'type' => self::TO_MANY,
				'conditions' => 'thread_id',
				'key' => 'user_id'
			],
			'Watch' => [
				'entity' => 'XF:ThreadWatch',
				'type' => self::TO_MANY,
				'conditions' => 'thread_id',
				'key' => 'user_id'
			],
			'UserPosts' => [
				'entity' => 'XF:ThreadUserPost',
				'type' => self::TO_MANY,
				'conditions' => 'thread_id',
				'key' => 'user_id'
			],
			'DeletionLog' => [
				'entity' => 'XF:DeletionLog',
				'type' => self::TO_ONE,
				'conditions' => [
					['content_type', '=', 'thread'],
					['content_id', '=', '$thread_id']
				],
				'primary' => true
			],
			'DraftReplies' => [
				'entity' => 'XF:Draft',
				'type' => self::TO_MANY,
				'conditions' => [
					['draft_key', '=', 'thread-', '$thread_id']
				],
				'key' => 'user_id'
			],
			'ApprovalQueue' => [
				'entity' => 'XF:ApprovalQueue',
				'type' => self::TO_ONE,
				'conditions' => [
					['content_type', '=', 'thread'],
					['content_id', '=', '$thread_id']
				],
				'primary' => true
			],
			'Redirect' => [
				'entity' => 'XF:ThreadRedirect',
				'type' => self::TO_ONE,
				'conditions' => 'thread_id',
				'primary' => true
			],
			'ReplyBans' => [
				'entity' => 'XF:ThreadReplyBan',
				'type' => self::TO_MANY,
				'conditions' => 'thread_id',
				'key' => 'user_id'
			],
			'Poll' => [
				'entity' => 'XF:Poll',
				'type' => self::TO_ONE,
				'conditions' => [
					['content_type', '=', 'thread'],
					['content_id', '=', '$thread_id']
				]
			],
			'CustomFields' => [
				'entity' => 'XF:ThreadFieldValue',
				'type' => self::TO_MANY,
				'conditions' => 'thread_id',
				'key' => 'field_id'
			],
			'Question' => [
				'entity' => 'XF:ThreadQuestion',
				'type' => self::TO_ONE,
				'conditions' => 'thread_id',
				'primary' => true
			],
			'Tags' => [
				'entity' => 'XF:TagContent',
				'type' => self::TO_MANY,
				'conditions' => [
					['content_type', '=', 'thread'],
					['content_id', '=', '$thread_id']
				],
				'key' => 'tag_id'
			]
		];

		$structure->columnAliases = [
			'first_post_likes' => 'first_post_reaction_score'
		];

		$structure->options = [
			'log_moderator' => true
		];

		$structure->withAliases = [
			'full' => [
				'User',
				'LastPoster',
				function()
				{
					$userId = \XF::visitor()->user_id;
					if ($userId)
					{
						return [
							'Read|' . $userId,
							'UserPosts|' . $userId,
							'Watch|' . $userId
						];
					}

					return null;
				}
			],
			'fullForum' => [
				'full',
				function()
				{
					$with = ['Forum', 'Forum.Node'];

					$userId = \XF::visitor()->user_id;
					if ($userId)
					{
						$with[] = 'Forum.Read|' . $userId;
						$with[] = 'Forum.Watch|' . $userId;
					}

					return $with;
				}
			],
			'api' => [
				'Forum.api',
				'User.api',
				function()
				{
					$userId = \XF::visitor()->user_id;
					if ($userId)
					{
						return [
							'Read|' . $userId,
							'Forum.Read|' . $userId,
							'UserPosts|' . $userId,
							'Watch|' . $userId,
							'ReplyBans|' . $userId,
							'ContentVotes|' . $userId,
						];
					}

					return null;
				}
			]
		];

		self::addVotableStructureElements($structure);

		return $structure;
	}
}