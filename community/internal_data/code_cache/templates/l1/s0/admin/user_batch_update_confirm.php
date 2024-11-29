<?php
// FROM HASH: 685cb72364472b533833c3d5c7e28bb4
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Batch update users');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if (!$__vars['userIds']) {
		$__compilerTemp1 .= '
					<span role="presentation" aria-hidden="true">&middot;</span>
					<a href="' . $__templater->func('link', array('users/list', null, array('criteria' => $__vars['criteria'], 'all' => true, ), ), true) . '">' . 'View or filter matches' . '</a>
				';
	}
	$__compilerTemp2 = array(array(
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['userGroups'])) {
		foreach ($__vars['userGroups'] AS $__vars['userGroup']) {
			$__compilerTemp2[] = array(
				'value' => $__vars['userGroup']['user_group_id'],
				'label' => $__templater->escape($__vars['userGroup']['title']),
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp3 = array(array(
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['userGroups'])) {
		foreach ($__vars['userGroups'] AS $__vars['userGroup']) {
			$__compilerTemp3[] = array(
				'value' => $__vars['userGroup']['user_group_id'],
				'label' => $__templater->escape($__vars['userGroup']['title']),
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp4 = array(array(
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['userGroups'])) {
		foreach ($__vars['userGroups'] AS $__vars['userGroup']) {
			$__compilerTemp4[] = array(
				'value' => $__vars['userGroup']['user_group_id'],
				'label' => $__templater->escape($__vars['userGroup']['title']),
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp5 = '';
	if ($__vars['userIds']) {
		$__compilerTemp5 .= '
		' . $__templater->formHiddenVal('user_ids', $__templater->filter($__vars['userIds'], array(array('json', array()),), false), array(
		)) . '
	';
	} else {
		$__compilerTemp5 .= '
		' . $__templater->formHiddenVal('criteria', $__templater->filter($__vars['criteria'], array(array('json', array()),), false), array(
		)) . '
	';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<h2 class="block-header">' . 'Update users' . '</h2>
		<div class="block-body">
			' . $__templater->formRow('
				' . $__templater->filter($__vars['total'], array(array('number', array()),), true) . '
				' . $__compilerTemp1 . '
			', array(
		'label' => 'Matched users',
	)) . '

			<hr class="formRowSep" />

			' . $__templater->formSelectRow(array(
		'name' => 'actions[set_primary_group_id]',
	), $__compilerTemp2, array(
		'label' => 'Set primary user group',
	)) . '

			' . $__templater->formSelectRow(array(
		'name' => 'actions[add_group_id]',
	), $__compilerTemp3, array(
		'label' => 'Add secondary user group',
	)) . '

			' . $__templater->formSelectRow(array(
		'name' => 'actions[remove_group_id]',
	), $__compilerTemp4, array(
		'label' => 'Remove secondary user group',
	)) . '

			<hr class="formRowSep" />

			' . $__templater->formSelectRow(array(
		'name' => 'actions[set_user_state]',
	), array(array(
		'_type' => 'option',
	),
	array(
		'value' => 'valid',
		'label' => 'Valid',
		'_type' => 'option',
	),
	array(
		'value' => 'email_confirm',
		'label' => 'Awaiting email confirmation',
		'_type' => 'option',
	),
	array(
		'value' => 'email_confirm_edit',
		'label' => 'Awaiting email confirmation (from edit)',
		'_type' => 'option',
	),
	array(
		'value' => 'email_bounce',
		'label' => 'Email invalid (bounced)',
		'_type' => 'option',
	),
	array(
		'value' => 'moderated',
		'label' => 'Awaiting approval',
		'_type' => 'option',
	),
	array(
		'value' => 'rejected',
		'label' => 'Rejected',
		'_type' => 'option',
	),
	array(
		'value' => 'disabled',
		'label' => 'Disabled',
		'_type' => 'option',
	)), array(
		'label' => 'Set user state',
	)) . '

			' . $__templater->formSelectRow(array(
		'name' => 'actions[set_security_lock]',
	), array(array(
		'_type' => 'option',
	),
	array(
		'value' => 'none',
		'label' => 'None',
		'_type' => 'option',
	),
	array(
		'value' => 'change',
		'label' => 'Locked' . $__vars['xf']['language']['label_separator'] . ' ' . 'User must change password',
		'_type' => 'option',
	),
	array(
		'value' => 'reset',
		'label' => 'Locked' . $__vars['xf']['language']['label_separator'] . ' ' . 'User must reset password',
		'_type' => 'option',
	)), array(
		'label' => 'Set security lock',
		'explain' => 'Administrators will not be security locked.',
	)) . '

			<hr class="formRowSep" />

			' . $__templater->formTextBoxRow(array(
		'name' => 'actions[custom_title]',
	), array(
		'label' => 'Set custom title',
	)) . '

			' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'actions[discourage]',
		'label' => 'Discourage users',
		'_type' => 'option',
	),
	array(
		'name' => 'actions[undiscourage]',
		'label' => 'Undiscourage users',
		'_type' => 'option',
	),
	array(
		'name' => 'actions[ban]',
		'label' => 'Ban users (permanently)',
		'_type' => 'option',
	),
	array(
		'name' => 'actions[unban]',
		'label' => 'Unban users',
		'_type' => 'option',
	),
	array(
		'name' => 'actions[remove_avatar]',
		'label' => 'Remove avatars',
		'_type' => 'option',
	),
	array(
		'name' => 'actions[remove_signature]',
		'label' => 'Remove signatures',
		'_type' => 'option',
	),
	array(
		'name' => 'actions[remove_website]',
		'label' => 'Remove websites',
		'_type' => 'option',
	),
	array(
		'name' => 'actions[enable_activity_summary_email]',
		'label' => 'Enable activity summary email',
		'_type' => 'option',
	),
	array(
		'name' => 'actions[disable_activity_summary_email]',
		'label' => 'Disable activity summary email',
		'_type' => 'option',
	)), array(
		'explain' => 'None of the batch update actions specified will apply to super admins.',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => 'Update users',
		'icon' => 'save',
	), array(
	)) . '
	</div>

	' . $__compilerTemp5 . '
', array(
		'action' => $__templater->func('link', array('users/batch-update/action', ), false),
		'class' => 'block',
	)) . '

';
	$__compilerTemp6 = '';
	if ($__vars['userIds']) {
		$__compilerTemp6 .= '
		' . $__templater->formHiddenVal('user_ids', $__templater->filter($__vars['userIds'], array(array('json', array()),), false), array(
		)) . '
	';
	} else {
		$__compilerTemp6 .= '
		' . $__templater->formHiddenVal('criteria', $__templater->filter($__vars['criteria'], array(array('json', array()),), false), array(
		)) . '
	';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<h2 class="block-header">' . 'Delete users' . '</h2>
		<div class="block-body">
			' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'actions[delete]',
		'label' => 'Confirm deletion of ' . $__templater->filter($__vars['total'], array(array('number', array()),), true) . ' users',
		'_type' => 'option',
	)), array(
		'explain' => 'Administrators and moderators will not be deleted.',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'name' => 'confirm_delete',
		'icon' => 'delete',
	), array(
	)) . '
	</div>

	' . $__compilerTemp6 . '
', array(
		'action' => $__templater->func('link', array('users/batch-update/action', ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);