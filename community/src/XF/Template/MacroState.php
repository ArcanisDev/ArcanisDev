<?php

namespace XF\Template;

class MacroState
{
	protected $arguments = [];

	protected $global = false;

	/**
	 * @var ExtensionSet|null
	 */
	protected $extensionSet;

	public function getArguments()
	{
		return $this->arguments;
	}

	public function addArguments(array $arguments)
	{
		// As this is build up from the extended version to the base version, subsequent calls will be adding
		// *less* specific values for arguments, so the current arguments should override.
		$this->arguments = array_replace($arguments, $this->arguments);
	}

	public function getGlobal()
	{
		return $this->global;
	}

	public function setGlobal($global = true)
	{
		$this->global = $global;
	}

	public function getExtensionSet()
	{
		return $this->extensionSet;
	}

	public function applyExtensionSet(ExtensionSet $set)
	{
		// Called bottom up, so each subsequent call is adding a base set.

		if ($this->extensionSet)
		{
			$this->extensionSet->applyBaseSet($set);
		}
		else
		{
			$this->extensionSet = $set;
		}
	}

	public function getAvailableVars(Templater $templater, array $arguments, array $globalVars)
	{
		$macroVars = $templater->setupBaseParamsForMacro($globalVars, $this->global);
		$macroVars = $templater->mergeMacroArguments($this->arguments, $arguments, $macroVars);
		return $macroVars;
	}
}