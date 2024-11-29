<?php
// FROM HASH: 8782caa624f0c17680b25645525fa4df
return array(
'macros' => array('setup' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'includeLess' => true,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__vars['includeLess']) {
		$__finalCompiled .= '
		';
		$__templater->includeCss('public:nestable.less');
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'prod' => 'xf/nestable-compiled.js',
		'dev' => 'vendor/nestable/jquery.nestable.js, xf/nestable.js',
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