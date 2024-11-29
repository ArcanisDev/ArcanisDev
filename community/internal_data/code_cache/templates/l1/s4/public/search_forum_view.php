<?php
// FROM HASH: 20d084c5e0855a548a32cab9e48e89f4
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['searchForum']['Node']['title']));
	$__templater->pageParams['pageNumber'] = $__vars['page'];
	$__finalCompiled .= '
';
	$__templater->pageParams['pageDescription'] = $__templater->preEscaped($__templater->filter($__vars['searchForum']['Node']['description'], array(array('raw', array()),), true));
	$__templater->pageParams['pageDescriptionMeta'] = true;
	$__finalCompiled .= '

';
	$__templater->includeCss('structured_list.less');
	$__finalCompiled .= '

' . $__templater->callMacro('metadata_macros', 'canonical_url', array(
		'canonicalUrl' => $__templater->func('link', array('canonical:search-forums', $__vars['searchForum'], array('page' => $__vars['page'], ), ), false),
	), $__vars) . '
';
	$__templater->setPageParam('head.' . 'metaNoindex', $__templater->preEscaped('<meta name="robots" content="noindex" />'));
	$__finalCompiled .= '

';
	$__templater->setPageParam('head.' . 'rss_forum', $__templater->preEscaped('
	<link
		rel="alternate"
		type="application/rss+xml"
		title="' . $__templater->filter('RSS feed for ' . $__vars['searchForum']['title'] . '', array(array('for_attr', array()),), true) . '"
		href="' . $__templater->func('link', array('search-forums/index.rss', $__vars['searchForum'], ), true) . '" />
'));
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['searchForum'], 'getBreadcrumbs', array(false, )));
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__templater->method($__vars['xf']['visitor'], 'canCreateThread', array())) {
		$__compilerTemp1 .= '
		' . $__templater->button('
			' . 'Post thread' . $__vars['xf']['language']['ellipsis'] . '
		', array(
			'href' => $__templater->func('link', array('forums/create-thread', ), false),
			'class' => 'button--cta',
			'icon' => 'write',
			'overlay' => 'true',
			'rel' => 'nofollow',
		), '', array(
		)) . '
	';
	}
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__compilerTemp1 . '
');
	$__finalCompiled .= '

';
	if ($__vars['nodeTree']) {
		$__finalCompiled .= '
	' . $__templater->callAdsMacro('forum_view_above_node_list', array(
			'forum' => $__vars['searchForum'],
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
			'forum' => $__vars['searchForum'],
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

' . $__templater->callAdsMacro('forum_view_above_thread_list', array(
		'forum' => $__vars['searchForum'],
	), $__vars) . '

<div class="block" data-xf-init="' . ($__vars['canInlineMod'] ? 'inline-mod' : '') . '" data-type="thread" data-href="' . $__templater->func('link', array('inline-mod', ), true) . '">
	<div class="block-outer">';
	$__compilerTemp2 = '';
	$__compilerTemp3 = '';
	$__compilerTemp3 .= '
						';
	if ($__vars['canInlineMod']) {
		$__compilerTemp3 .= '
							' . $__templater->callMacro('inline_mod_macros', 'button', array(), $__vars) . '
						';
	}
	$__compilerTemp3 .= '
					';
	if (strlen(trim($__compilerTemp3)) > 0) {
		$__compilerTemp2 .= '
			<div class="block-outer-opposite">
				<div class="buttonGroup">
					' . $__compilerTemp3 . '
				</div>
			</div>
		';
	}
	$__finalCompiled .= $__templater->func('trim', array('
		' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'search-forums',
		'data' => $__vars['searchForum'],
		'wrapperclass' => 'block-outer-main',
		'perPage' => $__vars['perPage'],
	))) . '

		' . $__compilerTemp2 . '
	'), false) . '</div>

	<div class="block-container">
		<div class="block-body">
			<div class="structItemContainer">
				';
	if (!$__templater->test($__vars['threads'], 'empty', array())) {
		$__finalCompiled .= '
					';
		if ($__templater->isTraversable($__vars['threads'])) {
			foreach ($__vars['threads'] AS $__vars['thread']) {
				$__finalCompiled .= '
						' . $__templater->callMacro('thread_list_macros', 'item', array(
					'thread' => $__vars['thread'],
					'showVoteCount' => true,
				), $__vars) . '
					';
			}
		}
		$__finalCompiled .= '
				';
	} else {
		$__finalCompiled .= '
					<div class="structItem">
						<div class="structItem-cell">' . 'There are no threads matching this search forum.' . '</div>
					</div>
				';
	}
	$__finalCompiled .= '
			</div>
		</div>
	</div>

	<div class="block-outer block-outer--after">
		' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'search-forums',
		'data' => $__vars['searchForum'],
		'wrapperclass' => 'block-outer-main',
		'perPage' => $__vars['perPage'],
	))) . '

		' . $__templater->func('show_ignored', array(array(
		'wrapperclass' => 'block-outer-opposite',
	))) . '
	</div>
</div>

' . $__templater->callAdsMacro('forum_view_below_thread_list', array(
		'forum' => $__vars['searchForum'],
	), $__vars) . '

';
	$__templater->modifySidebarHtml('_xfWidgetPositionSidebare9a21e8d642f6759d856bf4636179327', $__templater->widgetPosition('forum_view_sidebar', array(
		'forum' => $__vars['searchForum'],
	)), 'replace');
	return $__finalCompiled;
}
);