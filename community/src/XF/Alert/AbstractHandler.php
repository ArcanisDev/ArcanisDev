<?php

namespace XF\Alert;

use XF\Entity\UserAlert;
use XF\Mvc\Entity\Entity;

abstract class AbstractHandler
{
	protected $contentType;

	public function __construct($contentType)
	{
		$this->contentType = $contentType;
	}

	public function canViewContent(Entity $entity, &$error = null)
	{
		if (method_exists($entity, 'canView'))
		{
			return $entity->canView($error);
		}

		throw new \LogicException("Could not determine content viewability; please override");
	}

	public function canViewAlert(UserAlert $alert, &$error = null)
	{
		return true;
	}

	/**
	 * For alerts which are pushed, you can create a push specific template which should be text only.
	 * If no value is provided or the template does not exist, the push contents will come from a
	 * rendered version of the normal alert template with HTML tags stripped.
	 *
	 * @param $action
	 * @return string|null
	 */
	public function getPushTemplateName($action)
	{
		return 'public:push_' . $this->contentType . '_' . $action;
	}

	public function getTemplateName($action)
	{
		return 'public:alert_' . $this->contentType . '_' . $action;
	}

	public function getTemplateData($action, UserAlert $alert, Entity $content = null)
	{
		if (!$content)
		{
			$content = $alert->Content;
		}

		return [
			'alert' => $alert,
			'user' => $alert->User,
			'extra' => $alert->extra_data,
			'content' => $content
		];
	}

	public function render(UserAlert $alert, Entity $content = null)
	{
		if (!$content)
		{
			$content = $alert->Content;
			if (!$content)
			{
				return '';
			}
		}

		$action = $alert->action;
		$template = $this->getTemplateName($action);
		$data = $this->getTemplateData($action, $alert, $content);

		return \XF::app()->templater()->renderTemplate($template, $data);
	}

	public function isAlertRenderable(UserAlert $alert)
	{
		$template = $this->getTemplateName($alert->action);
		return \XF::app()->templater()->isKnownTemplate($template);
	}

	public function getApiOutput(UserAlert $alert)
	{
		$templater = \XF::app()->templater();
		$content = $alert->Content;
		if (!$content)
		{
			return null;
		}

		$templateName = $this->getPushTemplateName($alert->action);
		if (!$templater->isKnownTemplate($templateName))
		{
			$templateName = $this->getTemplateName($alert->action);
		}
		$templateData = $this->getTemplateData($alert->action, $alert, $content);

		$pushContent = $templater->renderTemplate($templateName, $templateData);

		if (preg_match('#<push:url>(.*)</push:url>#siU', $pushContent, $match))
		{
			$alertUrl = trim(htmlspecialchars_decode($match[1], ENT_QUOTES));
			$alertUrl = \XF::canonicalizeUrl($alertUrl);
		}
		else
		{
			$alertUrl = null;
		}

		$pushContent = preg_replace('#<(push:[a-z0-9_]+)>.*</\\1>#siU', '', $pushContent);
		$pushContent = strip_tags($pushContent);
		$pushContent = html_entity_decode($pushContent, ENT_QUOTES);
		$pushContent = trim($pushContent);

		return [
			'text' => $pushContent,
			'url' => $alertUrl
		];
	}

	public function getEntityWith()
	{
		return [];
	}

	public function getContent($id)
	{
		return \XF::app()->findByContentType($this->contentType, $id, $this->getEntityWith());
	}

	public function getContentType()
	{
		return $this->contentType;
	}

	/**
	 * An array of alert actions which can be opted out of for this type.
	 *
	 * @return array
	 */
	public function getOptOutActions()
	{
		return [];
	}

	/**
	 * The display order of this type's alert opt outs.
	 *
	 * @return int
	 */
	public function getOptOutDisplayOrder()
	{
		return 0;
	}

	/**
	 *
	 *
	 * @return array
	 */
	public function getOptOutsMap()
	{
		$optOuts = $this->getOptOutActions();
		if (!$optOuts)
		{
			return [];
		}

		return array_combine($optOuts, array_map(function($action)
		{
			return \XF::phrase('alert_opt_out.' . $this->contentType . '_' . $action);
		}, $optOuts));
	}
}