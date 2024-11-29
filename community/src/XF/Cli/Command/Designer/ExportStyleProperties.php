<?php

namespace XF\Cli\Command\Designer;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExportStyleProperties extends AbstractExportCommand
{
	protected function getContentTypeDetails()
	{
		return [
			'name' => 'style properties',
			'command' => 'style-properties',
			'entity' => 'XF:StyleProperty'
		];
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$returnCode = parent::execute($input, $output);
		if (!$returnCode)
		{
			$style = $this->getStyleByDesignerModeInput($input, $output);

			// success
			$write = function($entity)
			{
				\XF::app()->designerOutput()->export($entity);
			};
			$this->exportData($input, $output, 'style property groups', 'XF:StylePropertyGroup', $style, $write);
		}

		return $returnCode;
	}
}