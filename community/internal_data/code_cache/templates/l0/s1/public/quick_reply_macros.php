<?php
// FROM HASH: 7a3102f0d9feaa7d5fdcb9377bbd8087
return array(
'macros' => array('body' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'message' => '',
		'attachmentData' => null,
		'forceHash' => '',
		'messageSelector' => '',
		'multiQuoteHref' => '',
		'multiQuoteStorageKey' => '',
		'simple' => false,
		'submitText' => '',
		'lastDate' => '0',
		'lastKnownDate' => '0',
		'loadExtra' => true,
		'simpleSubmit' => false,
		'minHeight' => '100',
		'placeholder' => 'Write your reply...',
		'deferred' => false,
		'showGuestControls' => true,
		'previewUrl' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__templater->includeCss('message.less');
	$__finalCompiled .= '
	';
	$__vars['sticky'] = $__templater->func('property', array('messageSticky', ), false);
	$__finalCompiled .= '

	<div class="message message--quickReply block-topRadiusContent block-bottomRadiusContent' . ($__vars['simple'] ? ' message--simple' : '') . '">
		<div class="message-inner">
			<div class="message-cell message-cell--user">
				<div class="message-user ' . ($__vars['sticky']['user_info'] ? 'is-sticky' : '') . '">
					<div class="message-avatar">
						<div class="message-avatar-wrapper">
							';
	$__vars['user'] = ($__vars['xf']['visitor']['user_id'] ? $__vars['xf']['visitor'] : null);
	$__finalCompiled .= '
							' . $__templater->func('avatar', array($__vars['user'], ($__vars['simple'] ? 's' : 'm'), false, array(
		'defaultname' => '',
	))) . '
						</div>
					</div>
					<span class="message-userArrow"></span>
				</div>
			</div>
			<div class="message-cell message-cell--main">
				<div class="message-editorWrapper">
					';
	$__vars['editorHtml'] = $__templater->preEscaped('
						' . $__templater->callMacro(null, 'editor', array(
		'message' => $__vars['message'],
		'attachmentData' => $__vars['attachmentData'],
		'forceHash' => $__vars['forceHash'],
		'messageSelector' => $__vars['messageSelector'],
		'multiQuoteHref' => $__vars['multiQuoteHref'],
		'multiQuoteStorageKey' => $__vars['multiQuoteStorageKey'],
		'minHeight' => $__vars['minHeight'],
		'placeholder' => $__vars['placeholder'],
		'submitText' => $__vars['submitText'],
		'deferred' => $__vars['deferred'],
		'lastDate' => $__vars['lastDate'],
		'lastKnownDate' => $__vars['lastKnownDate'],
		'loadExtra' => $__vars['loadExtra'],
		'simpleSubmit' => $__vars['simpleSubmit'],
		'showGuestControls' => $__vars['showGuestControls'],
		'previewUrl' => $__vars['previewUrl'],
	), $__vars) . '
					');
	$__finalCompiled .= '

					';
	if ($__vars['deferred']) {
		$__finalCompiled .= '
						<div class="editorPlaceholder" data-xf-click="editor-placeholder">
							<div class="editorPlaceholder-editor is-hidden">' . $__templater->filter($__vars['editorHtml'], array(array('raw', array()),), true) . '</div>
							<div class="editorPlaceholder-placeholder">
								<div class="input"><span class="u-muted"> ' . $__templater->escape($__vars['placeholder']) . '</span></div>
							</div>
						</div>
					';
	} else {
		$__finalCompiled .= '
						' . $__templater->filter($__vars['editorHtml'], array(array('raw', array()),), true) . '
					';
	}
	$__finalCompiled .= '
				</div>
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'editor' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'message' => '',
		'attachmentData' => null,
		'forceHash' => '',
		'messageSelector' => '',
		'multiQuoteHref' => '',
		'multiQuoteStorageKey' => '',
		'minHeight' => '100',
		'placeholder' => '',
		'submitText' => '',
		'deferred' => false,
		'lastDate' => '0',
		'lastKnownDate' => '0',
		'loadExtra' => true,
		'simpleSubmit' => false,
		'showGuestControls' => true,
		'previewUrl' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->formEditor(array(
		'name' => 'message',
		'value' => $__vars['message'],
		'attachments' => ($__vars['attachmentData'] ? $__vars['attachmentData']['attachments'] : array()),
		'data-min-height' => $__vars['minHeight'],
		'placeholder' => $__vars['placeholder'],
		'data-deferred' => ($__vars['deferred'] ? 'on' : 'off'),
		'data-xf-key' => 'r',
		'data-preview-url' => $__vars['previewUrl'],
	)) . '

	';
	if ((!$__vars['xf']['visitor']['user_id']) AND $__vars['showGuestControls']) {
		$__finalCompiled .= '
		' . $__templater->formTextBoxRow(array(
			'name' => '_xfUsername',
			'data-xf-init' => 'guest-username',
			'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor'], 'username', ), false),
		), array(
			'rowtype' => 'fullWidth noGutter',
			'label' => 'Name',
		)) . '
	';
	}
	$__finalCompiled .= '
	';
	if ($__templater->method($__vars['xf']['visitor'], 'isShownCaptcha', array())) {
		$__finalCompiled .= '
		<div class="js-captchaContainer" data-row-type="fullWidth noGutter"></div>
		<noscript>' . $__templater->formHiddenVal('no_captcha', '1', array(
		)) . '</noscript>
	';
	}
	$__finalCompiled .= '

	';
	if ($__vars['attachmentData']) {
		$__finalCompiled .= '
		' . $__templater->callMacro('helper_attach_upload', 'uploaded_files_list', array(
			'attachments' => $__vars['attachmentData']['attachments'],
			'class' => 'attachmentUploads--spaced',
		), $__vars) . '
	';
	}
	$__finalCompiled .= '

	<div class="formButtonGroup ' . ($__vars['simpleSubmit'] ? 'formButtonGroup--simple' : '') . '">
		<div class="formButtonGroup-primary">
			' . $__templater->button('
				' . ($__templater->escape($__vars['submitText']) ?: 'Post reply') . '
			', array(
		'type' => 'submit',
		'class' => 'button--primary',
		'icon' => 'reply',
	), '', array(
	)) . '
		</div>
		';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
					';
	if ($__vars['attachmentData']) {
		$__compilerTemp1 .= '
						' . $__templater->callMacro('helper_attach_upload', 'upload_link_from_data', array(
			'attachmentData' => $__vars['attachmentData'],
			'forceHash' => $__vars['forceHash'],
		), $__vars) . '
					';
	}
	$__compilerTemp1 .= '
					';
	if ($__vars['xf']['options']['multiQuote'] AND $__vars['multiQuoteHref']) {
		$__compilerTemp1 .= '
						' . $__templater->callMacro('multi_quote_macros', 'button', array(
			'href' => $__vars['multiQuoteHref'],
			'messageSelector' => $__vars['messageSelector'],
			'storageKey' => $__vars['multiQuoteStorageKey'],
		), $__vars) . '
					';
	}
	$__compilerTemp1 .= '
				';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
			<div class="formButtonGroup-extra">
				' . $__compilerTemp1 . '
			</div>
		';
	}
	$__finalCompiled .= '
		' . $__templater->formHiddenVal('last_date', $__vars['lastDate'], array(
		'autocomplete' => 'off',
	)) . '
		' . $__templater->formHiddenVal('last_known_date', $__vars['lastKnownDate'], array(
		'autocomplete' => 'off',
	)) . '
		' . $__templater->formHiddenVal('load_extra', ($__vars['loadExtra'] ? 1 : 0), array(
	)) . '
	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . '
';
	return $__finalCompiled;
}
);