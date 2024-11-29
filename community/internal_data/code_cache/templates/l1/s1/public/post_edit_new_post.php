<?php
// FROM HASH: eec45c72c6ba50c726c5d8da7f7bbeb9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->func('prefix', array('thread', $__vars['thread'], 'escaped', ), true) . $__templater->escape($__vars['thread']['title']));
	$__finalCompiled .= '
';
	$__templater->pageParams['pageH1'] = $__templater->preEscaped($__templater->func('prefix', array('thread', $__vars['thread'], ), true) . $__templater->escape($__vars['thread']['title']));
	$__finalCompiled .= '

' . $__templater->callMacro(null, 'thread_view::thread_custom_fields_status', array(
		'thread' => $__vars['thread'],
		'forum' => $__vars['thread']['Forum'],
		'wrapperClass' => 'block-outer',
	), $__vars) . '

';
	if ($__vars['isPinnedFirstPost']) {
		$__finalCompiled .= '
	' . $__templater->callMacro(null, ($__vars['templateOverrides']['pinned_first_post_macro'] ?: 'post_macros::post'), $__templater->combineMacroArgumentAttributes($__vars['templateOverrides']['pinned_first_post_macro_args'], array(
			'post' => $__vars['post'],
			'thread' => $__vars['thread'],
		)), $__vars) . '
';
	} else {
		$__finalCompiled .= '
	' . $__templater->callMacro(null, ($__vars['templateOverrides']['post_macro'] ?: 'post_macros::post'), $__templater->combineMacroArgumentAttributes($__vars['templateOverrides']['post_macro_args'], array(
			'post' => $__vars['post'],
			'thread' => $__vars['thread'],
		)), $__vars) . '
';
	}
	return $__finalCompiled;
}
);