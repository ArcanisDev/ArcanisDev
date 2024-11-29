<?php
// FROM HASH: f6e61790bb96358a11a7d77fdc543401
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formRadioRow(array(
		'name' => $__vars['inputName'] . '[type]',
	), array(array(
		'selected' => $__vars['option']['option_value']['type'] == '',
		'label' => 'No terms and rules',
		'_type' => 'option',
	),
	array(
		'value' => 'default',
		'selected' => $__vars['option']['option_value']['type'] == 'default',
		'label' => 'Default URL' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->func('link_type', array('public', 'canonical:help/terms', ), true),
		'_type' => 'option',
	),
	array(
		'value' => 'custom',
		'selected' => $__vars['option']['option_value']['type'] == 'custom',
		'label' => 'Custom URL',
		'_dependent' => array($__templater->formTextBox(array(
		'name' => $__vars['inputName'] . '[custom]',
		'value' => $__vars['option']['option_value']['custom'],
	))),
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