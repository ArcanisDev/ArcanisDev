<?php

namespace XF\Cli\Command\Development;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function defined, in_array, is_string;

class ClassUseFunction extends Command
{
	use RequiresDevModeTrait;

	const FUNC_WHITELIST = ['array_key_exists', 'array_slice', 'boolval', 'call_user_func', 'call_user_func_array', 'chr', 'count', 'defined', 'doubleval', 'floatval', 'func_get_args', 'func_num_args', 'get_called_class', 'get_class', 'gettype', 'in_array', 'intval', 'is_array', 'is_bool', 'is_double', 'is_float', 'is_int', 'is_integer', 'is_long', 'is_null', 'is_object', 'is_resource', 'is_scalar', 'is_string', 'ord', 'sizeof', 'strlen', 'strval'];
	const USE_PLACEHOLDER = 'const USE_FUNCTION_PLACEHOLDER = true;';

	protected function configure()
	{
		$this
			->setName('xf-dev:class-use-function')
			->setDescription('Parses functions used within each class and adds them to a use function declaration.')
			->addArgument(
				'addon',
				InputArgument::REQUIRED,
				'Add-on ID to generate use function statements for. Note: Existing use function statements will be overwritten.'
			);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln("Checking classes for non-imported native functions...");

		$addOnId = $input->getArgument('addon');

		if ($addOnId === 'XF')
		{
			$srcDir = \XF::getSourceDirectory() . \XF::$DS . 'XF';
		}
		else
		{
			$addOn = \XF::app()->addOnManager()->getById($addOnId);
			if (!$addOn || !$addOn->isAvailable())
			{
				$output->writeln('Add-on could not be found.');
				return 1;
			}

			$srcDir = $addOn->getAddOnDirectory();
		}

		$dirIterator = \XF\Util\File::getRecursiveDirectoryIterator($srcDir, null, null);
		$iterator = new \RegexIterator($dirIterator, '/^.+\.php$/');

		foreach ($iterator AS $file)
		{
			/** @var \SplFileInfo $file */
			if (preg_match('#(^|\\\\|/)(tests|test|_templates|_vendor|vendor)(\\\\|/|$)#i', $file->getPath()))
			{
				continue;
			}
			if (!preg_match('#^[A-Z].+\.php$#', $file->getFilename()))
			{
				continue;
			}

			$source = file_get_contents($file->getRealPath());
			$existingUse = false;

			if (preg_match_all('/^use function\s+(.*);$/m', $source, $matches, PREG_SET_ORDER))
			{
				foreach ($matches AS $match)
				{
					if (stripos($match[1], ' AS ') !== false)
					{
						// an existing alias line can be ignored
						continue;
					}
					else
					{
						$source = preg_replace('/^use function\s+' . $match[1] . ';$/m', self::USE_PLACEHOLDER, $source);
						$existingUse = true;
						break;
					}
				}
			}

			if (!$existingUse)
			{
				$source = preg_replace("/^(?:\/\**.*\s\*\/$\n)?(?:interface|abstract|class|trait)\s[\w\\\_]+.*(?:$\n{|\s{}$)/Ums", self::USE_PLACEHOLDER . "\n\n$0", $source, 1);
			}

			if (substr_count($source, self::USE_PLACEHOLDER) == 0)
			{
				$output->writeln("** SKIPPING: " . $file->getRealPath() . " **");
				continue;
			}

			if (substr_count($source, self::USE_PLACEHOLDER) > 1)
			{
				if ($file->getRealPath() != __FILE__)
				{
					$output->writeln("Use statement placeholder inserted more than once for file '" . $file->getRealPath() . "'. Abort!");
					return 1;
				}
			}

			$tokens = token_get_all($source);

			$withinObject = false;
			$withinFunction = false;

			$functions = [];
			foreach ($tokens AS $token)
			{
				list ($id, $text) = $token;

				if (is_string($token) || $id == T_WHITESPACE)
				{
					continue;
				}

				if ($id == T_OBJECT_OPERATOR)
				{
					$withinObject = true;
					continue;
				}

				if ($id == T_FUNCTION)
				{
					$withinFunction = true;
					continue;
				}

				if ($withinObject)
				{
					$withinObject = false;
					continue;
				}

				if ($withinFunction)
				{
					$withinFunction = false;
					continue;
				}

				if ($id == T_STRING && in_array($text, self::FUNC_WHITELIST))
				{
					$functions[] = $text;
				}

				if (defined('T_NAME_FULLY_QUALIFIED'))
				{
					if ($id == T_NAME_FULLY_QUALIFIED)
					{
						$function = substr($text, 1);
						if (in_array($function, self::FUNC_WHITELIST))
						{
							$functions[] = $function;
						}
					}
				}
			}

			if ($functions)
			{
				$functions = array_unique($functions);
				sort($functions);

				foreach ($functions AS $function)
				{
					$source = preg_replace("/\\\\$function/", $function, $source);
				}

				$placeholder = self::USE_PLACEHOLDER;
				$useFuncString = 'use function ' . implode(', ', $functions) . ';';
			}
			else
			{
				$placeholder = "\n" . self::USE_PLACEHOLDER . "\n";
				$useFuncString = "";
			}

			$source = preg_replace('/^' . $placeholder . '$/m', $useFuncString, $source);

			file_put_contents($file->getRealPath(), $source);
		}

		$output->writeln("... Complete!");

		return 0;
	}
}