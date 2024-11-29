<?php
// FROM HASH: 224b421ae50533c0540268f84eb2f8d1
return array(
'macros' => array('color_picker' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'name' => '!',
		'value' => '',
		'mapName' => '',
		'allowPalette' => 'false',
		'label' => '',
		'hint' => '',
		'explain' => '',
		'html' => '',
		'row' => true,
		'rowClass' => '',
		'rowtype' => '',
		'colorData' => '',
		'required' => false,
		'controlId' => '',
		'includeScripts' => true,
		'showTxt' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__templater->includeCss('public:color_picker.less');
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'src' => 'xf/color_picker.js',
		'min' => '1',
	));
	$__finalCompiled .= '

	';
	if ($__vars['row'] AND (!$__vars['controlId'])) {
		$__finalCompiled .= '
		';
		$__vars['controlId'] = $__templater->func('unique_id', array(), false);
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '

	';
	$__compilerTemp1 = '';
	if ($__vars['showTxt']) {
		$__compilerTemp1 .= '
				<div class="inputGroup-text inputGroup-text--rgbTxt"><span class="js-rgbTxt-r"></span></div>
				<div class="inputGroup-text inputGroup-text--rgbTxt"><span class="js-rgbTxt-g"></span></div>
				<div class="inputGroup-text inputGroup-text--rgbTxt"><span class="js-rgbTxt-b"></span></div>
				<!--<div class="inputGroup-text inputGroup-text&#45;&#45;rgbTxt"><span class="js-rgbTxt-b"></span></div>-->
			';
	}
	$__vars['picker'] = $__templater->preEscaped('
		<div class="inputGroup inputGroup--joined inputGroup--color"
			data-xf-init="color-picker"
			data-allow-palette="' . $__templater->escape($__vars['allowPalette']) . '"
			data-map-name="' . $__templater->escape($__vars['mapName']) . '">

			' . $__templater->formTextBox(array(
		'name' => $__vars['name'],
		'value' => $__vars['value'],
		'required' => $__vars['required'],
		'id' => $__vars['controlId'],
		'dir' => 'ltr',
	)) . '
			<div class="inputGroup-text"><span class="colorPickerBox js-colorPickerTrigger"></span></div>
			' . $__compilerTemp1 . '
		</div>
	');
	$__finalCompiled .= '

	';
	if ($__vars['row']) {
		$__finalCompiled .= '
		' . $__templater->formRow('

			' . $__templater->filter($__vars['picker'], array(array('raw', array()),), true) . '
		', array(
			'rowtype' => $__vars['rowtype'],
			'rowclass' => 'formRow--input ' . $__vars['rowClass'],
			'controlid' => $__vars['controlId'],
			'label' => $__templater->escape($__vars['label']),
			'hint' => $__templater->escape($__vars['hint']),
			'explain' => $__templater->escape($__vars['explain']),
			'html' => $__templater->escape($__vars['html']),
		)) . '
	';
	} else {
		$__finalCompiled .= '
		' . $__templater->filter($__vars['picker'], array(array('raw', array()),), true) . '
	';
	}
	$__finalCompiled .= '

	';
	if ($__vars['includeScripts']) {
		$__finalCompiled .= '
		' . $__templater->callMacro(null, 'color_picker_scripts', array(
			'colorData' => $__vars['colorData'],
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'color_picker_scripts' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'colorData' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__compilerTemp1 = '';
	if ($__vars['colorData']) {
		$__compilerTemp1 .= '
			<script class="js-colorPickerData" type="application/json">
				' . $__templater->filter($__vars['colorData'], array(array('json', array()),array('raw', array()),), true) . '
			</script>
		';
	}
	$__templater->setPageParam('head.' . 'js-colorPicker', $__templater->preEscaped('

		<script class="js-namedColors" type="application/json">
			' . $__templater->filter($__templater->func('named_colors', array(), false), array(array('json', array()),array('raw', array()),), true) . '
		</script>

		<script class="js-extraPhrases" type="application/json">
			{
				"picker": "' . $__templater->filter('Picker', array(array('escape', array('json', )),), true) . '",
				"update": "' . $__templater->filter('Update', array(array('escape', array('json', )),), true) . '"
			}
		</script>

		' . $__compilerTemp1 . '

	'));
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '



';
	return $__finalCompiled;
}
);