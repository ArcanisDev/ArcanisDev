<?php
// FROM HASH: ea312e6cde043da877aaacd0ac7044a2
return array(
'macros' => array('key_type' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'apiKey' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__vars['apiKey']['key_type'] == 'super') {
		$__finalCompiled .= '
		' . 'Super user key' . '
	';
	} else if ($__vars['apiKey']['key_type'] == 'user') {
		$__finalCompiled .= '
		' . 'User key' . ':
		' . $__templater->func('username_link', array($__vars['apiKey']['User'], false, array(
			'href' => '',
			'defaultname' => 'Deleted member',
		))) . '
	';
	} else {
		$__finalCompiled .= '
		' . 'Guest key' . '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'key_type_row' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'apiKey' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->formRow('
		' . $__templater->callMacro(null, 'key_type', array(
		'apiKey' => $__vars['apiKey'],
	), $__vars) . '
	', array(
		'label' => 'Key type',
		'explain' => 'This cannot be changed after creation. Changes require a new API key to be generated.',
	)) . '
';
	return $__finalCompiled;
}
),
'copy_key_row' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'apiKey' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->formRow('
		' . $__templater->callMacro(null, 'copy_key', array(
		'apiKey' => $__vars['apiKey'],
	), $__vars) . '

		<div class="formRow-explain">
			' . $__templater->callMacro(null, 'key_usage', array(
		'apiKey' => $__vars['apiKey'],
	), $__vars) . '
		</div>
	', array(
		'label' => 'API key',
		'rowtype' => 'button',
	)) . '
';
	return $__finalCompiled;
}
),
'copy_key' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'apiKey' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<code class="js-copyTarget">' . $__templater->escape($__vars['apiKey']['api_key']) . '</code>
	' . $__templater->button('', array(
		'icon' => 'copy',
		'data-xf-init' => 'copy-to-clipboard',
		'data-copy-target' => '.js-copyTarget',
		'data-success' => 'API key copied to clipboard.',
		'class' => 'button--link is-hidden',
	), '', array(
	)) . '
';
	return $__finalCompiled;
}
),
'key_usage' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'apiKey' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . 'This key should be provided to API requests via the <code>XF-Api-Key</code> header.' . '

	';
	if ($__vars['apiKey']['key_type'] == 'super') {
		$__finalCompiled .= '
		' . 'As this is a super user key, the user ID that the request will be made as should be included in the <code>XF-Api-User</code> header.' . '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . '

' . '

' . '

';
	return $__finalCompiled;
}
);