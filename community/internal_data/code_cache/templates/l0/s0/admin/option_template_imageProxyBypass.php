<?php
// FROM HASH: e5d42d28fb93cfb89fec19e28b6b47d8
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formRadioRow(array(
		'name' => $__vars['inputName'] . '[bypassType]',
		'value' => $__vars['option']['option_value']['bypassType'],
	), array(array(
		'value' => '',
		'label' => 'Do not bypass image proxy',
		'_type' => 'option',
	),
	array(
		'value' => 'https',
		'label' => 'Bypass all HTTPS requests',
		'_type' => 'option',
	),
	array(
		'value' => 'domains',
		'label' => 'Bypass only the domains listed below' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array('
			' . $__templater->formTextArea(array(
		'name' => $__vars['inputName'] . '[bypassDomains]',
		'value' => $__vars['option']['option_value']['bypassDomains'],
		'rows' => '3',
		'autosize' => 'true',
	)) . '
			<dfn class="inputChoices-explain inputChoices-explain--after">' . 'Place each domain on a separate line. If you start the line with /, the line will be treated as a regular expression (example: /^domain.com$/i). Subdomains will automatically be included unless the regular expression method is used.' . '</dfn>
		'),
		'_type' => 'option',
	)), array(
		'label' => $__templater->escape($__vars['option']['title']),
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['explainHtml']),
		'html' => $__templater->escape($__vars['listedHtml']),
		'rowclass' => $__vars['rowClass'],
	));
	return $__finalCompiled;
}
);