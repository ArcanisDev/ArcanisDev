<?php
// FROM HASH: cb70d1fe5f0c828a0adac523a6389b1c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('User change log');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body block-row">
			' . $__templater->formTextBox(array(
		'name' => 'username',
		'placeholder' => 'Username' . $__vars['xf']['language']['ellipsis'],
		'type' => 'search',
		'value' => ($__vars['limitUser'] ? $__vars['limitUser']['username'] : ''),
		'class' => 'input--inline',
	)) . '
			' . $__templater->button('Show changes', array(
		'type' => 'submit',
	), '', array(
	)) . '
		</div>
	</div>
', array(
		'action' => $__templater->func('link', array('logs/user-change', ), false),
		'class' => 'block',
	)) . '

';
	if ($__vars['changesGrouped']) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<div class="block-body">
				' . $__templater->callMacro('user_change_log', 'change_log_list', array(
			'changesGrouped' => $__vars['changesGrouped'],
		), $__vars) . '
			</div>
			<div class="block-footer">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['totalChanges'], $__vars['total'], ), true) . '</span>
			</div>
		</div>

		' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'link' => 'logs/user-change',
			'params' => $__vars['linkFilters'],
			'wrapperclass' => 'block-outer block-outer--after',
			'perPage' => $__vars['perPage'],
		))) . '
	</div>
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'No changes have been logged.' . '</div>
';
	}
	return $__finalCompiled;
}
);