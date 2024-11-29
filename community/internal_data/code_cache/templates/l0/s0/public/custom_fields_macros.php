<?php
// FROM HASH: 3ad7d552b123926ffd62761b67d84fbd
return array(
'macros' => array('custom_fields_view' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'type' => '!',
		'group' => '!',
		'set' => '!',
		'onlyInclude' => null,
		'additionalFilters' => array(),
		'wrapperClass' => '',
		'valueClass' => 'pairs pairs--columns pairs--fixedSmall pairs--customField',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
			' . $__templater->callMacro(null, 'custom_fields_values', array(
		'type' => $__vars['type'],
		'group' => $__vars['group'],
		'set' => $__vars['set'],
		'onlyInclude' => $__vars['onlyInclude'],
		'additionalFilters' => $__vars['additionalFilters'],
		'valueClass' => $__vars['valueClass'],
	), $__vars) . '
		';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
		<div class="' . $__templater->escape($__vars['wrapperClass']) . '">
		' . $__compilerTemp1 . '
		</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'custom_fields_values' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'type' => '!',
		'group' => '!',
		'set' => '!',
		'onlyInclude' => null,
		'additionalFilters' => array(),
		'valueClass' => 'pairs pairs--columns pairs--fixedSmall pairs--customField',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__compilerTemp1 = $__templater->method($__vars['xf']['app'], 'getCustomFields', array($__vars['type'], $__vars['group'], $__vars['onlyInclude'], $__vars['additionalFilters'], ));
	if ($__templater->isTraversable($__compilerTemp1)) {
		foreach ($__compilerTemp1 AS $__vars['fieldId'] => $__vars['fieldDefinition']) {
			$__finalCompiled .= '
		';
			if ($__templater->method($__vars['fieldDefinition'], 'hasValue', array($__vars['set'][$__vars['fieldDefinition']['field_id']], ))) {
				$__finalCompiled .= '
			';
				$__vars['fieldValue'] = $__templater->preEscaped($__templater->func('trim', array($__templater->callMacro(null, 'custom_field_value', array(
					'definition' => $__vars['fieldDefinition'],
					'value' => $__vars['set'][$__vars['fieldDefinition']['field_id']],
				), $__vars) . '
				'), false));
				$__finalCompiled .= '

			';
				if ($__vars['fieldDefinition']['wrapper_template']) {
					$__finalCompiled .= '
				' . $__templater->filter($__templater->method($__vars['fieldDefinition'], 'getFormattedOutput', array($__vars['fieldValue'], )), array(array('raw', array()),), true) . '
			';
				} else {
					$__finalCompiled .= '
				<dl class="' . $__templater->escape($__vars['valueClass']) . '" data-field="' . $__templater->escape($__vars['fieldId']) . '">
					<dt>' . $__templater->escape($__vars['fieldDefinition']['title']) . '</dt>
					<dd>' . $__templater->escape($__vars['fieldValue']) . '</dd>
				</dl>
			';
				}
				$__finalCompiled .= '
		';
			}
			$__finalCompiled .= '
	';
		}
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'custom_field_value' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'definition' => '!',
		'value' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__vars['definition']['field_type'] == 'stars') {
		$__finalCompiled .= '
		' . $__templater->callMacro('rating_macros', 'stars', array(
			'rating' => $__vars['value'],
		), $__vars) . '
	';
	} else {
		$__finalCompiled .= '
		';
		if ($__vars['definition']['match_type'] == 'date') {
			$__finalCompiled .= '
			' . $__templater->callMacro(null, 'custom_field_value_date', array(
				'date' => $__vars['value'],
			), $__vars) . '
		';
		} else if ($__vars['definition']['match_type'] == 'color') {
			$__finalCompiled .= '
			' . $__templater->callMacro(null, 'custom_field_value_color', array(
				'color' => $__vars['value'],
			), $__vars) . '
		';
		} else {
			$__finalCompiled .= '
			' . $__templater->filter($__templater->method($__vars['definition'], 'getFormattedValue', array($__vars['value'], )), array(array('raw', array()),), true) . '
		';
		}
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'custom_field_value_date' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'date' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	' . $__templater->func('date', array($__templater->func('date_from_format', array('Y-m-d', $__vars['date'], ), false), ), true) . '
';
	return $__finalCompiled;
}
),
'custom_field_value_color' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'color' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	<span class="colorChip" data-xf-init="tooltip" title="' . $__templater->escape($__vars['color']) . '">
		<span class="colorChip-inner" style="background-color: ' . $__templater->escape($__vars['color']) . '">
			<span class="colorChip-value">' . $__templater->escape($__vars['color']) . '</span>
		</span>
	</span>
';
	return $__finalCompiled;
}
),
'custom_fields_edit' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'type' => '!',
		'group' => null,
		'set' => '!',
		'editMode' => 'user',
		'onlyInclude' => null,
		'additionalFilters' => array(),
		'rowType' => '',
		'rowClass' => '',
		'namePrefix' => 'custom_fields',
		'requiredOnly' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__compilerTemp1 = $__templater->method($__vars['xf']['app'], 'getCustomFieldsForEdit', array($__vars['type'], $__vars['set'], $__vars['editMode'], $__vars['group'], $__vars['onlyInclude'], $__vars['additionalFilters'], ));
	if ($__templater->isTraversable($__compilerTemp1)) {
		foreach ($__compilerTemp1 AS $__vars['fieldId'] => $__vars['fieldDefinition']) {
			$__finalCompiled .= '
		';
			if ((!$__vars['requiredOnly']) OR (($__vars['requiredOnly'] AND $__vars['fieldDefinition']['required']))) {
				$__finalCompiled .= '
			';
				$__vars['controlId'] = ($__templater->func('in_array', array($__vars['fieldDefinition']['field_type'], array('textbox', 'textarea', 'select', 'multiselect', 'date', 'stars', 'color', ), ), false) ? $__templater->func('unique_id', array(), false) : '');
				$__finalCompiled .= '
			';
				$__vars['labelId'] = ($__templater->func('in_array', array($__vars['fieldDefinition']['field_type'], array('radio', 'checkbox', ), ), false) ? $__templater->func('unique_id', array(), false) : '');
				$__finalCompiled .= '

			' . $__templater->formRow('

				' . $__templater->callMacro(null, 'custom_fields_edit_' . $__vars['fieldDefinition']['field_type'], array(
					'set' => $__vars['set'],
					'definition' => $__vars['fieldDefinition'],
					'editMode' => $__vars['editMode'],
					'refId' => ($__vars['controlId'] ?: $__vars['labelId']),
					'namePrefix' => $__vars['namePrefix'],
				), $__vars) . '
			', array(
					'label' => $__templater->escape($__vars['fieldDefinition']['title']),
					'explain' => $__templater->escape($__vars['fieldDefinition']['description']),
					'hint' => ($__templater->method($__vars['fieldDefinition'], 'isRequired', array($__vars['editMode'], )) ? 'Required' : ''),
					'rowtype' => $__vars['rowType'] . ' customField ' . ($__templater->func('in_array', array($__vars['fieldDefinition']['field_type'], array('textbox', 'textarea', 'bbcode', 'select', ), ), false) ? 'input' : ''),
					'rowclass' => $__vars['rowClass'],
					'labelid' => $__vars['labelId'],
					'controlid' => $__vars['controlId'],
					'data-field' => $__vars['fieldDefinition']['field_id'],
				)) . '
		';
			}
			$__finalCompiled .= '
	';
		}
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'custom_fields_edit_groups' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'type' => '!',
		'groups' => '!',
		'set' => '!',
		'editMode' => 'user',
		'onlyInclude' => null,
		'additionalFilters' => array(),
		'rowType' => '',
		'namePrefix' => 'custom_fields',
		'requiredOnly' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	if ($__templater->isTraversable($__vars['groups'])) {
		foreach ($__vars['groups'] AS $__vars['group']) {
			$__finalCompiled .= '
		' . $__templater->callMacro(null, 'custom_fields_edit', array(
				'type' => $__vars['type'],
				'group' => $__vars['group'],
				'set' => $__vars['set'],
				'editMode' => $__vars['editMode'],
				'onlyInclude' => $__vars['onlyInclude'],
				'additionalFilters' => $__vars['additionalFilters'],
				'rowType' => $__vars['rowType'],
				'namePrefix' => $__vars['namePrefix'],
				'requiredOnly' => $__vars['requiredOnly'],
			), $__vars) . '
	';
		}
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'custom_fields_edit_textbox' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'set' => '!',
		'definition' => '!',
		'editMode' => '!',
		'refId' => '',
		'namePrefix' => 'custom_fields',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	if ($__vars['definition']['match_type'] == 'date') {
		$__finalCompiled .= '

		' . $__templater->formDateInput(array(
			'name' => $__vars['namePrefix'] . '[' . $__vars['definition']['field_id'] . ']',
			'value' => $__vars['set'][$__vars['definition']['field_id']],
			'data-field' => $__vars['definition']['field_id'],
			'maxlength' => ($__vars['definition']['max_length'] ? $__vars['definition']['max_length'] : ''),
			'required' => ($__templater->method($__vars['definition'], 'isRequired', array($__vars['editMode'], )) ? 'required' : ''),
			'id' => $__vars['refId'],
			'class' => 'field_' . $__vars['definition']['field_id'],
		)) . '

	';
	} else if ($__vars['definition']['match_type'] == 'color') {
		$__finalCompiled .= '

		' . $__templater->callMacro('color_picker_macros', 'color_picker', array(
			'name' => $__vars['namePrefix'] . '[' . $__vars['definition']['field_id'] . ']',
			'value' => $__vars['set'][$__vars['definition']['field_id']],
			'mapName' => '',
			'row' => false,
			'controlId' => $__vars['refId'],
			'required' => $__templater->method($__vars['definition'], 'isRequired', array($__vars['editMode'], )),
		), $__vars) . '

	';
	} else if ($__vars['definition']['match_type'] == 'number') {
		$__finalCompiled .= '

		';
		$__vars['step'] = '1';
		$__finalCompiled .= '

		';
		if ($__vars['definition']['match_params']['number_integer']) {
			$__finalCompiled .= '
			';
			if ($__vars['definition']['match_params']['number_min'] >= 0) {
				$__finalCompiled .= '
				';
				$__vars['pattern'] = '\\d*';
				$__finalCompiled .= '
			';
			}
			$__finalCompiled .= '
		';
		} else {
			$__finalCompiled .= '
			';
			$__vars['step'] = 'any';
			$__finalCompiled .= '
		';
		}
		$__finalCompiled .= '
		';
		if ($__vars['definition']['match_params']['number_min'] !== '') {
			$__finalCompiled .= '
			';
			$__vars['min'] = $__vars['definition']['match_params']['number_min'];
			$__finalCompiled .= '
		';
		}
		$__finalCompiled .= '
		';
		if ($__vars['definition']['match_params']['number_max'] !== '') {
			$__finalCompiled .= '
			';
			$__vars['max'] = $__vars['definition']['match_params']['number_max'];
			$__finalCompiled .= '
		';
		}
		$__finalCompiled .= '

		' . $__templater->formNumberBox(array(
			'name' => $__vars['namePrefix'] . '[' . $__vars['definition']['field_id'] . ']',
			'value' => $__vars['set'][$__vars['definition']['field_id']],
			'maxlength' => ($__vars['definition']['max_length'] ? $__vars['definition']['max_length'] : ''),
			'pattern' => $__vars['pattern'],
			'default' => '',
			'min' => $__vars['min'],
			'max' => $__vars['max'],
			'step' => $__vars['step'],
			'required' => ($__templater->method($__vars['definition'], 'isRequired', array($__vars['editMode'], )) ? 'required' : ''),
			'id' => $__vars['refId'],
			'class' => 'field_' . $__vars['definition']['field_id'],
		)) . '

	';
	} else {
		$__finalCompiled .= '

		';
		if ($__templater->func('in_array', array($__vars['definition']['match_type'], array('regex', 'alphanumeric', ), ), false)) {
			$__finalCompiled .= '

			';
			$__vars['type'] = 'text';
			$__finalCompiled .= '
			';
			$__vars['pattern'] = (($__vars['definition']['match_type'] == 'regex') ? $__vars['definition']['match_params']['regex'] : '\\w+');
			$__finalCompiled .= '
			';
			$__vars['title'] = $__templater->preEscaped('Please enter a value that matches the required format.');
			$__finalCompiled .= '

		';
		} else if ($__templater->func('in_array', array($__vars['definition']['match_type'], array('date', 'email', 'url', 'color', ), ), false)) {
			$__finalCompiled .= '

			';
			$__vars['type'] = $__vars['definition']['match_type'];
			$__finalCompiled .= '

		';
		} else {
			$__finalCompiled .= '

			';
			$__vars['type'] = 'text';
			$__finalCompiled .= '

		';
		}
		$__finalCompiled .= '

		' . $__templater->formTextBox(array(
			'name' => $__vars['namePrefix'] . '[' . $__vars['definition']['field_id'] . ']',
			'value' => $__vars['set'][$__vars['definition']['field_id']],
			'type' => $__vars['type'],
			'maxlength' => ($__vars['definition']['max_length'] ? $__vars['definition']['max_length'] : ''),
			'pattern' => $__vars['pattern'],
			'title' => $__vars['title'],
			'min' => $__vars['min'],
			'max' => $__vars['max'],
			'step' => $__vars['step'],
			'required' => ($__templater->method($__vars['definition'], 'isRequired', array($__vars['editMode'], )) ? 'required' : ''),
			'id' => $__vars['refId'],
			'class' => 'field_' . $__vars['definition']['field_id'],
		)) . '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'custom_fields_edit_textarea' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'set' => '!',
		'definition' => '!',
		'editMode' => '!',
		'refId' => '',
		'namePrefix' => 'custom_fields',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	' . $__templater->formTextArea(array(
		'name' => $__vars['namePrefix'] . '[' . $__vars['definition']['field_id'] . ']',
		'value' => $__vars['set'][$__vars['definition']['field_id']],
		'maxlength' => ($__vars['definition']['max_length'] ? $__vars['definition']['max_length'] : ''),
		'autosize' => 'true',
		'required' => ($__templater->method($__vars['definition'], 'isRequired', array($__vars['editMode'], )) ? 'required' : ''),
		'id' => $__vars['refId'],
		'class' => 'field_' . $__vars['definition']['field_id'],
	)) . '
';
	return $__finalCompiled;
}
),
'custom_fields_edit_bbcode' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'set' => '!',
		'definition' => '!',
		'editMode' => '!',
		'refId' => '',
		'namePrefix' => 'custom_fields',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	' . $__templater->formEditor(array(
		'name' => $__vars['namePrefix'] . '[' . $__vars['definition']['field_id'] . ']',
		'value' => $__vars['set'][$__vars['definition']['field_id']],
		'previewable' => '0',
		'data-min-height' => '80',
		'data-attachment-target' => 'false',
		'class' => 'field_' . $__vars['definition']['field_id'],
	)) . '
';
	return $__finalCompiled;
}
),
'custom_fields_edit_select' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'set' => '!',
		'definition' => '!',
		'editMode' => '!',
		'refId' => '',
		'multi' => '',
		'namePrefix' => 'custom_fields',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__compilerTemp1 = array(array(
		'value' => '',
		'_type' => 'option',
	));
	$__compilerTemp1 = $__templater->mergeChoiceOptions($__compilerTemp1, $__vars['definition']['field_choices']);
	$__finalCompiled .= $__templater->formSelect(array(
		'name' => $__vars['namePrefix'] . '[' . $__vars['definition']['field_id'] . ']',
		'value' => (($__vars['set'][$__vars['definition']['field_id']] === null) ? '' : $__vars['set'][$__vars['definition']['field_id']]),
		'multiple' => $__vars['multi'],
		'id' => $__vars['refId'],
		'class' => 'field_' . $__vars['definition']['field_id'],
	), $__compilerTemp1) . '
';
	return $__finalCompiled;
}
),
'custom_fields_edit_radio' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'set' => '!',
		'definition' => '!',
		'editMode' => '!',
		'refId' => '',
		'namePrefix' => 'custom_fields',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__compilerTemp1 = array();
	if (!$__templater->method($__vars['definition'], 'isRequired', array($__vars['editMode'], ))) {
		$__compilerTemp1[] = array(
			'value' => '',
			'label' => 'No selection',
			'_type' => 'option',
		);
	}
	if ($__templater->isTraversable($__vars['definition']['field_choices'])) {
		foreach ($__vars['definition']['field_choices'] AS $__vars['value'] => $__vars['label']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['value'],
				'required' => ($__templater->method($__vars['definition'], 'isRequired', array($__vars['editMode'], )) ? 'required' : ''),
				'label' => $__templater->escape($__vars['label']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formRadio(array(
		'name' => $__vars['namePrefix'] . '[' . $__vars['definition']['field_id'] . ']',
		'value' => (($__vars['set'][$__vars['definition']['field_id']] === null) ? '' : $__vars['set'][$__vars['definition']['field_id']]),
		'class' => 'field_' . $__vars['definition']['field_id'],
		'role' => 'radiogroup',
		'aria-labelledby' => $__vars['refId'],
		'listclass' => 'listColumns',
	), $__compilerTemp1) . '
';
	return $__finalCompiled;
}
),
'custom_fields_edit_checkbox' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'set' => '!',
		'definition' => '!',
		'editMode' => '!',
		'refId' => '',
		'namePrefix' => 'custom_fields',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__compilerTemp1 = $__templater->mergeChoiceOptions(array(), $__vars['definition']['field_choices']);
	$__finalCompiled .= $__templater->formCheckBox(array(
		'name' => $__vars['namePrefix'] . '[' . $__vars['definition']['field_id'] . ']',
		'value' => $__vars['set'][$__vars['definition']['field_id']],
		'required' => ($__templater->method($__vars['definition'], 'isRequired', array($__vars['editMode'], )) ? 'required' : ''),
		'role' => 'group',
		'aria-labelledby' => $__vars['refId'],
		'listclass' => 'field_' . $__vars['definition']['field_id'] . ' listColumns',
	), $__compilerTemp1) . '
';
	return $__finalCompiled;
}
),
'custom_fields_edit_multiselect' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'set' => '!',
		'definition' => '!',
		'editMode' => '!',
		'refId' => '',
		'namePrefix' => 'custom_fields',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	' . $__templater->callMacro(null, 'custom_fields_edit_select', array(
		'set' => $__vars['set'],
		'definition' => $__vars['definition'],
		'editMode' => $__vars['editMode'],
		'refId' => $__vars['refId'],
		'multi' => '1',
		'namePrefix' => $__vars['namePrefix'],
	), $__vars) . '
';
	return $__finalCompiled;
}
),
'custom_fields_edit_stars' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'set' => '!',
		'definition' => '!',
		'editMode' => '!',
		'refId' => '',
		'namePrefix' => 'custom_fields',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->callMacro('rating_macros', 'rating', array(
		'name' => $__vars['namePrefix'] . '[' . $__vars['definition']['field_id'] . ']',
		'controlId' => $__vars['refId'],
		'currentRating' => $__vars['set'][$__vars['definition']['field_id']],
		'deselectable' => ($__templater->method($__vars['definition'], 'isRequired', array($__vars['editMode'], )) ? 'false' : 'true'),
		'row' => false,
	), $__vars) . '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . '

' . '

' . '

' . '

' . '

' . '

' . '

' . '

' . '

' . '

' . '

' . '

' . '

';
	return $__finalCompiled;
}
);