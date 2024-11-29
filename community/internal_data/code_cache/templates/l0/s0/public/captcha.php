<?php
// FROM HASH: a217267ad45727598de53bd760952cca
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['withRow']) {
		$__finalCompiled .= '
	' . $__templater->formRowIfContent($__templater->func('captcha_options', array(array(
			'label' => ($__vars['phrase'] ? $__templater->escape($__vars['phrase']) : 'Verification'),
			'rowtype' => $__vars['rowType'],
			'force' => 'true',
			'context' => $__vars['context'],
		))), array(
			'label' => ($__vars['phrase'] ? $__templater->escape($__vars['phrase']) : 'Verification'),
			'rowtype' => $__vars['rowType'],
			'force' => 'true',
			'context' => $__vars['context'],
		)) . '

';
	} else {
		$__finalCompiled .= '
	' . $__templater->func('captcha_options', array(array(
			'force' => 'true',
			'context' => $__vars['context'],
		))) . '
';
	}
	return $__finalCompiled;
}
);