<?php
// FROM HASH: 3f87580339bc43c1e754e2a5e4823663
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Choose activity summary definition');
	$__finalCompiled .= '

';
	$__compilerTemp1 = array();
	if ($__templater->isTraversable($__vars['definitions'])) {
		foreach ($__vars['definitions'] AS $__vars['definition']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['definition']['definition_id'],
				'label' => $__templater->escape($__vars['definition']['title']),
				'hint' => $__templater->escape($__vars['definition']['description']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRadioRow(array(
		'name' => 'definition_id',
	), $__compilerTemp1, array(
		'label' => 'Activity summary definition',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => 'Add section',
		'icon' => 'add',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('activity-summary/add', ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);