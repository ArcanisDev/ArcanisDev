<?php

namespace XF\Import\Data;

class ContentVote extends AbstractEmulatedData
{
	public function getImportType()
	{
		return 'content_vote';
	}

	public function getEntityShortName()
	{
		return 'XF:ContentVote';
	}

	protected function postSave($oldId, $newId)
	{
		if ($this->is_content_user_counted && $this->content_user_id)
		{
			$this->db()->query("
				UPDATE xf_user
				SET vote_score = vote_score + ?
				WHERE user_id = ?
			", [$this->score, $this->content_user_id]);
		}

		$this->app()->repository('XF:ContentVote')->rebuildVoteCache(
			$this->content_type, $this->content_id, false
		);
	}
}