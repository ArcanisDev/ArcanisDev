<?php

namespace XF\Cli\Command\Designer;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use XF\Cli\Command\StyleArchiveTrait;

class RebuildMetadata extends Command
{
	use RequiresDesignerModeTrait, StyleArchiveTrait;

	protected function configure()
	{
		$this
			->setName('xf-designer:rebuild-metadata')
			->setDescription('Rebuilds metadata hashes based on file system content')
			->addArgument(
				'designer-mode',
				InputArgument::REQUIRED,
				'Designer mode ID'
			);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$style = $this->getStyleByDesignerModeInput($input, $output);

		$designerOutput = \XF::app()->designerOutput();
		$hasChanged = false;

		foreach ($designerOutput->getTypes() AS $type)
		{
			$changes = $designerOutput->rebuildTypeMetadata($type, $style->designer_mode);
			if ($changes)
			{
				$hasChanged = true;

				$output->writeln("Rebuilding metadata hashes $type:");
				foreach ($changes AS $addOnId => $files)
				{
					foreach ($files AS $file)
					{
						$output->writeln("\t$addOnId/$file");
					}
				}
			}
		}

		if (!$hasChanged)
		{
			$output->writeln("No changes necessary.");
		}

		return 0;
	}
}