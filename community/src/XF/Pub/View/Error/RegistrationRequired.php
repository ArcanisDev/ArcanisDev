<?php

namespace XF\Pub\View\Error;

class RegistrationRequired extends \XF\Mvc\View
{
	public function renderJson()
	{
		$html = $this->renderTemplate($this->templateName, $this->params);

		return [
			'status' => 'error',
			'errors' => [$this->params['error']],
			'errorHtml' => $this->renderer->getHtmlOutputStructure($html)
		];
	}
}