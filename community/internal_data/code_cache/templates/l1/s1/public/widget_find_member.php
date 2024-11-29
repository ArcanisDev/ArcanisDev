<?php
// FROM HASH: 1f8ca3738d64425c4b91d2638542591c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<h3 class="block-minorHeader">' . $__templater->escape($__vars['title']) . '</h3>
		<div class="block-body block-row">
			' . $__templater->formTextBox(array(
		'type' => 'search',
		'name' => 'username',
		'ac' => 'single',
		'data-autosubmit' => 'true',
		'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor'], 'username', ), false),
		'placeholder' => 'Name' . $__vars['xf']['language']['ellipsis'],
	)) . '
		</div>
	</div>
', array(
		'action' => $__templater->func('link', array('members', ), false),
		'class' => 'block',
		'attributes' => $__templater->func('widget_data', array($__vars['widget'], true, ), false),
	));
	return $__finalCompiled;
}
);