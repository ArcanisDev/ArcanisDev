<?php
// FROM HASH: c291453f47a2ced89cba08a90d0dc8cc
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= 'Attempts to send emails to ' . $__templater->filter($__vars['xf']['visitor']['email'], array(array('email_display', array()),), true) . ' have failed. Please update your email.' . '<br />
<a href="' . $__templater->func('link', array('account/email', ), true) . '">' . 'Update your contact details' . '</a>';
	return $__finalCompiled;
}
);