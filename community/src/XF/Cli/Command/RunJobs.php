<?php

namespace XF\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RunJobs extends Command
{
	protected function configure()
	{
		$this
			->setName('xf:run-jobs')
			->setDescription('Runs any outstanding jobs.')
			->addOption(
				'max-execution-time',
				null,
				InputOption::VALUE_OPTIONAL,
				'Sets a max execution time in seconds. Use 0 to run until all jobs have completed.',
				55
			)
			->addOption(
				'wait',
				null,
				InputOption::VALUE_NONE,
				'Waits for more jobs until the max execution time has been reached. This option has no effect if the max execution time is 0.'
			)
			->addOption(
				'manual-only',
				null,
				InputOption::VALUE_NONE,
				'Ensures that only manually triggered jobs are run'
			);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$app = \XF::app();
		$jobManager = $app->jobManager();

		if (!$jobManager->canRunJobs())
		{
			$output->writeln('<error>Jobs cannot be run at this time.</error>');
			return 1;
		}

		$maxRunTime = $app->config('jobMaxRunTime');
		$manualOnly = $input->getOption('manual-only');

		$maxExecutionTime = $input->getOption('max-execution-time');
		$wait = $input->getOption('wait');

		$start = microtime(true);

		do
		{
			$jobManager->runQueue($manualOnly, $maxRunTime);

			// keep the memory limit down on long running jobs
			$app->em()->clearEntityCache();
			\XF::updateTime();

			$more = $jobManager->queuePending($manualOnly);
			if (!$more)
			{
				if ($maxExecutionTime && $wait)
				{
					sleep(1);
				}
				else
				{
					break;
				}
			}
		}
		while (!$maxExecutionTime || microtime(true) - $start < $maxExecutionTime);

		$output->writeln('<info>All outstanding jobs have run.</info>');

		return 0;
	}
}