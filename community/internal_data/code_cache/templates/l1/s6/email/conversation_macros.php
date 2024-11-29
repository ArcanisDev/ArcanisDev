<?php
// FROM HASH: c0e48021b94c07bd5b869cf19e6e6720
return array(
'macros' => array('footer' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'conversation' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . '<p class="minorText">Please do not reply to this message. You must visit the forum to reply.</p>

<p class="minorText">This message was sent to you because your preferences are set to receive email when a new conversation message is received. <a href="' . $__templater->func('link', array('canonical:email-stop/conversation', $__vars['xf']['toUser'], ), true) . '">Stop receiving these emails</a>.</p>' . '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';

	return $__finalCompiled;
}
);