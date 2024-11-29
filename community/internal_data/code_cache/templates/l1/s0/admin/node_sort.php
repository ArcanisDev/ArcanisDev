<?php
// FROM HASH: 0cb36a230b8325c005ed9823a88b3028
return array(
'macros' => array('node_list' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'children' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<ol class="nestable-list">
		';
	if ($__templater->isTraversable($__vars['children'])) {
		foreach ($__vars['children'] AS $__vars['id'] => $__vars['child']) {
			$__finalCompiled .= '
			' . $__templater->callMacro(null, 'node_list_entry', array(
				'node' => $__vars['child'],
				'children' => $__vars['child']['children'],
			), $__vars) . '
		';
		}
	}
	$__finalCompiled .= '
	</ol>
';
	return $__finalCompiled;
}
),
'node_list_entry' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'node' => '!',
		'children' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<li class="nestable-item" data-id="' . $__templater->escape($__vars['node']['id']) . '">
		<div class="nestable-handle" aria-label="' . $__templater->filter('Drag handle', array(array('for_attr', array()),), true) . '">' . $__templater->callMacro(null, 'node_list::node_icon', array(
		'node' => $__vars['node']['record'],
	), $__vars) . '</div>
		<div class="nestable-content">
			<strong>' . $__templater->escape($__vars['node']['record']['title']) . '</strong>
			<span class="nestable-label nestable-label--smallest" dir="auto">
				' . $__templater->escape($__vars['node']['record']['NodeType']['title']) . '
				';
	if (($__vars['node']['record']['node_type_id'] == 'Forum') AND ($__vars['node']['record']['Data']['TypeHandler'] AND ($__vars['node']['record']['Data']['forum_type_id'] != 'discussion'))) {
		$__finalCompiled .= '
					(' . $__templater->escape($__templater->method($__vars['node']['record']['Data']['TypeHandler'], 'getTypeTitle', array())) . ')
				';
	}
	$__finalCompiled .= '
			</span>
		</div>
		';
	if (!$__templater->test($__vars['node']['children'], 'empty', array())) {
		$__finalCompiled .= '
			' . $__templater->callMacro(null, 'node_list', array(
			'children' => $__vars['node']['children'],
		), $__vars) . '
		';
	}
	$__finalCompiled .= '
	</li>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Sort nodes');
	$__finalCompiled .= '

' . $__templater->callMacro('public:nestable_macros', 'setup', array(), $__vars) . '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			<div class="nestable-container" data-xf-init="nestable">
				' . $__templater->callMacro(null, 'node_list', array(
		'children' => $__vars['nodeTree'],
	), $__vars) . '
				' . $__templater->formHiddenVal('nodes', '', array(
	)) . '
			</div>
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('nodes/sort', ), false),
		'class' => 'block',
		'ajax' => 'true',
	)) . '

' . '

';
	return $__finalCompiled;
}
);