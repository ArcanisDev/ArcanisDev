<?php

namespace XF\Repository;

use XF\Mvc\Entity\Repository;

class ErrorLog extends Repository
{
	public function clearErrorLog()
	{
		$this->db()->emptyTable('xf_error_log');
	}

	public function hasErrorsInLog()
	{
		$hasErrors = $this->db()->fetchOne('
			SELECT error_id
			FROM xf_error_log
			LIMIT 1
		');

		return (bool)$hasErrors;
	}
}