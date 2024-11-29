<?php
// FROM HASH: 85b540c2139ced128f0c3f896c60b09a
return array(
'macros' => array('section_list' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'sections' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<ol class="nestable-list">
		';
	if ($__templater->isTraversable($__vars['sections'])) {
		foreach ($__vars['sections'] AS $__vars['id'] => $__vars['section']) {
			$__finalCompiled .= '
			<li class="nestable-item" data-id="' . $__templater->escape($__vars['id']) . '">
				<div class="nestable-handle" aria-label="' . $__templater->filter('Drag handle', array(array('for_attr', array()),), true) . '">' . $__templater->fontAwesome('fa-bars', array(
			)) . '</div>
				<div class="nestable-content">
					' . $__templater->escape($__vars['section']['title']) . '
				</div>
			</li>
		';
		}
	}
	$__finalCompiled .= '
	</ol>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Sort activity summary sections');
	$__finalCompiled .= '

' . $__templater->callMacro('public:nestable_macros', 'setup', array(), $__vars) . '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			<div class="nestable-container" data-xf-init="nestable" data-max-depth="1" data-value-function="serialize">
				' . $__templater->callMacro(null, 'section_list', array(
		'sections' => $__vars['sections'],
	), $__vars) . '
				' . $__templater->formHiddenVal('sections', '', array(
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
		'action' => $__templater->func('link', array('activity-summary/sort', ), false),
		'class' => 'block',
		'ajax' => 'true',
	)) . '

';
	return $__finalCompiled;
}
);