<?php
// FROM HASH: f1516e683d30edfbfd92d3957c59c3a0
return array(
'macros' => array('progress_bar' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'percentage' => '!',
		'tooltip' => '',
		'label' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeCss('progress_bar.less');
	$__finalCompiled .= '

	<div class="progressBar">
		<div class="progressBar-progress" style="width: ' . $__templater->escape($__vars['percentage']) . '%">
			<span class="progressBar-label"
				data-trigger="' . ($__vars['tooltip'] ? 'hover focus click' : null) . '" data-xf-init="' . ($__vars['tooltip'] ? 'tooltip' : null) . '"
				title="' . ($__templater->escape($__vars['tooltip']) ?: null) . '">
				';
	if ($__vars['label']) {
		$__finalCompiled .= $__templater->escape($__vars['label']);
	}
	$__finalCompiled .= ' ';
	if ($__vars['label'] AND $__vars['tooltip']) {
		$__finalCompiled .= $__templater->fontAwesome('far fa-question-circle', array(
			'class' => 'u-muted u-smaller',
		));
	}
	$__finalCompiled .= '
			</span>
		</div>
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