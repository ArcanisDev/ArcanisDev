<?php
// FROM HASH: 7bd4a03439e4e08265d43a4ebc56f0e3
return array(
'macros' => array('dob_edit' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'dobData' => array(),
		'row' => true,
		'labelId' => null,
		'required' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__vars['row'] AND (!$__vars['labelId'])) {
		$__finalCompiled .= '
		';
		$__vars['labelId'] = $__templater->func('unique_id', array(), false);
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	if ($__vars['labelId']) {
		$__compilerTemp1 .= ' aria-labelledby="' . $__templater->escape($__vars['labelId']) . '"';
	}
	$__vars['labelAttr'] = $__templater->preEscaped($__compilerTemp1);
	$__finalCompiled .= '
	';
	$__vars['inputGroup'] = $__templater->preEscaped('
		<div class="inputGroup inputGroup--auto" role="group"' . $__templater->escape($__vars['labelAttr']) . '>
			' . $__templater->formSelect(array(
		'name' => 'dob_month',
		'value' => ($__vars['dobData']['dob_month'] ?: 0),
		'aria-label' => $__templater->filter('Month', array(array('for_attr', array()),), false),
	), array(array(
		'value' => '0',
		'_type' => 'option',
	),
	array(
		'value' => '1',
		'label' => 'January',
		'_type' => 'option',
	),
	array(
		'value' => '2',
		'label' => 'February',
		'_type' => 'option',
	),
	array(
		'value' => '3',
		'label' => 'March',
		'_type' => 'option',
	),
	array(
		'value' => '4',
		'label' => 'April',
		'_type' => 'option',
	),
	array(
		'value' => '5',
		'label' => 'May',
		'_type' => 'option',
	),
	array(
		'value' => '6',
		'label' => 'June',
		'_type' => 'option',
	),
	array(
		'value' => '7',
		'label' => 'July',
		'_type' => 'option',
	),
	array(
		'value' => '8',
		'label' => 'August',
		'_type' => 'option',
	),
	array(
		'value' => '9',
		'label' => 'September',
		'_type' => 'option',
	),
	array(
		'value' => '10',
		'label' => 'October',
		'_type' => 'option',
	),
	array(
		'value' => '11',
		'label' => 'November',
		'_type' => 'option',
	),
	array(
		'value' => '12',
		'label' => 'December',
		'_type' => 'option',
	))) . '
			<span class="inputGroup-splitter"></span>
			' . $__templater->formTextBox(array(
		'name' => 'dob_day',
		'value' => ($__vars['dobData']['dob_day'] ?: ''),
		'pattern' => '\\d*',
		'size' => '4',
		'maxlength' => '2',
		'aria-label' => $__templater->filter('Day', array(array('for_attr', array()),), false),
		'placeholder' => 'Day',
	)) . '
			<span class="inputGroup-splitter"></span>
			' . $__templater->formTextBox(array(
		'name' => 'dob_year',
		'value' => ($__vars['dobData']['dob_year'] ?: ''),
		'pattern' => '\\d*',
		'size' => '6',
		'maxlength' => '4',
		'aria-label' => $__templater->filter('Year', array(array('for_attr', array()),), false),
		'placeholder' => 'Year',
	)) . '
		</div>
	');
	$__finalCompiled .= '
	';
	if ($__vars['row']) {
		$__finalCompiled .= '
		' . $__templater->formRow('

			' . $__templater->filter($__vars['inputGroup'], array(array('raw', array()),), true) . '
		', array(
			'rowtype' => 'input',
			'label' => 'Date of birth',
			'labelid' => $__vars['labelId'],
			'hint' => ($__vars['required'] ? 'Required' : ''),
		)) . '
	';
	} else {
		$__finalCompiled .= '
		' . $__templater->filter($__vars['inputGroup'], array(array('raw', array()),), true) . '
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

	return $__finalCompiled;
}
);