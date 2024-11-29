<?php
// FROM HASH: 15981cdf276415c435501c74a7e34a80
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit profile post');
	$__finalCompiled .= '

';
	$__templater->breadcrumb($__templater->preEscaped($__templater->escape($__vars['profileUser']['username'])), $__templater->func('link', array('members', $__vars['profileUser'], ), false), array(
	));
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['attachmentData']) {
		$__compilerTemp1 .= '
				' . $__templater->formRow('
					' . $__templater->callMacro('helper_attach_upload', 'upload_link_from_data', array(
			'attachmentData' => $__vars['attachmentData'],
		), $__vars) . '
					' . $__templater->callMacro('helper_attach_upload', 'uploaded_files_list', array(
			'attachments' => $__vars['attachmentData']['attachments'],
			'class' => 'attachmentUploads--spaced',
		), $__vars) . '
				', array(
			'rowtype' => ($__vars['quickEdit'] ? 'fullWidth noLabel' : ''),
		)) . '
			';
	}
	$__compilerTemp2 = '';
	if ($__templater->method($__vars['profilePost'], 'canSendModeratorActionAlert', array())) {
		$__compilerTemp2 .= '
				' . $__templater->formRow('
					' . $__templater->callMacro('helper_action', 'author_alert', array(
			'row' => false,
		), $__vars) . '
				', array(
			'rowtype' => ($__vars['quickEdit'] ? 'fullWidth noLabel' : ''),
		)) . '
			';
	}
	$__compilerTemp3 = '';
	if ($__vars['quickEdit']) {
		$__compilerTemp3 .= '
					' . $__templater->button('Cancel', array(
			'class' => 'js-cancelButton',
		), '', array(
		)) . '
				';
	}
	$__compilerTemp4 = '';
	if ($__vars['noInlineMod']) {
		$__compilerTemp4 .= '
		' . $__templater->formHiddenVal('_xfNoInlineMod', '1', array(
		)) . '
	';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			<span class="u-anchorTarget js-editContainer"></span>

			' . $__templater->formEditorRow(array(
		'name' => 'message',
		'value' => $__vars['profilePost']['message'],
		'attachments' => ($__vars['attachmentData'] ? $__vars['attachmentData']['attachments'] : array()),
		'data-min-height' => ($__vars['quickEdit'] ? 40 : 100),
		'rendereropts' => array('treatAsStructuredText' => true, ),
	), array(
		'rowtype' => ($__vars['quickEdit'] ? 'fullWidth noLabel' : ''),
		'label' => 'Message',
	)) . '

			' . $__compilerTemp1 . '

			' . $__compilerTemp2 . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'sticky' => 'true',
	), array(
		'rowtype' => ($__vars['quickEdit'] ? 'simple' : ''),
		'html' => '
				' . $__compilerTemp3 . '
			',
	)) . '
	</div>

	' . $__compilerTemp4 . '
', array(
		'action' => $__templater->func('link', array('profile-posts/edit', $__vars['profilePost'], ), false),
		'data-xf-init' => 'attachment-manager',
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);