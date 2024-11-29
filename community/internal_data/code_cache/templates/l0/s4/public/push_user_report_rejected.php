<?php
// FROM HASH: 3f6dc8adaf7aa5dbd5eeb7004860df7c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['extra']['comment']) {
		$__finalCompiled .= '
	' . 'Unfortunately, your recent report has been rejected: ' . $__templater->filter($__vars['extra']['title'], array(array('strip_tags', array()),), true) . ' - ' . $__templater->escape($__vars['extra']['comment']) . '' . '
';
	} else {
		$__finalCompiled .= '
	' . 'Unfortunately, your recent report was rejected: ' . $__templater->filter($__vars['extra']['title'], array(array('strip_tags', array()),), true) . '' . '
';
	}
	$__finalCompiled .= '
<push:url>' . $__templater->func('base_url', array($__vars['extra']['link'], 'canonical', ), true) . '</push:url>';
	return $__finalCompiled;
}
);