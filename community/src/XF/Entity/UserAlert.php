<?php

namespace XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int|null $alert_id
 * @property int $alerted_user_id
 * @property int $user_id
 * @property string $username
 * @property string $content_type
 * @property int $content_id
 * @property string $action
 * @property int $event_date
 * @property int $view_date
 * @property int $read_date
 * @property bool $auto_read
 * @property array $extra_data
 * @property string $depends_on_addon_id
 *
 * GETTERS
 * @property Entity|null $Content
 *
 * RELATIONS
 * @property \XF\Entity\User $User
 * @property \XF\Entity\User $Receiver
 * @property \XF\Entity\AddOn $AddOn
 */
class UserAlert extends Entity
{
	public function canView(&$error = null)
	{
		$handler = $this->getHandler();
		$content = $this->Content;

		if ($handler && $content)
		{
			return $handler->canViewContent($content, $error) && $handler->canViewAlert($this, $error);
		}
		else
		{
			return false;
		}
	}

	public function getHandler()
	{
		return $this->getAlertRepo()->getAlertHandler($this->content_type);
	}

	/**
	 * @return Entity|null
	 */
	public function getContent()
	{
		$handler = $this->getHandler();
		return $handler ? $handler->getContent($this->content_id) : null;
	}

	public function setContent(Entity $content = null)
	{
		$this->_getterCache['Content'] = $content;
	}

	public function render()
	{
		$handler = $this->getHandler();
		return $handler ? $handler->render($this) : '';
	}

	public function isAlertRenderable()
	{
		$handler = $this->getHandler();
		return $handler ? $handler->isAlertRenderable($this) : false;
	}

	/**
	 * @return bool
	 */
	public function isUnviewed()
	{
		return !$this->view_date;
	}

	/**
	 * @return bool
	 */
	public function isUnread()
	{
		return !$this->read_date;
	}

	/**
	 * @return bool
	 */
	public function isUnreadInUi(): bool
	{
		if ($this->getOption('force_unread_in_ui'))
		{
			return true;
		}

		return !$this->read_date;
	}

	public function isRecentlyRead()
	{
		return ($this->read_date && $this->read_date >= \XF::$time - 900);
	}

	protected function _postSave()
	{
		if ($this->isChanged('view_date'))
		{
			if (!$this->view_date)
			{
				$this->db()->query("
					UPDATE IGNORE xf_user
					SET alerts_unviewed = alerts_unviewed + 1
					WHERE user_id = ?
				", $this->alerted_user_id);
			}
			else if ($this->isUpdate())
			{
				$this->db()->query("
					UPDATE xf_user
					SET alerts_unviewed = GREATEST(0, CAST(alerts_unviewed AS SIGNED) - 1)
					WHERE user_id = ?
				", $this->alerted_user_id);
			}
		}
		if ($this->isChanged('read_date'))
		{
			if (!$this->read_date)
			{
				$this->db()->query("
					UPDATE IGNORE xf_user
					SET alerts_unread = alerts_unread + 1
					WHERE user_id = ?
				", $this->alerted_user_id);
			}
			else if ($this->isUpdate())
			{
				$this->db()->query("
					UPDATE xf_user
					SET alerts_unread = GREATEST(0, CAST(alerts_unread AS SIGNED) - 1)
					WHERE user_id = ?
				", $this->alerted_user_id);
			}
		}
	}

	protected function _postDelete()
	{
		if (!$this->view_date)
		{
			$this->db()->query("
				UPDATE xf_user
				SET alerts_unviewed = GREATEST(0, CAST(alerts_unviewed AS SIGNED) - 1)
				WHERE user_id = ?
			", $this->alerted_user_id);
		}
		if (!$this->read_date)
		{
			$this->db()->query("
				UPDATE xf_user
				SET alerts_unread = GREATEST(0, CAST(alerts_unread AS SIGNED) - 1)
				WHERE user_id = ?
			", $this->alerted_user_id);
		}
	}

	protected function setupApiResultData(
		\XF\Api\Result\EntityResult $result, $verbosity = self::VERBOSITY_NORMAL, array $options = []
	)
	{
		$handler = $this->getHandler();
		if ($handler)
		{
			$output = $handler->getApiOutput($this);
			if ($output)
			{
				$result->alert_text = $output['text'];
				$result->alert_url = $output['url'];
			}
		}
	}

	public static function getStructure(Structure $structure)
	{
		$structure->table = 'xf_user_alert';
		$structure->shortName = 'XF:UserAlert';
		$structure->primaryKey = 'alert_id';
		$structure->columns = [
			'alert_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true],
			'alerted_user_id' => ['type' => self::UINT, 'required' => true, 'api' => true],
			'user_id' => ['type' => self::UINT, 'default' => 0, 'api' => true],
			'username' => ['type' => self::STR, 'maxLength' => 50, 'default' => '', 'api' => true],
			'content_type' => ['type' => self::STR, 'maxLength' => 25, 'required' => true, 'api' => true],
			'content_id' => ['type' => self::UINT, 'required' => true, 'api' => true],
			'action' => ['type' => self::STR, 'maxLength' => 30, 'required' => true, 'api' => true],
			'event_date' => ['type' => self::UINT, 'default' => \XF::$time, 'api' => true],
			'view_date' => ['type' => self::UINT, 'default' => 0, 'api' => true],
			'read_date' => ['type' => self::UINT, 'default' => 0, 'api' => true],
			'auto_read' => ['type' => self::BOOL, 'default' => true, 'api' => true],
			'extra_data' => ['type' => self::JSON_ARRAY, 'default' => []],
			'depends_on_addon_id' => ['type' => self::BINARY, 'maxLength' => 50, 'default' => '']
		];
		$structure->getters = [
			'Content' => true
		];
		$structure->relations = [
			'User' => [
				'entity' => 'XF:User',
				'type' => self::TO_ONE,
				'conditions' => 'user_id',
				'primary' => true,
				'api' => true
			],
			'Receiver' => [
				'entity' => 'XF:User',
				'type' => self::TO_ONE,
				'conditions' =>[['user_id', '=', '$alerted_user_id']],
				'primary' => true
			],
			'AddOn' => [
				'entity' => 'XF:AddOn',
				'type' => self::TO_ONE,
				'conditions' => [['addon_id', '=', '$depends_on_addon_id']],
				'primary' => true
			]
		];
		$structure->options = [
			'force_unread_in_ui' => false
		];

		$structure->withAliases = [
			'api' => [
				'User.api'
			]
		];

		return $structure;
	}

	/**
	 * @return \XF\Repository\UserAlert
	 */
	protected function getAlertRepo()
	{
		return $this->repository('XF:UserAlert');
	}
}