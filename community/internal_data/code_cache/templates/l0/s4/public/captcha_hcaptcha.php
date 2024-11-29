<?php
// FROM HASH: 85cb552901acc74af3405c39a8faff79
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeJs(array(
		'src' => 'xf/captcha.js',
		'min' => '1',
	));
	$__finalCompiled .= '

<div data-xf-init="h-captcha" data-sitekey="' . $__templater->escape($__vars['siteKey']) . '" data-theme="' . $__templater->func('property', array('styleType', ), true) . '" data-invisible="' . $__templater->escape($__vars['invisible']) . '"></div>';
	return $__finalCompiled;
}
);