<?php

namespace XF\Navigation;

use function strlen;

abstract class AbstractType
{
	protected $typeId;

	public function __construct($typeId)
	{
		$this->typeId = $typeId;
	}

	abstract public function getTitle();
	abstract public function validateConfigInput(\XF\Entity\Navigation $nav, array $config, Compiler $compiler, &$error = null, &$errorField = null);

	/**
	 * @param \XF\Entity\Navigation $nav
	 * @param Compiler $compiler
	 * @return CompiledEntry
	 */
	abstract public function compileCode(\XF\Entity\Navigation $nav, Compiler $compiler);

	public function renderEditForm(\XF\Entity\Navigation $nav, array $config, $formPrefix)
	{
		$params = array_replace([
			'navigation' => $nav,
			'config' => $config,
			'formPrefix' => $formPrefix
		], $this->getExtraEditParams($nav, $config));

		return \XF::app()->templater()->renderTemplate('admin:navigation_edit_type_' . $this->typeId, $params);
	}

	protected function getExtraEditParams(\XF\Entity\Navigation $nav, array $config)
	{
		return [];
	}

	/**
	 * @param array    $config
	 * @param Compiler $compiler
	 * @param null     $error
	 * @param null     $errorField
	 *
	 * @return array|false
	 */
	protected function validateExtraAttrs(array $config, Compiler $compiler, &$error = null, &$errorField = null)
	{
		$input = \XF::app()->inputFilterer()->filterArray($config, [
			'extra_attr_names' => 'array-str',
			'extra_attr_values' => 'array-str'
		]);

		$extraAttrs = [];
		foreach ($input['extra_attr_names'] AS $i => $name)
		{
			if (!$name || !isset($input['extra_attr_values'][$i]))
			{
				continue;
			}

			$value = $input['extra_attr_values'][$i];
			if (!strlen($value))
			{
				continue;
			}

			$extraAttrs[$name] = $value;
		}

		if (!$compiler->validateArrayValue($extraAttrs, $error))
		{
			$error = \XF::phrase('extra_attributes:') . " $error";
			$errorField = 'extra_attributes';
			return false;
		}

		return $extraAttrs;
	}
}