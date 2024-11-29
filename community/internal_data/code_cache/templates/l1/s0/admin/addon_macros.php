<?php
// FROM HASH: ce6b21077b1606606401ec7e00620686
return array(
'macros' => array('addon_edit' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'addOnId' => '!',
		'row' => true,
		'includeAny' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['addOnRepo'] = $__templater->method($__vars['xf']['app']['em'], 'getRepository', array('XF:AddOn', ));
	$__finalCompiled .= '
	';
	if ($__templater->method($__vars['addOnRepo'], 'canChangeAddOn', array())) {
		$__finalCompiled .= '
		' . $__templater->callMacro(null, 'addon_select', array(
			'addOnId' => $__vars['addOnId'],
			'row' => $__vars['row'],
			'includeAny' => $__vars['includeAny'],
		), $__vars) . '
	';
	} else {
		$__finalCompiled .= '
		' . $__templater->formHiddenVal('addon_id', $__vars['addOnId'], array(
		)) . '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'addon_change_menu' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'addOns' => '!',
		'route' => '!',
		'routeData' => '!',
		'routeParams' => array(),
		'currentAddOn' => null,
		'linkClass' => 'button button--link',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	<a class="' . $__templater->escape($__vars['linkClass']) . ' menuTrigger"
		data-xf-click="menu"
		role="button"
		tabindex="0"
		aria-expanded="false"
		aria-haspopup="true">' . 'Add-on' . $__vars['xf']['language']['label_separator'] . ' ' . ($__vars['currentAddOn'] ? $__templater->escape($__vars['currentAddOn']['title']) : $__vars['xf']['language']['parenthesis_open'] . 'Any' . $__vars['xf']['language']['parenthesis_close']) . '</a>

	<div class="menu" data-menu="menu" aria-hidden="true">
		<div class="menu-content">
			<h3 class="menu-header">' . 'Add-ons' . '</h3>
			<a href="' . $__templater->func('link', array($__vars['route'], $__vars['routeData'], array('addon_id' => null, ) + $__vars['routeParams'], ), true) . '"
				class="menu-linkRow ' . ((!$__vars['currentAddOn']) ? 'is-selected' : '') . '">
				' . $__vars['xf']['language']['parenthesis_open'] . 'Any' . $__vars['xf']['language']['parenthesis_close'] . '
			</a>
			';
	if ($__templater->isTraversable($__vars['addOns'])) {
		foreach ($__vars['addOns'] AS $__vars['addOn']) {
			$__finalCompiled .= '
				<a href="' . $__templater->func('link', array($__vars['route'], $__vars['routeData'], array('addon_id' => $__vars['addOn']['addon_id'], ) + $__vars['routeParams'], ), true) . '"
					class="menu-linkRow ' . ((($__vars['currentAddOn'] AND ($__vars['currentAddOn']['addon_id'] == $__vars['addOn']['addon_id']))) ? 'is-selected' : '') . '">
					' . $__templater->escape($__vars['addOn']['title']) . '
				</a>
			';
		}
	}
	$__finalCompiled .= '
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'addon_select' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'addOnId' => '!',
		'row' => true,
		'class' => '',
		'includeAny' => false,
		'emptyValue' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['addOnRepo'] = $__templater->method($__vars['xf']['app']['em'], 'getRepository', array('XF:AddOn', ));
	$__finalCompiled .= '
	';
	$__compilerTemp1 = array(array(
		'value' => $__vars['emptyValue'],
		'_type' => 'option',
	));
	if ($__vars['includeAny']) {
		$__compilerTemp1[] = array(
			'value' => '_any',
			'label' => $__vars['xf']['language']['parenthesis_open'] . 'Any' . $__vars['xf']['language']['parenthesis_close'],
			'_type' => 'option',
		);
	}
	$__compilerTemp2 = $__templater->method($__templater->method($__vars['addOnRepo'], 'findAddOnsForList', array()), 'fetch', array());
	if ($__templater->isTraversable($__compilerTemp2)) {
		foreach ($__compilerTemp2 AS $__vars['addOn']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['addOn']['addon_id'],
				'label' => $__templater->escape($__vars['addOn']['title']),
				'_type' => 'option',
			);
		}
	}
	$__vars['select'] = $__templater->preEscaped('
		' . $__templater->formSelect(array(
		'name' => 'addon_id',
		'value' => (($__vars['addOnId'] === false) ? $__templater->method($__vars['addOnRepo'], 'getDefaultAddOnId', array()) : $__vars['addOnId']),
		'class' => $__vars['class'],
	), $__compilerTemp1) . '
	');
	$__finalCompiled .= '
	';
	if ($__vars['row']) {
		$__finalCompiled .= '
		' . $__templater->formRow('

			' . $__templater->filter($__vars['select'], array(array('raw', array()),), true) . '
		', array(
			'rowtype' => 'input',
			'label' => 'Add-on',
		)) . '
	';
	} else {
		$__finalCompiled .= '
		' . $__templater->filter($__vars['select'], array(array('raw', array()),), true) . '
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

';
	return $__finalCompiled;
}
);