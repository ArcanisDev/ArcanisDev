<?php
// FROM HASH: 6fcf0e7287d7951a63ff78a398b25f7f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Change username');
	$__finalCompiled .= '

';
	$__templater->wrapTemplate('account_wrapper', $__vars);
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__templater->method($__vars['xf']['visitor'], 'getNextAllowedUsernameChange', array($__vars['xf']['time'], ))) {
		$__compilerTemp1 .= '
				' . $__templater->formInfoRow('
					<div class="blockMessage blockMessage--important">
						' . 'If you decide to change your username now you will not be able to again until ' . $__templater->func('date', array($__templater->method($__vars['xf']['visitor'], 'getNextAllowedUsernameChange', array($__vars['xf']['time'], )), ), true) . '.' . '
					</div>
				', array(
		)) . '
			';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__compilerTemp1 . '
			' . $__templater->formTextBoxRow(array(
		'name' => 'username',
		'value' => $__vars['xf']['visitor']['username'],
		'autofocus' => 'autofocus',
		'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor'], 'username', ), false),
		'validation-url' => $__templater->func('link', array('misc/validate-username', ), false),
	), array(
		'label' => 'Username',
	)) . '
			' . $__templater->formTextAreaRow(array(
		'name' => 'change_reason',
		'autosize' => 'true',
		'maxlength' => $__templater->func('max_length', array('XF:UsernameChange', 'change_reason', ), false),
		'required' => ($__vars['xf']['options']['usernameChangeRequireReason'] ? 'required' : null),
	), array(
		'label' => 'Change reason',
		'hint' => ($__vars['xf']['options']['usernameChangeRequireReason'] ? 'Required' : ''),
		'explain' => 'Please explain the reason for this username change.',
	)) . '
		</div>

		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'sticky' => 'true',
	), array(
	)) . '
	</div>

	' . $__templater->func('redirect_input', array(null, null, true)) . '
', array(
		'action' => $__templater->func('link', array('account/username', ), false),
		'ajax' => 'true',
		'class' => 'block',
		'data-force-flash-message' => 'on',
	));
	return $__finalCompiled;
}
);