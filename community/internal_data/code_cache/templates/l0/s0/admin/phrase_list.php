<?php
// FROM HASH: 82a6f304e204ff53e3568ae89e0cd415
return array(
'macros' => array('phrase_list' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'phrases' => '!',
		'language' => '!',
		'page' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__templater->isTraversable($__vars['phrases'])) {
		foreach ($__vars['phrases'] AS $__vars['phrase']) {
			$__finalCompiled .= '
		';
			$__compilerTemp1 = array(array(
				'href' => $__templater->func('link', array('phrases/edit', $__vars['phrase'], array('language_id' => $__vars['language']['language_id'], ), ), false),
				'label' => $__templater->escape($__vars['phrase']['title']),
				'hint' => ((($__vars['phrase']['addon_id'] AND (($__vars['phrase']['addon_id'] != 'XF') AND $__vars['phrase']['AddOn']))) ? $__templater->escape($__vars['phrase']['AddOn']['title']) : ''),
				'colspan' => (($__vars['phrase']['language_id'] == $__vars['language']['language_id']) ? 1 : 2),
				'hash' => $__vars['phrase']['phrase_id'],
				'dir' => 'auto',
				'_type' => 'main',
				'html' => '',
			));
			if ($__vars['phrase']['language_id'] == $__vars['language']['language_id']) {
				$__compilerTemp1[] = array(
					'href' => $__templater->func('link', array('phrases/delete', $__vars['phrase'], ), false),
					'tooltip' => ($__vars['phrase']['language_id'] ? 'Revert' : 'Delete'),
					'_type' => 'delete',
					'html' => '',
				);
			}
			$__finalCompiled .= $__templater->dataRow(array(
				'rowclass' => (($__vars['phrase']['language_id'] == 0) ? '' : (($__vars['phrase']['language_id'] == $__vars['language']['language_id']) ? 'dataList-row--custom' : 'dataList-row--parentCustom')),
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
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['language']['title']) . ' - ' . 'Phrases');
	$__finalCompiled .= '

';
	$__templater->setPageParam('breadcrumbPath', 'languages');
	$__finalCompiled .= '
';
	$__templater->setPageParam('section', 'phrases');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('
		' . 'Add phrase' . '
	', array(
		'href' => $__templater->func('link', array('phrases/add', null, array('language_id' => $__vars['language']['language_id'], ), ), false),
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
			' . $__templater->callMacro('language_macros', 'language_change_menu', array(
		'languageTree' => $__vars['languageTree'],
		'currentLanguage' => $__vars['language'],
		'route' => 'languages/phrases',
		'routeParams' => $__vars['linkParams'],
	), $__vars) . '

			' . $__templater->callMacro('addon_macros', 'addon_change_menu', array(
		'addOns' => $__vars['addOns'],
		'currentAddOn' => $__vars['currentAddOn'],
		'route' => 'languages/phrases',
		'routeData' => $__vars['language'],
		'routeParams' => $__vars['linkParams'],
	), $__vars) . '
		</div>
		' . $__templater->callMacro('filter_macros', 'quick_filter', array(
		'key' => 'phrases',
		'ajax' => $__templater->func('link', array('languages/phrases', $__vars['language'], $__vars['linkParams'], ), false),
		'class' => 'block-outer-opposite',
	), $__vars) . '
	</div>
	<div class="block-container">
		' . $__templater->callMacro(null, 'filter_macros::filter_bar', array(
		'params' => array('language_id' => $__vars['language']['language_id'], 'addon_id' => ($__vars['currentAddOn'] ? $__vars['currentAddOn']['addon_id'] : null), ),
		'menu' => 'phrases/refine-search',
		'menuTitle' => 'Refine and translate',
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
				' . $__templater->callMacro(null, 'phrase_list', array(
		'phrases' => $__vars['phrases'],
		'language' => $__vars['language'],
		'page' => $__vars['page'],
	), $__vars) . '
				' . $__compilerTemp1 . '
			', array(
	)) . '
		</div>

		<div class="block-footer">
			<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['phrases'], $__vars['total'], ), true) . '</span>
		</div>
	</div>

	' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'languages/phrases',
		'params' => $__vars['linkParams'],
		'data' => $__vars['language'],
		'wrapperclass' => 'js-filterHide block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	))) . '
</div>

';
	return $__finalCompiled;
}
);