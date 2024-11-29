<?php
// FROM HASH: 2eb5386be1a5147616a58284ea5d0b44
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->callMacro(null, ($__vars['templateOverrides']['thread_list_macro'] ?: 'thread_list_macros::item'), $__templater->combineMacroArgumentAttributes($__vars['templateOverrides']['thread_list_macro_args'], array(
		'thread' => $__vars['thread'],
		'allowInlineMod' => ($__vars['noInlineMod'] ? false : true),
		'forum' => ($__vars['forumName'] ? null : $__vars['forum']),
	)), $__vars) . '
';
	return $__finalCompiled;
}
);