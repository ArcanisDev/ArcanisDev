<?php
// FROM HASH: b92b6e2edb9ac4cc1ea72e7e33b84ded
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Email handler setup');
	$__finalCompiled .= '

';
	$__compilerTemp1 = array(array(
		'value' => 'disabled',
		'label' => 'Disabled',
		'_type' => 'option',
	));
	if ($__vars['option']['option_value']['enabled']) {
		$__compilerTemp2 = '';
		if ($__vars['option']['option_value']['username']) {
			$__compilerTemp2 .= '
								<li>' . $__templater->escape($__vars['option']['option_value']['username']) . '</li>
							';
		}
		$__compilerTemp3 = '';
		if ($__vars['option']['option_value']['oauth'] AND ($__vars['option']['option_value']['oauth']['provider'] == 'Google')) {
			$__compilerTemp3 .= '
								<li>' . 'Google OAuth' . '</li>
							';
		}
		$__vars['unchangedHint'] = $__templater->preEscaped('
						<ul class="listInline listInline--bullet listInline--selfInline">
							<li>' . $__templater->filter($__vars['option']['option_value']['type'], array(array('to_upper', array()),), true) . '</li>
							<li>' . $__templater->escape($__vars['option']['option_value']['host']) . ':' . $__templater->escape($__vars['option']['option_value']['port']) . '</li>
							' . $__compilerTemp2 . '
							' . $__compilerTemp3 . '
						</ul>
					');
		$__compilerTemp1[] = array(
			'value' => 'unchanged',
			'label' => 'Do not change',
			'hint' => $__templater->escape($__vars['unchangedHint']),
			'_type' => 'option',
		);
	}
	$__compilerTemp1[] = array(
		'value' => 'pop3',
		'label' => 'POP3',
		'_type' => 'option',
	);
	$__compilerTemp1[] = array(
		'value' => 'imap',
		'label' => 'IMAP',
		'_type' => 'option',
	);
	$__compilerTemp1[] = array(
		'value' => 'google',
		'label' => 'Google OAuth',
		'_type' => 'option',
	);
	$__compilerTemp1[] = array(
		'value' => 'microsoft',
		'label' => 'Microsoft OAuth',
		'_type' => 'option',
	);
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRadioRow(array(
		'name' => 'new_type',
		'value' => ($__vars['option']['option_value']['enabled'] ? 'unchanged' : 'disabled'),
	), $__compilerTemp1, array(
		'label' => $__templater->escape($__vars['option']['title']),
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => 'Continue',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('options/email-handler-setup', $__vars['option'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);