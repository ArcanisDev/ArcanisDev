<?php
// FROM HASH: 21d4fc6e18378dd3a5b8a2f620384209
return array(
'extends' => function($__templater, array $__vars) { return 'forum_view'; },
'extensions' => array('filters' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
						' . $__templater->callMacro(null, 'filters', array(
		'forum' => $__vars['forum'],
		'filters' => $__vars['filters'],
		'starterFilter' => $__vars['starterFilter'],
		'suggestionTabs' => $__vars['suggestionTabs'],
	), $__vars) . '
					';
	return $__finalCompiled;
},
'thread_list_header' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
	<h2 class="block-tabHeader tabs">
		<div class="hScroller" data-xf-init="h-scroller">
			<span class="hScroller-scroll">
				' . '
				<a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__vars['suggestionTabs']['latest']['filters'], ), true) . '" class="tabs-tab ' . ($__vars['suggestionTabs']['latest']['selected'] ? 'is-active' : '') . '">' . 'Latest updates' . '</a>
				<a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__vars['suggestionTabs']['popular']['filters'], ), true) . '" class="tabs-tab ' . ($__vars['suggestionTabs']['popular']['selected'] ? 'is-active' : '') . '" rel="nofollow">' . 'Popular' . '</a>
				<a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__vars['suggestionTabs']['newest']['filters'], ), true) . '" class="tabs-tab ' . ($__vars['suggestionTabs']['newest']['selected'] ? 'is-active' : '') . '" rel="nofollow">' . 'Newest' . '</a>
				';
	if ($__vars['suggestionTabs']['implemented']) {
		$__finalCompiled .= '
					<a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__vars['suggestionTabs']['implemented']['filters'], ), true) . '" class="tabs-tab ' . ($__vars['suggestionTabs']['implemented']['selected'] ? 'is-active' : '') . '" rel="nofollow">' . 'Implemented' . '</a>
				';
	}
	$__finalCompiled .= '
				';
	if ($__vars['suggestionTabs']['yourSuggestions']) {
		$__finalCompiled .= '
					<a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__vars['suggestionTabs']['yourSuggestions']['filters'], ), true) . '" class="tabs-tab ' . ($__vars['suggestionTabs']['yourSuggestions']['selected'] ? 'is-active' : '') . '" rel="nofollow">' . 'Your suggestions' . '</a>
				';
	}
	$__finalCompiled .= '
				';
	if ($__vars['suggestionTabs']['yourVotes']) {
		$__finalCompiled .= '
					<a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__vars['suggestionTabs']['yourVotes']['filters'], ), true) . '" class="tabs-tab ' . ($__vars['suggestionTabs']['yourVotes']['selected'] ? 'is-active' : '') . '" rel="nofollow">' . 'Your votes' . '</a>
				';
	}
	$__finalCompiled .= '
				' . '
			</span>
		</div>

		<div class="tabs-extra tabs-extra--minor">
			<a class="menuTrigger" data-xf-click="menu" role="button" tabindex="0" aria-expanded="false" aria-haspopup="true">' . 'Filters' . '</a>
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
	</h2>

	';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
					' . $__templater->renderExtension('filters', $__vars, $__extensions) . '
				';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
		<div class="block-filterBar">
			<div class="filterBar">
				<ul class="filterBar-filters">
				' . $__compilerTemp1 . '
				</ul>
			</div>
		</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}),
'macros' => array('filters' => array(
'extends' => 'forum_view::filters',
'arguments' => function($__templater, array $__vars) { return array(
		'suggestionTabs' => '!',
	); },
'extensions' => array('prefix_id' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
		' . $__templater->renderExtensionParent($__vars, null, $__extensions) . '

		';
	if ($__vars['filters']['suggestion_state'] AND ((($__vars['filters']['suggestion_state'] != 'implemented') OR (!$__vars['suggestionTabs']['implemented']['selected'])))) {
		$__finalCompiled .= '
			<li><a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__templater->filter($__vars['filters'], array(array('replace', array('suggestion_state', null, )),), false), ), true) . '"
				class="filterBar-filterToggle" data-xf-init="tooltip" title="' . $__templater->filter('Remove this filter', array(array('for_attr', array()),), true) . '">
				<span class="filterBar-filterToggle-label">' . 'Suggestion status' . ':</span>
				';
		if ($__vars['filters']['suggestion_state'] == 'open') {
			$__finalCompiled .= 'Open' . '
				';
		} else if ($__vars['filters']['suggestion_state'] == 'closed') {
			$__finalCompiled .= 'Closed' . '
				';
		} else if ($__vars['filters']['suggestion_state'] == 'implemented') {
			$__finalCompiled .= 'Implemented';
		}
		$__finalCompiled .= '</a></li>
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
	if (($__vars['suggestionTabs']['latest']['selected'] OR $__vars['suggestionTabs']['popular']['selected']) OR $__vars['suggestionTabs']['newest']['selected']) {
	} else {
		$__finalCompiled .= '
			' . $__templater->renderExtensionParent($__vars, null, $__extensions) . '
		';
	}
	$__finalCompiled .= '
	';
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->renderExtension('prefix_id', $__vars, $__extensions) . '

	' . $__templater->renderExtension('order', $__vars, $__extensions) . '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . $__templater->renderExtension('thread_list_header', $__vars, $__extensions) . '

';
	return $__finalCompiled;
}
);