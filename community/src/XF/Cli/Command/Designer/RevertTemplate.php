<?php

namespace XF\Cli\Command\Designer;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use XF\Cli\Command\StyleArchiveTrait;

class RevertTemplate extends Command
{
	use RequiresDesignerModeTrait, StyleArchiveTrait;

	protected function configure()
	{
		$this
			->setName('xf-designer:revert-template')
			->setDescription('Reverts the specified template.')
			->addArgument(
				'designer-mode',
				InputArgument::REQUIRED,
				'Designer mode ID'
			)
			->addArgument(
				'template',
				InputArgument::REQUIRED,
				'Template to mark as modified. Must include the type prefix, e.g. \'public:template_name\''
			)
			->addOption(
				'force',
				'f',
				InputOption::VALUE_NONE,
				'If specified, no confirmation is required.'
			);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$style = $this->getStyleByDesignerModeInput($input, $output);

		$templater = \XF::app()->templater();

		$title = $input->getArgument('template');
		list ($type, $title) = $templater->getTemplateTypeAndName($title);

		if (!$type)
		{
			$type = 'public';
		}

		$template = \XF::em()->findOne('XF:Template', [
			'style_id' => $style->style_id,
			'type' => $type,
			'title' => $title
		]);
		if (!$template)
		{
			$output->writeln("The template '$type:$title' does not exist in this style.");
			return 1;
		}

		if (!$input->getOption('force'))
		{
			/** @var QuestionHelper $helper */
			$helper = $this->getHelper('question');

			$question = new ConfirmationQuestion("Are you sure you want to revert '$type:$title'? (y/n) ");
			if (!$helper->ask($input, $output, $question))
			{
				return 1;
			}
		}

		$template->delete();

		$output->writeln("Template '$type:$title' reverted.");
		return 0;
	}
}