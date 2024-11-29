<?php
// FROM HASH: 91d147d0fdff3fa2c383bb6b17699e90
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
				' . 'You will need to navigate to the Microsoft Azure Portal and <a href="https://learn.microsoft.com/en-us/azure/active-directory/develop/quickstart-register-app#register-an-application" target="_blank">register an Azure Active Directory application</a>. You will need to ensure the credentials support redirecting to the following URL' . $__vars['xf']['language']['label_separator'] . '
				<div><code>' . $__templater->escape($__vars['redirectUri']) . '</code></div>
			', array(
	)) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'client_id',
		'value' => $__vars['option']['option_value']['oauth']['client_id'],
		'required' => 'required',
	), array(
		'label' => 'Client ID',
		'explain' => 'You can get a client ID via the <a href=\'https://portal.azure.com/\' target=\'_blank\'>Microsoft Azure Portal</a>.',
	)) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'client_secret',
		'required' => 'required',
	), array(
		'label' => 'Client secret',
		'explain' => 'The secret that corresponds to your Azure client ID above.',
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
				' . 'Continuing will redirect you to Microsoft to confirm the account you want to connect with.' . '
			', array(
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'submit' => 'Continue',
	), array(
	)) . '
	</div>
	' . $__templater->formHiddenVal('oauth_provider', 'microsoft', array(
	)) . '
', array(
		'action' => $__templater->func('link', array('options/email-handler-oauth', $__vars['option'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);