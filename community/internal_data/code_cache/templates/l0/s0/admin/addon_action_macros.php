<?php
// FROM HASH: 4d2964f868d7d7756b0c51bdc2f3966c
return array(
'macros' => array('summary' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'errors' => array(),
		'warnings' => array(),
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
				' . $__templater->callMacro('addon_action_macros', 'errors', array(
		'errors' => $__vars['errors'],
	), $__vars) . '
				' . $__templater->callMacro('addon_action_macros', 'warnings', array(
		'warnings' => $__vars['warnings'],
	), $__vars) . '
			';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
		<div class="block-row">
			' . $__compilerTemp1 . '
		</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'action' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'errors' => array(),
		'warnings' => array(),
		'submit' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if (!$__vars['errors']) {
		$__finalCompiled .= '
		';
		if ($__vars['warnings']) {
			$__finalCompiled .= '
			<div class="block-body">
				' . $__templater->formCheckBoxRow(array(
			), array(array(
				'name' => 'confirm',
				'data-xf-init' => 'disabler',
				'data-container' => '.js-submitDisable',
				'label' => 'I have reviewed the warnings and I still wish to proceed',
				'_type' => 'option',
			)), array(
				'rowtype' => 'fullWidth noLabel',
			)) . '
			</div>
		';
		}
		$__finalCompiled .= '
		' . $__templater->formSubmitRow(array(
			'submit' => $__templater->escape($__vars['submit']),
		), array(
			'rowtype' => 'simple',
			'rowclass' => 'js-submitDisable',
		)) . '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'errors' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'errors' => array(),
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__vars['errors']) {
		$__finalCompiled .= '
		<div class="block-rowMessage block-rowMessage--error block-rowMessage--iconic">
			' . 'The following errors must be resolved before continuing' . $__vars['xf']['language']['label_separator'] . '
			<ul>
				';
		if ($__templater->isTraversable($__vars['errors'])) {
			foreach ($__vars['errors'] AS $__vars['error']) {
				$__finalCompiled .= '
					<li>' . $__templater->escape($__vars['error']) . '</li>
				';
			}
		}
		$__finalCompiled .= '
			</ul>
		</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'warnings' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'warnings' => array(),
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__vars['warnings']) {
		$__finalCompiled .= '
		<div class="block-rowMessage block-rowMessage--warning block-rowMessage--iconic">
			' . 'To prevent potential issues, please resolve the following warnings before continuing' . $__vars['xf']['language']['label_separator'] . '
			<ul>
				';
		if ($__templater->isTraversable($__vars['warnings'])) {
			foreach ($__vars['warnings'] AS $__vars['warning']) {
				$__finalCompiled .= '
					<li>' . $__templater->escape($__vars['warning']) . '</li>
				';
			}
		}
		$__finalCompiled .= '
			</ul>
		</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . '

' . '

';
	return $__finalCompiled;
}
);