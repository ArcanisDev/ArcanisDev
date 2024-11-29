<?php
// FROM HASH: 19f702ae79be2959cec719aa6959b469
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeJs(array(
		'src' => 'xf/sort.js, vendor/dragula/dragula.js',
	));
	$__finalCompiled .= '
';
	$__templater->includeCss('public:dragula.less');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['typeConfig']['allowed_thread_types'])) {
		foreach ($__vars['typeConfig']['allowed_thread_types'] AS $__vars['threadTypeId']) {
			if ($__vars['possibleThreadTypes'][$__vars['threadTypeId']]) {
				$__compilerTemp1 .= '
			<div class="u-inputSpacer">
				<span class="dragHandle" aria-label="' . $__templater->filter('Drag handle', array(array('for_attr', array()),), true) . '"></span>
				' . $__templater->formCheckBox(array(
					'standalone' => 'true',
				), array(array(
					'name' => 'type_config[allowed_thread_types][]',
					'value' => $__vars['threadTypeId'],
					'selected' => true,
					'label' => $__templater->escape($__vars['possibleThreadTypes'][$__vars['threadTypeId']]),
					'data-xf-init' => 'disabler',
					'data-container' => '#js-' . $__vars['threadTypeId'] . 'Config',
					'data-optional' => 'on',
					'data-hide' => 'on',
					'_type' => 'option',
				))) . '
			</div>
		';
			}
		}
	}
	$__compilerTemp2 = '';
	if ($__templater->isTraversable($__vars['possibleThreadTypes'])) {
		foreach ($__vars['possibleThreadTypes'] AS $__vars['threadTypeId'] => $__vars['typeTitle']) {
			if ((!$__templater->func('in_array', array($__vars['threadTypeId'], $__vars['typeConfig']['allowed_thread_types'], ), false))) {
				$__compilerTemp2 .= '
			<div class="u-inputSpacer">
				<span class="dragHandle" aria-label="' . $__templater->filter('Drag handle', array(array('for_attr', array()),), true) . '"></span>
				' . $__templater->formCheckBox(array(
					'standalone' => 'true',
				), array(array(
					'name' => 'type_config[allowed_thread_types][]',
					'value' => $__vars['threadTypeId'],
					'label' => $__templater->escape($__vars['typeTitle']),
					'data-xf-init' => 'disabler',
					'data-container' => '#js-' . $__vars['threadTypeId'] . 'Config',
					'data-optional' => 'on',
					'data-hide' => 'on',
					'_type' => 'option',
				))) . '
			</div>
		';
			}
		}
	}
	$__finalCompiled .= $__templater->formRow('
	<div data-xf-init="list-sorter" data-drag-handle=".dragHandle">
		<div class="is-undraggable js-blockDragbefore">
			<span class="dragHandle" aria-label="' . $__templater->filter('Drag handle', array(array('for_attr', array()),), true) . '"></span>
			' . $__templater->formCheckBox(array(
		'standalone' => 'true',
	), array(array(
		'selected' => true,
		'disabled' => 'true',
		'label' => 'Discussions',
		'_type' => 'option',
	))) . '
		</div>

		' . $__compilerTemp1 . '

		' . $__compilerTemp2 . '
	</div>
', array(
		'label' => 'Allowed thread types',
	)) . '

';
	if ($__vars['possibleThreadTypes']['question']) {
		$__finalCompiled .= '
	' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'type_config[allow_answer_voting]',
			'selected' => $__vars['typeConfig']['allow_answer_voting'],
			'label' => 'Allow answer voting in question threads',
			'hint' => 'If enabled, users will be able to vote on the answers given to questions.',
			'_dependent' => array($__templater->formCheckBox(array(
		), array(array(
			'name' => 'type_config[allow_answer_downvote]',
			'selected' => ((!$__vars['typeConfig']['allow_answer_voting']) OR $__vars['typeConfig']['allow_answer_downvote']),
			'label' => 'Allow answers given to votable questions to be downvoted',
			'hint' => 'If disabled, users may only choose to upvote answers.',
			'_type' => 'option',
		)))),
			'_type' => 'option',
		)), array(
			'rowid' => 'js-questionConfig',
		)) . '
';
	}
	return $__finalCompiled;
}
);