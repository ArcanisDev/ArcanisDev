<?php

namespace XF\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use XF\Util\File;

use function boolval;

class StyleArchiveExport extends Command
{
	use StyleArchiveTrait;

	protected function configure()
	{
		$this
			->setName('xf:style-archive-export')
			->setDescription('Exports the specified style to an archive.')
			->addArgument(
				'style-id',
				InputArgument::REQUIRED,
				'Style ID'
			)
			->addOption(
				'destination',
				'd',
				InputOption::VALUE_REQUIRED,
				'Destination to store the exported archive. Default: current working directory.'
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
			);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$style = $this->getStyleByStyleIdInput($input, $output);

		if (!\XF::repository('XF:Style')->canSupportStyleArchives())
		{
			$output->writeln('<error>Importing to/exporting from style archives is only supported if you have <code>ZipArchive</code> support. You may need to ask your host to enable this.</error>');
			return 1;
		}

		if ($style->designer_mode && \XF::config('designer')['enabled'])
		{
			$output->writeln("<error>The specified style has designer mode enabled. Please use the xf-designer commands to import/export.</error>");
			return 1;
		}

		/** @var \XF\Service\Style\ArchiveExport $styleArchiveExporter */
		$styleArchiveExporter = \XF::service('XF:Style\ArchiveExport', $style);

		$addOnId = $input->getOption('addon-id');
		$addOn = $addOnId ? \XF::em()->find('XF:AddOn', $addOnId) : null;
		$styleArchiveExporter->setAddOn($addOn);

		$independent = $input->getOption('independent');
		$styleArchiveExporter->setIndependent(boolval($independent));

		$DS = \XF::$DS;

		$output->writeln(["", "Building archive."]);

		$tempFile = $styleArchiveExporter->build();

		$rootPath = \XF::getRootDirectory();
		$targetPath = $input->getOption('destination');
		if (!$targetPath)
		{
			$targetPath = getcwd();
		}
		if (!$targetPath)
		{
			$targetPath = $rootPath;
		}

		if (!is_writable($targetPath))
		{
			$output->writeln('<error>Unable to write style archive to the specified directory. Please try again.</error>');
			return 1;
		}

		$targetPath .= $DS . $styleArchiveExporter->getArchiveFileName();

		File::copyFile($tempFile, $targetPath, false);

		$output->writeln(["", "Archive copied to path: $targetPath"]);

		return 0;
	}
}