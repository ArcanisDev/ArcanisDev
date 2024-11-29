<?php
// FROM HASH: fdd9ccc614631b047373c1ec32d17c59
return array(
'macros' => array('find_new_filter_footer' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<hr class="menu-separator" />
	<div class="menu-row">
		' . $__templater->formCheckBox(array(
	), array(array(
		'name' => 'save',
		'label' => 'Save as default',
		'hint' => 'These filters will be used by default whenever you return.',
		'_type' => 'option',
	))) . '
	</div>
	<div class="menu-footer">
		<span class="menu-footer-controls">
			' . $__templater->button('Filter', array(
		'type' => 'submit',
		'class' => 'button--primary',
	), '', array(
	)) . '
		</span>
		' . $__templater->formHiddenVal('skip', '1', array(
	)) . '
	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';

	return $__finalCompiled;
}
);