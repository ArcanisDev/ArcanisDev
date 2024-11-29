<?php
// FROM HASH: a9a5bece7b290a186f87d24522aa49bc
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => $__vars['inputName'] . '[enabled]',
		'selected' => $__vars['option']['option_value']['enabled'],
		'label' => $__templater->escape($__vars['option']['title']),
		'_dependent' => array('
			<dl class="inputLabelPair">
				<dt><label for="' . $__templater->escape($__vars['inputName']) . '_h">' . 'Store drafts for X hours' . '</label></dt>
				<dd>' . $__templater->formNumberBox(array(
		'name' => $__vars['inputName'] . '[lifetime]',
		'id' => $__vars['inputName'] . '_h',
		'value' => ($__vars['option']['option_value']['enabled'] ? $__vars['option']['option_value']['lifetime'] : '24'),
		'min' => '1',
	)) . '</dd>
			</dl>
			<dl class="inputLabelPair">
				<dt><label for="' . $__templater->escape($__vars['inputName']) . '_s">' . 'Save drafts every X seconds' . '</label></dt>
				<dd>' . $__templater->formNumberBox(array(
		'name' => $__vars['inputName'] . '[saveFrequency]',
		'id' => $__vars['inputName'] . '_s',
		'value' => ($__vars['option']['option_value']['enabled'] ? $__vars['option']['option_value']['saveFrequency'] : '60'),
		'min' => '1',
	)) . '</dd>
			</dl>
		'),
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