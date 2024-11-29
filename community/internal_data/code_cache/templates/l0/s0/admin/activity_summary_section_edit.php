<?php
// FROM HASH: eb484a6edd8e12f02f6df4c60e987405
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['section'], 'isInsert', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add activity summary section');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit activity summary section' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['section']['title']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['section'], 'isUpdate', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('', array(
			'href' => $__templater->func('link', array('activity-summary/delete', $__vars['section'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">

			' . $__templater->formRow('
				' . $__templater->escape($__vars['definition']['title']) . '
				' . $__templater->formHiddenVal('definition_id', $__vars['definition']['definition_id'], array(
	)) . '
			', array(
		'label' => 'Activity summary definition',
		'explain' => $__templater->escape($__vars['definition']['description']),
	)) . '

			<hr class="formRowSep" />

			' . $__templater->formTextBoxRow(array(
		'name' => 'title',
		'value' => ($__vars['section']['section_id'] ? $__vars['section']['MasterTitle']['phrase_text'] : ''),
	), array(
		'label' => 'Title',
		'hint' => 'Optional',
		'explain' => 'You may choose to enter a specific title for this section. If you do not enter one, the section will display an appropriate title.',
	)) . '

			' . $__templater->callMacro('display_order_macros', 'row', array(
		'value' => $__vars['section']['display_order'],
	), $__vars) . '

			' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'show_value',
		'value' => '1',
		'selected' => $__vars['section']['show_value'],
		'label' => 'Display total count in summary',
		'_type' => 'option',
	)), array(
		'explain' => 'If enabled, the total number of items found for this section will be displayed at the top of the activity summary email.',
	)) . '

			' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'active',
		'value' => '1',
		'selected' => $__vars['section']['active'],
		'label' => '
					' . 'Enabled' . '
				',
		'_type' => 'option',
	)), array(
	)) . '

			' . $__templater->filter($__templater->method($__vars['section'], 'renderOptions', array()), array(array('raw', array()),), true) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('activity-summary/save', $__vars['section'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);