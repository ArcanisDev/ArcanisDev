<?php
// FROM HASH: dbc35f63dbd20cfeeb2a4f035859acce
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

';
	if ($__templater->method($__vars['thread'], 'canEditModeratorFields', array())) {
		$__finalCompiled .= '
	' . $__templater->formRadioRow(array(
			'name' => 'question[allow_question_actions]',
			'value' => $__vars['typeData']['allow_question_actions'],
		), array(array(
			'value' => 'yes',
			'label' => 'Yes',
			'_type' => 'option',
		),
		array(
			'value' => 'no',
			'label' => 'No',
			'hint' => 'No voting or solution options will be displayed. This is primarily useful for announcements or sticky threads that aren\'t directly questions.',
			'_type' => 'option',
		),
		array(
			'value' => 'paused',
			'label' => 'Paused',
			'hint' => 'Voting will not be allowed and a solution cannot be selected, but existing values will be displayed.',
			'_type' => 'option',
		)), array(
			'label' => 'Allow question actions',
			'rowtype' => $__vars['rowType'],
		)) . '
';
	}
	return $__finalCompiled;
}
);