<?php
// FROM HASH: 6957d26f484a95fc214375383cfdf884
return array(
'macros' => array('dob_privacy_row' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'hint' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->formCheckBoxRow(array(
	), array(array(
		'value' => '1',
		'name' => 'option[show_dob_date]',
		'checked' => $__vars['xf']['visitor']['Option']['show_dob_date'],
		'label' => 'Show day and month of birth',
		'_dependent' => array($__templater->formCheckBox(array(
	), array(array(
		'value' => '1',
		'name' => 'option[show_dob_year]',
		'checked' => $__vars['xf']['visitor']['Option']['show_dob_year'],
		'label' => 'Show year of birth',
		'hint' => 'This will allow people to see your age.',
		'_type' => 'option',
	)))),
		'_type' => 'option',
	)), array(
		'hint' => ($__vars['hint'] ? $__templater->escape($__vars['hint']) : ''),
	)) . '
';
	return $__finalCompiled;
}
),
'activity_privacy_row' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'user[visible]',
		'checked' => $__vars['xf']['visitor']['visible'],
		'label' => 'Show your online status',
		'hint' => 'This will allow other people to see when you are online.',
		'_dependent' => array($__templater->formCheckBox(array(
	), array(array(
		'name' => 'user[activity_visible]',
		'checked' => $__vars['xf']['visitor']['activity_visible'],
		'label' => 'Show your current activity',
		'hint' => 'This will allow other people to see what page you are currently viewing.',
		'_type' => 'option',
	)))),
		'_type' => 'option',
	)), array(
		'label' => 'Privacy options',
	)) . '
';
	return $__finalCompiled;
}
),
'email_options_row' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'showExplain' => false,
		'showConversationOption' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = array(array(
		'name' => 'option[receive_admin_email]',
		'selected' => $__vars['xf']['visitor']['Option']['receive_admin_email'],
		'label' => 'Receive news and update emails',
		'hint' => '',
		'_type' => 'option',
	));
	if ($__vars['xf']['options']['activitySummaryEmail']['enabled']) {
		$__compilerTemp1[] = array(
			'name' => 'enable_activity_summary_email',
			'selected' => $__vars['xf']['visitor']['last_summary_email_date'] !== null,
			'label' => 'Receive activity summary email',
			'hint' => 'We will keep you updated about new content when you haven\'t visited for a while.',
			'_type' => 'option',
		);
	}
	if ($__vars['showConversationOption']) {
		$__compilerTemp1[] = array(
			'name' => 'option[email_on_conversation]',
			'selected' => $__vars['xf']['visitor']['Option']['email_on_conversation'],
			'label' => 'Receive email when a new conversation message is received',
			'_type' => 'option',
		);
	}
	$__compilerTemp2 = '';
	if ($__vars['showExplain']) {
		$__compilerTemp2 .= 'You may find additional email options under <a href="' . $__templater->func('link', array('account/preferences', ), true) . '">Preferences</a>.';
	}
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), $__compilerTemp1, array(
		'label' => 'Email options',
		'explain' => $__compilerTemp2,
	)) . '

	';
	if (!$__vars['xf']['options']['activitySummaryEmail']['enabled']) {
		$__finalCompiled .= '
		';
		if ($__vars['xf']['visitor']['last_summary_email_date'] !== null) {
			$__finalCompiled .= '
			' . $__templater->formHiddenVal('enable_activity_summary_email', '1', array(
			)) . '
		';
		}
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . '

';
	return $__finalCompiled;
}
);