<?php
// FROM HASH: 45afbaf72d1eba462adbb25c70106261
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = array();
	if ($__templater->isTraversable($__vars['userGroups'])) {
		foreach ($__vars['userGroups'] AS $__vars['userGroup']) {
			$__compilerTemp1[] = array(
				'label' => $__templater->escape($__vars['userGroup']['label']),
				'value' => $__vars['userGroup']['value'],
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => $__vars['inputName'] . '[enabled]',
		'selected' => $__vars['option']['option_value']['enabled'],
		'label' => 'Enable writing before registering',
		'_dependent' => array('
			<div>' . 'Inherit permissions from' . $__vars['xf']['language']['label_separator'] . '</div>

			' . $__templater->formCheckBox(array(
		'name' => $__vars['inputName'] . '[userGroups]',
		'value' => ($__vars['option']['option_value']['userGroups'] ?: array(2, )),
		'listclass' => 'listColumns',
	), $__compilerTemp1) . '
		'),
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