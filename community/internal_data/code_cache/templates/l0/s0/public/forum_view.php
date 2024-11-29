<?php
// FROM HASH: ab8ae78d4280750265ba0d947942ce3d
return array(
'extensions' => array('above_node_list' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'above_thread_list' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'thread_list_block_classes' => function($__templater, array $__vars, $__extensions = null)
{
	return '';
},
'filters' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
								' . $__templater->callMacro(null, 'filters', array(
		'forum' => $__vars['forum'],
		'filters' => $__vars['filters'],
		'starterFilter' => $__vars['starterFilter'],
		'threadTypeFilter' => $__vars['threadTypeFilter'],
	), $__vars) . '
							';
	return $__finalCompiled;
},
'thread_list_header' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
			<div class="block-filterBar">
				<div class="filterBar">
					';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
							' . $__templater->renderExtension('filters', $__vars, $__extensions) . '
						';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
						<ul class="filterBar-filters">
						' . $__compilerTemp1 . '
						</ul>
					';
	}
	$__finalCompiled .= '

					<a class="filterBar-menuTrigger" data-xf-click="menu" role="button" tabindex="0" aria-expanded="false" aria-haspopup="true">' . 'Filters' . '</a>
					<div class="menu menu--wide" data-menu="menu" aria-hidden="true"
						data-href="' . $__templater->func('link', array('forums/filters', $__vars['forum'], $__vars['filters'], ), true) . '"
						data-load-target=".js-filterMenuBody">
						<div class="menu-content">
							<h4 class="menu-header">' . 'Show only' . $__vars['xf']['language']['label_separator'] . '</h4>
							<div class="js-filterMenuBody">
								<div class="menu-row">' . 'Loading' . $__vars['xf']['language']['ellipsis'] . '</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		';
	return $__finalCompiled;
},
'thread_list' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
				<div class="structItemContainer">
					' . $__templater->callMacro(null, ($__vars['templateOverrides']['quick_thread_macro'] ?: 'thread_list_macros::quick_thread'), $__templater->combineMacroArgumentAttributes($__vars['templateOverrides']['quick_thread_macro_args'], array(
		'forum' => $__vars['forum'],
		'page' => $__vars['page'],
		'order' => $__vars['sortInfo']['order'],
		'direction' => $__vars['sortInfo']['direction'],
		'prefixes' => $__vars['quickThreadPrefixes'],
	)), $__vars) . '

					';
	if (!$__templater->test($__vars['stickyThreads'], 'empty', array()) OR !$__templater->test($__vars['threads'], 'empty', array())) {
		$__finalCompiled .= '
						';
		if (!$__templater->test($__vars['stickyThreads'], 'empty', array())) {
			$__finalCompiled .= '
							<div class="structItemContainer-group structItemContainer-group--sticky">
								';
			if ($__templater->isTraversable($__vars['stickyThreads'])) {
				foreach ($__vars['stickyThreads'] AS $__vars['thread']) {
					$__finalCompiled .= '
									' . $__templater->callMacro(null, ($__vars['templateOverrides']['thread_list_macro'] ?: 'thread_list_macros::item'), $__templater->combineMacroArgumentAttributes($__vars['templateOverrides']['thread_list_macro_args'], array(
						'thread' => $__vars['thread'],
						'forum' => $__vars['forum'],
					)), $__vars) . '
								';
				}
			}
			$__finalCompiled .= '
							</div>

							' . $__templater->callAdsMacro('forum_view_below_stickies', array(
				'forum' => $__vars['forum'],
			), $__vars) . '
						';
		}
		$__finalCompiled .= '

						<div class="structItemContainer-group js-threadList">
							';
		if (!$__templater->test($__vars['threads'], 'empty', array())) {
			$__finalCompiled .= '
								';
			if ($__templater->isTraversable($__vars['threads'])) {
				foreach ($__vars['threads'] AS $__vars['thread']) {
					$__finalCompiled .= '
									' . $__templater->callMacro(null, ($__vars['templateOverrides']['thread_list_macro'] ?: 'thread_list_macros::item'), $__templater->combineMacroArgumentAttributes($__vars['templateOverrides']['thread_list_macro_args'], array(
						'thread' => $__vars['thread'],
						'forum' => $__vars['forum'],
					)), $__vars) . '
								';
				}
			}
			$__finalCompiled .= '
								';
			if ($__vars['showDateLimitDisabler']) {
				$__finalCompiled .= '
									' . $__templater->callMacro(null, 'date_limit_disabler', array(
					'forum' => $__vars['forum'],
					'page' => $__vars['page'],
					'filters' => $__vars['filters'],
				), $__vars) . '
								';
			}
			$__finalCompiled .= '
							';
		}
		$__finalCompiled .= '
						</div>
					';
	} else if ($__vars['filters']) {
		$__finalCompiled .= '
						<div class="structItemContainer-group js-threadList">
							<div class="structItem js-emptyThreadList">
								<div class="structItem-cell">' . 'There are no threads matching your filters.' . '</div>
							</div>
							';
		if ($__vars['showDateLimitDisabler']) {
			$__finalCompiled .= '
								' . $__templater->callMacro(null, 'date_limit_disabler', array(
				'forum' => $__vars['forum'],
				'page' => $__vars['page'],
				'filters' => $__vars['filters'],
			), $__vars) . '
							';
		}
		$__finalCompiled .= '
						</div>
					';
	} else {
		$__finalCompiled .= '
						<div class="structItemContainer-group js-threadList">
							';
		if ($__vars['showDateLimitDisabler']) {
			$__finalCompiled .= '
								<div class="structItem js-emptyThreadList">
									<div class="structItem-cell">' . 'There are no threads to display.' . '</div>
								</div>
								' . $__templater->callMacro(null, 'date_limit_disabler', array(
				'forum' => $__vars['forum'],
				'page' => $__vars['page'],
				'filters' => $__vars['filters'],
			), $__vars) . '
							';
		} else {
			$__finalCompiled .= '
								<div class="structItem js-emptyThreadList">
									<div class="structItem-cell">' . 'There are no threads in this forum.' . '</div>
								</div>
							';
		}
		$__finalCompiled .= '
						</div>
					';
	}
	$__finalCompiled .= '
				</div>
			';
	return $__finalCompiled;
},
'below_thread_list' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
}),
'macros' => array('filters' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'forum' => '!',
		'filters' => '!',
		'starterFilter' => null,
		'threadTypeFilter' => null,
	); },
'extensions' => array('start' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'prefix_id' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
		';
	if ($__vars['filters']['prefix_id']) {
		$__finalCompiled .= '
			<li><a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__templater->filter($__vars['filters'], array(array('replace', array('prefix_id', null, )),), false), ), true) . '"
				class="filterBar-filterToggle" data-xf-init="tooltip" title="' . $__templater->filter('Remove this filter', array(array('for_attr', array()),), true) . '">
				<span class="filterBar-filterToggle-label">' . 'Prefix' . $__vars['xf']['language']['label_separator'] . '</span>
				' . $__templater->func('prefix_title', array('thread', $__vars['filters']['prefix_id'], ), true) . '</a></li>
		';
	}
	$__finalCompiled .= '
	';
	return $__finalCompiled;
},
'starter_id' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
		';
	if ($__vars['filters']['starter_id'] AND $__vars['starterFilter']) {
		$__finalCompiled .= '
			<li><a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__templater->filter($__vars['filters'], array(array('replace', array('starter_id', null, )),), false), ), true) . '"
				class="filterBar-filterToggle" data-xf-init="tooltip" title="' . $__templater->filter('Remove this filter', array(array('for_attr', array()),), true) . '">
				<span class="filterBar-filterToggle-label">' . 'Started by' . $__vars['xf']['language']['label_separator'] . '</span>
				' . $__templater->escape($__vars['starterFilter']['username']) . '</a></li>
		';
	}
	$__finalCompiled .= '
	';
	return $__finalCompiled;
},
'thread_type' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
		';
	if ($__vars['filters']['thread_type'] AND $__vars['threadTypeFilter']) {
		$__finalCompiled .= '
			<li><a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__templater->filter($__vars['filters'], array(array('replace', array('thread_type', null, )),), false), ), true) . '"
				class="filterBar-filterToggle" data-xf-init="tooltip" title="' . $__templater->filter('Remove this filter', array(array('for_attr', array()),), true) . '">
				<span class="filterBar-filterToggle-label">' . 'Thread type' . $__vars['xf']['language']['label_separator'] . '</span>
				' . $__templater->escape($__templater->method($__vars['threadTypeFilter'], 'getTypeTitle', array())) . '</a></li>
		';
	}
	$__finalCompiled .= '
	';
	return $__finalCompiled;
},
'last_days' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
		';
	if ($__vars['filters']['last_days'] AND $__vars['dateLimits'][$__vars['filters']['last_days']]) {
		$__finalCompiled .= '
			<li><a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__templater->filter($__vars['filters'], array(array('replace', array('last_days', null, )),), false), ), true) . '"
				class="filterBar-filterToggle" data-xf-init="tooltip" title="' . $__templater->filter('Remove this filter', array(array('for_attr', array()),), true) . '">
				<span class="filterBar-filterToggle-label">' . 'Last updated' . $__vars['xf']['language']['label_separator'] . '</span>
				' . $__templater->escape($__vars['dateLimits'][$__vars['filters']['last_days']]) . '</a></li>
		';
	}
	$__finalCompiled .= '
	';
	return $__finalCompiled;
},
'order' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
		';
	if ($__vars['filters']['order']) {
		$__finalCompiled .= '
			<li><a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__templater->filter($__vars['filters'], array(array('replace', array(array('order' => null, 'direction' => null, ), )),), false), ), true) . '"
				class="filterBar-filterToggle" data-xf-init="tooltip" title="' . $__templater->filter('Return to the default order', array(array('for_attr', array()),), true) . '">
				<span class="filterBar-filterToggle-label">' . 'Sort by' . $__vars['xf']['language']['label_separator'] . '</span>
				' . $__templater->func('phrase_dynamic', array('forum_sort.' . $__vars['filters']['order'], ), true) . '
				' . $__templater->fontAwesome((($__vars['filters']['direction'] == 'asc') ? 'fa-angle-up' : 'fa-angle-down'), array(
		)) . '
				<span class="u-srOnly">';
		if ($__vars['filters']['direction'] == 'asc') {
			$__finalCompiled .= 'Ascending';
		} else {
			$__finalCompiled .= 'Descending';
		}
		$__finalCompiled .= '</span>
			</a></li>
		';
	}
	$__finalCompiled .= '
	';
	return $__finalCompiled;
},
'end' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['dateLimits'] = array('-1' => 'Any time', '7' => '' . '7' . ' days', '14' => '' . '14' . ' days', '30' => '' . '30' . ' days', '60' => '' . '2' . ' months', '90' => '' . '3' . ' months', '182' => '' . '6' . ' months', '365' => '1 year', );
	$__finalCompiled .= '

	' . $__templater->renderExtension('start', $__vars, $__extensions) . '

	' . $__templater->renderExtension('prefix_id', $__vars, $__extensions) . '

	' . $__templater->renderExtension('starter_id', $__vars, $__extensions) . '

	' . $__templater->renderExtension('thread_type', $__vars, $__extensions) . '

	' . $__templater->renderExtension('last_days', $__vars, $__extensions) . '

	' . $__templater->renderExtension('order', $__vars, $__extensions) . '

	' . $__templater->renderExtension('end', $__vars, $__extensions) . '
';
	return $__finalCompiled;
}
),
'date_limit_disabler' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'forum' => '!',
		'page' => '!',
		'filters' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="structItem structItem--note">
		<div class="structItem-cell">
			<a href="' . $__templater->func('link', array('forums', $__vars['forum'], array('page' => $__vars['page'], 'no_date_limit' => 1, ) + $__vars['filters'], ), true) . '">
				' . 'Show older items' . '
			</a>
		</div>
	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['forum']['Node']['title']));
	$__templater->pageParams['pageNumber'] = $__vars['page'];
	$__finalCompiled .= '
';
	$__templater->pageParams['pageDescription'] = $__templater->preEscaped($__templater->filter($__vars['forum']['Node']['description'], array(array('raw', array()),), true));
	$__templater->pageParams['pageDescriptionMeta'] = true;
	$__finalCompiled .= '

';
	$__templater->includeCss('structured_list.less');
	$__finalCompiled .= '

';
	if (!$__templater->method($__vars['forum'], 'isSearchEngineIndexable', array())) {
		$__finalCompiled .= '
	';
		$__templater->setPageParam('head.' . 'metaNoindex', $__templater->preEscaped('<meta name="robots" content="noindex" />'));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

' . $__templater->callMacro('metadata_macros', 'canonical_url', array(
		'canonicalUrl' => $__templater->func('link', array('canonical:forums', $__vars['forum'], $__vars['canonicalFilters'] + array('page' => $__vars['page'], ), ), false),
	), $__vars) . '

';
	$__templater->setPageParam('head.' . 'rss_forum', $__templater->preEscaped('<link rel="alternate" type="application/rss+xml" title="' . $__templater->filter('RSS feed for ' . $__vars['forum']['title'] . '', array(array('for_attr', array()),), true) . '" href="' . $__templater->func('link', array('forums/index.rss', $__vars['forum'], ), true) . '" />'));
	$__finalCompiled .= '

' . $__templater->callMacro('forum_macros', 'forum_page_options', array(
		'forum' => $__vars['forum'],
	), $__vars) . '
';
	$__templater->breadcrumbs($__templater->method($__vars['forum'], 'getBreadcrumbs', array(false, )));
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['forum'], 'canCreateThread', array()) OR $__templater->method($__vars['forum'], 'canCreateThreadPreReg', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('
		' . 'Post thread' . '
	', array(
			'href' => $__templater->func('link', array('forums/post-thread', $__vars['forum'], ), false),
			'class' => 'button--cta',
			'icon' => 'write',
			'rel' => 'nofollow',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

';
	if ($__vars['pendingApproval']) {
		$__finalCompiled .= '
	<div class="blockMessage blockMessage--important">' . 'Your content has been submitted and will be displayed pending approval by a moderator.' . '</div>
';
	}
	$__finalCompiled .= '

' . $__templater->renderExtension('above_node_list', $__vars, $__extensions) . '

';
	if ($__vars['nodeTree']) {
		$__finalCompiled .= '
	' . $__templater->callAdsMacro('forum_view_above_node_list', array(
			'forum' => $__vars['forum'],
		), $__vars) . '
	<div class="block">
		<div class="block-container">
			<div class="block-body">
				' . $__templater->callMacro('forum_list', 'node_list', array(
			'children' => $__vars['nodeTree'],
			'extras' => $__vars['nodeExtras'],
			'depth' => '2',
		), $__vars) . '
			</div>
		</div>
	</div>
	' . $__templater->callAdsMacro('forum_view_below_node_list', array(
			'forum' => $__vars['forum'],
		), $__vars) . '
';
	}
	$__finalCompiled .= '

';
	if ($__vars['canInlineMod']) {
		$__finalCompiled .= '
	';
		$__templater->includeJs(array(
			'src' => 'xf/inline_mod.js',
			'min' => '1',
		));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

' . $__templater->renderExtension('above_thread_list', $__vars, $__extensions) . '
' . $__templater->callAdsMacro('forum_view_above_thread_list', array(
		'forum' => $__vars['forum'],
	), $__vars) . '

' . '
<div class="block ' . $__templater->escape($__templater->renderExtension('thread_list_block_classes', $__vars, $__extensions)) . '" data-xf-init="' . ($__vars['canInlineMod'] ? 'inline-mod' : '') . '" data-type="thread" data-href="' . $__templater->func('link', array('inline-mod', ), true) . '">

	<div class="block-outer">';
	$__compilerTemp1 = '';
	$__compilerTemp2 = '';
	$__compilerTemp2 .= '
					';
	if ($__vars['canInlineMod']) {
		$__compilerTemp2 .= '
						' . $__templater->callMacro('inline_mod_macros', 'button', array(), $__vars) . '
					';
	}
	$__compilerTemp2 .= '
					';
	if ($__vars['xf']['visitor']['user_id']) {
		$__compilerTemp2 .= '
						' . $__templater->button('
							' . 'Mark read' . '
						', array(
			'href' => $__templater->func('link', array('forums/mark-read', $__vars['forum'], array('date' => $__vars['xf']['time'], ), ), false),
			'class' => 'button--link',
			'overlay' => 'true',
		), '', array(
		)) . '
					';
	}
	$__compilerTemp2 .= '
					';
	if ($__templater->method($__vars['forum'], 'canWatch', array())) {
		$__compilerTemp2 .= '
						';
		$__compilerTemp3 = '';
		if ($__vars['forum']['Watch'][$__vars['xf']['visitor']['user_id']]) {
			$__compilerTemp3 .= 'Unwatch';
		} else {
			$__compilerTemp3 .= 'Watch';
		}
		$__compilerTemp2 .= $__templater->button('
							' . $__compilerTemp3 . '
						', array(
			'href' => $__templater->func('link', array('forums/watch', $__vars['forum'], ), false),
			'class' => 'button--link',
			'data-xf-click' => 'switch-overlay',
			'data-sk-watch' => 'Watch',
			'data-sk-unwatch' => 'Unwatch',
		), '', array(
		)) . '
					';
	}
	$__compilerTemp2 .= '
				';
	if (strlen(trim($__compilerTemp2)) > 0) {
		$__compilerTemp1 .= '
			<div class="block-outer-opposite">
				<div class="buttonGroup">
				' . $__compilerTemp2 . '
				</div>
			</div>
		';
	}
	$__finalCompiled .= $__templater->func('trim', array('
		' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'forums',
		'data' => $__vars['forum'],
		'params' => $__vars['filters'],
		'wrapperclass' => 'block-outer-main',
		'perPage' => $__vars['perPage'],
	))) . '
		' . $__compilerTemp1 . '
	'), false) . '</div>

	<div class="block-container">

		' . $__templater->renderExtension('thread_list_header', $__vars, $__extensions) . '

		';
	$__vars['qtPos'] = $__templater->preEscaped((((($__vars['sortInfo']['order'] == 'last_post_date') AND ($__vars['sortInfo']['direction'] == 'asc'))) ? 'bottom' : 'top'));
	$__finalCompiled .= '

		<div class="block-body">
			' . $__templater->renderExtension('thread_list', $__vars, $__extensions) . '
		</div>
	</div>

	<div class="block-outer block-outer--after">
		' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'forums',
		'data' => $__vars['forum'],
		'params' => $__vars['filters'],
		'wrapperclass' => 'block-outer-main',
		'perPage' => $__vars['perPage'],
	))) . '
		' . $__templater->func('show_ignored', array(array(
		'wrapperclass' => 'block-outer-opposite',
	))) . '
		';
	if ((!$__templater->method($__vars['forum'], 'canCreateThread', array())) AND (!$__templater->method($__vars['forum'], 'canCreateThreadPreReg', array()))) {
		$__finalCompiled .= '
			<div class="block-outer-opposite">
				';
		if ($__vars['xf']['visitor']['user_id']) {
			$__finalCompiled .= '
					<span class="button button--wrap is-disabled">
						' . 'You have insufficient privileges to post threads here.' . '
						<!-- this is not interactive so shouldn\'t be a button element -->
					</span>
				';
		} else {
			$__finalCompiled .= '
					' . $__templater->button('
						' . 'You must log in or register to post here.' . '
					', array(
				'href' => $__templater->func('link', array('login', ), false),
				'class' => 'button--link button--wrap',
				'overlay' => 'true',
			), '', array(
			)) . '
				';
		}
		$__finalCompiled .= '
			</div>
		';
	}
	$__finalCompiled .= '
	</div>
</div>

' . $__templater->callAdsMacro('forum_view_below_thread_list', array(
		'forum' => $__vars['forum'],
	), $__vars) . '
' . $__templater->renderExtension('below_thread_list', $__vars, $__extensions) . '

';
	$__templater->modifySidebarHtml('_xfWidgetPositionSidebarfe322c91013383793fda9cb0d7e31c1f', $__templater->widgetPosition('forum_view_sidebar', array(
		'forum' => $__vars['forum'],
	)), 'replace');
	$__finalCompiled .= '

' . '

';
	return $__finalCompiled;
}
);