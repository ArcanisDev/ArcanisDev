<?php
// FROM HASH: 60f4a34e987f638b49ecfb3613b050df
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['extra']['expiry']) {
		$__finalCompiled .= '
	' . 'You will be unable to reply to the thread ' . ($__templater->func('prefix', array('thread', $__vars['content'], 'plain', ), true) . $__templater->escape($__vars['content']['title'])) . ' until ' . $__templater->func('date', array($__vars['extra']['expiry'], ), true) . '.' . '
';
	} else {
		$__finalCompiled .= '
	' . 'You are no longer able to reply to the thread ' . ($__templater->func('prefix', array('thread', $__vars['content'], 'plain', ), true) . $__templater->escape($__vars['content']['title'])) . '.' . '
';
	}
	$__finalCompiled .= '
';
	if ($__vars['extra']['reason']) {
		$__finalCompiled .= 'Reason' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['extra']['reason']);
	}
	$__finalCompiled .= '
<push:url>' . $__templater->func('link', array('canonical:threads', $__vars['content'], ), true) . '</push:url>';
	return $__finalCompiled;
}
);