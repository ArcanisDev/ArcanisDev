<?php
// FROM HASH: cf633db1b45026e34e73cbf2230fc693
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<hr class="formRowSep" />

';
	if (!$__templater->test($__templater->method($__vars['nodeTree'], 'getFlattened', array(0, )), 'empty', array())) {
		$__finalCompiled .= '
	';
		$__compilerTemp1 = array(array(
			'value' => '0',
			'label' => $__vars['xf']['language']['parenthesis_open'] . 'None' . $__vars['xf']['language']['parenthesis_close'],
			'_type' => 'option',
		));
		$__compilerTemp2 = $__templater->method($__vars['nodeTree'], 'getFlattened', array(0, ));
		if ($__templater->isTraversable($__compilerTemp2)) {
			foreach ($__compilerTemp2 AS $__vars['treeEntry']) {
				$__compilerTemp1[] = array(
					'value' => $__vars['treeEntry']['record']['node_id'],
					'disabled' => ($__vars['treeEntry']['record']['node_type_id'] != 'SearchForum'),
					'label' => $__templater->filter($__templater->func('repeat', array('&nbsp;&nbsp;', $__vars['treeEntry']['depth'], ), false), array(array('raw', array()),), true) . ' ' . $__templater->escape($__vars['treeEntry']['record']['title']),
					'_type' => 'option',
				);
			}
		}
		$__finalCompiled .= $__templater->formSelectRow(array(
			'name' => 'options[node_id]',
			'value' => $__vars['options']['node_id'],
		), $__compilerTemp1, array(
			'label' => 'Search forum',
			'explain' => 'Threads will be displayed from the selected search forum.',
		)) . '
';
	} else {
		$__finalCompiled .= '
	' . $__templater->formRow('
		<div class="block-rowMessage block-rowMessage--important">
			' . 'No search forum nodes have been added yet. <a href="' . $__templater->func('link', array('search-forums/add', ), true) . '">Add one</a>.' . '
		</div>
	', array(
			'label' => 'Search forum',
			'rowtype' => 'button',
		)) . '
';
	}
	$__finalCompiled .= '

' . $__templater->formNumberBoxRow(array(
		'name' => 'options[limit]',
		'value' => $__vars['options']['limit'],
		'min' => '1',
	), array(
		'label' => 'Maximum entries',
	)) . '

' . $__templater->formRadioRow(array(
		'name' => 'options[style]',
		'value' => ($__vars['options']['style'] ?: 'simple'),
	), array(array(
		'value' => 'simple',
		'label' => 'Simple',
		'hint' => 'A simple view, designed for narrow spaces such as sidebars.',
		'_type' => 'option',
	),
	array(
		'value' => 'full',
		'label' => 'Standard',
		'hint' => 'A full size view, displaying as a standard thread list.',
		'_type' => 'option',
	),
	array(
		'value' => 'expanded',
		'label' => 'Expanded',
		'hint' => 'An expanded view, displaying as a list of complete, rendered first posts.
',
		'_dependent' => array($__templater->formCheckBox(array(
	), array(array(
		'name' => 'options[show_expanded_title]',
		'selected' => $__vars['options']['show_expanded_title'],
		'label' => '
				' . 'Display the widget title above the list of threads.' . '
			',
		'_type' => 'option',
	)))),
		'_type' => 'option',
	)), array(
		'label' => 'Display style',
	));
	return $__finalCompiled;
}
);