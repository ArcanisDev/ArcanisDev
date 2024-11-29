<?php
// FROM HASH: cf83fe861dc407440e141596a012e3eb
return array(
'macros' => array('quick_filter' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'key' => '',
		'ajax' => '',
		'class' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'src' => 'xf/filter.js',
		'min' => '1',
	));
	$__finalCompiled .= '
	<div class="' . $__templater->escape($__vars['class']) . ' quickFilter u-jsOnly" data-xf-init="filter" data-key="' . $__templater->escape($__vars['key']) . '" data-ajax="' . $__templater->escape($__vars['ajax']) . '">
		<div class="inputGroup inputGroup--inline inputGroup--joined">
			<input type="text" class="input js-filterInput" placeholder="' . 'Filter' . $__vars['xf']['language']['ellipsis'] . '" data-xf-key="' . $__templater->filter('f', array(array('for_attr', array()),), true) . '" />
			<span class="inputGroup-text">
				' . $__templater->formCheckBox(array(
		'standalone' => 'true',
	), array(array(
		'class' => 'js-filterPrefix',
		'label' => 'Prefix',
		'_type' => 'option',
	))) . '
			</span>
			<i class="inputGroup-text js-filterClear is-disabled" aria-hidden="true"></i>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'filter_bar' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'params' => '!',
		'content' => null,
		'route' => '',
		'displayValues' => array(),
		'phrases' => array(),
		'menu' => '',
		'menuIsRoute' => true,
		'menuParams' => array(),
		'menuTitle' => 'Refine search',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '

					';
	if ($__vars['route'] AND $__vars['displayValues']) {
		$__compilerTemp1 .= '
						<ul class="filterBar-filters">
							';
		if ($__templater->isTraversable($__vars['displayValues'])) {
			foreach ($__vars['displayValues'] AS $__vars['filterName'] => $__vars['displayValue']) {
				$__compilerTemp1 .= '
								';
				$__vars['lookupName'] = 'key:' . $__vars['filterName'];
				$__compilerTemp1 .= '
								';
				$__vars['displayName'] = $__templater->preEscaped(($__templater->escape($__vars['phrases'][$__vars['lookupName']]) ?: $__templater->escape($__vars['filterName'])));
				$__compilerTemp1 .= '

								<li><a href="' . $__templater->func('link', array($__vars['route'], $__vars['content'], $__vars['params'] + array('_skipFilter' => $__vars['filterName'], ), ), true) . '" class="filterBar-filterToggle">
									';
				if ($__vars['displayValue'] === true) {
					$__compilerTemp1 .= '
										' . $__templater->escape($__vars['displayName']) . '
									';
				} else {
					$__compilerTemp1 .= '
										<span class="filterBar-filterToggle-label">' . $__templater->escape($__vars['displayName']) . '</span>
										';
					if ($__templater->func('is_array', array($__vars['displayValue'], ), false)) {
						$__compilerTemp1 .= '
											';
						if ($__templater->isTraversable($__vars['displayValue'])) {
							foreach ($__vars['displayValue'] AS $__vars['_displayValue']) {
								$__compilerTemp1 .= '
												';
								$__vars['v'] = $__templater->preEscaped($__templater->callMacro(null, 'lookup', array(
									'value' => $__vars['_displayValue'],
									'phrases' => $__vars['phrases'],
								), $__vars));
								$__compilerTemp1 .= '
												<span class="filterBar-filterToggle-value" data-xf-init="tooltip" title="' . $__templater->escape($__vars['v']) . '">' . $__templater->escape($__vars['v']) . '</span>
											';
							}
						}
						$__compilerTemp1 .= '
										';
					} else {
						$__compilerTemp1 .= '
											';
						$__vars['v'] = $__templater->preEscaped($__templater->callMacro(null, 'lookup', array(
							'value' => $__vars['displayValue'],
							'phrases' => $__vars['phrases'],
						), $__vars));
						$__compilerTemp1 .= '
											<span class="filterBar-filterToggle-value" data-xf-init="tooltip" title="' . $__templater->escape($__vars['v']) . '">' . $__templater->escape($__vars['v']) . '</span>
										';
					}
					$__compilerTemp1 .= '
									';
				}
				$__compilerTemp1 .= '
								</a></li>
							';
			}
		}
		$__compilerTemp1 .= '
						</ul>
					';
	}
	$__compilerTemp1 .= '

					';
	if ($__vars['menu']) {
		$__compilerTemp1 .= '
						<a class="filterBar-menuTrigger" data-xf-click="menu" role="button" tabindex="0" aria-expanded="false" aria-haspopup="true">' . $__templater->escape($__vars['menuTitle']) . '</a>
						';
		$__vars['menuLink'] = ($__vars['menuIsRoute'] ? $__templater->func('link', array($__vars['menu'], $__vars['content'], $__vars['params'] + $__vars['menuParams'], ), false) : $__vars['menu']);
		$__compilerTemp1 .= '
						<div class="menu menu--wide" data-menu="menu" aria-hidden="true"
							data-href="' . $__templater->escape($__vars['menuLink']) . '"
							data-load-target=".js-filterMenuBody">
							<div class="menu-content">
								<h4 class="menu-header">' . $__templater->escape($__vars['menuTitle']) . '</h4>
								<div class="js-filterMenuBody">
									<div class="menu-row">' . 'Loading' . $__vars['xf']['language']['ellipsis'] . '</div>
								</div>
							</div>
						</div>
					';
	}
	$__compilerTemp1 .= '

				';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
		<div class="block-filterBar">
			<div class="filterBar">
				' . $__compilerTemp1 . '
			</div>
		</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'lookup' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'value' => '!',
		'phrases' => array(),
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__templater->func('is_scalar', array($__vars['value'], ), false) AND $__vars['phrases'][$__vars['value']]) {
		$__compilerTemp1 .= '
		' . $__templater->escape($__vars['phrases'][$__vars['value']]) . '
	';
	} else {
		$__compilerTemp1 .= '
		' . $__templater->escape($__vars['value']) . '
	';
	}
	$__finalCompiled .= $__templater->func('trim', array('
	' . $__compilerTemp1 . '

'), false);
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