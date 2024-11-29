<?php

namespace XF\Cli\Command\Designer;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

trait RequiresDesignerModeTrait
{
	public function run(InputInterface $input, OutputInterface $output)
	{
		$config = \XF::config();

		if (!$config['designer']['enabled'])
		{
			$output->writeln("<error>Designer mode is not enabled</error>");
			return 1;
		}

		return parent::run($input, $output);
	}

	protected function runExport($designerMode, OutputInterface $output)
	{
		$command = $this->getApplication()->find('xf-designer:export');

		$i = [
			'command' => 'xf-designer:export',
			'designer-mode' => $designerMode
		];

		$childInput = new ArrayInput($i);
		$command->run($childInput, $output);
	}

	protected function runImport($designerMode, OutputInterface $output)
	{
		$output->writeln("Importing style from designer mode files...");
		$output->writeln("");

		$command = $this->getApplication()->find('xf-designer:import');

		$i = [
			'command' => 'xf-designer:import',
			'designer-mode' => $designerMode
		];

		$childInput = new ArrayInput($i);
		$command->run($childInput, $output);
	}
}