<?php
// FROM HASH: c87b1b8074e193023301eb65331c43b9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Import a style');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['canSupportStyleArchives']) {
		$__compilerTemp1 .= '
				' . $__templater->formUploadRow(array(
			'name' => 'upload',
			'accept' => '.xml,.zip',
		), array(
			'label' => 'Import from uploaded XML or archive file',
		)) . '
			';
	} else {
		$__compilerTemp1 .= '
				' . $__templater->formUploadRow(array(
			'name' => 'upload',
			'accept' => '.xml',
		), array(
			'label' => 'Import from uploaded XML file',
		)) . '
			';
	}
	$__compilerTemp2 = array(array(
		'label' => $__vars['xf']['language']['parenthesis_open'] . 'No parent' . $__vars['xf']['language']['parenthesis_close'],
		'_type' => 'option',
	));
	$__compilerTemp3 = $__templater->method($__vars['styleTree'], 'getFlattened', array(0, ));
	if ($__templater->isTraversable($__compilerTemp3)) {
		foreach ($__compilerTemp3 AS $__vars['treeEntry']) {
			$__compilerTemp2[] = array(
				'value' => $__vars['treeEntry']['record']['style_id'],
				'label' => '
								' . $__templater->func('repeat', array('--', $__vars['treeEntry']['depth'], ), true) . ' ' . $__templater->escape($__vars['treeEntry']['record']['title']) . '
							',
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp4 = array();
	$__compilerTemp5 = $__templater->method($__vars['styleTree'], 'getFlattened', array(0, ));
	if ($__templater->isTraversable($__compilerTemp5)) {
		foreach ($__compilerTemp5 AS $__vars['treeEntry']) {
			$__compilerTemp4[] = array(
				'value' => $__vars['treeEntry']['record']['style_id'],
				'label' => $__templater->func('repeat', array('--', $__vars['treeEntry']['depth'], ), true) . '
								' . $__templater->escape($__vars['treeEntry']['record']['title']) . '
							',
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__compilerTemp1 . '

			' . $__templater->formRadioRow(array(
		'name' => 'target',
	), array(array(
		'value' => 'new',
		'checked' => 'checked',
		'label' => 'Child of style' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formSelect(array(
		'name' => 'parent_style_id',
	), $__compilerTemp2)),
		'_type' => 'option',
	),
	array(
		'value' => 'overwrite',
		'label' => 'Overwrite style',
		'_dependent' => array($__templater->formSelect(array(
		'name' => 'overwrite_style_id',
	), $__compilerTemp4)),
		'_type' => 'option',
	)), array(
		'label' => 'Import as',
	)) . '

			' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'force',
		'label' => 'Skip import checks',
		'hint' => 'Selecting this will bypass checks made by the import process to prevent accidents. Select this only if you understand what you are bypassing.',
		'_type' => 'option',
	)), array(
	)) . '

		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'import',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('styles/import', ), false),
		'upload' => 'true',
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);