<?php
// FROM HASH: addc3716b7395e1ff549fa709b8f65c4
return array(
'macros' => array('suggestion' => array(
'extends' => 'post_macros::post',
'extensions' => array('main_cell' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
		' . $__templater->renderExtensionParent($__vars, null, $__extensions) . '

		';
	if ($__templater->method($__vars['thread'], 'isContentVotingSupported', array())) {
		$__finalCompiled .= '
			<div class="message-cell message-cell--vote">
				' . $__templater->callMacro('content_vote_macros', 'vote_control', array(
			'link' => 'threads/vote',
			'content' => $__vars['thread'],
		), $__vars) . '
			</div>
		';
	}
	$__finalCompiled .= '
	';
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->renderExtension('main_cell', $__vars, $__extensions) . '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';

	return $__finalCompiled;
}
);