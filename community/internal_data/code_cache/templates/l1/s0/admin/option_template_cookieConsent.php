<?php
// FROM HASH: 0c6183d430f5ed8a8f0f7ba2c02e5292
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formRadioRow(array(
		'name' => $__vars['inputName'] . '[type]',
	), array(array(
		'value' => 'disabled',
		'selected' => $__vars['option']['option_value']['type'] == 'disabled',
		'label' => 'Disabled',
		'_type' => 'option',
	),
	array(
		'value' => 'simple',
		'selected' => $__vars['option']['option_value']['type'] == 'simple',
		'label' => 'Simple',
		'_type' => 'option',
	),
	array(
		'value' => 'advanced',
		'selected' => $__vars['option']['option_value']['type'] == 'advanced',
		'label' => 'Advanced' . ' ' . $__vars['xf']['language']['parenthesis_open'] . 'Beta' . $__vars['xf']['language']['parenthesis_close'],
		'_type' => 'option',
	)), array(
		'label' => $__templater->escape($__vars['option']['title']),
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['explainHtml']),
		'html' => $__templater->escape($__vars['listedHtml']),
		'rowclass' => $__vars['rowClass'],
	));
	return $__finalCompiled;
}
);