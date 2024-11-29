<?php

namespace XF\ControllerPlugin;

class AdminSection extends AbstractPlugin
{
	public function actionView(string $navId, $title = null, string $viewClass = null, string $templateName = null, array $viewParams = [])
	{
		/** @var \XF\Entity\AdminNavigation $entry */
		$entry = $this->assertRecordExists('XF:AdminNavigation', $navId);

		$viewParams += [
			'title' => $title ?: $entry->title,
			'entry' => $entry
		];
		return $this->view($viewClass ?: 'XF:AdminSection', $templateName ?: 'admin_section', $viewParams);
	}
}