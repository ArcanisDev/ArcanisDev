<?php
// FROM HASH: f0aac4859cda824a008b36fd91595035
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeJs(array(
		'src' => 'xf/captcha.js',
		'min' => '1',
	));
	$__finalCompiled .= '

<div data-xf-init="turnstile" data-sitekey="' . $__templater->escape($__vars['siteKey']) . '" data-action="' . $__templater->escape($__vars['context']) . '" data-theme="' . $__templater->func('property', array('styleType', ), true) . '"></div>';
	return $__finalCompiled;
}
);