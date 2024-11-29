<?php
// FROM HASH: 725cfc6d6363dc00b5382538ab6d86a9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['user']['username']));
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['tabbed']) {
		$__compilerTemp1 .= '
		<div class="block-body">
			<div class="block-row">' . 'Here, you may edit permissions exclusively for this user. For ease and simplicity of permission management, you should only set per-user permissions if you can not otherwise <a href="' . $__templater->func('link', array('permissions/user-groups', ), true) . '">set permissions at a user-group level</a> to achieve the permissions you want for this user.' . '</div>
			' . $__templater->formHiddenVal('from-user-edit', '1', array(
		)) . '
		</div>
	';
	}
	$__finalCompiled .= $__templater->form('

	' . $__compilerTemp1 . '

	' . $__templater->callMacro('permission_macros', 'edit_outer', array(
		'type' => 'global',
		'class' => ($__vars['tabbed'] ? 'block-row' : 'block-outer'),
	), $__vars) . '

	<div class="' . ($__vars['tabbed'] ? '' : 'block-container') . '">
		' . $__templater->callMacro('permission_macros', 'edit_groups', array(
		'interfaceGroups' => $__vars['permissionData']['interfaceGroups'],
		'permissionsGrouped' => $__vars['permissionData']['permissionsGrouped'],
		'values' => $__vars['userEntries'],
	), $__vars) . '
		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('permissions/users/save', $__vars['user'], ), false),
		'ajax' => 'true',
		'class' => ($__vars['tabbed'] ? '' : 'block'),
	));
	return $__finalCompiled;
}
);