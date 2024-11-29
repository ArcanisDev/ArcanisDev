<?php
// FROM HASH: 8b64d09e74bc1a046467cc41ffa47a74
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
		'questionTabs' => $__vars['questionTabs'],
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
				<a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__vars['questionTabs']['latest']['filters'], ), true) . '" class="tabs-tab ' . ($__vars['questionTabs']['latest']['selected'] ? 'is-active' : '') . '">' . 'Latest updates' . '</a>
				<a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__vars['questionTabs']['popular']['filters'], ), true) . '" class="tabs-tab ' . ($__vars['questionTabs']['popular']['selected'] ? 'is-active' : '') . '" rel="nofollow">' . 'Popular' . '</a>
				<a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__vars['questionTabs']['newest']['filters'], ), true) . '" class="tabs-tab ' . ($__vars['questionTabs']['newest']['selected'] ? 'is-active' : '') . '" rel="nofollow">' . 'Newest' . '</a>
				<a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__vars['questionTabs']['unanswered']['filters'], ), true) . '" class="tabs-tab ' . ($__vars['questionTabs']['unanswered']['selected'] ? 'is-active' : '') . '" rel="nofollow">' . 'Unanswered' . '</a>
				<a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__vars['questionTabs']['unsolved']['filters'], ), true) . '" class="tabs-tab ' . ($__vars['questionTabs']['unsolved']['selected'] ? 'is-active' : '') . '" rel="nofollow">' . 'Unsolved' . '</a>
				';
	if ($__vars['questionTabs']['yourQuestions']) {
		$__finalCompiled .= '
					<a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__vars['questionTabs']['yourQuestions']['filters'], ), true) . '" class="tabs-tab ' . ($__vars['questionTabs']['yourQuestions']['selected'] ? 'is-active' : '') . '" rel="nofollow">' . 'Your questions' . '</a>
				';
	}
	$__finalCompiled .= '
				';
	if ($__vars['questionTabs']['yourAnswers']) {
		$__finalCompiled .= '
					<a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__vars['questionTabs']['yourAnswers']['filters'], ), true) . '" class="tabs-tab ' . ($__vars['questionTabs']['yourAnswers']['selected'] ? 'is-active' : '') . '" rel="nofollow">' . 'Your answers' . '</a>
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
		'questionTabs' => '!',
	); },
'extensions' => array('order' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
		';
	if (($__vars['questionTabs']['latest']['selected'] OR $__vars['questionTabs']['popular']['selected']) OR $__vars['questionTabs']['newest']['selected']) {
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