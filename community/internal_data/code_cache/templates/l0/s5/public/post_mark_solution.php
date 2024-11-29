<?php
// FROM HASH: 7570c4b1df8adc5e4cebd8f2c528f213
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm action');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if (($__vars['type'] == 'add') OR ($__vars['type'] == 'replace')) {
		$__compilerTemp1 .= '
					' . 'Please confirm that you want to mark this post as the solution.' . '
				';
	} else {
		$__compilerTemp1 .= '
					' . 'Please confirm that you want to unmark this post as the solution.' . '
				';
	}
	$__compilerTemp2 = '';
	if ($__vars['type'] == 'replace') {
		$__compilerTemp2 .= '
				' . $__templater->formInfoRow('
					<div class="block-rowMessage block-rowMessage--important block-rowMessage--iconic">
						' . 'This will replace the <a href="' . $__templater->func('link', array('posts', $__vars['existingSolution'], ), true) . '">existing solution</a>.' . '

						<div>
							' . $__templater->func('bb_code', array($__templater->filter('[QUOTE=%s]%s[/QUOTE]', array(array('format', array($__vars['existingSolution']['username'], $__vars['existingSolution']['message'], )),), false), 'question_thread_solution', $__vars['existingSolution'], ), true) . '
						</div>
					</div>
				', array(
		)) . '
			';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . $__compilerTemp1 . '
			', array(
		'rowtype' => 'confirm',
	)) . '

			' . $__compilerTemp2 . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'confirm',
	), array(
		'rowtype' => 'simple',
	)) . '
		' . $__templater->formHiddenVal('confirm', '1', array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('posts/mark-solution', $__vars['post'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);