<?php
// FROM HASH: d1bc3bfc220e71b86c68a1d5a7744891
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['extra']['comment']) {
		$__finalCompiled .= '
	' . 'Your recent report has been resolved: ' . (((('<a href="' . $__templater->escape($__vars['extra']['link'])) . '" class="fauxBlockLink-blockLink">') . $__templater->escape($__vars['extra']['title'])) . '</a>') . ' - ' . $__templater->escape($__vars['extra']['comment']) . '' . '
';
	} else {
		$__finalCompiled .= '
	' . 'Your recent report has been resolved: ' . (((('<a href="' . $__templater->escape($__vars['extra']['link'])) . '" class="fauxBlockLink-blockLink">') . $__templater->escape($__vars['extra']['title'])) . '</a>') . '' . '
';
	}
	return $__finalCompiled;
}
);