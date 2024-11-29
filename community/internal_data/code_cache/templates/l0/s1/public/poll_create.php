<?php
// FROM HASH: b9de7d00e8ff0120843044f678b0774d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Create poll');
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__vars['breadcrumbs']);
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->callMacro('poll_macros', 'add_edit_inputs', array(), $__vars) . '
		</div>

		' . $__templater->func('redirect_input', array($__vars['redirect'], null, true)) . '
		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__vars['createFormUrl'],
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);