<?php
// FROM HASH: 1ffb392ab80a48179ce56e9f9794c76a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (($__vars['context'] == 'create') AND ($__vars['subContext'] == 'quick')) {
		$__finalCompiled .= '
	';
		$__vars['rowType'] = 'fullWidth noGutter mergeNext';
		$__finalCompiled .= '
';
	} else if (($__vars['context'] == 'edit') AND ($__vars['subContext'] == 'first_post_quick')) {
		$__finalCompiled .= '
	';
		$__vars['rowType'] = 'fullWidth mergeNext';
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__vars['rowType'] = '';
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

' . $__templater->callMacro(null, 'poll_macros::add_edit_inputs', array(
		'draft' => $__vars['pollDraft'],
		'rowType' => $__vars['rowType'],
	), $__vars);
	return $__finalCompiled;
}
);