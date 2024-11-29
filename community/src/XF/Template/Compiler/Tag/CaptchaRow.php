<?php

namespace XF\Template\Compiler\Tag;

use XF\Template\Compiler\Syntax\Tag;
use XF\Template\Compiler;

class CaptchaRow extends AbstractFormElement
{
	public function compile(Tag $tag, Compiler $compiler, array $context, $inlineExpected)
	{
		$withEscaping = [];
		foreach ($this->defaultRowOptions AS $option => $escaped)
		{
			if ($escaped)
			{
				$withEscaping[] = $option;
			}
		}

		$config = $this->compileAttributesAsArray($tag->attributes, $compiler, $context, $withEscaping);
		$indent = $compiler->indent();

		$optionsCode = "array(array(" . implode('', $config)  . "\n$indent))";
		$contentHtml = "{$compiler->templaterVariable}->func('captcha_options', $optionsCode)";

		$rowOptionsCode = "array(" . implode('', $config)  . "\n$indent)";
		return "{$compiler->templaterVariable}->formRowIfContent($contentHtml, $rowOptionsCode)";
	}
}