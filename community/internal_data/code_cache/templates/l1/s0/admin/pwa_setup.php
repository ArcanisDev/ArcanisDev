<?php
// FROM HASH: 00426afbe22860de109429e9dfdb904d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('PWA setup');
	$__finalCompiled .= '
';
	$__templater->pageParams['pageDescription'] = $__templater->preEscaped('A properly configured <a href="https://web.dev/progressive-web-apps/" target="_blank">progressive web app</a> allows users to install your site to their device.');
	$__templater->pageParams['pageDescriptionMeta'] = true;
	$__finalCompiled .= '

';
	if ($__vars['isInstallable']) {
		$__finalCompiled .= '
	<div class="blockMessage blockMessage--success blockMessage--iconic">
		' . 'Your board meets the requirements to be an installable progressive web app.' . '
	</div>
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage blockMessage--error blockMessage--iconic">
		' . 'Your board does not meet the requirements to be an installable progressive web app. Please ensure the settings listed below are filled out correctly.' . '
	</div>
';
	}
	$__finalCompiled .= '

<div class="blockMessage blockMessage--highlight">
	' . 'Browsers only check for updates to these values periodically. It may take up to 24 hours for changes to be applied.' . '
</div>

';
	$__compilerTemp1 = '';
	if ($__templater->method($__vars['xf']['request'], 'isSecure', array()) OR $__templater->method($__vars['xf']['request'], 'isHostLocal', array())) {
		$__compilerTemp1 .= '
					' . 'Yes' . '
				';
	} else {
		$__compilerTemp1 .= '
					' . 'No' . '
				';
	}
	$__compilerTemp2 = '';
	if ($__templater->isTraversable($__vars['optionGroup']['Options'])) {
		foreach ($__vars['optionGroup']['Options'] AS $__vars['option']) {
			$__compilerTemp2 .= '
				' . $__templater->callMacro('option_macros', 'option_row', array(
				'group' => $__vars['optionGroup'],
				'option' => $__vars['option'],
			), $__vars) . '
			';
		}
	}
	$__compilerTemp3 = array(array(
		'value' => '',
		'label' => '&nbsp;',
		'_type' => 'option',
	));
	$__compilerTemp3 = $__templater->mergeChoiceOptions($__compilerTemp3, $__vars['languageLocales']);
	$__compilerTemp4 = '';
	if ($__templater->isTraversable($__vars['stylePropertyMaps'])) {
		foreach ($__vars['stylePropertyMaps'] AS $__vars['map']) {
			$__compilerTemp4 .= '
				' . $__templater->callMacro('style_property_macros', 'property_edit', array(
				'property' => $__vars['map']['Property'],
				'definitionEditable' => $__templater->method($__vars['map'], 'isDefinitionEditable', array()),
			), $__vars) . '
			';
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<h3 class="block-formSectionHeader">
			<span class="block-formSectionHeader-aligner">' . 'Requirements' . '</span>
		</h3>
		<div class="block-body">
			' . $__templater->formRow('

				' . $__compilerTemp1 . '
			', array(
		'label' => 'HTTPS enabled',
		'explain' => 'Your board must be served over HTTPS for progressive web app support.',
	)) . '
		</div>

		<h3 class="block-formSectionHeader">
			<span class="block-formSectionHeader-aligner">' . 'Options' . '</span>
		</h3>
		<div class="block-body">
			' . $__compilerTemp2 . '
		</div>

		<h3 class="block-formSectionHeader">
			<span class="block-formSectionHeader-aligner">' . 'Language settings' . '</span>
		</h3>
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'These settings reflect the default language ' . $__templater->filter($__vars['language']['title'], array(array('parens', array()),), true) . '.' . '
			', array(
	)) . '

			' . $__templater->formSelectRow(array(
		'name' => 'language[language_code]',
		'value' => $__vars['language']['language_code'],
	), $__compilerTemp3, array(
		'label' => 'Locale',
	)) . '

			' . $__templater->formRadioRow(array(
		'name' => 'language[text_direction]',
		'value' => $__vars['language']['text_direction'],
	), array(array(
		'value' => 'LTR',
		'label' => 'Left-to-right',
		'_type' => 'option',
	),
	array(
		'value' => 'RTL',
		'label' => 'Right-to-left',
		'_type' => 'option',
	)), array(
		'label' => 'Text direction',
	)) . '
		</div>


		<h3 class="block-formSectionHeader">
			<span class="block-formSectionHeader-aligner">' . 'Style properties' . '</span>
		</h3>
		<div class="block-body p-styleProperties">
			' . $__templater->formInfoRow('
				' . 'These settings reflect the default style ' . $__templater->filter($__vars['style']['title'], array(array('parens', array()),), true) . '.' . '
			', array(
	)) . '

			' . $__compilerTemp4 . '

			' . $__templater->callMacro('public:color_picker_macros', 'color_picker_scripts', array(
		'colorData' => $__vars['styleColorData'],
	), $__vars) . '
		</div>

		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('pwa', ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);