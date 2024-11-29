<?php
// FROM HASH: 8b82d0f4d5c8afc96e63aa7a4d4ffe21
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['extra']['comment']) {
		$__finalCompiled .= '
	' . 'Your recent report has been resolved: ' . $__templater->filter($__vars['extra']['title'], array(array('strip_tags', array()),), true) . ' - ' . $__templater->escape($__vars['extra']['comment']) . '' . '
';
	} else {
		$__finalCompiled .= '
	' . 'Your recent report has been resolved: ' . $__templater->filter($__vars['extra']['title'], array(array('strip_tags', array()),), true) . '' . '
';
	}
	$__finalCompiled .= '
<push:url>' . $__templater->func('base_url', array($__vars['extra']['link'], 'canonical', ), true) . '</push:url>';
	return $__finalCompiled;
}
);