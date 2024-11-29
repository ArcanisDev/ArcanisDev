<?php
// FROM HASH: 57e36c2501a790f2cf486f0b61f67691
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = array(array(
		'value' => '0',
		'label' => '&nbsp;',
		'_type' => 'option',
	));
	$__compilerTemp2 = $__templater->method($__vars['nodeTree'], 'getFlattened', array(0, ));
	if ($__templater->isTraversable($__compilerTemp2)) {
		foreach ($__compilerTemp2 AS $__vars['treeEntry']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['treeEntry']['record']['node_id'],
				'label' => $__templater->func('repeat', array('--', $__vars['treeEntry']['depth'], ), true) . ' ' . $__templater->escape($__vars['treeEntry']['record']['title']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formSelectRow(array(
		'name' => $__vars['formPrefix'] . '[node_id]',
		'value' => $__vars['config']['node_id'],
	), $__compilerTemp1, array(
		'label' => 'Node',
	)) . '

' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => $__vars['formPrefix'] . '[node_title]',
		'selected' => $__vars['config']['node_title'],
		'label' => '
		' . 'Display the node title instead of the navigation entry title' . '
	',
		'_type' => 'option',
	),
	array(
		'name' => $__vars['formPrefix'] . '[with_children]',
		'selected' => $__vars['config']['with_children'],
		'label' => '
		' . 'Display children in navigation' . '
	',
		'_type' => 'option',
	)), array(
	)) . '

' . $__templater->callMacro(null, 'navigation_edit_macros::extra_attrs', array(
		'config' => $__vars['config'],
		'formPrefix' => $__vars['formPrefix'],
	), $__vars);
	return $__finalCompiled;
}
);