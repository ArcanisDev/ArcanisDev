<?php
// FROM HASH: c5d774139e849bf52fac3d603595e02c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['userGroup']) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['userGroup']['title']));
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['user']['username']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__templater->breadcrumb($__templater->preEscaped($__templater->escape($__vars['record']['title'])), $__templater->func('link', array($__vars['routePrefix'], $__vars['record'], ), false), array(
	));
	$__finalCompiled .= '

' . $__templater->callMacro('permission_node_macros', 'edit', array(
		'node' => $__vars['record'],
		'permissionData' => $__vars['permissionData'],
		'typeEntries' => $__vars['typeEntries'],
		'routeBase' => $__vars['routePrefix'],
		'saveParams' => $__vars['saveParams'],
	), $__vars);
	return $__finalCompiled;
}
);