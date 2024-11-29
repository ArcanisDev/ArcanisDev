<?php
// FROM HASH: 1201780519c6b6a482fdbc5517ba28bc
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= $__templater->escape($__vars['error']);
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
	<div class="blockMessage blockMessage--error blockMessage--iconic">
		' . $__compilerTemp1 . '
	</div>
';
	}
	$__finalCompiled .= '

<div class="blocks blocks--login">
	';
	$__compilerTemp2 = '';
	if ($__vars['captcha']) {
		$__compilerTemp2 .= '
					' . $__templater->formRowIfContent($__templater->func('captcha_options', array(array(
			'label' => 'Verification',
			'force' => 'true',
		))), array(
			'label' => 'Verification',
			'force' => 'true',
		)) . '
				';
	}
	$__compilerTemp3 = '';
	if ($__vars['xf']['options']['registrationSetup']['enabled']) {
		$__compilerTemp3 .= '
					<div class="block-outer block-outer--after block-outer--register">
						<div class="block-outer-middle">
							' . 'Don\'t have an account?' . ' ' . $__templater->button('Register now', array(
			'href' => $__templater->func('link', array('register', ), false),
		), '', array(
		)) . '
						</div>
					</div>
				';
	}
	$__finalCompiled .= $__templater->form('
		<div class="block-container">
			<h3 class="block-minorHeader">
				' . 'Log in' . '
			</h3>
			<div class="block-body">
				<div class="block-row">
				' . $__templater->formTextBoxRow(array(
		'name' => 'login',
		'value' => $__vars['login'],
		'autocomplete' => 'username',
	), array(
		'label' => 'Your name or email address',
	)) . '

				' . $__templater->formTextBoxRow(array(
		'name' => 'password',
		'type' => 'password',
		'autocomplete' => 'current-password',
	), array(
		'label' => 'Password',
		'html' => '
						<a href="' . $__templater->func('link', array('lost-password', ), true) . '" data-xf-click="overlay">' . 'Forgot your password?' . '</a>
					',
	)) . '

				' . $__compilerTemp2 . '

				' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'remember',
		'selected' => true,
		'label' => 'Stay logged in',
		'_type' => 'option',
	)), array(
	)) . '
					' . $__templater->formSubmitRow(array(
		'icon' => 'login',
	), array(
	)) . '
					
				' . $__compilerTemp3 . '
					
				</div>
			</div>
			
		</div>

	', array(
		'action' => $__templater->func('link', array('login/login', ), false),
		'class' => 'block',
	)) . '
</div>';
	return $__finalCompiled;
}
);