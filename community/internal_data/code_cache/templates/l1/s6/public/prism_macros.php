<?php
// FROM HASH: a3fc55f08f3a0fca9aead15275eddc10
return array(
'macros' => array('setup' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeCss('bb_code.less');
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'prod' => 'xf/code_block-compiled.js',
		'dev' => 'vendor/prism/prism.min.js, xf/code_block.js',
	));
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';

	return $__finalCompiled;
}
);