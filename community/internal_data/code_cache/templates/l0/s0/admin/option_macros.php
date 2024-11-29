<?php
// FROM HASH: ebfad7a37a41ea18296e03e8cda2ea64
return array(
'macros' => array('option_row' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'group' => '',
		'option' => '!',
		'includeAddOnHint' => true,
		'forceShowAdvanced' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['formatParams'] = $__vars['option']['formatParams'];
	$__finalCompiled .= '
	';
	$__vars['rowClass'] = ((($__vars['option']['advanced'] AND (!$__vars['forceShowAdvanced']))) ? 'acp--advanced' : '');
	$__finalCompiled .= '
	';
	$__vars['inputName'] = $__templater->preEscaped($__templater->callMacro(null, 'input_name', array(
		'id' => $__vars['option']['option_id'],
	), $__vars));
	$__finalCompiled .= '
	';
	$__vars['listedHtml'] = $__templater->preEscaped('
		' . $__templater->callMacro(null, 'listed_html', array(
		'id' => $__vars['option']['option_id'],
	), $__vars) . '
	');
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	if ($__templater->method($__vars['option'], 'canEdit', array())) {
		$__compilerTemp1 .= '
			' . $__templater->callMacro(null, 'option_edit_link', array(
			'group' => $__vars['group'],
			'option' => $__vars['option'],
		), $__vars) . '
		';
	}
	$__compilerTemp2 = '';
	if ($__vars['includeAddOnHint'] AND ($__vars['group'] AND ($__vars['option']['addon_id'] AND (($__vars['option']['addon_id'] != $__vars['group']['addon_id']) AND ($__vars['option']['addon_id'] != 'XF'))))) {
		$__compilerTemp2 .= '
			<span class="formRow-hint-featured">
				<a href="' . $__templater->func('link', array('add-ons/options', $__vars['option']['AddOn'], ), true) . '">' . $__templater->escape($__vars['option']['AddOn']['title']) . '</a>
			</span>
		';
	}
	$__vars['hintHtml'] = $__templater->preEscaped($__templater->func('trim', array('
		' . $__compilerTemp1 . '
		' . $__compilerTemp2 . '
	'), false));
	$__finalCompiled .= '
	';
	$__vars['explainHtml'] = $__templater->preEscaped($__templater->escape($__vars['option']['explain']));
	$__finalCompiled .= '

	<span class="u-anchorTarget" id="' . $__templater->escape($__vars['option']['option_id']) . '"></span>

	';
	if ($__vars['option']['edit_format'] == 'onoff') {
		$__finalCompiled .= '
		' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => $__vars['inputName'],
			'value' => '1',
			'selected' => $__vars['option']['option_value'] == 1,
			'label' => $__templater->escape($__vars['option']['title']),
			'_type' => 'option',
		)), array(
			'hint' => $__templater->escape($__vars['hintHtml']),
			'rowclass' => $__vars['rowClass'],
			'explain' => $__templater->escape($__vars['explainHtml']),
			'finalhtml' => $__templater->escape($__vars['listedHtml']),
		)) . '
	';
	} else if ($__vars['option']['edit_format'] == 'onofftextbox') {
		$__finalCompiled .= '
		';
		$__compilerTemp3 = '';
		if ($__vars['formatParams']['type'] == 'spinbox') {
			$__compilerTemp3 .= '
						' . $__templater->formNumberBox(array(
				'name' => $__vars['inputName'] . '[' . $__vars['formatParams']['value'] . ']',
				'value' => ($__vars['option']['option_value'][$__vars['formatParams']['onoff']] ? $__vars['option']['option_value'][$__vars['formatParams']['value']] : $__templater->filter($__vars['formatParams']['default'], array(array('nl2nl', array()),), false)),
				'min' => $__vars['formatParams']['min'],
				'max' => $__vars['formatParams']['max'],
				'step' => $__vars['formatParams']['step'],
				'data-step' => $__vars['formatParams']['stepOverride'],
				'units' => $__vars['formatParams']['units'],
			)) . '
					';
		} else if ($__vars['formatParams']['type'] == 'textarea') {
			$__compilerTemp3 .= '
						' . $__templater->formTextArea(array(
				'name' => $__vars['inputName'] . '[' . $__vars['formatParams']['value'] . ']',
				'value' => ($__vars['option']['option_value'][$__vars['formatParams']['onoff']] ? $__vars['option']['option_value'][$__vars['formatParams']['value']] : $__templater->filter($__vars['formatParams']['default'], array(array('nl2nl', array()),), false)),
				'maxlength' => $__vars['formatParams']['maxlength'],
				'rows' => $__vars['formatParams']['rows'],
				'autosize' => 'true',
			)) . '
					';
		} else {
			$__compilerTemp3 .= '
						' . $__templater->formTextBox(array(
				'name' => $__vars['inputName'] . '[' . $__vars['formatParams']['value'] . ']',
				'value' => ($__vars['option']['option_value'][$__vars['formatParams']['onoff']] ? $__vars['option']['option_value'][$__vars['formatParams']['value']] : $__templater->filter($__vars['formatParams']['default'], array(array('nl2nl', array()),), false)),
				'placeholder' => $__vars['formatParams']['placeholder'],
				'maxlength' => $__vars['formatParams']['maxlength'],
			)) . '
					';
		}
		$__finalCompiled .= $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => $__vars['inputName'] . '[' . $__vars['formatParams']['onoff'] . ']',
			'value' => '1',
			'selected' => $__vars['option']['option_value'][$__vars['formatParams']['onoff']],
			'label' => $__templater->escape($__vars['option']['title']),
			'_dependent' => array('
					' . $__compilerTemp3 . '
				'),
			'_type' => 'option',
		)), array(
			'hint' => $__templater->escape($__vars['hintHtml']),
			'rowclass' => $__vars['rowClass'],
			'explain' => $__templater->escape($__vars['explainHtml']),
			'finalhtml' => $__templater->escape($__vars['listedHtml']),
		)) . '
	';
	} else if ($__vars['option']['edit_format'] == 'radio') {
		$__finalCompiled .= '
		';
		$__compilerTemp4 = $__templater->mergeChoiceOptions(array(), $__vars['formatParams']);
		$__finalCompiled .= $__templater->formRadioRow(array(
			'name' => $__vars['inputName'],
			'value' => $__vars['option']['option_value'],
		), $__compilerTemp4, array(
			'rowclass' => $__vars['rowClass'],
			'label' => $__templater->escape($__vars['option']['title']),
			'hint' => $__templater->escape($__vars['hintHtml']),
			'explain' => $__templater->escape($__vars['explainHtml']),
			'finalhtml' => $__templater->escape($__vars['listedHtml']),
		)) . '
	';
	} else if ($__vars['option']['edit_format'] == 'select') {
		$__finalCompiled .= '
		';
		$__compilerTemp5 = $__templater->mergeChoiceOptions(array(), $__vars['formatParams']);
		$__finalCompiled .= $__templater->formSelectRow(array(
			'name' => $__vars['inputName'],
			'value' => $__vars['option']['option_value'],
		), $__compilerTemp5, array(
			'rowclass' => $__vars['rowClass'],
			'label' => $__templater->escape($__vars['option']['title']),
			'hint' => $__templater->escape($__vars['hintHtml']),
			'explain' => $__templater->escape($__vars['explainHtml']),
			'finalhtml' => $__templater->escape($__vars['listedHtml']),
		)) . '
	';
	} else if ($__vars['option']['edit_format'] == 'checkbox') {
		$__finalCompiled .= '
		';
		$__compilerTemp6 = array();
		if ($__templater->isTraversable($__vars['formatParams'])) {
			foreach ($__vars['formatParams'] AS $__vars['name'] => $__vars['text']) {
				$__compilerTemp6[] = array(
					'name' => $__vars['inputName'] . '[' . $__vars['name'] . ']',
					'selected' => $__vars['option']['option_value'][$__vars['name']],
					'label' => $__templater->escape($__vars['text']),
					'_type' => 'option',
				);
			}
		}
		$__finalCompiled .= $__templater->formCheckBoxRow(array(
		), $__compilerTemp6, array(
			'rowclass' => $__vars['rowClass'],
			'label' => $__templater->escape($__vars['option']['title']),
			'hint' => $__templater->escape($__vars['hintHtml']),
			'explain' => $__templater->escape($__vars['explainHtml']),
			'finalhtml' => $__templater->escape($__vars['listedHtml']),
		)) . '
	';
	} else if ($__vars['option']['edit_format'] == 'spinbox') {
		$__finalCompiled .= '
		' . $__templater->formNumberBoxRow(array(
			'name' => $__vars['inputName'],
			'value' => $__vars['option']['option_value'],
			'min' => $__vars['formatParams']['min'],
			'max' => $__vars['formatParams']['max'],
			'step' => $__vars['formatParams']['step'],
			'data-step' => $__vars['formatParams']['stepOverride'],
			'units' => $__vars['formatParams']['units'],
		), array(
			'rowclass' => $__vars['rowClass'],
			'label' => $__templater->escape($__vars['option']['title']),
			'hint' => $__templater->escape($__vars['hintHtml']),
			'explain' => $__templater->escape($__vars['explainHtml']),
			'finalhtml' => $__templater->escape($__vars['listedHtml']),
		)) . '
	';
	} else if ($__vars['option']['edit_format'] == 'callback') {
		$__finalCompiled .= '
		';
		$__vars['includeHtml'] = $__templater->preEscaped($__templater->filter($__templater->method($__vars['option'], 'renderDisplayCallback', array(array('explainHtml' => $__vars['explainHtml'], 'hintHtml' => $__vars['hintHtml'], 'listedHtml' => $__vars['listedHtml'], 'inputName' => $__vars['inputName'], 'rowClass' => $__vars['rowClass'], ), )), array(array('raw', array()),), true));
		$__finalCompiled .= '
		';
		if ($__templater->test($__vars['includeHtml'], 'empty', array())) {
			$__finalCompiled .= '
			' . $__templater->formRow('
				<div class="blockMessage blockMessage--error blockMessage--iconic">
					DEBUG: ' . $__templater->escape($__templater->method($__vars['option'], 'getDisplayCallbackError', array())) . '
					' . $__templater->escape($__vars['hintHtml']) . '
				</div>
			', array(
				'rowclass' => $__vars['rowClass'],
			)) . '
		';
		} else {
			$__finalCompiled .= '
			' . $__templater->escape($__vars['includeHtml']) . '
		';
		}
		$__finalCompiled .= '
	';
	} else if ($__vars['option']['edit_format'] == 'template') {
		$__finalCompiled .= '
		';
		$__vars['includeHtml'] = $__templater->preEscaped($__templater->includeTemplate($__vars['formatParams']['template'], $__vars));
		$__finalCompiled .= '
		';
		if ($__templater->test($__vars['includeHtml'], 'empty', array())) {
			$__finalCompiled .= '
			' . $__templater->formRow('
				<div class="blockMessage blockMessage--error blockMessage--iconic">
					DEBUG: Template ' . $__templater->escape($__vars['formatParams']['template']) . ' not found.
					' . $__templater->escape($__vars['hintHtml']) . '
				</div>

			', array(
				'rowclass' => $__vars['rowClass'],
			)) . '
		';
		} else {
			$__finalCompiled .= '
			' . $__templater->escape($__vars['includeHtml']) . '
		';
		}
		$__finalCompiled .= '
	';
	} else if (($__vars['option']['edit_format'] == 'textbox') AND ($__vars['formatParams']['rows'] AND ($__vars['formatParams']['rows'] > 1))) {
		$__finalCompiled .= '
		' . $__templater->formTextAreaRow(array(
			'name' => $__vars['inputName'],
			'value' => $__vars['option']['option_value'],
			'rows' => $__vars['formatParams']['rows'],
			'autosize' => 'true',
			'class' => $__vars['formatParams']['class'],
		), array(
			'rowclass' => $__vars['rowClass'],
			'label' => $__templater->escape($__vars['option']['title']),
			'hint' => $__templater->escape($__vars['hintHtml']),
			'explain' => $__templater->escape($__vars['explainHtml']),
			'finalhtml' => $__templater->escape($__vars['listedHtml']),
		)) . '
	';
	} else if ($__vars['option']['edit_format'] == 'textbox') {
		$__finalCompiled .= '
		' . $__templater->formTextBoxRow(array(
			'name' => $__vars['inputName'],
			'value' => $__vars['option']['option_value'],
			'type' => $__vars['formatParams']['type'],
			'class' => $__vars['formatParams']['class'],
		), array(
			'rowclass' => $__vars['rowClass'],
			'label' => $__templater->escape($__vars['option']['title']),
			'hint' => $__templater->escape($__vars['hintHtml']),
			'explain' => $__templater->escape($__vars['explainHtml']),
			'finalhtml' => $__templater->escape($__vars['listedHtml']),
		)) . '
	';
	} else if ($__vars['option']['edit_format'] == 'username') {
		$__finalCompiled .= '
		';
		$__vars['singleUsername'] = true;
		$__finalCompiled .= '
		';
		if ($__templater->method($__vars['option'], 'isDataTypeNumeric', array())) {
			$__finalCompiled .= '
			';
			$__vars['user'] = $__templater->method($__vars['xf']['app']['em'], 'find', array('XF:User', $__vars['option']['option_value'], ));
			$__finalCompiled .= '
			';
			$__vars['value'] = $__vars['user']['username'];
			$__finalCompiled .= '
		';
		} else if ($__vars['option']['data_type'] == 'array') {
			$__finalCompiled .= '
			';
			$__vars['users'] = $__templater->method($__templater->method($__vars['xf']['app']['em'], 'getRepository', array('XF:User', )), 'getUsersByIdsOrdered', array(($__templater->func('is_array', array($__vars['option']['option_value'], ), false) ? $__vars['option']['option_value'] : array()), ));
			$__finalCompiled .= '
			';
			$__vars['value'] = $__templater->filter($__templater->method($__vars['users'], 'pluckNamed', array('username', )), array(array('join', array(', ', )),), false);
			$__finalCompiled .= '
			';
			$__vars['singleUsername'] = false;
			$__finalCompiled .= '
		';
		} else {
			$__finalCompiled .= '
			';
			$__vars['value'] = $__vars['option']['option_value'];
			$__finalCompiled .= '
		';
		}
		$__finalCompiled .= '

		';
		if ($__vars['singleUsername']) {
			$__finalCompiled .= '
			' . $__templater->formTextBoxRow(array(
				'name' => $__vars['inputName'],
				'value' => $__vars['value'],
				'ac' => 'single',
				'autocomplete' => 'off',
				'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor'], 'username', ), false),
			), array(
				'rowclass' => $__vars['rowClass'],
				'label' => $__templater->escape($__vars['option']['title']),
				'hint' => $__templater->escape($__vars['hintHtml']),
				'explain' => $__templater->escape($__vars['explainHtml']),
				'finalhtml' => $__templater->escape($__vars['listedHtml']),
			)) . '
		';
		} else {
			$__finalCompiled .= '
			' . $__templater->formTokenInputRow(array(
				'name' => $__vars['inputName'],
				'value' => $__vars['value'],
				'href' => $__templater->func('link', array('users/find', ), false),
			), array(
				'rowclass' => $__vars['rowClass'],
				'explain' => $__templater->escape($__vars['explainHtml']),
				'label' => $__templater->escape($__vars['option']['title']),
				'hint' => $__templater->escape($__vars['hintHtml']),
				'finalhtml' => $__templater->escape($__vars['listedHtml']),
			)) . '
		';
		}
		$__finalCompiled .= '
	';
	} else {
		$__finalCompiled .= '
		' . $__templater->formRow('
			<div class="blockMessage blockMessage--error blockMessage--iconic">
				DEBUG: Unknown edit format ' . $__templater->escape($__vars['option']['edit_format']) . '.
				' . $__templater->escape($__vars['hintHtml']) . '
			</div>
		', array(
		)) . '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'input_name' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'id' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= 'options[' . $__templater->escape($__vars['id']) . ']';
	return $__finalCompiled;
}
),
'listed_html' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'id' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formHiddenVal('options_listed[]', $__vars['id'], array(
	));
	return $__finalCompiled;
}
),
'option_edit_link' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'group' => '',
		'option' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__vars['group']) {
		$__finalCompiled .= '
		' . ($__vars['option']['advanced'] ? '(adv)' : '') . ' ' . $__templater->escape($__vars['option']['option_id']) . ' ' . $__templater->filter($__vars['option']['Relations'][$__vars['group']['group_id']]['display_order'], array(array('parens', array()),), true) . '
	';
	}
	$__finalCompiled .= '
	<a href="' . $__templater->func('link', array('options/edit', $__vars['option'], ($__vars['group'] ? array('group_id' => $__vars['group']['group_id'], ) : array()), ), true) . '"
		title="' . $__templater->escape($__vars['option']['option_id']) . ($__vars['group'] ? (' / ' . $__templater->escape($__vars['option']['Relations'][$__vars['group']['group_id']]['display_order'])) : '') . '"
		data-xf-init="tooltip"
	>' . 'Edit' . '</a>
';
	return $__finalCompiled;
}
),
'option_form' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'group' => '',
		'options' => '!',
		'formClass' => '',
		'forceShowAdvanced' => true,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['options'])) {
		foreach ($__vars['options'] AS $__vars['option']) {
			$__compilerTemp1 .= '
			' . $__templater->callMacro(null, 'option_row', array(
				'group' => $__vars['group'],
				'option' => $__vars['option'],
				'forceShowAdvanced' => $__vars['forceShowAdvanced'],
			), $__vars) . '
		';
		}
	}
	$__finalCompiled .= $__templater->form('
		' . $__compilerTemp1 . '
		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	', array(
		'action' => $__templater->func('link', array('options/update', ), false),
		'ajax' => 'true',
		'class' => $__vars['formClass'],
	)) . '
';
	return $__finalCompiled;
}
),
'option_form_block' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'group' => '',
		'options' => '!',
		'containerBeforeHtml' => '',
		'forceShowAdvanced' => true,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__vars['hundred'] = '0';
	$__finalCompiled .= '

	';
	if (!$__templater->test($__vars['options'], 'empty', array())) {
		$__finalCompiled .= '
		';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['options'])) {
			foreach ($__vars['options'] AS $__vars['option']) {
				$__compilerTemp1 .= '

						';
				if ($__vars['group']) {
					$__compilerTemp1 .= '
							';
					$__vars['curHundred'] = $__templater->func('floor', array($__vars['option']['Relations'][$__vars['group']['group_id']]['display_order'] / 100, ), false);
					$__compilerTemp1 .= '
							';
					if (($__vars['curHundred'] > $__vars['hundred'])) {
						$__compilerTemp1 .= '
								';
						$__vars['hundred'] = $__vars['curHundred'];
						$__compilerTemp1 .= '
								<hr class="formRowSep" />
							';
					}
					$__compilerTemp1 .= '
						';
				}
				$__compilerTemp1 .= '

						' . $__templater->callMacro(null, 'option_row', array(
					'group' => $__vars['group'],
					'option' => $__vars['option'],
					'forceShowAdvanced' => $__vars['forceShowAdvanced'],
				), $__vars) . '
					';
			}
		}
		$__compilerTemp2 = '';
		if (!$__vars['forceShowAdvanced']) {
			$__compilerTemp2 .= '
				';
			$__vars['advancedCount'] = 0;
			$__compilerTemp2 .= '
				';
			if ($__templater->isTraversable($__vars['options'])) {
				foreach ($__vars['options'] AS $__vars['option']) {
					if ($__vars['option']['advanced']) {
						$__vars['advancedCount'] = ($__vars['advancedCount'] + 1);
					}
				}
			}
			$__compilerTemp2 .= '
				';
			if ($__vars['advancedCount'] > 0) {
				$__compilerTemp2 .= '
					<div class="block-outer block-outer--after acp--simple">
						<div class="block-outer-middle block-outer-hint">
							' . 'This list contains advanced options which may be hidden.' . '
							<a tabindex="0" role="button" data-xf-init="admin-toggle-advanced" data-value="1" data-url="' . $__templater->func('link', array('account/toggle-advanced', ), true) . '">' . 'Enable advanced mode.' . '</a>
						</div>
					</div>
				';
			}
			$__compilerTemp2 .= '
			';
		}
		$__finalCompiled .= $__templater->form('
			<div class="block-container">
				' . $__templater->filter($__vars['containerBeforeHtml'], array(array('raw', array()),), true) . '
				<div class="block-body">
					' . $__compilerTemp1 . '
				</div>
				' . $__templater->formSubmitRow(array(
			'sticky' => 'true',
			'icon' => 'save',
		), array(
		)) . '
			</div>

			' . $__compilerTemp2 . '
		', array(
			'action' => $__templater->func('link', array('options/update', ), false),
			'ajax' => 'true',
			'class' => 'block',
		)) . '
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

' . '

' . '

' . '

';
	return $__finalCompiled;
}
);