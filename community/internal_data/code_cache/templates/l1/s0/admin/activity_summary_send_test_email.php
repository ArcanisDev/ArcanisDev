<?php
// FROM HASH: 9288567774ba4ddf91c220eb7bc25e60
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Activity summary' . $__vars['xf']['language']['label_separator'] . ' ' . 'Send test email');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'Are you sure you want to generate and receive a test activity summary email? This email will be sent to ' . $__templater->escape($__vars['xf']['visitor']['email']) . '.' . '
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => 'Send test email',
		'fa' => 'fa-envelope',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('activity-summary/send-test-email', ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);