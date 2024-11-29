<?php
// FROM HASH: 745884b13e541d327da7fb8227355dee
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__vars['option']['option_value']['emailTransport'] == 'sendmail') {
		$__compilerTemp1 .= '
		<div>' . 'PHP built-in mail system' . '</div>
	';
	} else {
		$__compilerTemp1 .= '
		<dl class="pairs pairs--columns pairs--fixedSmall">
			<dt>' . 'Connection type' . '</dt>
			<dd>
				' . $__templater->filter($__vars['option']['option_value']['emailTransport'], array(array('to_upper', array()),), true) . '
				';
		if ($__vars['option']['option_value']['oauth'] AND ($__vars['option']['option_value']['oauth']['provider'] == 'Google')) {
			$__compilerTemp1 .= '
					' . $__templater->filter('Google OAuth', array(array('parens', array()),), true) . '
				';
		}
		$__compilerTemp1 .= '
				';
		if ($__vars['option']['option_value']['oauth'] AND ($__vars['option']['option_value']['oauth']['provider'] == 'XF:Service\\MicrosoftEmail')) {
			$__compilerTemp1 .= '
					' . $__templater->filter('Microsoft OAuth', array(array('parens', array()),), true) . '
				';
		}
		$__compilerTemp1 .= '
			</dd>
		</dl>

		<dl class="pairs pairs--columns pairs--fixedSmall">
			<dt>' . 'Host' . '</dt>
			<dd>' . $__templater->escape($__vars['option']['option_value']['smtpHost']) . ':' . $__templater->escape($__vars['option']['option_value']['smtpPort']) . '</dd>
		</dl>

		';
		if ($__vars['option']['option_value']['smtpLoginUsername']) {
			$__compilerTemp1 .= '
			<dl class="pairs pairs--columns pairs--fixedSmall">
				<dt>' . 'Username' . '</dt>
				<dd>' . $__templater->escape($__vars['option']['option_value']['smtpLoginUsername']) . '</dd>
			</dl>
		';
		}
		$__compilerTemp1 .= '

		';
		if ($__vars['option']['option_value']['smtpEncrypt'] != 'none') {
			$__compilerTemp1 .= '
			<dl class="pairs pairs--columns pairs--fixedSmall">
				<dt>' . 'Encryption' . '</dt>
				<dd>' . $__templater->filter($__vars['option']['option_value']['smtpEncrypt'], array(array('to_upper', array()),), true) . '</dd>
			</dl>
		';
		}
		$__compilerTemp1 .= '
	';
	}
	$__finalCompiled .= $__templater->formRow('

	' . $__compilerTemp1 . '

	<div class="u-inputSpacer">
		' . $__templater->button('
			' . 'Change' . '
		', array(
		'href' => $__templater->func('link', array('options/email-transport-setup', $__vars['option'], ), false),
		'data-xf-click' => 'overlay',
	), '', array(
	)) . '
	</div>
', array(
		'label' => $__templater->escape($__vars['option']['title']),
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['explainHtml']),
		'rowclass' => $__vars['rowClass'],
	));
	return $__finalCompiled;
}
);