<?php
// FROM HASH: acf223025c452cd47b769c63d9a79bf7
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Resend account confirmation');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['needsCaptcha']) {
		$__compilerTemp1 .= '
				' . $__templater->formRowIfContent($__templater->func('captcha_options', array(array(
			'label' => 'Verification',
			'force' => 'true',
			'context' => 'xf_account_confirm_resend',
		))), array(
			'label' => 'Verification',
			'force' => 'true',
			'context' => 'xf_account_confirm_resend',
		)) . '
			';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'Are you sure you want to resend the account confirmation email? Any previous account confirmation emails will no longer function. This email will be sent to ' . $__templater->filter($__vars['user']['email'], array(array('email_display', array()),), true) . '.' . '
			', array(
		'rowtype' => 'confirm',
	)) . '

			' . $__compilerTemp1 . '
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => 'Resend email',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__vars['confirmUrl'],
		'class' => 'block',
		'ajax' => 'true',
		'data-redirect' => 'off',
		'data-reset-complete' => 'true',
	));
	return $__finalCompiled;
}
);