<?php
// FROM HASH: ebc30c5db3c76766873f743da107065d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formRow('

	' . $__templater->escape($__vars['explainHtml']) . '
', array(
		'label' => $__templater->escape($__vars['option']['title']),
		'hint' => $__templater->escape($__vars['hintHtml']),
		'rowclass' => $__vars['rowClass'],
	));
	return $__finalCompiled;
}
);