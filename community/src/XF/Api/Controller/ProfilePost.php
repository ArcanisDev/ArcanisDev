<?php

namespace XF\Api\Controller;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Finder;
use XF\Mvc\ParameterBag;

use function intval;

/**
 * @api-group Profile posts
 */
class ProfilePost extends AbstractController
{
	protected function preDispatchController($action, ParameterBag $params)
	{
		$this->assertApiScopeByRequestMethod('profile_post');
	}

	/**
	 * @api-desc Gets information about the specified profile post.
	 *
	 * @api-in   bool $with_comments If specified, the response will include a page of comments.
	 * @api-in   int $page The page of comments to include
	 *
	 * @api-out  ProfilePost $profile_post
	 * @api-see  self::getCommentsOnProfilePostPaginated()
	 */
	public function actionGet(ParameterBag $params)
	{
		$profilePost = $this->assertViewableProfilePost($params->profile_post_id, 'api|profile');

		if ($this->filter('with_comments', 'bool'))
		{
			$commentData = $this->getCommentsOnProfilePostPaginated($profilePost, $this->filterPage());
		}
		else
		{
			$commentData = [];
		}

		$result = $profilePost->toApiResult(
			Entity::VERBOSITY_VERBOSE, [
			'with_profile' => true
		]
		);

		$result = [
			'profile_post' => $result
		];
		$result += $commentData;

		return $this->apiResult($result);
	}

	/**
	 * @api-desc Gets a page of comments on the specified profile post.
	 *
	 * @api-in   int $page
	 *
	 * @api-see  self::getCommentsOnProfilePostPaginated
	 */
	public function actionGetComments(ParameterBag $params)
	{
		$profilePost = $this->assertViewableProfilePost($params->profile_post_id);

		$commentData = $this->getCommentsOnProfilePostPaginated($profilePost, $this->filterPage());

		return $this->apiResult($commentData);
	}

	/**
	 *
	 * @api-in  string $direction Request a particular sort order for comments - default 'desc' (newest first) also allows 'asc' (oldest first)
	 *
	 * @api-out ProfilePostComment[] $comments List of comments on the requested page
	 * @api-out pagination $pagination Pagination details
	 *
	 * @param \XF\Entity\ProfilePost $profilePost
	 * @param int                    $page
	 * @param null|int               $perPage
	 *
	 * @return array
	 *
	 * @throws \XF\Mvc\Reply\Exception
	 */
	protected function getCommentsOnProfilePostPaginated(\XF\Entity\ProfilePost $profilePost, $page = 1, $perPage = null)
	{
		$perPage = intval($perPage);
		if ($perPage <= 0)
		{
			$perPage = $this->options()->messagesPerPage;
		}

		$commentFinder = $this->setupCommentsFinder($profilePost);

		$total = $commentFinder->total();
		$this->assertValidApiPage($page, $perPage, $total);

		$commentFinder->limitByPage($page, $perPage);
		$postResults = $commentFinder->fetch()->toApiResults();

		/** @var \XF\Repository\Attachment $attachmentRepo */
		$attachmentRepo = $this->repository('XF:Attachment');
		$attachmentRepo->addAttachmentsToContent($postResults, 'profile_post_comment');

		return [
			'comments' => $postResults,
			'pagination' => $this->getPaginationData($postResults, $page, $perPage, $total)
		];
	}

	/**
	 * @param \XF\Entity\ProfilePost $profilePost
	 *
	 * @return \XF\Finder\ProfilePostComment
	 */
	protected function setupCommentsFinder(\XF\Entity\ProfilePost $profilePost)
	{
		/** @var \XF\Finder\ProfilePostComment $finder */
		$finder = $this->finder('XF:ProfilePostComment');
		$finder
			->forProfilePost($profilePost)
			->with('api');

		$this->applyCommentOrder($finder);

		return $finder;
	}

	/**
	 * @param Finder $finder
	 *
	 * @return array [order, direction] as applied
	 */
	protected function applyCommentOrder(Finder $finder): array
	{
		$order = 'comment_date'; // alternative orders are not available at this time

		$direction = $this->filter('direction', 'str');
		if ($direction !== 'asc')
		{
			$direction = 'desc';
		}

		$finder->order($order, $direction);

		return [$order, $direction];
	}

	/**
	 * @api-desc Updates the specified profile post.
	 *
	 * @api-in str $message
	 * @api-in bool $author_alert
	 * @api-in bool $author_alert_reason
	 * @api-in str $attachment_key API attachment key to upload files. Attachment key context type must be profile_post with context[profile_post_id] set to this profile post ID.
	 *
	 * @api-out true $success
	 * @api-out ProfilePost $profile_post
	 */
	public function actionPost(ParameterBag $params)
	{
		$profilePost = $this->assertViewableProfilePost($params->profile_post_id);

		if (\XF::isApiCheckingPermissions() && !$profilePost->canEdit($error))
		{
			return $this->noPermission($error);
		}

		$editor = $this->setupProfilePostEdit($profilePost);

		if (\XF::isApiCheckingPermissions())
		{
			$editor->checkForSpam();
		}

		if (!$editor->validate($errors))
		{
			return $this->error($errors);
		}

		$editor->save();

		return $this->apiSuccess([
			'profile_post' => $profilePost->toApiResult(Entity::VERBOSITY_VERBOSE)
		]);
	}

	/**
	 * @param \XF\Entity\ProfilePost $profilePost
	 *
	 * @return \XF\Service\ProfilePost\Editor
	 */
	protected function setupProfilePostEdit(\XF\Entity\ProfilePost $profilePost)
	{
		$input = $this->filter([
			'message' => '?str',
			'author_alert' => 'bool',
			'author_alert_reason' => 'str',
			'attachment_key' => 'str'
		]);

		/** @var \XF\Service\ProfilePost\Editor $editor */
		$editor = $this->service('XF:ProfilePost\Editor', $profilePost);

		if ($input['message'] !== null)
		{
			$editor->setMessage($input['message']);
		}

		if (\XF::isApiBypassingPermissions() || $profilePost->canUploadAndManageAttachments())
		{
			$hash = $this->getAttachmentTempHashFromKey(
				$input['attachment_key'],
				'profile_post',
				['profile_post_id' => $profilePost->profile_post_id]
			);
			$editor->setAttachmentHash($hash);
		}

		if ($input['author_alert'] && $profilePost->canSendModeratorActionAlert())
		{
			$editor->setSendAlert(true, $input['author_alert_reason']);
		}

		return $editor;
	}

	/**
	 * @api-desc Deletes the specified profile post. Default to soft deletion.
	 *
	 * @api-in bool $hard_delete
	 * @api-in str $reason
	 * @api-in bool $author_alert
	 * @api-in str $author_alert_reason
	 *
	 * @api-out true $success
	 */
	public function actionDelete(ParameterBag $params)
	{
		$profilePost = $this->assertViewableProfilePost($params->profile_post_id);

		if (\XF::isApiCheckingPermissions() && !$profilePost->canDelete('soft', $error))
		{
			return $this->noPermission($error);
		}

		$type = 'soft';
		$reason = $this->filter('reason', 'str');

		if ($this->filter('hard_delete', 'bool'))
		{
			$this->assertApiScope('profile_post:delete_hard');

			if (\XF::isApiCheckingPermissions() && !$profilePost->canDelete('hard', $error))
			{
				return $this->noPermission($error);
			}

			$type = 'hard';
		}

		/** @var \XF\Service\ProfilePost\Deleter $deleter */
		$deleter = $this->service('XF:ProfilePost\Deleter', $profilePost);

		if ($this->filter('author_alert', 'bool') && $profilePost->canSendModeratorActionAlert())
		{
			$deleter->setSendAlert(true, $this->filter('author_alert_reason', 'str'));
		}

		$deleter->delete($type, $reason);

		return $this->apiSuccess();
	}

	/**
	 * @api-desc Reacts to the specified profile post
	 *
	 * @api-see \XF\Api\ControllerPlugin\Reaction::actionReact()
	 */
	public function actionPostReact(ParameterBag $params)
	{
		$profilePost = $this->assertViewableProfilePost($params->profile_post_id);

		/** @var \XF\Api\ControllerPlugin\Reaction $reactPlugin */
		$reactPlugin = $this->plugin('XF:Api:Reaction');
		return $reactPlugin->actionReact($profilePost);
	}

	/**
	 * @param int $id
	 * @param string|array $with
	 *
	 * @return \XF\Entity\ProfilePost
	 *
	 * @throws \XF\Mvc\Reply\Exception
	 */
	protected function assertViewableProfilePost($id, $with = 'api')
	{
		return $this->assertViewableApiRecord('XF:ProfilePost', $id, $with);
	}
}