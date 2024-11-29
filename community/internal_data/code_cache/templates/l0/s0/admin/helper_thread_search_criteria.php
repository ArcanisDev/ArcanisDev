<?php
// FROM HASH: 7c554bfdc9dfbb3bc9265d66b35c3d00
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<hr class="formRowSep" />

' . $__templater->formTextBoxRow(array(
		'name' => 'criteria[title]',
		'value' => $__vars['criteria']['title'],
		'type' => 'search',
	), array(
		'label' => 'Title',
	)) . '

' . $__templater->callMacro('public:prefix_macros', 'row', array(
		'includeAny' => true,
		'prefixes' => $__vars['prefixes']['prefixesGrouped'],
		'selected' => $__vars['criteria']['prefix_id'],
		'name' => 'criteria[prefix_id]',
		'type' => 'thread',
		'multiple' => true,
	), $__vars) . '

' . $__templater->formTokenInputRow(array(
		'name' => 'criteria[tags]',
		'value' => $__vars['criteria']['tags'],
		'href' => $__templater->func('link_type', array('public', 'misc/tag-auto-complete', ), false),
	), array(
		'label' => 'Tags',
	)) . '

<div class="formRowSep"></div>

';
	$__compilerTemp1 = $__templater->mergeChoiceOptions(array(), $__vars['threadTypes']);
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
		'name' => 'criteria[thread_type]',
		'value' => $__vars['criteria']['thread_type'],
		'listclass' => 'listColumns',
	), $__compilerTemp1, array(
		'label' => 'Thread type',
	)) . '

<div class="formRowSep"></div>

';
	$__compilerTemp2 = array(array(
		'value' => '0',
		'label' => $__vars['xf']['language']['parenthesis_open'] . 'Any' . $__vars['xf']['language']['parenthesis_close'],
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['forums'])) {
		foreach ($__vars['forums'] AS $__vars['forum']) {
			$__compilerTemp2[] = array(
				'value' => $__vars['forum']['value'],
				'disabled' => $__vars['forum']['disabled'],
				'label' => $__templater->escape($__vars['forum']['label']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formRow('

	<ul class="inputList">
		<li>' . $__templater->formRadio(array(
		'name' => 'criteria[node_id][search_type]',
		'value' => (($__templater->func('is_array', array($__vars['criteria']['node_id'], ), false) ? $__vars['criteria']['node_id']['search_type'] : '') ?: 'include'),
		'listclass' => 'inputChoices--inline',
	), array(array(
		'value' => 'include',
		'label' => 'Include selected',
		'_type' => 'option',
	),
	array(
		'value' => 'exclude',
		'label' => 'Exclude selected',
		'_type' => 'option',
	))) . '</li>

		<li>' . $__templater->formSelect(array(
		'name' => 'criteria[node_id]',
		'value' => ($__templater->func('is_array', array($__vars['criteria']['node_id'], ), false) ? $__templater->filter($__vars['criteria']['node_id'], array(array('numeric_keys_only', array()),), false) : $__vars['criteria']['node_id']),
		'multiple' => 'true',
		'size' => '8',
	), $__compilerTemp2) . '</li>
	</ul>
', array(
		'label' => 'Forum',
	)) . '

<div class="formRowSep"></div>

' . $__templater->formTextBoxRow(array(
		'name' => 'criteria[username]',
		'value' => $__vars['criteria']['username'],
		'type' => 'search',
	), array(
		'label' => 'Created by',
	)) . '

';
	$__compilerTemp3 = array();
	if ($__templater->isTraversable($__vars['userGroups'])) {
		foreach ($__vars['userGroups'] AS $__vars['userGroup']) {
			$__compilerTemp3[] = array(
				'value' => $__vars['userGroup']['user_group_id'],
				'label' => $__templater->escape($__vars['userGroup']['title']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
		'name' => 'criteria[starter_user_group_id]',
		'value' => $__vars['criteria']['starter_user_group_id'],
		'listclass' => 'listColumns',
	), $__compilerTemp3, array(
		'label' => 'Thread creator in user groups',
		'explain' => 'True if the thread creator is in one or more of the selected groups.',
	)) . '

';
	$__compilerTemp4 = array();
	if ($__templater->isTraversable($__vars['userGroups'])) {
		foreach ($__vars['userGroups'] AS $__vars['userGroup']) {
			$__compilerTemp4[] = array(
				'value' => $__vars['userGroup']['user_group_id'],
				'label' => $__templater->escape($__vars['userGroup']['title']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
		'name' => 'criteria[starter_not_user_group_id]',
		'value' => $__vars['criteria']['starter_not_user_group_id'],
		'listclass' => 'listColumns',
	), $__compilerTemp4, array(
		'label' => 'Thread creator not in user groups',
		'explain' => 'True if the thread creator is not in any of the selected groups.',
	)) . '

<hr class="formRowSep" />

' . $__templater->formRow('
	<div class="inputGroup">
		' . $__templater->formDateInput(array(
		'name' => 'criteria[post_date][start]',
		'value' => $__vars['criteria']['post_date']['start'],
		'size' => '15',
	)) . '
		<span class="inputGroup-text">-</span>
		' . $__templater->formDateInput(array(
		'name' => 'criteria[post_date][end]',
		'value' => $__vars['criteria']['post_date']['end'],
		'size' => '15',
	)) . '
	</div>
', array(
		'rowtype' => 'input',
		'label' => 'Created between',
	)) . '

' . $__templater->formRow('
	<div class="inputGroup inputGroup--auto">
		' . $__templater->formNumberBox(array(
		'name' => 'criteria[posted_in_last][value]',
		'value' => $__vars['criteria']['posted_in_last']['value'],
		'size' => '5',
		'min' => '0',
	)) . '
		<span class="inputGroup-splitter"></span>
		' . $__templater->formSelect(array(
		'name' => 'criteria[posted_in_last][unit]',
		'value' => $__vars['criteria']['posted_in_last']['unit'],
	), array(array(
		'value' => 'hour',
		'label' => 'Hours',
		'_type' => 'option',
	),
	array(
		'value' => 'day',
		'label' => 'Days',
		'_type' => 'option',
	),
	array(
		'value' => 'week',
		'label' => 'Weeks',
		'_type' => 'option',
	),
	array(
		'value' => 'month',
		'label' => 'Months',
		'_type' => 'option',
	),
	array(
		'value' => 'year',
		'label' => 'Years',
		'_type' => 'option',
	))) . '
	</div>
', array(
		'rowtype' => 'input',
		'label' => 'Created in last',
		'explain' => 'Use 0 to specify no restriction.',
	)) . '

<div class="formRowSep"></div>

' . $__templater->formRow('
	<div class="inputGroup">
		' . $__templater->formDateInput(array(
		'name' => 'criteria[last_post_date][start]',
		'value' => $__vars['criteria']['last_post_date']['start'],
		'size' => '15',
	)) . '
		<span class="inputGroup-text">-</span>
		' . $__templater->formDateInput(array(
		'name' => 'criteria[last_post_date][end]',
		'value' => $__vars['criteria']['last_post_date']['end'],
		'size' => '15',
	)) . '
	</div>
', array(
		'rowtype' => 'input',
		'label' => 'Last post between',
	)) . '

' . $__templater->formRow('
	<div class="inputGroup inputGroup--auto">
		' . $__templater->formNumberBox(array(
		'name' => 'criteria[last_post_in_last][value]',
		'value' => $__vars['criteria']['last_post_in_last']['value'],
		'size' => '5',
		'min' => '0',
	)) . '
		<span class="inputGroup-splitter"></span>
		' . $__templater->formSelect(array(
		'name' => 'criteria[last_post_in_last][unit]',
		'value' => $__vars['criteria']['last_post_in_last']['unit'],
	), array(array(
		'value' => 'hour',
		'label' => 'Hours',
		'_type' => 'option',
	),
	array(
		'value' => 'day',
		'label' => 'Days',
		'_type' => 'option',
	),
	array(
		'value' => 'week',
		'label' => 'Weeks',
		'_type' => 'option',
	),
	array(
		'value' => 'month',
		'label' => 'Months',
		'_type' => 'option',
	),
	array(
		'value' => 'year',
		'label' => 'Years',
		'_type' => 'option',
	))) . '
	</div>
', array(
		'rowtype' => 'input',
		'label' => 'Last post in last',
		'explain' => 'Use 0 to specify no restriction.',
	)) . '

<hr class="formRowSep" />

' . $__templater->formRow('
	<div class="inputGroup">
		' . $__templater->formNumberBox(array(
		'name' => 'criteria[reply_count][start]',
		'value' => $__vars['criteria']['reply_count']['start'],
		'size' => '5',
		'min' => '0',
	)) . '
		<span class="inputGroup-text">-</span>
		' . $__templater->formNumberBox(array(
		'name' => 'criteria[reply_count][end]',
		'value' => $__vars['criteria']['reply_count']['end'],
		'size' => '5',
		'min' => '-1',
	)) . '
	</div>
', array(
		'rowtype' => 'input',
		'label' => 'Reply count between',
		'explain' => 'Use -1 to specify no maximum.',
	)) . '

' . $__templater->formRow('
	<div class="inputGroup">
		' . $__templater->formNumberBox(array(
		'name' => 'criteria[vote_score][start]',
		'value' => $__vars['criteria']['vote_score']['start'],
		'size' => '5',
		'step' => 'any',
	)) . '
		<span class="inputGroup-text">-</span>
		' . $__templater->formNumberBox(array(
		'name' => 'criteria[vote_score][end]',
		'value' => $__vars['criteria']['vote_score']['end'],
		'size' => '5',
		'step' => 'any',
	)) . '
	</div>
', array(
		'rowtype' => 'input',
		'label' => 'Vote score between',
	)) . '

' . $__templater->formRow('
	<div class="inputGroup">
		' . $__templater->formNumberBox(array(
		'name' => 'criteria[first_post_reaction_score][start]',
		'value' => $__vars['criteria']['first_post_reaction_score']['start'],
		'size' => '5',
		'step' => 'any',
	)) . '
		<span class="inputGroup-text">-</span>
		' . $__templater->formNumberBox(array(
		'name' => 'criteria[first_post_reaction_score][end]',
		'value' => $__vars['criteria']['first_post_reaction_score']['end'],
		'size' => '5',
		'step' => 'any',
	)) . '
	</div>
', array(
		'rowtype' => 'input',
		'label' => 'First post reaction score between',
	)) . '

' . $__templater->formRow('
	<div class="inputGroup">
		' . $__templater->formNumberBox(array(
		'name' => 'criteria[view_count][start]',
		'value' => $__vars['criteria']['view_count']['start'],
		'size' => '5',
		'min' => '0',
	)) . '
		<span class="inputGroup-text">-</span>
		' . $__templater->formNumberBox(array(
		'name' => 'criteria[view_count][end]',
		'value' => $__vars['criteria']['view_count']['end'],
		'size' => '5',
		'min' => '-1',
	)) . '
	</div>
', array(
		'rowtype' => 'input',
		'label' => 'View count between',
		'explain' => 'Use -1 to specify no maximum.',
	)) . '

<hr class="formRowSep" />

' . $__templater->formCheckBoxRow(array(
		'name' => 'criteria[discussion_state]',
		'value' => $__vars['criteria']['discussion_state'],
	), array(array(
		'value' => 'visible',
		'label' => 'Visible',
		'_type' => 'option',
	),
	array(
		'value' => 'deleted',
		'label' => 'Deleted',
		'_type' => 'option',
	),
	array(
		'value' => 'moderated',
		'label' => 'Moderated',
		'_type' => 'option',
	)), array(
		'label' => 'State',
	)) . '

' . $__templater->formCheckBoxRow(array(
		'name' => 'criteria[discussion_open]',
		'value' => $__vars['criteria']['discussion_open'],
	), array(array(
		'value' => '1',
		'label' => 'Unlocked',
		'_type' => 'option',
	),
	array(
		'value' => '0',
		'label' => 'Locked',
		'_type' => 'option',
	)), array(
		'label' => 'Locked',
	)) . '

' . $__templater->formCheckBoxRow(array(
		'name' => 'criteria[sticky]',
		'value' => $__vars['criteria']['sticky'],
	), array(array(
		'value' => '0',
		'label' => 'Not sticky',
		'_type' => 'option',
	),
	array(
		'value' => '1',
		'label' => 'Sticky',
		'_type' => 'option',
	)), array(
		'label' => 'Sticky',
	)) . '

';
	$__compilerTemp5 = '';
	$__compilerTemp5 .= '
		';
	$__compilerTemp6 = $__templater->method($__templater->method($__vars['xf']['app']['em'], 'getRepository', array('XF:ThreadField', )), 'getDisplayGroups', array());
	if ($__templater->isTraversable($__compilerTemp6)) {
		foreach ($__compilerTemp6 AS $__vars['fieldGroup'] => $__vars['phrase']) {
			$__compilerTemp5 .= '
			';
			$__vars['customFields'] = $__templater->method($__vars['xf']['app'], 'getCustomFields', array('threads', $__vars['fieldGroup'], ));
			$__compilerTemp5 .= '
			';
			$__compilerTemp7 = '';
			$__compilerTemp7 .= '
					';
			if ($__templater->isTraversable($__vars['customFields'])) {
				foreach ($__vars['customFields'] AS $__vars['fieldId'] => $__vars['fieldDefinition']) {
					$__compilerTemp7 .= '
						';
					$__vars['choices'] = $__vars['fieldDefinition']['field_choices'];
					$__compilerTemp7 .= '
						';
					$__vars['fieldName'] = 'criteria[thread_field]' . ((($__vars['choices'] AND ($__vars['fieldDefinition']['type_group'] != 'multiple'))) ? '[exact]' : '') . '[' . $__vars['fieldId'] . ']';
					$__compilerTemp7 .= '
						';
					$__compilerTemp8 = '';
					if (!$__vars['choices']) {
						$__compilerTemp8 .= '
								' . $__templater->formTextBox(array(
							'name' => $__vars['fieldName'],
							'value' => $__vars['criteria']['thread_field'][$__vars['fieldId']],
						)) . '
							';
					} else {
						$__compilerTemp8 .= '
								';
						$__compilerTemp9 = array();
						if ($__templater->isTraversable($__vars['choices'])) {
							foreach ($__vars['choices'] AS $__vars['val'] => $__vars['choice']) {
								$__compilerTemp9[] = array(
									'value' => (($__vars['fieldDefinition']['type_group'] == 'multiple') ? (((('s:' . $__templater->func('strlen', array($__vars['val'], ), false)) . ':"') . $__vars['val']) . '"') : $__vars['val']),
									'label' => $__templater->escape($__vars['choice']),
									'_type' => 'option',
								);
							}
						}
						$__compilerTemp8 .= $__templater->formCheckBox(array(
							'name' => $__vars['fieldName'],
							'value' => (($__vars['fieldDefinition']['type_group'] != 'multiple') ? $__vars['criteria']['thread_field']['exact'][$__vars['fieldId']] : $__vars['criteria']['thread_field'][$__vars['fieldId']]),
							'listclass' => 'listColumns',
						), $__compilerTemp9) . '
							';
					}
					$__compilerTemp7 .= $__templater->formRow('
							' . $__compilerTemp8 . '
						', array(
						'rowtype' => 'input',
						'label' => $__templater->escape($__vars['fieldDefinition']['title']),
					)) . '
					';
				}
			}
			$__compilerTemp7 .= '
				';
			if (strlen(trim($__compilerTemp7)) > 0) {
				$__compilerTemp5 .= '
				' . $__compilerTemp7 . '
			';
			}
			$__compilerTemp5 .= '
		';
		}
	}
	$__compilerTemp5 .= '
	';
	if (strlen(trim($__compilerTemp5)) > 0) {
		$__finalCompiled .= '
	<hr class="formRowSep" />
	' . $__compilerTemp5 . '
';
	}
	return $__finalCompiled;
}
);