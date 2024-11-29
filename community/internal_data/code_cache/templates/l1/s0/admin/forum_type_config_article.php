<?php
// FROM HASH: c4a4d279ec0fb87bba9dbf35f4a19848
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formRadioRow(array(
		'name' => 'type_config[display_style]',
		'value' => $__vars['typeConfig']['display_style'],
	), array(array(
		'value' => 'full',
		'label' => 'Standard',
		'hint' => 'A full size view, displaying as a standard thread list.',
		'_type' => 'option',
	),
	array(
		'value' => 'preview',
		'label' => 'Preview',
		'hint' => 'A grid of blocks showing a preview of the first post content including a cover image, if one is specified.',
		'data-xf-init' => 'disabler',
		'data-hide' => 'true',
		'data-container' => '.js-articlePreviewOptions',
		'_type' => 'option',
	),
	array(
		'value' => 'expanded',
		'label' => 'Expanded',
		'hint' => 'An expanded view, displaying as a list of rendered first posts, with either their complete content or a snippet thereof.',
		'data-xf-init' => 'disabler',
		'data-hide' => 'true',
		'data-container' => '.js-articleExpandedOptions',
		'_type' => 'option',
	)), array(
		'label' => 'Display style',
	)) . '

<div class="js-articlePreviewOptions">
	' . $__templater->formNumberBoxRow(array(
		'name' => 'type_config[expanded_per_page]',
		'value' => $__vars['typeConfig']['expanded_per_page'],
		'min' => '0',
	), array(
		'label' => 'Override articles per page',
		'explain' => 'This allows you to override the number of articles shown per page when viewing this forum. Use 0 to display the standard amount.',
	)) . '
</div>

<div class="js-articleExpandedOptions">
	' . $__templater->formNumberBoxRow(array(
		'name' => 'type_config[expanded_per_page]',
		'value' => $__vars['typeConfig']['expanded_per_page'],
		'min' => '0',
	), array(
		'label' => 'Override articles per page',
		'explain' => 'This allows you to override the number of articles shown per page when viewing this forum. Use 0 to display the standard amount.',
	)) . '
	' . $__templater->formNumberBoxRow(array(
		'name' => 'type_config[expanded_snippet]',
		'value' => $__vars['typeConfig']['expanded_snippet'],
		'min' => '0',
	), array(
		'label' => 'Article snippet length',
		'explain' => 'The maximum number of characters to display when viewing this forum. Use 0 to display the entire content.',
	)) . '
</div>';
	return $__finalCompiled;
}
);