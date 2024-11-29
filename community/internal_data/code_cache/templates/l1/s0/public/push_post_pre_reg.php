<?php
// FROM HASH: b0cde2c48ed2099889d3b942a759b303
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['extra']['welcome']) {
		$__finalCompiled .= '
	' . 'Welcome to ' . $__templater->escape($__vars['xf']['options']['boardTitle']) . '!' . '
';
	}
	$__finalCompiled .= '
';
	if ($__templater->method($__vars['content'], 'isFirstPost', array())) {
		$__finalCompiled .= '
	' . 'Your thread ' . ($__templater->func('prefix', array('thread', $__vars['content']['Thread'], 'plain', ), true) . $__templater->escape($__vars['content']['Thread']['title'])) . ' was created.' . '
	<push:url>' . $__templater->func('link', array('canonical:threads', $__vars['content']['Thread'], ), true) . '</push:url>
';
	} else {
		$__finalCompiled .= '
	' . 'Your reply to the thread ' . ($__templater->func('prefix', array('thread', $__vars['content']['Thread'], 'plain', ), true) . $__templater->escape($__vars['content']['Thread']['title'])) . ' was submitted.' . '
	<push:url>' . $__templater->func('link', array('canonical:posts', $__vars['content'], ), true) . '</push:url>
';
	}
	return $__finalCompiled;
}
);