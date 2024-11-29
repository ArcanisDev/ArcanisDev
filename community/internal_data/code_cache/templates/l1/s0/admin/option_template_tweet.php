<?php
// FROM HASH: 4003347d399992dfb25f60e863d77df9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => $__vars['inputName'] . '[enabled]',
		'selected' => $__vars['option']['option_value']['enabled'],
		'label' => $__templater->escape($__vars['option']['title']),
		'_dependent' => array($__templater->formTextBox(array(
		'name' => $__vars['inputName'] . '[via]',
		'value' => $__vars['option']['option_value']['via'],
		'placeholder' => 'Via account: @...',
	)), $__templater->formTextBox(array(
		'name' => $__vars['inputName'] . '[related]',
		'value' => $__vars['option']['option_value']['related'],
		'placeholder' => 'Related account: @...',
	))),
		'_type' => 'option',
	)), array(
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['explainHtml']),
		'html' => $__templater->escape($__vars['listedHtml']),
		'rowclass' => $__vars['rowClass'],
	));
	return $__finalCompiled;
}
);