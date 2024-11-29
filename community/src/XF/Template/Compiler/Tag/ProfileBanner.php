<?php

namespace XF\Template\Compiler\Tag;

use XF\Template\Compiler;
use XF\Template\Compiler\Syntax\Tag;

class ProfileBanner extends AbstractTag
{
	public function compile(Tag $tag, Compiler $compiler, array $context, $inlineExpected)
	{
		$tag->assertAttribute('user')->assertAttribute('size');

		$rawContext = $context;
		$rawContext['escape'] = false;

		$user = $compiler->compileForcedExpression($tag->attributes['user'], $rawContext);
		$size = $tag->attributes['size']->compile($compiler, $rawContext, true);

		if (isset($tag->attributes['canonical']))
		{
			$canonical = $compiler->compileForcedExpression($tag->attributes['canonical'], $rawContext);
		}
		else
		{
			$canonical = 'false';
		}

		$otherAttributes = $tag->attributes;
		unset($otherAttributes['user'], $otherAttributes['canonical'], $otherAttributes['size']);

		$config = $this->compileAttributesAsArray($otherAttributes, $compiler, $rawContext);
		$indent = $compiler->indent();
		$attributesCode = "array(" . implode('', $config) . "\n$indent)";

		$contentHtml = $compiler->compileInlineList($tag->children, $context);

		return "{$compiler->templaterVariable}->func('profile_banner', array($user, $size, $canonical, $attributesCode, $contentHtml))";
	}
}