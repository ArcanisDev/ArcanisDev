<?php

namespace XF\Template\Compiler\Tag;

use XF\Template\Compiler\Syntax\Tag;
use XF\Template\Compiler;

class ExtensionParent extends AbstractTag
{
	public function compile(Tag $tag, Compiler $compiler, array $context, $inlineExpected)
	{
		$tag->assertEmpty();

		if (isset($tag->attributes['name']))
		{
			$rawContext = $context;
			$context['escape'] = false;

			$name = $tag->attributes['name']->compile($compiler, $rawContext, true);
		}
		else
		{
			$name = 'null';
		}

		$varContainer = $compiler->variableContainer;
		return "{$compiler->templaterVariable}->renderExtensionParent({$varContainer}, {$name}, {$compiler->extensionsVariable})";
	}
}