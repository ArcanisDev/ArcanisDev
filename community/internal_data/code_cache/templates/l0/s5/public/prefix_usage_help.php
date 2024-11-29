<?php
// FROM HASH: d4009835a2b32023f0b6e55d5e5f78c4
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->callMacro('prefix_macros', 'usage_help', array(
		'prefix' => $__vars['prefix'],
		'contentType' => $__vars['contentType'],
	), $__vars);
	return $__finalCompiled;
}
);