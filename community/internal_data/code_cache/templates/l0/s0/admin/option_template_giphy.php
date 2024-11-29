<?php
// FROM HASH: dfd3259b96212e03fe46e1546da82a86
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => $__vars['inputName'] . '[enabled]',
		'selected' => $__vars['option']['option_value']['enabled'],
		'label' => $__templater->escape($__vars['option']['title']),
		'_dependent' => array('
			<div>' . 'API key' . $__vars['xf']['language']['label_separator'] . '</div>
			' . $__templater->formTextBox(array(
		'name' => $__vars['inputName'] . '[api_key]',
		'value' => $__vars['option']['option_value']['api_key'],
		'required' => 'required',
		'pattern' => '^[a-zA-Z0-9]{32}$',
		'title' => 'Please enter a valid API key',
	)) . '
			<dfn class="formRow-explain">' . 'You must obtain your own key from the <a href="https://developers.giphy.com/dashboard/" target="_blank">GIPHY Developers Dashboard</a> and upgrade it to a production key.' . '</dfn>
		', '
			<div>' . 'Only show GIFs up to and including the following rating' . $__vars['xf']['language']['label_separator'] . '</div>
			' . $__templater->formSelect(array(
		'name' => $__vars['inputName'] . '[rating]',
		'id' => $__vars['option']['option_id'] . '_rating',
		'value' => $__vars['option']['option_value']['rating'],
	), array(array(
		'value' => 'g',
		'label' => 'G - General audiences',
		'_type' => 'option',
	),
	array(
		'value' => 'pg',
		'label' => 'PG - Parental guidance suggested',
		'_type' => 'option',
	),
	array(
		'value' => 'pg-13',
		'label' => 'PG-13 - Parents strongly cautioned',
		'_type' => 'option',
	),
	array(
		'value' => 'r',
		'label' => 'R - Restricted',
		'_type' => 'option',
	))) . '
			<dfn class="formRow-explain">' . 'For an explanation of the ratings visit <a href="https://developers.giphy.com/docs/optional-settings#rating" target="_blank">GIPHY Developers docs</a>.' . '</dfn>
		'),
		'_type' => 'option',
	)), array(
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['explainHtml']),
		'html' => $__templater->escape($__vars['listedHtml']),
		'rowclass' => $__vars['rowClass'],
	));
	return $__finalCompiled;
}
);