<?php
// FROM HASH: f3e7f4436962423b5ca6f4edac833b62
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= 'Your account is currently awaiting confirmation. Confirmation was sent to ' . $__templater->filter($__vars['xf']['visitor']['email'], array(array('email_display', array()),), true) . '.' . '
';
	if ($__vars['xf']['session']['hasPreRegActionPending']) {
		$__finalCompiled .= '
	' . 'Once your registration has been completed, your content will be posted automatically.' . '
';
	}
	$__finalCompiled .= '<br />
<a href="' . $__templater->func('link', array('account-confirmation/resend', ), true) . '" data-xf-click="overlay">' . 'Resend confirmation email' . '</a>';
	return $__finalCompiled;
}
);