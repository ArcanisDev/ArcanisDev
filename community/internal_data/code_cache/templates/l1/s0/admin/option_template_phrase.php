<?php
// FROM HASH: 44ca04d0590b133811e32f680b965cf9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formTextBoxRow(array(
		'name' => $__vars['inputName'],
		'value' => $__vars['phrase']['phrase_text'],
		'type' => $__vars['formatParams']['type'],
		'class' => $__vars['formatParams']['class'],
	), array(
		'rowclass' => $__vars['rowClass'],
		'label' => $__templater->escape($__vars['option']['title']),
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['explainHtml']),
		'finalhtml' => $__templater->escape($__vars['listedHtml']),
	));
	return $__finalCompiled;
}
);