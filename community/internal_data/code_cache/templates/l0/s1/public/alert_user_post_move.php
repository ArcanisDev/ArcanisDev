<?php
// FROM HASH: 294de767ab7b47fd31d9a9b68f2fb3ba
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['extra']['wasVisible'] AND $__vars['extra']['isVisible']) {
		$__finalCompiled .= '
	' . 'Your post in the thread ' . $__templater->escape($__vars['extra']['sourceTitle']) . ' was moved to ' . ((((('<a href="' . $__templater->func('base_url', array($__vars['extra']['targetLink'], ), true)) . '" class="fauxBlockLink-blockLink">') . $__templater->func('prefix', array('thread', $__vars['extra']['prefix_id'], ), true)) . $__templater->escape($__vars['extra']['title'])) . '</a>') . '.' . '
';
	} else if ($__vars['extra']['wasVisible']) {
		$__finalCompiled .= '
	' . 'Your post in thread ' . $__templater->escape($__vars['extra']['sourceTitle']) . ' was moved to another thread.' . '
';
	} else if ($__vars['extra']['isVisible']) {
		$__finalCompiled .= '
	' . 'Your post in another thread was moved to ' . ((((('<a href="' . $__templater->func('base_url', array($__vars['extra']['targetLink'], ), true)) . '" class="fauxBlockLink-blockLink">') . $__templater->func('prefix', array('thread', $__vars['extra']['prefix_id'], ), true)) . $__templater->escape($__vars['extra']['title'])) . '</a>') . '.' . '
';
	}
	$__finalCompiled .= '

';
	if ($__vars['extra']['reason']) {
		$__finalCompiled .= 'Reason' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['extra']['reason']);
	}
	return $__finalCompiled;
}
);