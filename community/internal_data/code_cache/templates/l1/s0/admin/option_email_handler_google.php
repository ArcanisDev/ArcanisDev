<?php
// FROM HASH: 60c53a453fff4681f42b031f4aab62b1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['option']['title']));
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'email_setup_explain:' . '
				<div><code>' . $__templater->escape($__vars['redirectUri']) . '</code></div>
			', array(
	)) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'client_id',
		'value' => $__vars['option']['option_value']['oauth']['client_id'],
		'required' => 'required',
	), array(
		'label' => 'Client ID',
		'explain' => 'You can get a client ID via Google\'s <a href="https://console.developers.google.com/" target="_blank">Developer Console</a>',
	)) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'client_secret',
		'required' => 'required',
	), array(
		'label' => 'Client secret',
		'explain' => 'The secret that corresponds to your Google client ID above.',
	)) . '

			' . $__templater->formRadioRow(array(
		'name' => 'type',
		'value' => ($__vars['option']['option_value']['type'] ?: 'pop3'),
	), array(array(
		'value' => 'pop3',
		'label' => 'POP3',
		'_type' => 'option',
	),
	array(
		'value' => 'imap',
		'label' => 'IMAP',
		'_type' => 'option',
	)), array(
		'label' => 'Connection type',
	)) . '

			' . $__templater->formInfoRow('
				' . 'Continuing will redirect you to Google to confirm the account you want to connect with.' . '
			', array(
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'submit' => 'Continue',
	), array(
	)) . '
	</div>
	' . $__templater->formHiddenVal('oauth_provider', 'google', array(
	)) . '
', array(
		'action' => $__templater->func('link', array('options/email-handler-oauth', $__vars['option'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);