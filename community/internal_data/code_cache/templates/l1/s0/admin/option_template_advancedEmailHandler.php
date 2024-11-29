<?php
// FROM HASH: 3ab206d816710906d4633a9cc24d23f7
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__vars['option']['option_value']['enabled']) {
		$__compilerTemp1 .= '
		<dl class="pairs pairs--columns pairs--fixedSmall">
			<dt>' . 'Connection type' . '</dt>
			<dd>
				' . $__templater->filter($__vars['option']['option_value']['type'], array(array('to_upper', array()),), true) . '
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
			<dd>' . $__templater->escape($__vars['option']['option_value']['host']) . ':' . $__templater->escape($__vars['option']['option_value']['port']) . '</dd>
		</dl>

		';
		if ($__vars['option']['option_value']['username']) {
			$__compilerTemp1 .= '
			<dl class="pairs pairs--columns pairs--fixedSmall">
				<dt>' . 'Username' . '</dt>
				<dd>' . $__templater->escape($__vars['option']['option_value']['username']) . '</dd>
			</dl>
		';
		}
		$__compilerTemp1 .= '

		';
		if ($__vars['option']['option_value']['encryption']) {
			$__compilerTemp1 .= '
			<dl class="pairs pairs--columns pairs--fixedSmall">
				<dt>' . 'Encryption' . '</dt>
				<dd>' . $__templater->filter($__vars['option']['option_value']['encryption'], array(array('to_upper', array()),), true) . '</dd>
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
			' . ($__vars['option']['option_value']['enabled'] ? 'Change' : 'Enable') . '
		', array(
		'href' => $__templater->func('link', array('options/email-handler-setup', $__vars['option'], ), false),
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