<?php
// FROM HASH: 64bc94023907a5aaa8ade30b69d809e9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Password confirmation');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'To access this page, you must first confirm your password.' . '
			', array(
		'rowtype' => 'confirm',
	)) . '

			' . $__templater->formRow($__templater->escape($__vars['xf']['visitor']['username']), array(
		'label' => 'Username',
	)) . '

			' . $__templater->formPasswordBoxRow(array(
		'name' => 'password',
	), array(
		'label' => 'Password',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => 'Confirm',
	), array(
	)) . '
	</div>
	' . $__templater->func('redirect_input', array($__vars['redirect'], null, true)) . '
', array(
		'action' => $__templater->func('link', array('login/password-confirm', ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);