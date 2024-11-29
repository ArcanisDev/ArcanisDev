<?php
// FROM HASH: dc1704e04550fd3644ae6186d17db6bb
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->callAdsMacro('forum_overview_top', array(), $__vars) . '
' . $__templater->widgetPosition('forum_overview_top', array()) . '

';
	$__compilerTemp1 = '';
	if ($__vars['pageSelected'] == 'new_posts') {
		$__compilerTemp1 .= '
		' . $__templater->button('
			' . 'Forum list' . '
		', array(
			'href' => $__templater->func('link', array('forums/list', ), false),
			'icon' => 'list',
		), '', array(
		)) . '
	';
	} else {
		$__compilerTemp1 .= '
		' . $__templater->button('
			' . 'New posts' . '
		', array(
			'href' => (($__vars['xf']['options']['forumsDefaultPage'] == 'new_posts') ? $__templater->func('link', array('forums/new-posts', ), false) : $__templater->func('link', array('whats-new/posts', ), false)),
			'icon' => 'bolt',
		), '', array(
		)) . '
	';
	}
	$__compilerTemp2 = '';
	if ($__templater->method($__vars['xf']['visitor'], 'canCreateThread', array()) OR $__templater->method($__vars['xf']['visitor'], 'canCreateThreadPreReg', array())) {
		$__compilerTemp2 .= '
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
	' . $__compilerTemp2 . '
');
	$__finalCompiled .= '

' . $__templater->filter($__vars['innerContent'], array(array('raw', array()),), true) . '

' . $__templater->callAdsMacro('forum_overview_bottom', array(), $__vars) . '
' . $__templater->widgetPosition('forum_overview_bottom', array());
	return $__finalCompiled;
}
);