<?php

namespace XF\Template\Compiler\Tag;

use XF\Template\Compiler\Syntax\Tag;
use XF\Template\Compiler;

class ExtensionValue extends AbstractTag
{
	public function compile(Tag $tag, Compiler $compiler, array $context, $inlineExpected)
	{
		$tag->assertAttribute('name')->assertEmpty();

		$context['escape'] = false;
		$nameCode = $tag->attributes['name']->compile($compiler, $context, true);

		return "{$compiler->templaterVariable}->renderExtension({$nameCode}, {$compiler->variableContainer}, {$compiler->extensionsVariable})";
	}
}