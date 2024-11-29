<?php

namespace XF\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class StyleArchiveImport extends Command
{
	use StyleArchiveTrait;

	protected function configure()
	{
		$this
			->setName('xf:style-archive-import')
			->setDescription('Imports a style from a specified style archive path. By default imported as new style with no parent.')
			->addArgument(
				'archive',
				InputArgument::REQUIRED,
				'Path to valid style archive (Zip).'
			)
			->addOption(
				'target',
				't',
				InputOption::VALUE_REQUIRED,
				'Import the style as a child or overwrite an existing style.',
				'child'
			)
			->addOption(
				'parent-style-id',
				'p',
				InputOption::VALUE_REQUIRED,
				'Import as a child of the specified style. Set to 0 for "No parent".',
				0
			)
			->addOption(
				'overwrite-style-id',
				'o',
				InputOption::VALUE_REQUIRED,
				'Import and overwrite the specified style.'
			)
			->addOption(
				'force',
				'f',
				InputOption::VALUE_NONE,
				'Skip import checks.'
			);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$archiveFile = $input->getArgument('archive');
		if (!is_readable($archiveFile))
		{
			$output->writeln('<error>Unable to read style archive from the specified path. Please try again.</error>');
			return 1;
		}

		if (!\XF::repository('XF:Style')->canSupportStyleArchives())
		{
			$output->writeln('<error>Importing to/exporting from style archives is only supported if you have <code>ZipArchive</code> support. You may need to ask your host to enable this.</error>');
			return 1;
		}

		/** @var \XF\Service\Style\Import $styleImporter */
		$styleImporter = \XF::service('XF:Style\Import');

		/** @var \XF\Service\Style\ArchiveImport $styleArchiveImporter */
		$styleArchiveImporter = \XF::service('XF:Style\ArchiveImport', $archiveFile);

		if (!$styleArchiveImporter->validateArchive($errors))
		{
			$output->writeln($errors);
			return 1;
		}

		$styleImporter->setArchiveImporter($styleArchiveImporter);

		$xmlFile = $styleArchiveImporter->getXmlFile();

		try
		{
			$document = \XF\Util\Xml::openFile($xmlFile);
		}
		catch (\Exception $e)
		{
			$document = null;
		}

		if (!$styleImporter->isValidXml($document, $error))
		{
			$output->writeln($error);
			return 1;
		}

		$target = $input->getOption('target');
		if ($target == 'overwrite')
		{
			$overwriteStyleId = $input->getOption('overwrite-style-id');
			$overwriteStyle = \XF::em()->find('XF:Style', $overwriteStyleId);
			if (!$overwriteStyle)
			{
				$output->writeln('<error>Unable to find overwrite style from specified ID.</error>');
				return 1;
			}

			if ($overwriteStyle->designer_mode && \XF::config('designer')['enabled'])
			{
				$output->writeln("<error>The specified style has designer mode enabled. Please use the xf-designer commands to import/export.</error>");
				return 1;
			}

			$styleImporter->setOverwriteStyle($overwriteStyle);

			$output->writeln(["", 'Importing style from archive and overwriting existing style: ' . $overwriteStyle->title]);
		}
		else
		{
			$parentStyleId = $input->getOption('parent-style-id');
			$parentStyle = $parentStyleId ? \XF::em()->find('XF:Style', $parentStyleId) : null;
			if ($parentStyleId && !$parentStyle)
			{
				$output->writeln('<error>Unable to find parent style from specified ID.</error>');
				return 1;
			}
			$styleImporter->setParentStyle($parentStyle);

			if ($parentStyle)
			{
				$output->writeln(["", 'Importing style from archive as a child of existing style: ' . $parentStyle->title]);
			}
			else
			{
				$output->writeln(["", 'Importing style as new style with no parent.']);
			}
		}

		if (!$input->getOption('force'))
		{
			if (!$styleImporter->isValidConfiguration($document, $errors))
			{
				$output->writeln('<error>The import could not be completed due to errors: ' . implode(' ', $errors) . ' If you are sure you want to continue try again with the --force option.</error>');
				return 1;
			}
		}

		$output->writeln(["", 'Importing style...']);

		$styleImporter->importFromXml($document);

		$output->writeln(["", 'Style import complete.']);

		return 0;
	}
}