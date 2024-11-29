<?php

namespace XF\Template\Compiler\Func;

use XF\Template\Compiler\Syntax\AbstractSyntax;
use XF\Template\Compiler\Syntax\Func;
use XF\Template\Compiler;

class ExtensionValue extends AbstractFn
{
	/**
	 * @param AbstractSyntax|Func $func
	 * @param Compiler       $compiler
	 * @param array          $context
	 *
	 * @return mixed|string
	 * @throws Compiler\Exception
	 */
	public function compile(AbstractSyntax $func, Compiler $compiler, array $context)
	{
		$func->assertArgumentCount(1);

		$needsEscaping = $context['escape'];

		$context['escape'] = false;
		$extension = $func->arguments[0]->compile($compiler, $context, true);

		$result = "{$compiler->templaterVariable}->renderExtension({$extension}, {$compiler->variableContainer}, {$compiler->extensionsVariable})";
		return $needsEscaping ? "{$compiler->templaterVariable}->escape({$result})" : $result;
	}
}