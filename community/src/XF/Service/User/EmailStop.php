<?php

namespace XF\Service\User;

use XF\Entity\User;
use XF\Service\AbstractService;

class EmailStop extends AbstractService
{
	/**
	 * @var User
	 */
	protected $user;

	/**
	 * @var \XF\EmailStop\AbstractHandler[]
	 */
	protected $handlers = [];

	public function __construct(\XF\App $app, User $user)
	{
		parent::__construct($app);

		$user->getBehavior('XF:ChangeLoggable')->setOption('forceEditUserId', $user->user_id);
		$option = $user->Option;
		if ($option)
		{
			$option->getBehavior('XF:ChangeLoggable')->setOption('forceEditUserId', $user->user_id);
		}

		$this->user = $user;

		$this->addHandlerClasses($app->getContentTypeField('email_stop_class'));
	}

	/**
	 * @return User
	 */
	public function getUser()
	{
		return $this->user;
	}

	public function getConfirmKey()
	{
		return $this->user->email_confirm_key;
	}

	public function addHandlerClasses(array $classes)
	{
		foreach ($classes AS $contentType => $handlerClass)
		{
			if (class_exists($handlerClass))
			{
				$class = \XF::extendClass($handlerClass);
				$this->handlers[$contentType] = new $class($contentType);
			}
		}
	}

	public function addHandler($contentType, \XF\EmailStop\AbstractHandler $handler)
	{
		$this->handlers[$contentType] = $handler;
	}

	public function getHandler($contentType)
	{
		return $this->handlers[$contentType] ?? null;
	}

	public function getActionOptions(array $actions)
	{
		$phrases = [];

		foreach ($actions AS $action)
		{
			switch ($action)
			{
				case 'list':
					$phrases[$action] = \XF::phrase('unsubscribe_from_x_mailing_list', ['title' => $this->app->options()->boardTitle]);
					break;

				case 'activity_summary':
					$phrases[$action] = \XF::phrase('stop_receiving_activity_summary_emails');
					break;

				case 'conversations':
					$phrases[$action] = \XF::phrase('stop_notification_emails_from_conversations');
					break;

				case 'all':
					// this will always be presented
					break;

				default:
					$parts = explode(':', $action, 2);
					$type = $parts[0];
					$id = $parts[1] ?? null;

					$handler = $this->getHandler($type);
					if ($handler)
					{
						if ($id)
						{
							$stopOne = $handler->getStopOneText($this->user, $id);
							if ($stopOne)
							{
								$phrases["$type:$id"] = $stopOne;
							}
						}

						$phrases[$type] = $handler->getStopAllText($this->user);
					}
			}
		}

		return $phrases;
	}

	public function stop($action)
	{
		switch ($action)
		{
			case 'all': return $this->stopAll();
			case 'list': return $this->stopMailingList();
			case 'activity_summary': return $this->stopActivitySummary();
			case 'conversations': return $this->stopConversations();
			case 'content': return $this->stopAllContent();

			default:
				$parts = explode(':', $action, 2);
				$type = $parts[0];
				$id = $parts[1] ?? null;

				return $this->stopContent($type, $id);
		}
	}

	public function stopAll()
	{
		$user = $this->user;
		$option = $user->Option;

		if ($option)
		{
			$user->addCascadedSave($option);

			$option->receive_admin_email = false;
			$option->email_on_conversation = false;
			if ($option->creation_watch_state == 'watch_email')
			{
				$option->creation_watch_state = 'watch_no_email';
			}
			if ($option->interaction_watch_state == 'watch_email')
			{
				$option->interaction_watch_state = 'watch_no_email';
			}
		}

		$user->last_summary_email_date = null;
		$user->save();

		$this->stopAllContent();

		return true;
	}

	public function stopMailingList()
	{
		$option = $this->user->Option;
		if ($option)
		{
			$option->receive_admin_email = false;
			$option->save();
		}

		return true;
	}

	public function stopActivitySummary()
	{
		$user = $this->user;

		$user->last_summary_email_date = null;
		$user->save();

		return true;
	}

	public function stopConversations()
	{
		$option = $this->user->Option;
		if ($option)
		{
			$option->email_on_conversation = false;
			$option->save();
		}

		return true;
	}

	public function stopAllContent()
	{
		foreach (array_keys($this->handlers) AS $contentType)
		{
			$this->stopContent($contentType);
		}

		return true;
	}

	public function stopContent($type, $id = null)
	{
		$handler = $this->getHandler($type);
		if ($handler)
		{
			if ($id)
			{
				$handler->stopOne($this->user, $id);
			}
			else
			{
				$handler->stopAll($this->user);
			}

			return true;
		}
		else
		{
			return false;
		}
	}
}