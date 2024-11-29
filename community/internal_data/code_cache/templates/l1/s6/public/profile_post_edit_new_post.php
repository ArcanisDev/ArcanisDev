<?php
// FROM HASH: d4389b3d9cd9bc3cf689fe29fd94e568
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->callMacro('profile_post_macros', 'profile_post', array(
		'profilePost' => $__vars['profilePost'],
		'allowInlineMod' => ($__vars['noInlineMod'] ? false : true),
		'attachmentData' => $__vars['attachmentData'],
	), $__vars);
	return $__finalCompiled;
}
);