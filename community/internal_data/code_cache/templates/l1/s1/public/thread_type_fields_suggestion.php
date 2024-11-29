<?php
// FROM HASH: d2a138a079a0edcd60aa15ac086d5145
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
			'name' => 'suggestion[allow_voting]',
			'value' => $__vars['typeData']['allow_voting'],
		), array(array(
			'value' => 'yes',
			'label' => 'Yes',
			'_type' => 'option',
		),
		array(
			'value' => 'no',
			'label' => 'No',
			'hint' => 'No voting option will be displayed. This is primarily useful for announcements or sticky threads that aren\'t directly suggestions.',
			'_type' => 'option',
		),
		array(
			'value' => 'paused',
			'label' => 'Paused',
			'hint' => 'No new votes will be allowed, but existing votes will be displayed. Note that implemented and closed suggestions never allow new votes.',
			'_type' => 'option',
		)), array(
			'label' => 'Allow suggestion voting',
			'rowtype' => $__vars['rowType'],
		)) . '
';
	}
	return $__finalCompiled;
}
);