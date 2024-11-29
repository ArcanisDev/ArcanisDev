<?php
// FROM HASH: 37db37dfc6cda69ff793b4db862f272b
return array(
'macros' => array('button_group' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'key' => '!',
		'data' => '!',
		'buttonData' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="block-row block-row--buttonGroup js-buttonGroup" id="js-buttonGroup--' . $__templater->escape($__vars['key']) . '">
		<div class="block-row--buttons">
			<div class="js-dragList toolbar toolbar--dragTarget toolbar--' . $__templater->escape($__vars['key']) . '" id="js-toolbar--' . $__templater->escape($__vars['key']) . '">
				';
	if ($__templater->isTraversable($__vars['data']['buttons'])) {
		foreach ($__vars['data']['buttons'] AS $__vars['cmd']) {
			$__finalCompiled .= '
					' . $__templater->callMacro(null, 'toolbar_button', array(
				'button' => $__vars['buttonData'][$__vars['cmd']],
				'cmd' => $__vars['cmd'],
				'displayTooltips' => true,
				'includeDropdownControls' => false,
			), $__vars) . '
				';
		}
	}
	$__finalCompiled .= '
			</div>
		</div>
		<div class="block-row--buttonMenu">
			' . $__templater->button('', array(
		'class' => 'menuTrigger button--link button--icon button--iconOnly',
		'data-xf-click' => 'menu',
		'aria-expanded' => 'false',
		'aria-haspopup' => 'true',
		'fa' => 'fa-tools',
		'notfa' => 'fa-info-circle',
	), '', array(
	)) . '
			<div class="menu" data-menu="menu" aria-hidden="true" id="js-toolbar-menu--' . $__templater->escape($__vars['key']) . '">
				<div class="menu-content">
					<h3 class="menu-header">' . 'Group options' . '</h3>

					<div class="menu-row menu-row--separated">
						' . 'Buttons visible' . $__vars['xf']['language']['label_separator'] . '
						<div class="u-inputSpacer">
							' . $__templater->formNumberBox(array(
		'name' => 'buttonsVisible',
		'value' => $__vars['data']['buttonsVisible'],
		'autofocus' => 'autofocus',
		'min' => '0',
		'data-button-smaller' => '1',
	)) . '
						</div>
					</div>

					<div class="menu-row menu-row--separated">
						' . 'Group alignment' . $__vars['xf']['language']['label_separator'] . '
						<div class="u-inputSpacer">
							' . $__templater->formSelect(array(
		'name' => 'align',
		'value' => $__vars['data']['align'],
	), array(array(
		'value' => 'left',
		'label' => 'Left',
		'_type' => 'option',
	),
	array(
		'value' => 'right',
		'label' => 'Right',
		'_type' => 'option',
	))) . '
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'toolbar_block' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'type' => '',
		'name' => '',
		'buttons' => '!',
		'buttonData' => '!',
		'toolbarType' => '!',
		'displayTooltips' => false,
		'includeDropdownControls' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="block-body">
		<div class="block-row">
			<div class="fr-box fr-box--editor fr-box--editor--' . $__templater->escape($__vars['type']) . ' fr-ltr fr-basic fr-top">
				<div class="toolbar--dragTarget js-dragList js-dragList-' . $__templater->escape($__vars['toolbarType']) . ' toolbar-' . $__templater->escape($__vars['toolbarType']) . ' fr-toolbar fr-ltr fr-desktop fr-top fr-basic">
					';
	if ($__templater->isTraversable($__vars['buttons'])) {
		foreach ($__vars['buttons'] AS $__vars['cmd']) {
			$__finalCompiled .= '
						';
			if ($__vars['buttonData'][$__vars['cmd']]) {
				$__finalCompiled .= '
							' . $__templater->callMacro(null, 'toolbar_button', array(
					'button' => $__vars['buttonData'][$__vars['cmd']],
					'cmd' => $__vars['cmd'],
					'displayTooltips' => $__vars['displayTooltips'],
					'includeDropdownControls' => $__vars['includeDropdownControls'],
				), $__vars) . '
						';
			}
			$__finalCompiled .= '
					';
		}
	}
	$__finalCompiled .= '
					';
	if ($__vars['name']) {
		$__finalCompiled .= '
						' . $__templater->formHiddenVal($__vars['name'], '', array(
			'class' => 'js-dragListValue',
		)) . '
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
'toolbar_button' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'button' => '!',
		'cmd' => '!',
		'displayTooltips' => false,
		'includeDropdownControls' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div data-cmd="' . $__templater->escape($__vars['cmd']) . '" data-xf-init="' . ($__vars['displayTooltips'] ? 'tooltip' : '') . '" title="' . ($__vars['displayTooltips'] ? $__templater->escape($__vars['button']['title']) : '') . '"
		class="' . ($__vars['button']['type'] ? ('toolbar-' . $__templater->escape($__vars['button']['type'])) : '') . ' fr-command fr-btn ' . (((($__vars['button']['type'] == 'dropdown') OR ($__vars['button']['type'] == 'editable_dropdown'))) ? 'fr-dropdown' : '') . ' ' . ($__vars['button']['fa'] ? 'fr-btn-font_awesome' : ($__vars['button']['text'] ? 'fr-btn-text' : 'fr-btn-image')) . '">
		' . $__templater->callMacro(null, 'toolbar_icon', array(
		'button' => $__vars['button'],
	), $__vars) . '
		<span class="fr-sr-only">' . $__templater->escape($__vars['button']['title']) . '</span>
	</div>
';
	return $__finalCompiled;
}
),
'toolbar_icon' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'button' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__vars['button']['fa']) {
		$__finalCompiled .= '
		' . $__templater->fontAwesome($__templater->escape($__vars['button']['fa']), array(
		)) . '
	';
	} else if ($__vars['button']['image']) {
		$__finalCompiled .= '
		<img src="' . $__templater->escape($__vars['button']['image']) . '" alt="" />
	';
	} else if ($__vars['button']['text']) {
		$__finalCompiled .= '
		<span style="text-align: center;">' . $__templater->escape($__vars['button']['text']) . '</span>
	';
	} else if ($__vars['button']['svg']) {
		$__finalCompiled .= '
		<svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
			<path d="' . $__templater->escape($__vars['button']['svg']) . '"></path>
		</svg>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'setup' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeCss('public:editor.less');
	$__finalCompiled .= '
	';
	$__templater->includeCss('button_manager.less');
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'dev' => 'vendor/dragula/dragula.js, xf/editor_manager.js',
		'prod' => 'xf/editor_manager-compiled.js',
	));
	$__finalCompiled .= '

	<script class="js-extraPhrases" type="application/json">
		{
			"buttons_menus_may_not_be_duplicated": "' . $__templater->filter('Buttons and menus may not be duplicated.', array(array('escape', array('json', )),), true) . '",
			"button_removed": "' . $__templater->filter('Button removed', array(array('escape', array('json', )),), true) . '"
		}
	</script>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit toolbar' . ': ' . $__templater->escape($__vars['typeTitle']));
	$__finalCompiled .= '

' . $__templater->callMacro(null, 'setup', array(), $__vars) . '

';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['toolbarTypes'])) {
		foreach ($__vars['toolbarTypes'] AS $__vars['_toolbarTypeId'] => $__vars['_toolbarType']) {
			$__compilerTemp1 .= '
				<a href="' . $__templater->func('link', array('button-manager/edit', array(), array('type' => $__vars['_toolbarTypeId'], ), ), true) . '"
					class="menu-linkRow ' . ((($__vars['_toolbarTypeId'] == $__vars['type'])) ? 'is-selected' : '') . '">
					' . $__templater->escape($__vars['_toolbarType']['title']) . '
				</a>
			';
		}
	}
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('

	<a class="button menuTrigger"
		data-xf-click="menu"
		role="button"
		tabindex="0"
		aria-expanded="false"
		aria-haspopup="true">' . $__templater->escape($__vars['typeTitle']) . '</a>

	<div class="menu" data-menu="menu" aria-hidden="true">
		<div class="menu-content">
			<h3 class="menu-header">' . 'Editor toolbars' . '</h3>
			' . $__compilerTemp1 . '
		</div>
	</div>

	' . $__templater->button('
		' . 'Reset button configuration' . '
	', array(
		'href' => $__templater->func('link', array('button-manager/reset', null, array('type' => $__vars['type'], ), ), false),
		'data-xf-click' => 'overlay',
		'icon' => 'refresh',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

<script type="application/json" id="js-toolbarButtons">' . $__templater->escape($__vars['json']) . '</script>
<script type="application/json" id="js-buttonData">' . $__templater->filter($__vars['buttonData'], array(array('json', array()),array('raw', array()),), true) . '</script>

';
	$__templater->inlineCss('
.toolbarWidthLimit { margin: 0 auto; }
.toolbarWidthLimit.toolbarWidthLimit--toolbarButtons   { width: ' . $__vars['toolbarSizes']['LG'] . 'px; }
.toolbarWidthLimit.toolbarWidthLimit--toolbarButtonsMD { width: ' . $__vars['toolbarSizes']['MD'] . 'px; }
.toolbarWidthLimit.toolbarWidthLimit--toolbarButtonsSM { width: ' . $__vars['toolbarSizes']['SM'] . 'px; }
.toolbarWidthLimit.toolbarWidthLimit--toolbarButtonsXS { width: 320px; }
');
	$__finalCompiled .= '

';
	$__compilerTemp2 = '';
	$__compilerTemp3 = $__templater->func('array_keys', array($__vars['buttonData'], ), false);
	if ($__templater->isTraversable($__compilerTemp3)) {
		foreach ($__compilerTemp3 AS $__vars['cmd']) {
			$__compilerTemp2 .= '
								';
			if ($__vars['buttonData'][$__vars['cmd']]) {
				$__compilerTemp2 .= '
									' . $__templater->callMacro(null, 'toolbar_button', array(
					'button' => $__vars['buttonData'][$__vars['cmd']],
					'cmd' => $__vars['cmd'],
					'displayTooltips' => true,
					'includeDropdownControls' => true,
				), $__vars) . '
								';
			} else if ($__vars['cmd'] == '-hr') {
				$__compilerTemp2 .= '
									<div class="hr"></div>
								';
			}
			$__compilerTemp2 .= '
							';
		}
	}
	$__compilerTemp4 = '';
	if ($__vars['name']) {
		$__compilerTemp4 .= '
								' . $__templater->formHiddenVal($__vars['name'], '', array(
			'class' => 'js-dragListValue',
		)) . '
							';
	}
	$__compilerTemp5 = '';
	if ($__templater->isTraversable($__vars['toolbarButtons']['toolbarButtons'])) {
		foreach ($__vars['toolbarButtons']['toolbarButtons'] AS $__vars['key'] => $__vars['data']) {
			$__compilerTemp5 .= '
					' . $__templater->callMacro(null, 'button_group', array(
				'key' => $__vars['key'],
				'data' => $__vars['data'],
				'buttonData' => $__vars['buttonData'],
			), $__vars) . '
				';
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block">
		<div class="block-container">
			<h2 class="block-header">
				' . 'Available buttons and dropdown menus' . '
			</h2>

			<div class="block-body">
				<div class="block-row">
					<div class="fr-box fr-box--editor fr-box--editor--' . $__templater->escape($__vars['type']) . ' fr-ltr fr-basic fr-top">
						<div class="js-dragList js-dragList-commandTray toolbar-commandTray fr-toolbar fr-ltr fr-desktop fr-top fr-basic">
							' . $__compilerTemp2 . '
							' . $__compilerTemp4 . '
						</div>
					</div>
				</div>
			</div>

			<div class="block-row block-row--minor u-muted">
				' . 'This is a list of all editor buttons that can be added to the editor. The bottom row contains the available custom dropdown menus. Move buttons from here to the toolbar below.' . '
			</div>
		</div>
	</div>

	<div class="block">
		<div class="block-container">
			<h3 class="block-header">
				' . $__templater->escape($__vars['typeTitle']) . '
			</h3>

			<div class="block-body">
				' . $__compilerTemp5 . '
			</div>

			<div class="block-row block-row--minor u-muted">
				' . $__templater->escape($__vars['typeDescription']) . '
			</div>

			' . $__templater->formHiddenVal('editor_toolbar_config[' . $__vars['type'] . ']', '', array(
		'data-toolbar-type' => $__vars['type'],
		'class' => 'js-dragListValue',
	)) . '
			' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
		'rowtype' => 'simple',
	)) . '
		</div>
	</div>
', array(
		'action' => $__templater->func('link', array('button-manager/save', null, array('type' => $__vars['type'], ), ), false),
		'ajax' => 'true',
		'data-xf-init' => 'editor-manager',
		'data-force-flash-message' => 'on',
	)) . '

' . $__templater->form('

	<div class="block-container">
		<div class="block-body">
			<p></p>

			<!--this overrides the normal toolbar json sent to the RTE as $(\'.js-editorToolbars\').first()-->
			<script class="js-editorToolbars" type="application/json">' . $__templater->filter($__vars['toolbarButtons'], array(array('json', array()),array('raw', array()),), true) . '</script>


			<div class="toolbarWidthLimit toolbarWidthLimit--' . $__templater->escape($__vars['type']) . '">
				' . $__templater->formEditor(array(
		'name' => 'button_layout_preview',
		'value' => '',
		'attachments' => array(),
		'data-min-height' => '50',
		'data-max-height' => '100',
		'placeholder' => 'This is a preview of your button layout' . '...',
		'data-deferred' => 'off',
		'data-xf-key' => 'r',
		'data-preview-url' => $__templater->func('link', array('button-manager/dummy-preview', ), false),
	)) . '
				' . $__templater->callMacro('public:helper_attach_upload', 'upload_block', array(
		'attachmentData' => array('constraints' => array('extensions' => array('txt', 'mp4', 'png', ), ), ),
	), $__vars) . '
			</div>

			<p></p>

		</div>
	</div>
', array(
		'action' => $__templater->func('link', array('button-manager/dummy-post', $__vars['thread'], ), false),
		'class' => 'block',
		'ajax' => 'true',
		'draft' => $__templater->func('link', array('button-manager/dummy-draft', ), false),
		'data-xf-init' => 'attachment-manager',
	)) . '

' . '

' . '

' . '

' . '

';
	return $__finalCompiled;
}
);