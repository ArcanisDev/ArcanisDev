<?php
// FROM HASH: a1f429fe9815e22a6740792a0a1b98f8
return array(
'extensions' => array('start' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'before_started_by' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'before_date_limit' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'before_type' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'before_sort' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'end' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if (!$__templater->test($__vars['prefixes'], 'empty', array())) {
		$__compilerTemp1 .= '
		<div class="menu-row menu-row--separated">
			' . 'Prefix' . $__vars['xf']['language']['label_separator'] . '
			<div class="u-inputSpacer">
				' . $__templater->callMacro('prefix_macros', 'select', array(
			'prefixes' => $__vars['prefixes'],
			'type' => 'thread',
			'selected' => ($__vars['filters']['prefix_id'] ? $__vars['filters']['prefix_id'] : 0),
			'name' => 'prefix_id',
			'noneLabel' => $__vars['xf']['language']['parenthesis_open'] . 'Any' . $__vars['xf']['language']['parenthesis_close'],
		), $__vars) . '
			</div>
		</div>
	';
	}
	$__compilerTemp2 = '';
	if ($__vars['filters']['no_date_limit']) {
		$__compilerTemp2 .= '
				';
		$__vars['lastDays'] = '';
		$__compilerTemp2 .= '
			';
	} else {
		$__compilerTemp2 .= '
				';
		$__vars['lastDays'] = ($__vars['filters']['last_days'] ?: $__vars['forum']['list_date_limit_days']);
		$__compilerTemp2 .= '
			';
	}
	$__compilerTemp3 = '';
	if ($__templater->func('count', array($__vars['allowedThreadTypes'], ), false) > 1) {
		$__compilerTemp3 .= '
		<div class="menu-row menu-row--separated">
			<label for="ctrl_thread_type">' . 'Thread type' . $__vars['xf']['language']['label_separator'] . '</label>
			<div class="u-inputSpacer">
				';
		$__compilerTemp4 = array(array(
			'value' => '',
			'label' => $__vars['xf']['language']['parenthesis_open'] . 'Any' . $__vars['xf']['language']['parenthesis_close'],
			'_type' => 'option',
		));
		if ($__templater->isTraversable($__vars['allowedThreadTypes'])) {
			foreach ($__vars['allowedThreadTypes'] AS $__vars['threadTypeId'] => $__vars['threadType']) {
				$__compilerTemp4[] = array(
					'value' => $__vars['threadTypeId'],
					'label' => $__templater->escape($__templater->method($__vars['threadType'], 'getTypeTitle', array())),
					'_type' => 'option',
				);
			}
		}
		$__compilerTemp3 .= $__templater->formSelect(array(
			'name' => 'thread_type',
			'value' => $__vars['filters']['thread_type'],
			'id' => 'ctrl_thread_type',
		), $__compilerTemp4) . '
			</div>
		</div>
	';
	}
	$__compilerTemp5 = array();
	if ($__templater->isTraversable($__vars['sortOptions'])) {
		foreach ($__vars['sortOptions'] AS $__vars['sortKey'] => $__vars['null']) {
			$__compilerTemp5[] = array(
				'value' => $__vars['sortKey'],
				'label' => $__templater->func('phrase_dynamic', array('forum_sort.' . $__vars['sortKey'], ), true),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('
	' . $__templater->renderExtension('start', $__vars, $__extensions) . '

	' . '
	' . $__compilerTemp1 . '

	' . $__templater->renderExtension('before_started_by', $__vars, $__extensions) . '

	' . '
	<div class="menu-row menu-row--separated">
		<label for="ctrl_started_by">' . 'Started by' . $__vars['xf']['language']['label_separator'] . '</label>
		<div class="u-inputSpacer">
			' . $__templater->formTextBox(array(
		'name' => 'starter',
		'value' => ($__vars['starterFilter'] ? $__vars['starterFilter']['username'] : ''),
		'ac' => 'single',
		'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor'], 'username', ), false),
		'id' => 'ctrl_started_by',
	)) . '
		</div>
	</div>

	' . $__templater->renderExtension('before_date_limit', $__vars, $__extensions) . '

	' . '
	<div class="menu-row menu-row--separated">
		<label for="ctrl_last_updated">' . 'Last updated' . $__vars['xf']['language']['label_separator'] . '</label>
		<div class="u-inputSpacer">
			' . $__compilerTemp2 . '
			' . $__templater->formSelect(array(
		'name' => 'last_days',
		'value' => $__vars['lastDays'],
		'id' => 'ctrl_last_updated',
	), array(array(
		'value' => '-1',
		'label' => 'Any time',
		'_type' => 'option',
	),
	array(
		'value' => '7',
		'label' => '' . '7' . ' days',
		'_type' => 'option',
	),
	array(
		'value' => '14',
		'label' => '' . '14' . ' days',
		'_type' => 'option',
	),
	array(
		'value' => '30',
		'label' => '' . '30' . ' days',
		'_type' => 'option',
	),
	array(
		'value' => '60',
		'label' => '' . '2' . ' months',
		'_type' => 'option',
	),
	array(
		'value' => '90',
		'label' => '' . '3' . ' months',
		'_type' => 'option',
	),
	array(
		'value' => '182',
		'label' => '' . '6' . ' months',
		'_type' => 'option',
	),
	array(
		'value' => '365',
		'label' => '1 year',
		'_type' => 'option',
	))) . '
		</div>
	</div>

	' . $__templater->renderExtension('before_type', $__vars, $__extensions) . '

	' . '
	' . $__compilerTemp3 . '

	' . $__templater->renderExtension('before_sort', $__vars, $__extensions) . '

	' . '
	<div class="menu-row menu-row--separated">
		' . 'Sort by' . $__vars['xf']['language']['label_separator'] . '
		<div class="inputGroup u-inputSpacer">
			<span class="u-srOnly" id="ctrl_sort_by">' . 'Sort order' . '</span>
			' . $__templater->formSelect(array(
		'name' => 'order',
		'value' => ($__vars['filters']['order'] ?: $__vars['forum']['default_sort_order']),
		'aria-labelledby' => 'ctrl_sort_by',
	), $__compilerTemp5) . '
			<span class="inputGroup-splitter"></span>
			<span class="u-srOnly" id="ctrl_sort_direction">' . 'Sort direction' . '</span>
			' . $__templater->formSelect(array(
		'name' => 'direction',
		'value' => ($__vars['filters']['direction'] ?: $__vars['forum']['default_sort_direction']),
		'aria-labelledby' => 'ctrl_sort_direction',
	), array(array(
		'value' => 'desc',
		'label' => 'Descending',
		'_type' => 'option',
	),
	array(
		'value' => 'asc',
		'label' => 'Ascending',
		'_type' => 'option',
	))) . '
		</div>
	</div>

	' . $__templater->renderExtension('end', $__vars, $__extensions) . '

	<div class="menu-footer">
		<span class="menu-footer-controls">
			' . $__templater->button('Filter', array(
		'type' => 'submit',
		'class' => 'button--primary',
	), '', array(
	)) . '
		</span>
	</div>
	' . $__templater->formHiddenVal('apply', '1', array(
	)) . '
', array(
		'action' => $__templater->func('link', array('forums/filters', $__vars['forum'], ), false),
	));
	return $__finalCompiled;
}
);