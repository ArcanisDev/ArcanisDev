<?php

namespace XF\Cli\Command\Rebuild;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use XF\Cli\Command\JobRunnerTrait;

abstract class AbstractRebuildCommand extends Command
{
	use JobRunnerTrait;

	/**
	 * Name of the rebuild command suffix (do not include the command namespace)
	 *
	 * @return string
	 */
	abstract protected function getRebuildName();

	abstract protected function getRebuildDescription();

	abstract protected function getRebuildClass();

	protected function getRebuildAliases()
	{
		return [];
	}

	protected function configureOptions()
	{
		return;
	}

	protected function configure()
	{
		$this
			->setName('xf-rebuild:' . $this->getRebuildName())
			->setDescription($this->getRebuildDescription())
			->addOption(
				'log-queries',
				null,
				InputOption::VALUE_REQUIRED,
				'Enable query logger for this job. true / false Default: false',
				'false'
			)
			->addOption(
				'batch',
				'b',
				InputOption::VALUE_REQUIRED,
				'Batch size for this job. Default: 500.',
				500
			)
			->addOption(
				'resume',
				null,
				InputOption::VALUE_NONE
			);

		if ($this->getRebuildAliases())
		{
			$this->setAliases($this->getRebuildAliases());
		}

		$this->configureOptions();
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$jobUniqueKey = 'xfRebuildJob-' . $this->getRebuildName();

		if ($input->getOption('resume'))
		{
			if (\XF::app()->jobManager()->getUniqueJob($jobUniqueKey))
			{
				$this->runJob($jobUniqueKey, $output);
				return 0;
			}

			$output->writeln("<error>There are no pending jobs of this type to resume.</error>");
			return 1;
		}

		$params = $this->getJobParams($input, $error);
		if ($error)
		{
			$output->writeln('<error>' . $error . '</error>');
			return 1;
		}

		\XF::db()->logQueries((bool)$params['log-queries']);
		unset($params['log-queries']);

		$this->setupAndRunJob(
			$jobUniqueKey,
			$this->getRebuildClass(),
			$params, $output
		);

		return 0;
	}

	protected function getJobParams(InputInterface $input, &$error = null)
	{
		$params = $input->getOptions();

		$globalOptions = array_keys($this->getApplication()->getDefinition()->getOptions());
		foreach ($globalOptions AS $globalOption)
		{
			unset($params[$globalOption]);
		}

		if ($params['log-queries'] === 'false')
		{
			$params['log-queries'] = false;
		}

		return $params;
	}
}