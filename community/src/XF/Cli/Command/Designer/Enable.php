<?php

namespace XF\Cli\Command\Designer;

use League\Flysystem\FileNotFoundException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use XF\Cli\Command\StyleArchiveTrait;
use XF\Util\File;

class Enable extends Command
{
	use RequiresDesignerModeTrait, StyleArchiveTrait;

	protected function configure()
	{
		$this
			->setName('xf-designer:enable')
			->setDescription('Enables designer mode on the specified style')
			->addArgument(
				'style-id',
				InputArgument::REQUIRED,
				'Style ID'
			)
			->addArgument(
				'designer-mode',
				InputArgument::REQUIRED,
				'Designer mode ID'
			);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		/** @var QuestionHelper $helper */
		$helper = $this->getHelper('question');

		$style = $this->getStyleByStyleIdInput($input, $output);

		if ($style->designer_mode)
		{
			$output->writeln(\XF::phrase('once_enabled_it_is_not_possible_to_change_designer_mode_id')->render());
			return 1;
		}

		$designerMode = $input->getArgument('designer-mode');
		$style->designer_mode = $designerMode;

		$dataUriAssets = [];
		foreach ($style->assets AS $k => $assetPath)
		{
			$dataUriRegex = '#^data://styles/\d+/#';
			if (preg_match($dataUriRegex, $assetPath))
			{
				$dataUriAssets[$k] = [$assetPath, preg_replace($dataUriRegex, '', $assetPath)];
			}
		}

		if ($dataUriAssets)
		{
			$output->writeln("");

			$question = new ConfirmationQuestion("<question>This style has assets within the data directory. These will be copied to their original location. Is this ok? (y/n)</question> ");
			if (!$helper->ask($input, $output, $question))
			{
				return 1;
			}

			$newAssetValues = $style->assets;

			foreach ($dataUriAssets AS $k => $asset)
			{
				$finalPath = \XF::getRootDirectory() . '/' . $asset[1];
				if (!File::isWritable($finalPath))
				{
					$output->writeln('<error>The following asset path was not writable: ' . $asset[1] . '</error>');
					return 1;
				}

				$newAssetValues[$k] = $asset[1];
			}

			$style->assets = $newAssetValues;
		}

		if (!$style->preSave())
		{
			$output->writeln($style->getErrors());
			return 1;
		}

		$style->save();

		$this->copyDataUriAssets($dataUriAssets);

		$designerModePath = \XF::app()->designerOutput()->getDesignerModePath($style->designer_mode);
		$printablePath = str_replace(\XF::getRootDirectory() . \XF::$DS, '', $designerModePath);

		if (file_exists($designerModePath))
		{
			$question = new ChoiceQuestion(
				"<question>The designer mode path '$printablePath' already exists. How should this be treated?</question>",
				[
					'dir' => 'Treat the directory as the master version. (Overwrite style from directory.)',
					'db' => 'Treat the database as the master version. (Overwrite directory from style.)',
					'' => 'Do nothing. (You will need to resolve this manually.)'
				]
			);

			$action = $helper->ask($input, $output, $question);
			switch ($action)
			{
				case 'dir':
					$this->runImport($designerMode, $output);
					break;

				case 'db':
					File::deleteDirectory($designerModePath);
					File::createDirectory($designerModePath, false);
					$this->runExport($designerMode, $output);
			}
		}
		else
		{
			File::createDirectory($designerModePath, false);
			$this->runExport($designerMode, $output);
		}

		$output->writeln(["", "Designer mode enabled for '$style->title' in path '$printablePath'", ""]);

		return 0;
	}

	protected function copyDataUriAssets(array $dataUriAssets)
	{
		foreach ($dataUriAssets AS $asset)
		{
			$fs = \XF::fs();
			$dataUriPath = $asset[0];
			$finalAssetPath = \XF::getRootDirectory() . '/' . $asset[1];

			try
			{
				$metadata = $fs->getMetadata($dataUriPath);
			}
			catch (FileNotFoundException $e)
			{
				$metadata = false;
			}

			if (!$metadata)
			{
				continue;
			}

			if ($metadata['type'] == 'dir')
			{
				$contents = $fs->listContents($dataUriPath, true);

				foreach ($contents AS $file)
				{
					if ($file['type'] == 'dir')
					{
						continue;
					}

					$abstractedPath = 'data://' . $file['path'];

					$filePath = File::copyAbstractedPathToTempFile($abstractedPath);
					$stdPath = $this->stripDataStylesPathPrefix($abstractedPath);
					File::copyFile($filePath, $finalAssetPath . '/' . $stdPath, false);
				}
			}
			else
			{
				$filePath = File::copyAbstractedPathToTempFile($dataUriPath);
				$stdPath = $this->stripDataStylesPathPrefix($dataUriPath);
				File::copyFile($filePath, $finalAssetPath . '/' . $stdPath, false);
			}
		}
	}

	protected function stripDataStylesPathPrefix(string $abstractedPath): string
	{
		return preg_replace('#^data://styles/\d+/#i', '', $abstractedPath);
	}
}
