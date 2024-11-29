<?php
// FROM HASH: 0e1f203c97c0d5a04cb05ab6c3c0514d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => $__vars['inputName'] . '[enabled]',
		'selected' => $__vars['option']['option_value']['enabled'],
		'label' => $__templater->escape($__vars['option']['title']),
		'_type' => 'option',
	)), array(
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['explainHtml']),
		'html' => $__templater->escape($__vars['listedHtml']),
		'rowclass' => $__vars['rowClass'],
	)) . '

' . $__templater->formHiddenVal($__vars['inputName'] . '[configured]', '1', array(
	)) . '
' . $__templater->formHiddenVal($__vars['inputName'] . '[installation_id]', $__vars['option']['option_value']['installation_id'], array(
	)) . '
' . $__templater->formHiddenVal($__vars['inputName'] . '[last_sent]', $__vars['option']['option_value']['last_sent'], array(
	));
	return $__finalCompiled;
}
);