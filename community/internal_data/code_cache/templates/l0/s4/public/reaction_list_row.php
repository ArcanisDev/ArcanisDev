<?php
// FROM HASH: fc3c5be644da5e30fd691272b7d2506e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['reactionIds']) {
		$__finalCompiled .= '
	' . $__templater->callMacro('reactions_summary', 'summary', array(
			'reactionIds' => $__vars['reactionIds'],
		), $__vars) . '
';
	}
	$__finalCompiled .= '
<span class="u-srOnly">' . 'Reactions' . $__vars['xf']['language']['label_separator'] . '</span>
<a class="reactionsBar-link" href="' . $__templater->func('link', array($__vars['link'], $__vars['content'], $__vars['linkParams'], ), true) . '" data-xf-click="overlay" data-cache="false" rel="nofollow">' . $__templater->escape($__vars['reactions']) . '</a>';
	return $__finalCompiled;
}
);