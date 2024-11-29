<?php
// FROM HASH: d7307ce013c679a9ff469cdc9ce8e9a1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__vars['error']) {
		$__compilerTemp1 .= '
			<div class="block-rowMessage block-rowMessage--error">' . $__templater->escape($__vars['error']) . '</div>
		';
	}
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => $__vars['inputName'],
		'selected' => ($__vars['option']['option_value'] AND $__vars['canEnablePush']),
		'disabled' => ((!$__vars['canEnablePush']) ? 'disabled' : false),
		'label' => $__templater->escape($__vars['option']['title']),
		'_type' => 'option',
	)), array(
		'label' => '',
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['explainHtml']),
		'html' => $__templater->escape($__vars['listedHtml']),
		'rowclass' => $__vars['rowClass'],
		'initialhtml' => '
		' . $__compilerTemp1 . '
	',
	));
	return $__finalCompiled;
}
);