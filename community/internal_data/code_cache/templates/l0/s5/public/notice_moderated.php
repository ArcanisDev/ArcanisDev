<?php
// FROM HASH: 298826cc0575e4ba63c7cc6df11fa323
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= 'Your account is currently awaiting approval by an administrator. You will receive an email when a decision has been taken.' . '
';
	if ($__vars['xf']['session']['hasPreRegActionPending']) {
		$__finalCompiled .= '
	' . 'Once your registration has been completed, your content will be posted automatically.' . '
';
	}
	return $__finalCompiled;
}
);