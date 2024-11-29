<?php
// FROM HASH: cb64fac58191f9d09cd27a04a1253392
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit message in conversation' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['conversation']['title']));
	$__finalCompiled .= '

';
	$__templater->breadcrumb($__templater->preEscaped('Conversations'), $__templater->func('link', array('conversations', ), false), array(
	));
	$__finalCompiled .= '
';
	$__templater->breadcrumb($__templater->preEscaped($__templater->escape($__vars['conversation']['title'])), $__templater->func('link', array('conversations', $__vars['conversation'], ), false), array(
	));
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['attachmentData']) {
		$__compilerTemp1 .= '
					' . $__templater->callMacro('helper_attach_upload', 'upload_block', array(
			'attachmentData' => $__vars['attachmentData'],
		), $__vars) . '
				';
	}
	$__compilerTemp2 = '';
	if ($__vars['quickEdit']) {
		$__compilerTemp2 .= '
					' . $__templater->button('Cancel', array(
			'class' => 'js-cancelButton',
			'icon' => 'cancel',
		), '', array(
		)) . '
				';
	}
	$__finalCompiled .= $__templater->form('

	<div class="block-container">
		<div class="block-body">
			' . $__templater->formEditorRow(array(
		'name' => 'message',
		'value' => $__vars['message']['message'],
		'attachments' => $__vars['attachmentData']['attachments'],
		'data-preview-url' => $__templater->func('link', array('conversations/messages/preview', $__vars['message'], ), false),
	), array(
		'rowtype' => ($__vars['quickEdit'] ? 'fullWidth noLabel' : ''),
		'label' => 'Message',
	)) . '

			' . $__templater->formRow('
				' . $__compilerTemp1 . '
			', array(
		'rowtype' => ($__vars['quickEdit'] ? 'fullWidth noLabel' : ''),
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'sticky' => 'true',
	), array(
		'rowtype' => ($__vars['quickEdit'] ? 'simple' : ''),
		'html' => '
				' . $__compilerTemp2 . '
			',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('conversations/messages/edit', $__vars['message'], ), false),
		'ajax' => 'true',
		'class' => 'block',
		'data-xf-init' => 'attachment-manager',
	));
	return $__finalCompiled;
}
);