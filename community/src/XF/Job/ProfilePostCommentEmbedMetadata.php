<?php

namespace XF\Job;

use XF\Mvc\Entity\Entity;

class ProfilePostCommentEmbedMetadata extends AbstractEmbedMetadataJob
{
	protected function getIdsToRebuild(array $types)
	{
		return $this->getIdsBug153298Workaround('profile_post_comment');
	}

	protected function getRecordToRebuild($id)
	{
		return $this->app->em()->find('XF:ProfilePostComment', $id);
	}

	protected function getPreparerContext()
	{
		return 'profile_post_comment';
	}

	protected function getMessageContent(Entity $record)
	{
		return $record->message;
	}

	protected function rebuildAttachments(Entity $record, \XF\Service\Message\Preparer $preparer, array &$embedMetadata)
	{
		$embedMetadata['attachments'] = $preparer->getEmbeddedAttachments();
	}

	protected function getActionDescription()
	{
		$rebuildPhrase = \XF::phrase('rebuilding');
		$type = \XF::phrase('profile_post_comments');
		return sprintf('%s... %s', $rebuildPhrase, $type);
	}
}