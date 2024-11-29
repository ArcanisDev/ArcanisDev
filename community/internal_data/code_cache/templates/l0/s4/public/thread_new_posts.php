<?php
// FROM HASH: 35c2cc3470ee2da2c3ec1ad9fedf78f1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['firstUnshownPost']) {
		$__finalCompiled .= '
	<div class="message">
		<div class="message-inner">
			<div class="message-cell message-cell--alert">
				' . 'There are more posts to display.' . ' <a href="' . $__templater->func('link', array('posts', $__vars['firstUnshownPost'], ), true) . '">' . 'View them?' . '</a>
			</div>
		</div>
	</div>
';
	}
	$__finalCompiled .= '

';
	if ($__templater->isTraversable($__vars['posts'])) {
		foreach ($__vars['posts'] AS $__vars['post']) {
			$__finalCompiled .= '
	' . $__templater->callMacro(null, ($__vars['templateOverrides']['post_macro'] ?: 'post_macros::post'), $__templater->combineMacroArgumentAttributes($__vars['templateOverrides']['post_macro_args'], array(
				'post' => $__vars['post'],
				'thread' => $__vars['thread'],
			)), $__vars) . '
';
		}
	}
	return $__finalCompiled;
}
);