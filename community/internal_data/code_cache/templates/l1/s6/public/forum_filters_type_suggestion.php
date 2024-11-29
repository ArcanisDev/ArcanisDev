<?php
// FROM HASH: aa5567a5c114bd77ac0c02c680b2ae88
return array(
'extends' => function($__templater, array $__vars) { return 'forum_filters'; },
'extensions' => array('before_started_by' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
	';
	if ($__vars['forum']['type_config']['implemented_prefix_ids'] OR $__vars['forum']['type_config']['closed_prefix_ids']) {
		$__finalCompiled .= '
		<div class="menu-row menu-row--separated">
			' . 'Suggestion status' . ':
			<div class="u-inputSpacer">
				';
		$__compilerTemp1 = array(array(
			'value' => '',
			'label' => 'Any',
			'_type' => 'option',
		)
,array(
			'value' => 'open',
			'label' => 'Open',
			'_type' => 'option',
		));
		if ($__vars['forum']['type_config']['implemented_prefix_ids']) {
			$__compilerTemp1[] = array(
				'value' => 'implemented',
				'label' => 'Implemented',
				'_type' => 'option',
			);
		}
		if ($__vars['forum']['type_config']['closed_prefix_ids']) {
			$__compilerTemp1[] = array(
				'value' => 'closed',
				'label' => 'Closed',
				'_type' => 'option',
			);
		}
		$__finalCompiled .= $__templater->formSelect(array(
			'name' => 'suggestion_state',
			'value' => $__vars['filters']['suggestion_state'],
		), $__compilerTemp1) . '
			</div>
		</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
},
'before_date_limit' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
	';
	if ($__vars['xf']['visitor']['user_id']) {
		$__finalCompiled .= '
		<div class="menu-row menu-row--separated">
			' . $__templater->formCheckBox(array(
		), array(array(
			'name' => 'your_votes',
			'selected' => $__vars['filters']['your_votes'],
			'label' => 'Only show suggestions you\'ve voted on',
			'_type' => 'option',
		))) . '
		</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . $__templater->renderExtension('before_started_by', $__vars, $__extensions) . '

' . $__templater->renderExtension('before_date_limit', $__vars, $__extensions);
	return $__finalCompiled;
}
);