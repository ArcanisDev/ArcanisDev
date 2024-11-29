<?php
// FROM HASH: 151e038c0569cbf64d7d956306cddeb2
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__vars['newUnreadStatus']) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Mark alert read');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Mark alert unread');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__templater->wrapTemplate('account_wrapper', $__vars);
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if (!$__vars['newUnreadStatus']) {
		$__compilerTemp1 .= '
					' . 'Please confirm that you want to mark this alert read.' . '
				';
	} else {
		$__compilerTemp1 .= '
					' . 'Please confirm that you want to mark this alert unread.' . '
				';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . $__compilerTemp1 . '
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => ((!$__vars['newUnreadStatus']) ? 'Mark read' : 'Mark unread'),
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>

	' . $__templater->func('redirect_input', array($__vars['redirect'], null, true)) . '
	' . $__templater->formHiddenVal('unread', ($__vars['newUnreadStatus'] ? 1 : 0), array(
	)) . '
', array(
		'action' => $__templater->func('link', array('account/alert-toggle', null, array('alert_id' => $__vars['alert']['alert_id'], ), ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);