<?php

namespace XF\Template\Compiler\Tag;

use XF\Template\Compiler\Syntax\Tag;
use XF\Template\Compiler;

class ExtendsTag extends AbstractTag
{
	public function compile(Tag $tag, Compiler $compiler, array $context, $inlineExpected)
	{
		$tag->assertTopLevel()->assertEmpty()->assertAttribute('template');

		$context['escape'] = false;

		$template = $tag->attributes['template']->compile($compiler, $context, true);
		$compiler->setExtendsCode($template);

		return $inlineExpected ? "''" : false;
	}
}