<?php
// FROM HASH: 5fd0a1c16b921571cb95e89951a86bed
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formRadioRow(array(
		'name' => $__vars['inputName'] . '[emailTransport]',
		'value' => $__vars['option']['option_value']['emailTransport'],
	), array(array(
		'value' => 'sendmail',
		'label' => 'Default',
		'_type' => 'option',
	),
	array(
		'value' => 'smtp',
		'label' => 'SMTP',
		'data-hide' => 'true',
		'_dependent' => array('
			<div class="inputGroup">
				' . $__templater->formTextBox(array(
		'name' => $__vars['inputName'] . '[smtpHost]',
		'value' => $__vars['option']['option_value']['smtpHost'],
		'placeholder' => 'Host',
		'size' => '40',
	)) . '
				<span class="inputGroup-text">:</span>
				' . $__templater->formTextBox(array(
		'name' => $__vars['inputName'] . '[smtpPort]',
		'value' => $__vars['option']['option_value']['smtpPort'],
		'placeholder' => 'Port',
		'size' => '5',
	)) . '
			</div>

			<div class="inputChoices-spacer">' . 'Authentication' . '</div>
			' . $__templater->formRadio(array(
		'name' => $__vars['inputName'] . '[smtpAuth]',
		'value' => ($__vars['option']['option_value']['smtpAuth'] ? $__vars['option']['option_value']['smtpAuth'] : 'none'),
	), array(array(
		'value' => 'none',
		'label' => 'None',
		'_type' => 'option',
	),
	array(
		'value' => 'login',
		'label' => 'Username and password',
		'_dependent' => array('
						<div class="inputGroup">
							' . $__templater->formTextBox(array(
		'name' => $__vars['inputName'] . '[smtpLoginUsername]',
		'value' => $__vars['option']['option_value']['smtpLoginUsername'],
		'placeholder' => 'Username',
		'size' => '15',
	)) . '
							<span class="inputGroup-splitter"></span>
							' . $__templater->formTextBox(array(
		'name' => $__vars['inputName'] . '[smtpLoginPassword]',
		'value' => $__vars['option']['option_value']['smtpLoginPassword'],
		'type' => 'password',
		'size' => '15',
	)) . '
						</div>
					'),
		'_type' => 'option',
	))) . '

			<div class="inputChoices-spacer">' . 'Encryption' . '</div>
			' . $__templater->formRadio(array(
		'name' => $__vars['inputName'] . '[smtpEncrypt]',
		'value' => ($__vars['option']['option_value']['smtpEncrypt'] ? $__vars['option']['option_value']['smtpEncrypt'] : 'none'),
		'listclass' => 'indented',
	), array(array(
		'value' => 'none',
		'label' => 'None',
		'_type' => 'option',
	),
	array(
		'value' => 'tls',
		'label' => 'TLS',
		'_type' => 'option',
	),
	array(
		'value' => 'ssl',
		'label' => 'SSL',
		'_type' => 'option',
	))) . '
		'),
		'_type' => 'option',
	)), array(
		'label' => $__templater->escape($__vars['option']['title']),
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['explainHtml']),
		'html' => $__templater->escape($__vars['listedHtml']),
		'rowclass' => $__vars['rowClass'],
	));
	return $__finalCompiled;
}
);