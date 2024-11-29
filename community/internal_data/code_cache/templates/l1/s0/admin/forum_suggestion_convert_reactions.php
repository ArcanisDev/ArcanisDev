<?php
// FROM HASH: 797661ba9c66887e863dd80409c9c2bd
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Convert suggestion reactions to votes');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'This tool will convert reactions on the first post of suggestion threads to suggestion votes. Positive reactions will be converted to upvotes while negative reactions will be converted to downvotes, if enabled. Existing votes and the converted reactions will not be removed.' . '
			', array(
		'rowtype' => 'confirm',
	)) . '
			' . $__templater->formInfoRow('
				' . 'Please confirm that you want to convert suggestion reactions in the following forum' . $__vars['xf']['language']['label_separator'] . '
				<strong><a href="' . $__templater->func('link', array('forums/edit', $__vars['node'], ), true) . '">' . $__templater->escape($__vars['node']['title']) . '</a></strong>
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'confirm',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('forums/suggestion-convert-reactions', $__vars['node'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);