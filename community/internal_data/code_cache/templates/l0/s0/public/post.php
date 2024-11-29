<?php
// FROM HASH: 5ab091167a551f66701a5a1cdf8456b0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['canInlineMod']) {
		$__finalCompiled .= '
	';
		$__templater->includeJs(array(
			'src' => 'xf/inline_mod.js',
			'min' => '1',
		));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

<div class="block" data-xf-init="' . ($__vars['canInlineMod'] ? 'inline-mod' : '') . '" data-type="post" data-href="' . $__templater->func('link', array('inline-mod', ), true) . '">
	<div class="block-container">
		<div class="block-body">
			';
	if ($__vars['isPinnedFirstPost']) {
		$__finalCompiled .= '
				' . $__templater->callMacro(null, ($__vars['templateOverrides']['pinned_first_post_macro'] ?: 'post_macros::post'), $__templater->combineMacroArgumentAttributes($__vars['templateOverrides']['pinned_first_post_macro_args'], array(
			'post' => $__vars['post'],
			'thread' => $__vars['thread'],
		)), $__vars) . '
			';
	} else {
		$__finalCompiled .= '
				' . $__templater->callMacro(null, ($__vars['templateOverrides']['post_macro'] ?: 'post_macros::post'), $__templater->combineMacroArgumentAttributes($__vars['templateOverrides']['post_macro_args'], array(
			'post' => $__vars['post'],
			'thread' => $__vars['thread'],
		)), $__vars) . '
			';
	}
	$__finalCompiled .= '
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);