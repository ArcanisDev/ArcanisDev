<?php
// FROM HASH: abd0dae0788503fb0a12ad235cc7f4c5
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formInfoRow('A backup code can be used when you don\'t have access to an alternative verification method. Once a backup code is used, it will no longer be usable. You will receive an email when you login using a backup code.', array(
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => 'code',
		'autofocus' => 'autofocus',
		'inputmode' => 'numeric',
		'pattern' => '[0-9\\s]*',
	), array(
		'label' => 'Backup code',
	));
	return $__finalCompiled;
}
);