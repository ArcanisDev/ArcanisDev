<?php

namespace XF\Navigation;

class BasicType extends AbstractType
{
	public function getTitle()
	{
		return \XF::phrase('basic');
	}

	public function validateConfigInput(\XF\Entity\Navigation $nav, array $config, Compiler $compiler, &$error = null, &$errorField = null)
	{
		$input = \XF::app()->inputFilterer()->filterArray($config, [
			'link' => 'str',
			'display_condition' => 'str'
		]);

		$extraAttrs = $this->validateExtraAttrs($config, $compiler, $error, $errorField);
		if ($extraAttrs === false)
		{
			return false;
		}
		if (!$compiler->validateStringValue($input['link'], $error))
		{
			$error = \XF::phrase('link:') . " $error";
			$errorField = 'link';
			return false;
		}
		if (!$compiler->validateExpressionValue($input['display_condition'], $error))
		{
			$error = \XF::phrase('display_condition:') . " $error";
			$errorField = 'display_condition';
			return false;
		}

		return [
			'link' => $input['link'],
			'display_condition' => $input['display_condition'],
			'extra_attributes' => $extraAttrs
		];
	}

	public function compileCode(\XF\Entity\Navigation $nav, Compiler $compiler)
	{
		$typeConfig = $nav->type_config;
		$indent = $compiler->getIndenter();

		$displayExpression = $compiler->compileExpressionValue($typeConfig['display_condition'], '');
		$displaySetup = $compiler->flushIntermediateCode();

		$entryExpression = (
			"[\n"
				. "{$indent}\t'title' => \\XF::phrase(" . $compiler->getStringCode($nav->getPhraseName()) . "),\n"
				. "{$indent}\t'href' => " . $compiler->compileStringValue($typeConfig['link']) . ",\n"
				. "{$indent}\t'attributes' => " . $compiler->compileArrayValue($typeConfig['extra_attributes']) . ",\n"
			. "{$indent}]"
		);
		$setupCode = $compiler->flushIntermediateCode();

		$compiled = new CompiledEntry($nav->navigation_id, $entryExpression, $setupCode);
		$compiled->applyCondition($displayExpression, $displaySetup);

		return $compiled;
	}
}