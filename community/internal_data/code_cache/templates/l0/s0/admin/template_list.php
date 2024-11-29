<?php
// FROM HASH: 3f8efeb3c6e917f986b82d31e7dd2233
return array(
'macros' => array('template_list' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'templates' => '!',
		'style' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__templater->isTraversable($__vars['templates'])) {
		foreach ($__vars['templates'] AS $__vars['template']) {
			$__finalCompiled .= '
		';
			$__compilerTemp1 = array(array(
				'href' => $__templater->func('link', array('templates/edit', $__vars['template'], array('style_id' => $__vars['style']['style_id'], ), ), false),
				'label' => $__templater->escape($__vars['template']['title']),
				'hint' => ((($__vars['template']['addon_id'] AND (($__vars['template']['addon_id'] != 'XF') AND $__vars['template']['AddOn']))) ? $__templater->escape($__vars['template']['AddOn']['title']) : ''),
				'colspan' => (($__vars['template']['style_id'] == $__vars['style']['style_id']) ? 1 : 2),
				'hash' => $__vars['template']['template_id'],
				'dir' => 'auto',
				'_type' => 'main',
				'html' => '',
			));
			if ($__vars['template']['style_id'] == $__vars['style']['style_id']) {
				$__compilerTemp1[] = array(
					'href' => $__templater->func('link', array('templates/delete', $__vars['template'], ), false),
					'tooltip' => ($__vars['template']['style_id'] ? 'Revert' : 'Delete') . ' ',
					'_type' => 'delete',
					'html' => '',
				);
			}
			$__finalCompiled .= $__templater->dataRow(array(
				'rowclass' => (($__vars['template']['style_id'] == 0) ? '' : (($__vars['template']['style_id'] == $__vars['style']['style_id']) ? 'dataList-row--custom' : 'dataList-row--parentCustom')),
			), $__compilerTemp1) . '
	';
		}
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['style']['title']) . ' - ' . 'Templates');
	$__finalCompiled .= '

';
	$__templater->setPageParam('breadcrumbPath', 'styles');
	$__finalCompiled .= '
';
	$__templater->setPageParam('section', 'templates');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('
		' . 'Add template' . '
	', array(
		'href' => $__templater->func('link', array('templates/add', null, array('style_id' => $__vars['style']['style_id'], 'type' => $__vars['type'], ), ), false),
		'icon' => 'add',
		'data-xf-click' => 'prefix-grabber',
		'data-filter-element' => '[data-xf-init~=filter]',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

<div class="block">
	<div class="block-outer">
		<div class="block-outer-main">
			' . $__templater->callMacro('style_macros', 'style_change_menu', array(
		'styleTree' => $__vars['styleTree'],
		'currentStyle' => $__vars['style'],
		'route' => 'styles/templates',
		'routeParams' => $__vars['linkParams'],
	), $__vars) . '

			' . $__templater->callMacro('addon_macros', 'addon_change_menu', array(
		'addOns' => $__vars['addOns'],
		'currentAddOn' => $__vars['currentAddOn'],
		'route' => 'styles/templates',
		'routeData' => $__vars['style'],
		'routeParams' => $__vars['linkParams'],
	), $__vars) . '
		</div>
		' . $__templater->callMacro('filter_macros', 'quick_filter', array(
		'key' => 'templates',
		'ajax' => $__templater->func('link', array('styles/templates', $__vars['style'], $__vars['linkParams'], ), false),
		'class' => 'block-outer-opposite',
	), $__vars) . '
	</div>
	<div class="block-container">
		<h2 class="block-tabHeader tabs hScroller" data-xf-init="h-scroller">
			<span class="hScroller-scroll">
			';
	if ($__templater->isTraversable($__vars['types'])) {
		foreach ($__vars['types'] AS $__vars['typeId'] => $__vars['typeName']) {
			$__finalCompiled .= '
				<a href="' . $__templater->func('link', array('styles/templates', $__vars['style'], array('type' => $__vars['typeId'], ) + $__vars['linkParams'], ), true) . '"
					class="tabs-tab ' . (($__vars['typeId'] == $__vars['type']) ? 'is-active' : '') . '">' . $__templater->escape($__vars['typeName']) . '</a>
			';
		}
	}
	$__finalCompiled .= '
			</span>
		</h2>

		' . $__templater->callMacro(null, 'filter_macros::filter_bar', array(
		'menu' => 'templates/refine-search',
		'params' => ($__vars['linkParams'] + array('style_id' => $__vars['style']['style_id'], )),
	), $__vars) . '

		<div class="block-body">
			';
	$__compilerTemp1 = '';
	if ($__vars['filter'] AND ($__vars['total'] > $__vars['perPage'])) {
		$__compilerTemp1 .= '
					' . $__templater->dataRow(array(
			'rowclass' => 'dataList-row--note dataList-row--noHover js-filterForceShow',
		), array(array(
			'colspan' => '2',
			'_type' => 'cell',
			'html' => 'There are more records matching your filter. Please be more specific.',
		))) . '
				';
	}
	$__finalCompiled .= $__templater->dataList('
				' . $__templater->callMacro(null, 'template_list', array(
		'templates' => $__vars['templates'],
		'style' => $__vars['style'],
	), $__vars) . '
				' . $__compilerTemp1 . '
			', array(
	)) . '
		</div>

		<div class="block-footer">
			<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['templates'], $__vars['total'], ), true) . '</span>
		</div>
	</div>

	' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'styles/templates',
		'params' => $__vars['linkParams'],
		'data' => $__vars['style'],
		'wrapperclass' => 'js-filterHide block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	))) . '
</div>

';
	return $__finalCompiled;
}
);