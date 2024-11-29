<?php

namespace XF\Cli\Command;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Output\OutputInterface;

use function strval;

trait ImportCommandTrait
{
	protected function outputImportNotes(OutputInterface $output, string $context, \XF\Import\Session $session)
	{
		$manager = \XF::app()->import()->manager();
		$notes = $manager->getImportNotesData('complete', $session);

		$totalsTable = new Table($output);
		$totalsTable->setHeaders(['Step', 'Total', 'Time taken']);

		foreach ($notes['totals'] AS $total)
		{
			$totalsTable->addRow([
				$total['title'],
				number_format($total['total']),
				$this->getTimeString($total['time'])
			]);
		}

		$totalsTable->addRows([
			new TableSeparator(),
			[new TableCell('Total run time', ['colspan' => 1]), new TableCell($this->getTimeString($notes['runTime']), ['colspan' => 2])],
		]);

		$totalsTable->render();

		$output->writeln("");

		if (!empty($notes['notes']))
		{
			foreach ($notes['notes'] AS $noteSet)
			{
				$setTable = new Table($output);
				$setTable->setHeaders([strval($noteSet['title'])]);

				foreach ($noteSet['entries'] AS $entry)
				{
					$setTable->addRow([strip_tags(strval($entry))]);
				}

				$setTable->render();

				$output->writeln("");
			}
		}

		$output->writeln("A database table mapping old IDs to new IDs has been created: <info>{$notes['logTable']}</info>.");
		$output->writeln("You may need this table for redirection scripts.\n");
	}

	protected function getTimeString(float $time): string
	{
		if ($time > 3600)
		{
			$minutes = number_format(($time / 60) % 60);
			$hours = number_format(($time - $minutes * 60) / 3600);

			return "$hours hours, $minutes minutes";
		}
		else if ($time >= 120)
		{
			return number_format($time / 60, 2) . ' minutes';
		}
		else
		{
			return $time . ' seconds';
		}
	}
}