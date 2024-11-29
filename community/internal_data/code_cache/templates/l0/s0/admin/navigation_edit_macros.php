<?php
// FROM HASH: 80e90c9bb465b9490c1fdcbb1f02221b
return array(
'macros' => array('extra_attrs' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'config' => '!',
		'formPrefix' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['config']['extra_attributes'])) {
		foreach ($__vars['config']['extra_attributes'] AS $__vars['name'] => $__vars['value']) {
			$__compilerTemp1 .= '
				<li class="inputGroup"dir="ltr" >
					' . $__templater->formTextBox(array(
				'name' => $__vars['formPrefix'] . '[extra_attr_names][]',
				'value' => $__vars['name'],
				'size' => '15',
				'code' => 'true',
				'placeholder' => 'Name',
			)) . '
					<span class="inputGroup-splitter"></span>
					' . $__templater->formTextBox(array(
				'name' => $__vars['formPrefix'] . '[extra_attr_values][]',
				'value' => $__vars['value'],
				'size' => '25',
				'code' => 'true',
				'placeholder' => 'Value',
			)) . '
				</li>
			';
		}
	}
	$__finalCompiled .= $__templater->formRow('

		<ul class="listPlain inputGroup-container">
			' . $__compilerTemp1 . '
			<li class="inputGroup" data-xf-init="field-adder" dir="ltr" >
				' . $__templater->formTextBox(array(
		'name' => $__vars['formPrefix'] . '[extra_attr_names][]',
		'size' => '15',
		'code' => 'true',
		'placeholder' => 'Name',
	)) . '
				<span class="inputGroup-splitter"></span>
				' . $__templater->formTextBox(array(
		'name' => $__vars['formPrefix'] . '[extra_attr_values][]',
		'size' => '25',
		'code' => 'true',
		'placeholder' => 'Value',
	)) . '
			</li>
		</ul>
	', array(
		'rowtype' => 'input',
		'label' => 'Extra attributes',
	)) . '
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