<?php

namespace XF\Template\Compiler\Tag;

use XF\Template\Compiler\Syntax\Tag;
use XF\Template\Compiler;

class Extension extends AbstractTag
{
	public function compile(Tag $tag, Compiler $compiler, array $context, $inlineExpected)
	{
		$tag->assertAttribute('name');

		$attributes = $tag->attributes;

		if (!($attributes['name'] instanceof Compiler\Syntax\Str))
		{
			throw $tag->exception(\XF::phrase('extension_names_must_be_literal_strings'));
		}
		$name = $attributes['name']->content;

		if (!preg_match('#^[a-z0-9_]+$#i', $name))
		{
			throw $tag->exception(\XF::phrase('extension_names_may_only_contain_alphanumeric_underscore'));
		}

		$skipPrint = false;

		if (isset($tag->attributes['value']))
		{
			$tag->assertEmpty();

			$context['escape'] = false;
			$value = $tag->attributes['value']->compile($compiler, $context, true);

			$extensionCode = "return {$value};";

			// if the extension is being defined this way, assume it's for message passing or non-printed usage
			$skipPrint = true;
		}
		else
		{
			$globalScope = $compiler->getCodeScope();

			$extensionScope = new Compiler\CodeScope($compiler->finalVarName, $compiler);
			$compiler->setCodeScope($extensionScope);

			$compiler->traverseBlockChildren($tag->children, $context);

			$extensionCode = "{$compiler->finalVarName} = '';
	" . implode("\n", $compiler->getOutput()) . "
	return {$compiler->finalVarName};";

			$compiler->setCodeScope($globalScope);
		}

		$compiler->defineExtension($name, $extensionCode, $tag);

		if (isset($tag->attributes['skipprint']))
		{
			$skipPrint = (
				$tag->attributes['skipprint'] instanceof Compiler\Syntax\Str
				&& strtolower($tag->attributes['skipprint']->content) == 'true'
			);
		}

		if ($skipPrint)
		{
			return $inlineExpected ? "''" : false;
		}
		else
		{
			$nameCode = $compiler->getStringCode($name);

			return "{$compiler->templaterVariable}->renderExtension({$nameCode}, {$compiler->variableContainer}, {$compiler->extensionsVariable})";
		}
	}
}