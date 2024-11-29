<?php
// FROM HASH: 09144ac5d2f19b0a1cf82366e58e2ea8
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Change email');
	$__finalCompiled .= '

';
	$__templater->wrapTemplate('account_wrapper', $__vars);
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['hasPassword']) {
		$__compilerTemp1 .= '

				' . $__templater->formTextBoxRow(array(
			'name' => 'email',
			'value' => $__vars['xf']['visitor']['email'],
			'type' => 'email',
			'dir' => 'ltr',
			'autofocus' => 'autofocus',
			'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor'], 'email', ), false),
		), array(
			'label' => 'Email',
			'explain' => 'If you change your email, you may need to reconfirm your account.',
		)) . '

				' . $__templater->formPasswordBoxRow(array(
			'name' => 'password',
		), array(
			'label' => 'Current password',
		)) . '

			';
	} else {
		$__compilerTemp1 .= '

				' . $__templater->formRow('

					' . $__templater->filter($__vars['xf']['visitor']['email'], array(array('email_display', array()),), true) . '
				', array(
			'label' => 'Email',
			'explain' => 'Your email cannot be changed while your account does not have a password.',
		)) . '

			';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__compilerTemp1 . '
		</div>

		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'sticky' => 'true',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('account/email', ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);