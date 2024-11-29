<?php
// FROM HASH: 05c2f697ae1f4d3d5c1c2bc8f190303e
return array(
'macros' => array('select' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'prefixes' => '!',
		'type' => '!',
		'selected' => '',
		'name' => 'prefix_id',
		'noneLabel' => $__vars['xf']['language']['parenthesis_open'] . 'No prefix' . $__vars['xf']['language']['parenthesis_close'],
		'multiple' => false,
		'includeAny' => false,
		'class' => '',
		'href' => '',
		'controlId' => '',
		'listenTo' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__compilerTemp1 = array();
	if ($__vars['includeAny']) {
		$__compilerTemp1[] = array(
			'value' => '-1',
			'label' => $__vars['xf']['language']['parenthesis_open'] . 'Any' . $__vars['xf']['language']['parenthesis_close'],
			'_type' => 'option',
		);
	}
	$__compilerTemp1[] = array(
		'value' => '0',
		'label' => $__templater->escape($__vars['noneLabel']),
		'_type' => 'option',
	);
	$__compilerTemp2 = $__templater->func('array_keys', array($__vars['prefixes'], ), false);
	if ($__templater->isTraversable($__compilerTemp2)) {
		foreach ($__compilerTemp2 AS $__vars['groupId']) {
			if ($__vars['groupId'] > 0) {
				$__compilerTemp1[] = array(
					'label' => $__templater->func('prefix_group', array($__vars['type'], $__vars['groupId'], ), false),
					'_type' => 'optgroup',
					'options' => array(),
				);
				end($__compilerTemp1); $__compilerTemp3 = key($__compilerTemp1);
				if ($__templater->isTraversable($__vars['prefixes'][$__vars['groupId']])) {
					foreach ($__vars['prefixes'][$__vars['groupId']] AS $__vars['prefixId'] => $__vars['prefix']) {
						$__compilerTemp1[$__compilerTemp3]['options'][] = array(
							'value' => $__vars['prefixId'],
							'label' => $__templater->func('prefix_title', array($__vars['type'], $__vars['prefixId'], ), true),
							'data-prefix-class' => $__vars['prefix']['css_class'],
							'data-has-help' => $__vars['prefix']['has_usage_help'],
							'_type' => 'option',
						);
					}
				}
			} else {
				if ($__templater->isTraversable($__vars['prefixes'][$__vars['groupId']])) {
					foreach ($__vars['prefixes'][$__vars['groupId']] AS $__vars['prefixId'] => $__vars['prefix']) {
						$__compilerTemp1[] = array(
							'value' => $__vars['prefixId'],
							'label' => $__templater->func('prefix_title', array($__vars['type'], $__vars['prefixId'], ), true),
							'data-prefix-class' => $__vars['prefix']['css_class'],
							'data-has-help' => $__vars['prefix']['has_usage_help'],
							'_type' => 'option',
						);
					}
				}
			}
		}
	}
	$__finalCompiled .= $__templater->formSelect(array(
		'name' => $__vars['name'],
		'value' => $__vars['selected'],
		'multiple' => $__vars['multiple'],
		'class' => $__vars['class'],
		'data-xf-init' => ((($__vars['href'] AND $__vars['listenTo'])) ? 'prefix-loader' : ''),
		'data-href' => $__vars['href'],
		'data-listen-to' => $__vars['listenTo'],
		'id' => $__vars['controlId'],
		'title' => 'Prefix',
	), $__compilerTemp1) . '
';
	return $__finalCompiled;
}
),
'row' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'prefixes' => '!',
		'type' => '!',
		'label' => 'Prefix',
		'explain' => '',
		'selected' => '',
		'name' => 'prefix_id',
		'noneLabel' => $__vars['xf']['language']['parenthesis_open'] . 'No prefix' . $__vars['xf']['language']['parenthesis_close'],
		'multiple' => false,
		'includeAny' => false,
		'class' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__vars['controlId'] = $__templater->func('unique_id', array(), false);
	$__finalCompiled .= '

	';
	$__compilerTemp1 = '';
	if ($__vars['explain']) {
		$__compilerTemp1 .= '
			<div class="formRow-explain">' . $__templater->filter($__vars['explain'], array(array('raw', array()),), true) . '</div>
		';
	}
	$__finalCompiled .= $__templater->formRow('
		' . $__templater->callMacro(null, 'select', array(
		'prefixes' => $__vars['prefixes'],
		'type' => $__vars['type'],
		'selected' => $__vars['selected'],
		'name' => $__vars['name'],
		'noneLabel' => $__vars['noneLabel'],
		'multiple' => $__vars['multiple'],
		'includeAny' => $__vars['includeAny'],
		'controlId' => $__vars['controlId'],
		'class' => $__vars['class'],
	), $__vars) . '
		' . $__compilerTemp1 . '
	', array(
		'rowtype' => 'input',
		'label' => $__templater->escape($__vars['label']),
		'controlid' => $__vars['controlId'],
	)) . '
';
	return $__finalCompiled;
}
),
'usage_help' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'prefix' => '!',
		'contentType' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= $__templater->func('prefix_usage_help', array($__vars['contentType'], $__vars['prefix']->{'prefix_id'}, ), true);
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
		<div class="formRow-explain formRow-prefixHelp">
			' . $__compilerTemp1 . '
		</div>
	';
	}
	$__finalCompiled .= '
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