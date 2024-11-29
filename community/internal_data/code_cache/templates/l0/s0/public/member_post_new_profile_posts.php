<?php
// FROM HASH: abe9d78aaeacbaab1a5090e2d9e86b20
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['firstUnshownProfilePost']) {
		$__finalCompiled .= '
	<div class="message message--simple">
		<div class="message-inner">
			<div class="message-cell message-cell--alert">
				' . 'There are more posts to display.' . ' <a href="' . $__templater->func('link', array('profile-posts', $__vars['firstUnshownProfilePost'], ), true) . '">' . 'View them?' . '</a>
			</div>
		</div>
	</div>
';
	}
	$__finalCompiled .= '

';
	if ($__templater->isTraversable($__vars['profilePosts'])) {
		foreach ($__vars['profilePosts'] AS $__vars['profilePost']) {
			$__finalCompiled .= '
	';
			if ($__vars['style'] == 'simple') {
				$__finalCompiled .= '
		<div class="block-row">
			' . $__templater->callMacro('profile_post_macros', 'profile_post_simple', array(
					'profilePost' => $__vars['profilePost'],
				), $__vars) . '
		</div>
	';
			} else {
				$__finalCompiled .= '
		' . $__templater->callMacro('profile_post_macros', 'profile_post', array(
					'attachmentData' => $__vars['profilePostAttachData'][$__vars['profilePost']['profile_post_id']],
					'profilePost' => $__vars['profilePost'],
				), $__vars) . '
	';
			}
			$__finalCompiled .= '
';
		}
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
);