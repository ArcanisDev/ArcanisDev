<?php
// FROM HASH: 23f1a51680a612113b1040f6cc68a909
return array(
'macros' => array('callback_fields' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'data' => '',
		'namePrefix' => '',
		'className' => 'callback_class',
		'methodName' => 'callback_method',
		'classValue' => '',
		'methodValue' => '',
		'size' => '25',
		'readOnly' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	if ($__vars['namePrefix']) {
		$__finalCompiled .= '
		';
		$__vars['className'] = $__vars['namePrefix'] . '_class';
		$__finalCompiled .= '
		';
		$__vars['methodName'] = $__vars['namePrefix'] . '_method';
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '
	';
	if ($__templater->func('empty', array($__vars['classValue'])) AND (!$__templater->func('empty', array($__vars['data'])))) {
		$__finalCompiled .= '
		';
		$__vars['classValue'] = $__vars['data'][$__vars['className']];
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '
	';
	if ($__templater->func('empty', array($__vars['methodValue'])) AND (!$__templater->func('empty', array($__vars['data'])))) {
		$__finalCompiled .= '
		';
		$__vars['methodValue'] = $__vars['data'][$__vars['methodName']];
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '

	<div class="inputGroup" dir="ltr">
		' . $__templater->formTextBox(array(
		'name' => $__vars['className'],
		'value' => $__vars['classValue'],
		'size' => $__vars['size'],
		'maxlength' => '100',
		'dir' => 'ltr',
		'readonly' => $__vars['readOnly'],
		'placeholder' => 'Class',
	)) . '
		<span class="inputGroup-text">::</span>
		' . $__templater->formTextBox(array(
		'name' => $__vars['methodName'],
		'value' => $__vars['methodValue'],
		'size' => $__vars['size'],
		'maxlength' => '75',
		'dir' => 'ltr',
		'readonly' => $__vars['readOnly'],
		'placeholder' => 'Method',
	)) . '
	</div>
	<p class="formRow-explain">' . 'Example: <b>AddOn\\Path\\To\\ClassName</b> :: <b>methodName</b>' . '</p>
';
	return $__finalCompiled;
}
),
'callback_row' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'label' => '!',
		'explain' => '',
		'data' => '',
		'namePrefix' => '',
		'className' => 'callback_class',
		'methodName' => 'callback_method',
		'classValue' => '',
		'methodValue' => '',
		'size' => '25',
		'readOnly' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->formRow('
		' . $__templater->callMacro(null, 'callback_fields', array(
		'data' => $__vars['data'],
		'namePrefix' => $__vars['namePrefix'],
		'className' => $__vars['className'],
		'methodName' => $__vars['methodName'],
		'classValue' => $__vars['classValue'],
		'methodValue' => $__vars['methodValue'],
		'size' => $__vars['size'],
		'readOnly' => $__vars['readOnly'],
	), $__vars) . '
	', array(
		'label' => $__templater->escape($__vars['label']),
		'explain' => $__templater->filter($__vars['explain'], array(array('raw', array()),), true),
		'rowtype' => 'input',
	)) . '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
);