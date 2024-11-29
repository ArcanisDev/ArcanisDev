<?php
// FROM HASH: 005a99dff080cf536efc2ffe3a5d334b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formInfoRow('An email containing a single-use code has been sent to the address linked to this account. Please enter that code to continue.', array(
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => 'code',
		'autofocus' => 'autofocus',
		'inputmode' => 'numeric',
		'pattern' => '[0-9]*',
	), array(
		'label' => 'Email confirmation code',
	));
	return $__finalCompiled;
}
);