<?php
// FROM HASH: bd4dbae39fdec25c8ade9f2187fca40e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit profile post comment');
	$__finalCompiled .= '

';
	$__templater->breadcrumb($__templater->preEscaped($__templater->escape($__vars['profilePost']['ProfileUser']['username'])), $__templater->func('link', array('members', $__vars['profilePost']['ProfileUser'], ), false), array(
	));
	$__finalCompiled .= '
';
	$__templater->breadcrumb($__templater->preEscaped('Profile post by ' . $__templater->escape($__vars['profilePost']['username']) . ''), $__templater->func('link', array('profile-posts', $__vars['profilePost'], ), false), array(
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
	if ($__templater->method($__vars['comment'], 'canSendModeratorActionAlert', array())) {
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
			' . $__templater->formRow('
				' . $__templater->button('', array(
			'type' => 'submit',
			'class' => 'button--primary',
			'icon' => 'save',
		), '', array(
		)) . '
				' . $__templater->button('Cancel', array(
			'class' => 'js-cancelButton',
		), '', array(
		)) . '
			', array(
			'rowtype' => 'fullWidth noLabel',
		)) . '
		';
	} else {
		$__compilerTemp3 .= '
			' . $__templater->formSubmitRow(array(
			'icon' => 'save',
		), array(
		)) . '
		';
	}
	$__finalCompiled .= $__templater->form('
	<div class="' . ((!$__vars['quickEdit']) ? 'block-container' : '') . '">
		<div class="' . ((!$__vars['quickEdit']) ? 'block-body' : '') . '">
			' . $__templater->formEditorRow(array(
		'name' => 'message',
		'value' => $__vars['comment']['message'],
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
		' . $__compilerTemp3 . '
	</div>
', array(
		'action' => $__templater->func('link', array('profile-posts/comments/edit', $__vars['comment'], ), false),
		'data-xf-init' => 'attachment-manager',
		'class' => ((!$__vars['quickEdit']) ? 'block' : ''),
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);