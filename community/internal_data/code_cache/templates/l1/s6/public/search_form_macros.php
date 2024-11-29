<?php
// FROM HASH: e53b2433b1762d8f76c7a80c3f2eea55
return array(
'macros' => array('keywords' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'input' => array(),
		'canTitleLimit' => true,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['controlId'] = $__templater->preEscaped($__templater->func('unique_id', array(), true));
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	if ($__vars['canTitleLimit']) {
		$__compilerTemp1 .= '
				<li>
					';
		$__compilerTemp2 = '';
		if ($__vars['xf']['options']['enableTagging']) {
			$__compilerTemp2 .= '
									<span tabindex="0" role="button"
										data-xf-init="tooltip" data-trigger="hover focus click" title="' . $__templater->filter('Tags will also be searched in content where tags are supported', array(array('for_attr', array()),), true) . '">

										' . $__templater->fontAwesome('far fa-question-circle', array(
				'class' => 'u-muted u-smaller',
			)) . '
									</span>
								';
		}
		$__compilerTemp1 .= $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'name' => 'c[title_only]',
			'selected' => $__vars['input']['c']['title_only'],
			'label' => '
								' . 'Search titles only' . '

								' . $__compilerTemp2 . '
							',
			'_type' => 'option',
		))) . '
				</li>
			';
	}
	$__finalCompiled .= $__templater->formRow('

		<ul class="inputList">
			<li>' . $__templater->formTextBox(array(
		'type' => 'search',
		'name' => 'keywords',
		'value' => $__vars['input']['keywords'],
		'autofocus' => 'autofocus',
		'id' => $__vars['controlId'],
	)) . '</li>
			' . $__compilerTemp1 . '
		</ul>
	', array(
		'rowtype' => 'input',
		'controlid' => $__vars['controlId'],
		'label' => 'Keywords',
	)) . '
';
	return $__finalCompiled;
}
),
'user' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'input' => array(),
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->formTextBoxRow(array(
		'name' => 'c[users]',
		'value' => $__vars['input']['c']['users'],
		'ac' => 'true',
	), array(
		'label' => 'Posted by',
		'explain' => 'You may enter multiple names here.',
	)) . '
';
	return $__finalCompiled;
}
),
'date' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'input' => array(),
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->formDateInputRow(array(
		'name' => 'c[newer_than]',
		'value' => $__vars['input']['c']['newer_than'],
	), array(
		'label' => 'Newer than',
	)) . '

	' . $__templater->formDateInputRow(array(
		'name' => 'c[older_than]',
		'value' => $__vars['input']['c']['older_than'],
	), array(
		'label' => 'Older than',
	)) . '
';
	return $__finalCompiled;
}
),
'order' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'input' => array(),
		'isRelevanceSupported' => '!',
		'options' => array(),
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__vars['isRelevanceSupported'] OR $__templater->func('count', array($__vars['options'], ), false)) {
		$__finalCompiled .= '
		';
		$__compilerTemp1 = array();
		if ($__vars['isRelevanceSupported']) {
			$__compilerTemp1[] = array(
				'value' => 'relevance',
				'label' => 'Relevance',
				'_type' => 'option',
			);
		}
		$__compilerTemp1[] = array(
			'value' => 'date',
			'label' => 'Date',
			'_type' => 'option',
		);
		$__compilerTemp1 = $__templater->mergeChoiceOptions($__compilerTemp1, $__vars['options']);
		$__finalCompiled .= $__templater->formRadioRow(array(
			'name' => 'order',
			'value' => $__templater->filter($__vars['input']['order'], array(array('default', array(($__vars['isRelevanceSupported'] ? 'relevance' : 'date'), )),), false),
		), $__compilerTemp1, array(
			'label' => 'Order by',
		)) . '
	';
	} else {
		$__finalCompiled .= '
		' . $__templater->formHiddenVal('order', $__templater->filter($__vars['input']['order'], array(array('default', array(($__vars['isRelevanceSupported'] ? 'relevance' : 'date'), )),), false), array(
		)) . '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'grouped' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'label' => '!',
		'input' => array(),
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'grouped',
		'value' => '1',
		'selected' => $__vars['input']['grouped'],
		'label' => $__templater->escape($__vars['label']),
		'_type' => 'option',
	)), array(
	)) . '
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

' . '

';
	return $__finalCompiled;
}
);