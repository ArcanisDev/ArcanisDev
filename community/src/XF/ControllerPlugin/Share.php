<?php

namespace XF\ControllerPlugin;

class Share extends AbstractPlugin
{
	public function actionTooltip($contentUrl, $contentTitle, $tooltipTitle = null, $contentDesc = null)
	{
		if ($this->filter('_xfWithData', 'bool') && $this->filter('web_share', 'bool'))
		{
			$view = $this->view('XF:Share\WebShare', '');

			$view->setJsonParams([
				'contentUrl' => $contentUrl,
				'contentTitle' => \XF::renderPlainString($contentTitle),
				'contentDesc' => \XF::renderPlainString($contentDesc),
			]);

			return $view;
		}
		else
		{
			$viewParams = [
				'contentUrl' => $contentUrl,
				'contentTitle' => $contentTitle,
				'contentDesc' => $contentDesc,
				'tooltipTitle' => $tooltipTitle ?: \XF::phrase('share_this_content')
			];
			return $this->view('XF:Share\Tooltip', 'share_tooltip', $viewParams);
		}
	}
}