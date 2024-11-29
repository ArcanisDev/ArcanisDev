<?php
// FROM HASH: c62cb51f39e3d00f5516bfcf427d01b9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Password and security');
	$__finalCompiled .= '

';
	$__templater->wrapTemplate('account_wrapper', $__vars);
	$__finalCompiled .= '

';
	if ($__vars['isSecurityLocked']) {
		$__finalCompiled .= '
	<div class="blockMessage blockMessage--important">
		' . 'In order to keep your account secure, we require you to change your password before you can continue using the site.' . '
	</div>
';
	}
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ((!$__vars['isSecurityLocked']) AND $__vars['tfaEnabled']) {
		$__compilerTemp1 .= '
				';
		$__compilerTemp2 = '';
		if ($__vars['xf']['visitor']['Option']['use_tfa']) {
			$__compilerTemp2 .= '
						' . 'Enabled (' . $__templater->filter($__vars['enabledTfaProviders'], array(array('join', array(', ', )),), true) . ')' . '
					';
		} else {
			$__compilerTemp2 .= '
						' . 'Disabled' . '
					';
		}
		$__compilerTemp1 .= $__templater->formRow('

					' . $__compilerTemp2 . '
					' . $__templater->button('Change', array(
			'href' => $__templater->func('link', array('account/two-step', ), false),
			'class' => 'button--link',
		), '', array(
		)) . '
				', array(
			'rowtype' => 'button',
			'label' => 'Two-step verification',
		)) . '

				<hr class="formRowSep" />
			';
	}
	$__compilerTemp3 = '';
	if ($__vars['hasPassword']) {
		$__compilerTemp3 .= '
				' . $__templater->formPasswordBoxRow(array(
			'name' => 'old_password',
			'autocomplete' => 'current-password',
			'autofocus' => 'autofocus',
		), array(
			'label' => 'Your existing password',
			'explain' => 'For security reasons, you must verify your existing password before you may set a new password.',
		)) . '

				' . $__templater->formPasswordBoxRow(array(
			'name' => 'password',
			'autocomplete' => 'new-password',
			'checkstrength' => 'true',
		), array(
			'label' => 'New password',
		)) . '

				' . $__templater->formPasswordBoxRow(array(
			'name' => 'password_confirm',
			'autocomplete' => 'new-password',
		), array(
			'label' => 'Confirm new password',
		)) . '
			';
	} else {
		$__compilerTemp3 .= '
				' . $__templater->formRow('
					' . 'Your account does not currently have a password.' . ' <a href="' . $__templater->func('link', array('account/request-password', ), true) . '" data-xf-click="overlay">' . 'Request a password be emailed to you' . '</a>
				', array(
			'label' => 'Password',
		)) . '
			';
	}
	$__compilerTemp4 = '';
	if ($__vars['hasPassword']) {
		$__compilerTemp4 .= '
			' . $__templater->formSubmitRow(array(
			'icon' => 'save',
		), array(
		)) . '
		';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">

			' . $__compilerTemp1 . '

			' . $__compilerTemp3 . '
		</div>
		' . $__compilerTemp4 . '
	</div>

	' . $__templater->func('redirect_input', array($__vars['redirect'], null, true)) . '
', array(
		'action' => $__templater->func('link', array('account/security', ), false),
		'ajax' => 'true',
		'class' => 'block',
		'data-force-flash-message' => 'true',
	));
	return $__finalCompiled;
}
);