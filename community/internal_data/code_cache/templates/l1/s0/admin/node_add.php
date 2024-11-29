<?php
// FROM HASH: bdb8ef7bd589266055bcf15ef5a7ad14
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add node');
	$__finalCompiled .= '

';
	$__compilerTemp1 = array();
	if ($__templater->isTraversable($__vars['nodeTypes'])) {
		foreach ($__vars['nodeTypes'] AS $__vars['nodeType']) {
			if ($__vars['nodeType']['node_type_id'] == 'Forum') {
				$__compilerTemp1[] = array(
					'value' => $__vars['nodeType']['node_type_id'],
					'label' => $__templater->escape($__vars['nodeType']['title']),
					'data-hide' => 'true',
					'data-xf-init' => 'disabler',
					'data-container' => '.js-forumTypes',
					'_type' => 'option',
				);
			} else {
				$__compilerTemp1[] = array(
					'value' => $__vars['nodeType']['node_type_id'],
					'label' => $__templater->escape($__vars['nodeType']['title']),
					'_type' => 'option',
				);
			}
		}
	}
	$__compilerTemp2 = array();
	if ($__templater->isTraversable($__vars['forumTypesInfo'])) {
		foreach ($__vars['forumTypesInfo'] AS $__vars['forumTypeId'] => $__vars['forumTypeInfo']) {
			$__compilerTemp2[] = array(
				'value' => $__vars['forumTypeId'],
				'label' => $__templater->escape($__vars['forumTypeInfo']['title']),
				'hint' => $__templater->escape($__vars['forumTypeInfo']['description']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRadioRow(array(
		'name' => 'node_type_id',
		'value' => $__vars['defaultNodeTypeId'],
	), $__compilerTemp1, array(
		'label' => 'Node type',
		'explain' => 'This cannot be changed once the node has been created.',
	)) . '

			<div class="js-forumTypes">
				' . $__templater->formRadioRow(array(
		'name' => 'forum_type_id',
		'value' => $__vars['defaultForumTypeId'],
	), $__compilerTemp2, array(
		'label' => 'Forum type',
	)) . '
			</div>
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => 'Proceed' . $__vars['xf']['language']['ellipsis'],
	), array(
	)) . '
	</div>
	' . $__templater->formHiddenVal('parent_node_id', $__vars['parentNodeId'], array(
	)) . '
', array(
		'action' => $__templater->func('link', array('nodes/add', ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);