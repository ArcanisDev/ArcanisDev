<?php
// FROM HASH: 6a4606ef178dca3dfd6719f32e09155b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formTextBoxRow(array(
		'name' => $__vars['formPrefix'] . '[link]',
		'value' => $__vars['config']['link'],
		'code' => 'true',
	), array(
		'label' => 'Link',
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => $__vars['formPrefix'] . '[display_condition]',
		'value' => $__vars['config']['display_condition'],
		'code' => 'true',
	), array(
		'label' => 'Display condition',
		'explain' => 'This should be entered as a template-style expression.',
	)) . '

' . $__templater->callMacro(null, 'navigation_edit_macros::extra_attrs', array(
		'config' => $__vars['config'],
		'formPrefix' => $__vars['formPrefix'],
	), $__vars);
	return $__finalCompiled;
}
);