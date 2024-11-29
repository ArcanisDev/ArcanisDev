<?php

namespace XF\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class ImportFinalize extends Command
{
	use ImportCommandTrait, JobRunnerTrait;

	protected function configure()
	{
		$this
			->setName('xf:import-finalize')
			->setDescription('Finalize an import configured via the control panel');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$app = \XF::app();
		$em = $app->em();

		$manager = $app->import()->manager();
		$runner = $manager->getRunner();

		if (!$runner)
		{
			$output->writeln("<error>No valid import session could be found. Configure this via the control panel.</error>");

			return 1;
		}

		$session = $runner->getSession();
		if (!$session->runComplete)
		{
			$output->writeln("<error>The import session is not yet completed.</error>");

			return 1;
		}

		$importer = $manager->getImporter($session->importerId);
		if (!$importer)
		{
			$manager->clearCurrentSession();

			$output->writeln("<error>No valid importer could be found. The import session has been cleared.</error>");

			return 1;
		}

		$db = $app->db();
		$db->logQueries(false); // need to limit memory usage

		$importerTitle = $runner->getImporter()->getSourceTitle();
		$output->writeln("Finalizing import from $importerTitle...");

		// TODO: output each job on a single line?

		$jobs = $manager->getImporter($session->importerId)->getFinalizeJobs($session->getStepsRun());
		if ($jobs)
		{
			$this->setupAndRunJob('importFinalize', 'XF:Atomic', ['execute' => $jobs], $output);
		}
		else
		{
			$output->writeln('No jobs...');
		}

		$session->finalized = true;
		$manager->updateCurrentSession($session);

		/** @var QuestionHelper $helper */
		$helper = $this->getHelper('question');

		$question = new ConfirmationQuestion("<question>Would you like to view any import notes and complete the import? (y/n)</question> ");
		if ($helper->ask($input, $output, $question))
		{
			$manager->clearCurrentSession();
			$this->outputImportNotes($output, 'complete', $session);

			$output->writeln("The import has been finalized and completed and is ready for use.");
		}
		else
		{
			$output->writeln("The import has been finalized and is ready for use. You can view any notes and complete the import via the control panel.");
		}

		return 0;
	}
}