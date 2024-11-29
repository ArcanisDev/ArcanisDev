<?php
// FROM HASH: b54dc39576bc0ea58e002561f336be68
return array(
'macros' => array('item' => array(
'extends' => 'thread_list_macros::item',
'extensions' => array('icon_cell' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
		<div class="structItem-cell structItem-cell--vote">
			';
	if ($__templater->method($__vars['thread'], 'isContentVotingSupported', array())) {
		$__finalCompiled .= '
				' . $__templater->callMacro(null, 'content_vote_macros::vote_display', array(
			'content' => $__vars['thread'],
			'extraClass' => 'contentVote--small',
		), $__vars) . '
			';
	} else {
		$__finalCompiled .= '
				' . $__templater->callMacro(null, 'content_vote_macros::vote_display_placeholder', array(
			'extraClass' => 'contentVote--small',
		), $__vars) . '
			';
	}
	$__finalCompiled .= '
		</div>

		' . $__templater->renderExtensionParent($__vars, null, $__extensions) . '
	';
	return $__finalCompiled;
},
'before_status_watch' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
		';
	if ($__vars['xf']['visitor']['user_id']) {
		$__finalCompiled .= '
			';
		$__vars['voteState'] = $__templater->method($__vars['thread'], 'getVisitorContentVote', array());
		$__finalCompiled .= '
			';
		if ($__vars['voteState'] == 'up') {
			$__finalCompiled .= '
				<li>
					<i class="structItem-status structItem-status--upvoted" aria-hidden="true" title="' . $__templater->filter('Upvoted', array(array('for_attr', array()),), true) . '"></i>
					<span class="u-srOnly">' . 'Upvoted' . '</span>
				</li>
			';
		} else if ($__vars['voteState'] == 'down') {
			$__finalCompiled .= '
				<li>
					<i class="structItem-status structItem-status--downvoted" aria-hidden="true" title="' . $__templater->filter('Downvoted', array(array('for_attr', array()),), true) . '"></i>
					<span class="u-srOnly">' . 'Downvoted' . '</span>
				</li>
			';
		}
		$__finalCompiled .= '
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
	' . $__templater->renderExtension('icon_cell', $__vars, $__extensions) . '

	' . $__templater->renderExtension('before_status_watch', $__vars, $__extensions) . '
';
	return $__finalCompiled;
}
),
'quick_thread' => array(
'extends' => 'thread_list_macros::quick_thread',
'extensions' => array('icon_cell' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
		<div class="structItem-cell structItem-cell--vote">
			' . $__templater->callMacro(null, 'content_vote_macros::vote_display_placeholder', array(
		'extraClass' => 'contentVote--small',
	), $__vars) . '
		</div>

		' . $__templater->renderExtensionParent($__vars, null, $__extensions) . '
	';
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->renderExtension('icon_cell', $__vars, $__extensions) . '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
);