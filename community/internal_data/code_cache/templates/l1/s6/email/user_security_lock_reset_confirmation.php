<?php
// FROM HASH: e434f8bce260ab83731689228b12b4b5
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<mail:subject>
	' . '' . $__templater->escape($__vars['xf']['options']['boardTitle']) . ' - Please reset your password' . '
</mail:subject>

' . '<p>' . $__templater->escape($__vars['user']['username']) . ', in order to keep your account secure at ' . $__templater->escape($__vars['xf']['options']['boardTitle']) . ', we require you to change your password. To do this you need to click the button below. This will allow you to choose a new password.</p>' . '

<p><a href="' . $__templater->func('link', array('canonical:security-lock/reset', $__vars['user'], array('c' => $__vars['confirmation']['confirmation_key'], ), ), true) . '" class="button">' . 'Reset password' . '</a></p>';
	return $__finalCompiled;
}
);