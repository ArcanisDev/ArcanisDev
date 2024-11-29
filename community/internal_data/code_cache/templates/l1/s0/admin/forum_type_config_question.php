<?php
// FROM HASH: 0bd5d56204e3e0089855913c5ff5c37c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'type_config[allow_answer_voting]',
		'selected' => $__vars['typeConfig']['allow_answer_voting'],
		'label' => 'Support answer voting',
		'hint' => 'If enabled, users will be able to vote on the answers given to questions.',
		'_dependent' => array($__templater->formCheckBox(array(
	), array(array(
		'name' => 'type_config[allow_downvote]',
		'selected' => ((!$__vars['typeConfig']['allow_answer_voting']) OR $__vars['typeConfig']['allow_downvote']),
		'label' => 'Allow answers given to votable questions to be downvoted',
		'hint' => 'If disabled, users may only choose to upvote answers.',
		'_type' => 'option',
	)))),
		'_type' => 'option',
	)), array(
	));
	return $__finalCompiled;
}
);