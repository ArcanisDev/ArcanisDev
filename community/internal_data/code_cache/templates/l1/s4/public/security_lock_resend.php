<?php
// FROM HASH: 9cc935a6f89e9a49607e62dd5d5e88d8
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Resend security lock reset email');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'Are you sure you want to resend the security lock reset email? Any previous security lock reset emails will no longer function. This email will be sent to ' . $__templater->filter($__vars['xf']['visitor']['email'], array(array('email_display', array()),), true) . '.' . '
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => 'Resend email',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('security-lock/resend', ), false),
		'class' => 'block',
		'ajax' => 'true',
		'data-redirect' => 'off',
		'data-reset-complete' => 'true',
	));
	return $__finalCompiled;
}
);