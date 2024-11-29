<?php
// FROM HASH: fa42a522c8da600dcddc8326302266ec
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Poll results');
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__vars['breadcrumbs']);
	$__finalCompiled .= '

' . $__templater->callMacro('poll_macros', 'poll_block', array(
		'poll' => $__vars['poll'],
		'simpleDisplay' => $__vars['simpleDisplay'],
	), $__vars);
	return $__finalCompiled;
}
);