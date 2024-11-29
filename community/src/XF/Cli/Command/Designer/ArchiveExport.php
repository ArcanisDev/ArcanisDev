<?php

namespace XF\Cli\Command\Designer;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use XF\Cli\Command\StyleArchiveTrait;
use XF\Util\File;

use function boolval;

class ArchiveExport extends Command
{
	use RequiresDesignerModeTrait, StyleArchiveTrait;

	protected function configure()
	{
		$this
			->setName('xf-designer:archive-export')
			->setDescription('Exports specified designer mode style to an archive for easier distribution. Exported to designer mode path in the _archive directory.')
			->addArgument(
				'designer-mode',
				InputArgument::REQUIRED,
				'Designer mode ID'
			)
			->addOption(
				'addon-id',
				'a',
				InputOption::VALUE_REQUIRED,
				'If specified, only templates and properties of the specified style will be exported.'
			)
			->addOption(
				'independent',
				'i',
				InputOption::VALUE_REQUIRED,
				'If selected, any customizations in parent styles will be included as if they were made in this style.'
			)
			->addOption(
				'skip-export',
				's',
				InputOption::VALUE_NONE,
				'If specified, exporting style from the database will be skipped.'
			);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$style = $this->getStyleByDesignerModeInput($input, $output);

		if (!\XF::repository('XF:Style')->canSupportStyleArchives())
		{
			$output->writeln('<error>Importing to/exporting from style archives is only supported if you have <code>ZipArchive</code> support. You may need to ask your host to enable this.</error>');
			return 1;
		}

		if (!$input->getOption('skip-export'))
		{
			$this->runExport($style->designer_mode, $output);
		}

		/** @var \XF\Service\Style\ArchiveExport $styleArchiveExporter */
		$styleArchiveExporter = \XF::service('XF:Style\ArchiveExport', $style);

		$addOnId = $input->getOption('addon-id');
		$addOn = $addOnId ? \XF::em()->find('XF:AddOn', $addOnId) : null;
		$styleArchiveExporter->setAddOn($addOn);

		$independent = $input->getOption('independent');
		$styleArchiveExporter->setIndependent(boolval($independent));

		$designerOutput = \XF::app()->designerOutput();

		$DS = \XF::$DS;

		$output->writeln(["", "Building archive."]);
		$tempFile = $styleArchiveExporter->build();
		$targetPath = $designerOutput->getDesignerModePath($style->designer_mode) . $DS . '_archive' . $DS . $styleArchiveExporter->getArchiveFileName();
		$stdPath = File::stripRootPathPrefix($targetPath);
		$output->writeln(["", "Copying archive to {$stdPath}"]);
		File::copyFile($tempFile, $targetPath, false);

		return 0;
	}
}