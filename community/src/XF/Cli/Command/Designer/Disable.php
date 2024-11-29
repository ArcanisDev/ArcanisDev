<?php

namespace XF\Cli\Command\Designer;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use XF\Cli\Command\StyleArchiveTrait;
use XF\Util\File;

class Disable extends Command
{
	use RequiresDesignerModeTrait, StyleArchiveTrait;

	protected function configure()
	{
		$this
			->setName('xf-designer:disable')
			->setDescription('Disables designer mode on the specified style')
			->addArgument(
				'designer-mode',
				InputArgument::REQUIRED,
				'Designer mode ID'
			)
			->addOption(
				'clear',
				null,
				InputOption::VALUE_NONE,
				'If set, existing designer mode directory will be deleted.'
			);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$style = $this->getStyleByDesignerModeInput($input, $output);

		$designerModePath = \XF::app()->designerOutput()->getDesignerModePath($style->designer_mode);
		$style->designer_mode = null;

		if (!$style->preSave())
		{
			$output->writeln($style->getErrors());
			return 1;
		}

		$style->save();

		if ($input->getOption('clear'))
		{
			$printablePath = str_replace(\XF::getRootDirectory() . \XF::$DS, '', $designerModePath);

			if (file_exists($designerModePath))
			{
				File::deleteDirectory($designerModePath);

				$output->writeln(["", "Designer mode path '$printablePath' deleted."]);
			}
		}

		$output->writeln(["", "Designer mode disabled for '$style->title'", ""]);

		return 0;
	}
}