<?php
// FROM HASH: d2db709b7b61ec300ceb6cb9d3c5e3d3
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formRow('

	<ul class="inputChoices inputChoices--noChoice">
		<li class="inputChoices-choice">
			<div>' . 'Disallowed text in usernames' . $__vars['xf']['language']['label_separator'] . '</div>
			' . $__templater->formTextArea(array(
		'name' => $__vars['inputName'] . '[disallowedNames]',
		'value' => $__vars['option']['option_value']['disallowedNames'],
		'autosize' => 'true',
	)) . '
			<dfn class="inputChoices-explain">' . 'The words or phrases in this field will not be allowed in any part of usernames. Put each word or phrase on its own line. Entering \'tar\' will disallow \'star\' and \'tarnish\' etc.' . '</dfn>
		</li>
		<li class="inputChoices-choice">
			<div>' . 'Username match regular expression' . $__vars['xf']['language']['label_separator'] . '</div>
			' . $__templater->formTextBox(array(
		'name' => $__vars['inputName'] . '[matchRegex]',
		'value' => $__vars['option']['option_value']['matchRegex'],
	)) . '
			<dfn class="inputChoices-explain">' . 'This requires the usernames of new registrations to match the given regular expression. <b>Note</b>: use a full expression, including delimiters and switches.' . '</dfn>
		</li>
	</ul>
', array(
		'label' => $__templater->escape($__vars['option']['title']),
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['explainHtml']),
		'html' => $__templater->escape($__vars['listedHtml']),
		'rowclass' => $__vars['rowClass'],
	));
	return $__finalCompiled;
}
);