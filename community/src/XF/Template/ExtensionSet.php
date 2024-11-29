<?php

namespace XF\Template;

class ExtensionSet
{
	protected $type;
	protected $template;
	protected $macro;

	/**
	 * @var array
	 */
	protected $extensions;

	/**
	 * @var ExtensionSet|null
	 */
	protected $baseSet;

	public function __construct($type, $template, array $extensions, $macro = null)
	{
		$this->type = $type;
		$this->template = $template;
		$this->macro = $macro;

		$this->extensions = $extensions;
	}

	public function applyBaseSet(ExtensionSet $set)
	{
		if ($this->baseSet)
		{
			$this->baseSet->applyBaseSet($set);
		}
		else
		{
			$this->baseSet = $set;
		}
	}

	public function getBaseSet()
	{
		return $this->baseSet;
	}

	public function getExtension($name)
	{
		if (isset($this->extensions[$name]))
		{
			return [
				'type' => $this->type,
				'template' => $this->template,
				'macro' => $this->macro,
				'code' => $this->extensions[$name],
				'set' => $this
			];
		}
		else if ($this->baseSet)
		{
			return $this->baseSet->getExtension($name);
		}
		else
		{
			return null;
		}
	}
}