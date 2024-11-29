<?php

namespace XF\Cli\Command\Designer;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use XF\Cli\Command\StyleArchiveTrait;

class Export extends Command
{
	use RequiresDesignerModeTrait, StyleArchiveTrait;

	protected function configure()
	{
		$this
			->setName('xf-designer:export')
			->setDescription('Exports modified templates from the database to the file system for the specified designer mode.')
			->addArgument(
				'designer-mode',
				InputArgument::REQUIRED,
				'Designer mode ID'
			);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$style = $this->getStyleByDesignerModeInput($input, $output);

		$exporters = [
			'xf-designer:export-style-properties',
			'xf-designer:export-templates'
		];

		foreach ($exporters AS $exporter)
		{
			$command = $this->getApplication()->find($exporter);

			$i = [
				'command' => $exporter,
				'designer-mode' => $style->designer_mode
			];

			$childInput = new ArrayInput($i);
			$command->run($childInput, $output);
		}

		\XF::app()->designerOutput()->rebuildAssetsFile($style);

		return 0;
	}
}