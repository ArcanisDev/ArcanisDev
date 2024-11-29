<?php
// FROM HASH: 86459d2c6891e42a0256aa18c464f54f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Inline moderation - Change thread types');
	$__finalCompiled .= '

';
	$__compilerTemp1 = $__templater->mergeChoiceOptions(array(), $__vars['creatableThreadTypes']);
	$__compilerTemp2 = '';
	if ($__templater->isTraversable($__vars['threads'])) {
		foreach ($__vars['threads'] AS $__vars['thread']) {
			$__compilerTemp2 .= '
		' . $__templater->formHiddenVal('ids[]', $__vars['thread']['thread_id'], array(
			)) . '
	';
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				<div>' . 'Are you sure you want to change the thread type of ' . $__templater->escape($__vars['total']) . ' threads?' . '</div>

				<div class="block-rowMessage block-rowMessage--warning">
					' . 'Changing a thread\'s type may cause some data loss. Please be sure that you select the correct options before proceeding.' . '
				</div>
			', array(
		'rowtype' => 'confirm',
	)) . '

			' . $__templater->formRadioRow(array(
		'name' => 'new_thread_type_id',
	), $__compilerTemp1, array(
		'label' => 'Thread type',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'confirm',
	), array(
	)) . '
	</div>

	' . $__compilerTemp2 . '

	' . $__templater->formHiddenVal('type', 'thread', array(
	)) . '
	' . $__templater->formHiddenVal('action', 'change_type', array(
	)) . '
	' . $__templater->formHiddenVal('confirmed', '1', array(
	)) . '

	' . $__templater->func('redirect_input', array($__vars['redirect'], null, true)) . '
', array(
		'action' => $__templater->func('link', array('inline-mod', ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);