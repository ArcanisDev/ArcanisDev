<?php
// FROM HASH: 324d3aad3a434e4d32afc8de0877ab1a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Setup DKIM email authentication');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">

			' . $__templater->formTextBoxRow(array(
		'name' => 'domain',
		'value' => ($__vars['option']['option_value']['domain'] ?: $__vars['domain']),
		'required' => 'required',
	), array(
		'label' => 'Domain',
		'explain' => 'In most cases, this will be your board URL or root domain minus any protocols or paths. The URL should look similar to this: example.com',
	)) . '

		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => 'Proceed' . $__vars['xf']['language']['ellipsis'],
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('options/email-dkim-setup', $__vars['option'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);