<?php
// FROM HASH: 2ee6baf56c1d8b945fc1869e1c93a8b5
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'type_config[allow_downvote]',
		'selected' => $__vars['typeConfig']['allow_downvote'],
		'label' => 'Allow suggestions to be downvoted',
		'hint' => 'If disabled, users may only choose to upvote suggestions.',
		'_type' => 'option',
	)), array(
	)) . '

';
	if (!$__templater->test($__vars['prefixesGrouped'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__templater->includeCss('public:select2.less');
		$__finalCompiled .= '
	';
		$__templater->includeJs(array(
			'prod' => 'xf/token_input-compiled.js',
			'dev' => 'vendor/select2/select2.full.js, xf/token_input.js',
		));
		$__finalCompiled .= '

	';
		$__compilerTemp1 = array();
		if ($__templater->isTraversable($__vars['prefixGroups'])) {
			foreach ($__vars['prefixGroups'] AS $__vars['prefixGroupId'] => $__vars['prefixGroup']) {
				if (($__templater->func('count', array($__vars['prefixesGrouped'][$__vars['prefixGroupId']], ), false) > 0)) {
					$__compilerTemp1[] = array(
						'label' => (($__vars['prefixGroupId'] > 0) ? $__vars['prefixGroup']['title'] : 'Ungrouped'),
						'_type' => 'optgroup',
						'options' => array(),
					);
					end($__compilerTemp1); $__compilerTemp2 = key($__compilerTemp1);
					if ($__templater->isTraversable($__vars['prefixesGrouped'][$__vars['prefixGroupId']])) {
						foreach ($__vars['prefixesGrouped'][$__vars['prefixGroupId']] AS $__vars['prefixId'] => $__vars['prefix']) {
							$__compilerTemp1[$__compilerTemp2]['options'][] = array(
								'value' => $__vars['prefixId'],
								'disabled' => (!$__templater->func('in_array', array($__vars['prefixId'], $__vars['forum']['prefix_cache'], ), false)),
								'label' => $__templater->escape($__vars['prefix']['title']),
								'_type' => 'option',
							);
						}
					}
				}
			}
		}
		$__finalCompiled .= $__templater->formRow('

		' . $__templater->formSelect(array(
			'name' => 'type_config[implemented_prefix_ids][]',
			'data-xf-init' => 'token-input-select',
			'multiple' => 'multiple',
			'value' => $__vars['typeConfig']['implemented_prefix_ids'],
			'class' => 'js-availablePrefixSelect',
		), $__compilerTemp1) . '
	', array(
			'label' => 'Implemented prefixes',
			'explain' => 'These prefixes represent a suggestion that has been implemented. Users may quickly filter down to see only the suggestions that have been implemented. Implemented suggestions will no longer be votable. Only available prefixes can be selected.',
			'rowtype' => 'input',
		)) . '

	';
		$__compilerTemp3 = array();
		if ($__templater->isTraversable($__vars['prefixGroups'])) {
			foreach ($__vars['prefixGroups'] AS $__vars['prefixGroupId'] => $__vars['prefixGroup']) {
				if (($__templater->func('count', array($__vars['prefixesGrouped'][$__vars['prefixGroupId']], ), false) > 0)) {
					$__compilerTemp3[] = array(
						'label' => (($__vars['prefixGroupId'] > 0) ? $__vars['prefixGroup']['title'] : 'Ungrouped'),
						'_type' => 'optgroup',
						'options' => array(),
					);
					end($__compilerTemp3); $__compilerTemp4 = key($__compilerTemp3);
					if ($__templater->isTraversable($__vars['prefixesGrouped'][$__vars['prefixGroupId']])) {
						foreach ($__vars['prefixesGrouped'][$__vars['prefixGroupId']] AS $__vars['prefixId'] => $__vars['prefix']) {
							$__compilerTemp3[$__compilerTemp4]['options'][] = array(
								'value' => $__vars['prefixId'],
								'disabled' => (!$__templater->func('in_array', array($__vars['prefixId'], $__vars['forum']['prefix_cache'], ), false)),
								'label' => $__templater->escape($__vars['prefix']['title']),
								'_type' => 'option',
							);
						}
					}
				}
			}
		}
		$__finalCompiled .= $__templater->formRow('

		' . $__templater->formSelect(array(
			'name' => 'type_config[closed_prefix_ids][]',
			'data-xf-init' => 'token-input-select',
			'multiple' => 'multiple',
			'value' => $__vars['typeConfig']['closed_prefix_ids'],
			'class' => 'js-availablePrefixSelect',
		), $__compilerTemp3) . '
	', array(
			'label' => 'Closed prefixes',
			'explain' => 'These prefixes represent a suggestion that has been closed (but not implemented). Closed suggestions will no longer be votable. Only available prefixes can be selected.',
			'rowtype' => 'input',
		)) . '

	';
		$__templater->inlineJs('
		jQuery.extend(XF.phrases, {
			s2_no_results: "' . $__templater->filter('No results found.', array(array('escape', array('js', )),), false) . '"
		});
	');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['node'], 'exists', array()) AND (!$__vars['isTypeChange'])) {
		$__finalCompiled .= '
	' . $__templater->formRow('
		' . $__templater->button('
			' . 'Convert reactions to votes' . '
		', array(
			'href' => $__templater->func('link', array('forums/suggestion-convert-reactions', $__vars['node'], ), false),
			'class' => 'button--link',
			'data-xf-click' => 'overlay',
		), '', array(
		)) . '
	', array(
		)) . '
';
	}
	return $__finalCompiled;
}
);