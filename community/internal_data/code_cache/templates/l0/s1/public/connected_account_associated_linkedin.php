<?php
// FROM HASH: d516663b9e7e11b85328e2e90437df7d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['providerData']['avatarUrl']) {
		$__finalCompiled .= '
	<img src="' . $__templater->escape($__vars['providerData']['avatarUrl']) . '" width="48" alt="" />
	<div>' . $__templater->escape($__vars['providerData']['formattedName']) . '</div>
';
	} else {
		$__finalCompiled .= '
	' . 'Account associated' . '
';
	}
	return $__finalCompiled;
}
);