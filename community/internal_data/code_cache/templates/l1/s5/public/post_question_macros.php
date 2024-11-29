<?php
// FROM HASH: 07d3e610bc3a1f44bdf3e0fd267557e9
return array(
'macros' => array('answer' => array(
'extends' => 'post_macros::post',
'extensions' => array('extra_classes' => function($__templater, array $__vars, $__extensions = null)
{
	return 'message--post ' . ($__vars['post']['is_question_solution'] ? 'message--solution' : '');
},
'main_cell' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
		' . $__templater->renderExtensionParent($__vars, null, $__extensions) . '

		';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
					';
	if ($__templater->method($__vars['post'], 'isContentVotingSupported', array())) {
		$__compilerTemp1 .= '
						' . $__templater->callMacro('content_vote_macros', 'vote_control', array(
			'link' => 'posts/vote',
			'content' => $__vars['post'],
			'includeMicrodata' => true . ' ',
		), $__vars) . '
					';
	}
	$__compilerTemp1 .= '

					';
	if ($__templater->method($__vars['post'], 'canMarkAsQuestionSolution', array())) {
		$__compilerTemp1 .= '
						';
		$__vars['isSolutionText'] = 'Unmark as solution';
		$__compilerTemp1 .= '
						';
		$__vars['makeSolutionText'] = 'Mark as solution';
		$__compilerTemp1 .= '

						<a href="' . $__templater->func('link', array('posts/mark-solution', $__vars['post'], ), true) . '"
							class="solutionIcon ' . ($__vars['post']['is_question_solution'] ? 'is-solution' : '') . ' js-solutionControl"
							data-xf-click="solution-edit"
							data-sk-marked="addClass:is-solution, titleAttr:sync, ' . $__templater->filter($__vars['isSolutionText'], array(array('for_attr', array()),), true) . '"
							data-sk-removed="removeClass:is-solution, titleAttr:sync, ' . $__templater->filter($__vars['makeSolutionText'], array(array('for_attr', array()),), true) . '"
							data-label=".u-srOnly"
							data-xf-init="tooltip"
							title="' . ($__vars['post']['is_question_solution'] ? $__templater->escape($__vars['isSolutionText']) : $__templater->escape($__vars['makeSolutionText'])) . '">
							<span class="u-srOnly">' . ($__vars['post']['is_question_solution'] ? $__templater->escape($__vars['isSolutionText']) : $__templater->escape($__vars['makeSolutionText'])) . '</span>
						</a>
					';
	} else if ($__vars['post']['is_question_solution']) {
		$__compilerTemp1 .= '
						<span class="solutionIcon is-solution" data-xf-init="tooltip" title="' . $__templater->filter('Solution', array(array('for_attr', array()),), true) . '">
							<span class="u-srOnly">' . 'Solution' . '</span>
						</span>
					';
	}
	$__compilerTemp1 .= '
				';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
			<div class="message-cell message-cell--vote">
				<div class="message-column">
				' . $__compilerTemp1 . '
				</div>
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
	' . '

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