<?php
// FROM HASH: 983005d8891636e1c84fbafbc82978dd
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<a href="' . ($__templater->escape($__vars['providerData']['profile_link']) ?: ('https://www.facebook.com/profile.php?id=' . $__templater->escape($__vars['connectedAccounts']['facebook']))) . '" target="_blank">
	<img src="https://graph.facebook.com/' . $__templater->escape($__vars['connectedAccounts']['facebook']) . '/picture" width="48" alt="" />
</a>
<div><a href="' . ($__templater->escape($__vars['providerData']['profile_link']) ?: ('https://www.facebook.com/profile.php?id=' . $__templater->escape($__vars['connectedAccounts']['facebook']))) . '" target="_blank">' . ($__templater->escape($__vars['providerData']['username']) ?: 'View account') . '</a></div>';
	return $__finalCompiled;
}
);