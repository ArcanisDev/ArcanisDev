<?php
// FROM HASH: 34fda8c5bc10610a06fde87e2878d3af
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Reset password');
	$__finalCompiled .= '

';
	$__templater->setPageParam('head.' . 'meta_referrer', $__templater->preEscaped('<meta name="referrer" content="origin" />'));
	$__finalCompiled .= '
';
	$__templater->setPageParam('head.' . 'robots', $__templater->preEscaped('<meta name="robots" content="noindex" />'));
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRow($__templater->escape($__vars['user']['username']), array(
		'label' => 'Your name',
	)) . '

			' . $__templater->formPasswordBoxRow(array(
		'name' => 'password',
		'autocomplete' => 'new-password',
		'checkstrength' => 'true',
	), array(
		'label' => 'New password',
	)) . '

			' . $__templater->formPasswordBoxRow(array(
		'name' => 'password_confirm',
		'autocomplete' => 'new-password',
	), array(
		'label' => 'Confirm new password',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('lost-password/confirm', $__vars['user'], array('c' => $__vars['c'], ), ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);