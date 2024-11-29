<?php

namespace XF\Cli\Command\Rebuild;

use Symfony\Component\Console\Input\InputOption;

class RebuildStats extends AbstractRebuildCommand
{
	protected function getRebuildName(): string
	{
		return 'stats';
	}

	protected function getRebuildDescription(): string
	{
		return 'Rebuilds daily statistics.';
	}

	protected function getRebuildClass(): string
	{
		return 'XF:Stats';
	}

	protected function configureOptions()
	{
		$this
			->addOption(
				'delete',
				null,
				InputOption::VALUE_NONE,
				'Delete existing cached data. Default: false'
			);
	}
}