<?php
// FROM HASH: 4cd019d1661e8b0e5f412af6405580eb
return array(
'extends' => function($__templater, array $__vars) { return 'thread_view'; },
'extensions' => array('above_messages' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
	';
	if ($__vars['poll']) {
		$__finalCompiled .= '
		' . $__templater->callMacro('poll_macros', 'poll_block', array(
			'poll' => $__vars['poll'],
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . $__templater->renderExtension('above_messages', $__vars, $__extensions);
	return $__finalCompiled;
}
);