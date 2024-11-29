<?php

namespace XF\Cli\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

trait StyleArchiveTrait
{
	protected function getStyleByDesignerModeInput(
		InputInterface $input,
		OutputInterface $output
	): \XF\Entity\Style
	{
		$designerMode = $input->getArgument('designer-mode');
		$style = \XF::em()->findOne('XF:Style', ['designer_mode' => $designerMode]);

		if (!$style)
		{
			throw new \XF\PrintableException("No style with designer mode ID '$designerMode' could be found.");
		}

		return $style;
	}

	protected function getStyleByStyleIdInput(
		InputInterface $input,
		OutputInterface $output
	): \XF\Entity\Style
	{
		$styleId = $input->getArgument('style-id');
		$style = \XF::em()->find('XF:Style', $styleId);

		if (!$style)
		{
			throw new \XF\PrintableException("No style with ID '$styleId' could be found.");
		}

		return $style;
	}
}