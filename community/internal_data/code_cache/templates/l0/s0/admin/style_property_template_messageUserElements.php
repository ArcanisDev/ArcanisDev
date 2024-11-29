<?php
// FROM HASH: 938eb80c602758e5844b4b717efb9c36
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => $__vars['formBaseKey'] . '[register_date]',
		'selected' => $__vars['property']['property_value']['register_date'],
		'label' => '
		' . 'Registration date' . '
	',
		'_type' => 'option',
	),
	array(
		'name' => $__vars['formBaseKey'] . '[message_count]',
		'selected' => $__vars['property']['property_value']['message_count'],
		'label' => '
		' . 'Total messages' . '
	',
		'_type' => 'option',
	),
	array(
		'name' => $__vars['formBaseKey'] . '[solutions]',
		'selected' => $__vars['property']['property_value']['solutions'],
		'label' => '
		' . 'Solutions' . '
	',
		'_type' => 'option',
	),
	array(
		'name' => $__vars['formBaseKey'] . '[reaction_score]',
		'selected' => $__vars['property']['property_value']['reaction_score'],
		'label' => '
		' . 'Reaction score' . '
	',
		'_type' => 'option',
	),
	array(
		'name' => $__vars['formBaseKey'] . '[trophy_points]',
		'selected' => $__vars['property']['property_value']['trophy_points'],
		'label' => '
		' . 'Trophy points' . '
	',
		'_type' => 'option',
	),
	array(
		'name' => $__vars['formBaseKey'] . '[age]',
		'selected' => $__vars['property']['property_value']['age'],
		'label' => '
		' . 'Age' . '
	',
		'_type' => 'option',
	),
	array(
		'name' => $__vars['formBaseKey'] . '[location]',
		'selected' => $__vars['property']['property_value']['location'],
		'label' => '
		' . 'Location' . '
	',
		'_type' => 'option',
	),
	array(
		'name' => $__vars['formBaseKey'] . '[website]',
		'selected' => $__vars['property']['property_value']['website'],
		'label' => '
		' . 'Website' . '
	',
		'_type' => 'option',
	),
	array(
		'name' => $__vars['formBaseKey'] . '[custom_fields]',
		'selected' => $__vars['property']['property_value']['custom_fields'],
		'label' => '
		' . 'Custom fields' . '
	',
		'_type' => 'option',
	)), array(
		'rowclass' => $__vars['rowClass'],
		'label' => $__templater->escape($__vars['titleHtml']),
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['property']['description']),
	));
	return $__finalCompiled;
}
);