<?php
// FROM HASH: 4faea4be1dd2c10f9827910754034ba4
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
				' . 'You will need to navigate to Google\'s <a href="https://console.developers.google.com/" target="_blank">Developer Console</a> and setup a new project with OAuth 2.0 credentials for a web application. If you are using G Suite, creating an app with an internal user type is recommended to avoid a lengthy review process. In all cases, you will need to ensure the credentials support redirecting to the following URL' . $__vars['xf']['language']['label_separator'] . '
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
		'action' => $__templater->func('link', array('options/email-transport-oauth', $__vars['option'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);