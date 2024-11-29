<?php
// FROM HASH: c8189ae89c888c87afe5c6b0f3ad5709
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '' . ($__templater->escape($__vars['user']['username']) ?: $__templater->escape($__vars['alert']['username'])) . ' marked your answer to the question ' . ($__templater->func('prefix', array('thread', $__vars['content']['Thread'], 'plain', ), true) . $__templater->escape($__vars['content']['Thread']['title'])) . ' as a solution.' . '
<push:url>' . $__templater->func('link', array('canonical:posts', $__vars['content'], ), true) . '</push:url>';
	return $__finalCompiled;
}
);