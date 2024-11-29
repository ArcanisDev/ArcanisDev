<?php
// FROM HASH: b813eebe2f264b7fe8990c948829a639
return array(
'macros' => array('page_link' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'page' => '!',
		'current' => '!',
		'link' => '!',
		'data' => '!',
		'params' => '!',
		'hash' => '',
		'pageParam' => '!',
		'pageClass' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	if ($__vars['page'] == $__vars['current']) {
		$__finalCompiled .= '
		<li class="pageNav-page pageNav-page--current ' . $__templater->escape($__vars['pageClass']) . '"><a href="' . $__templater->func('link', array($__vars['link'], $__vars['data'], $__vars['params'] + array($__vars['pageParam'] => (($__vars['page'] > 1) ? $__vars['page'] : null), ), $__vars['hash'], ), true) . '">' . $__templater->escape($__vars['page']) . '</a></li>
	';
	} else {
		$__finalCompiled .= '
		<li class="pageNav-page ' . $__templater->escape($__vars['pageClass']) . '"><a href="' . $__templater->func('link', array($__vars['link'], $__vars['data'], $__vars['params'] + array($__vars['pageParam'] => (($__vars['page'] > 1) ? $__vars['page'] : null), ), $__vars['hash'], ), true) . '">' . $__templater->escape($__vars['page']) . '</a></li>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'page_jump_menu' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'page' => '!',
		'totalPages' => '!',
		'link' => '!',
		'data' => '!',
		'params' => '!',
		'hash' => '',
		'pageParam' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	<div class="menu menu--pageJump" data-menu="menu" aria-hidden="true">
		<div class="menu-content">
			<h4 class="menu-header">' . 'Go to page' . '</h4>
			<div class="menu-row" data-xf-init="page-jump" data-page-url="' . $__templater->func('link', array($__vars['link'], $__vars['data'], $__vars['params'] + array($__vars['pageParam'] => '%page%', ), $__vars['hash'], ), true) . '">
				<div class="inputGroup inputGroup--numbers">
					' . $__templater->formNumberBox(array(
		'class' => 'input input--numberNarrow js-pageJumpPage',
		'value' => $__vars['page'],
		'min' => '1',
		'max' => $__vars['totalPages'],
		'data-menu-autofocus' => 'true',
	)) . '
					<span class="inputGroup-text">' . $__templater->button('Go', array(
		'class' => 'js-pageJumpGo',
	), '', array(
	)) . '</span>
				</div>
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<nav class="pageNavWrapper pageNavWrapper--' . $__templater->func('property', array('pageNavStyle', ), true) . ' ' . $__templater->escape($__vars['variantClass']) . '">

';
	$__vars['hasSkipStart'] = ($__vars['startInner'] > 2);
	$__finalCompiled .= '
';
	$__vars['hasSkipEnd'] = (($__vars['endInner'] + 1) < $__vars['totalPages']);
	$__finalCompiled .= '
<div class="pageNav ' . ($__vars['hasSkipStart'] ? 'pageNav--skipStart' : '') . ' ' . ($__vars['hasSkipEnd'] ? 'pageNav--skipEnd' : '') . '">
	';
	if ($__vars['prev']) {
		$__finalCompiled .= '
		<a href="' . $__templater->escape($__vars['prev']) . '" class="pageNav-jump pageNav-jump--prev">' . 'Prev' . '</a>
	';
	}
	$__finalCompiled .= '

	<ul class="pageNav-main">
		' . $__templater->callMacro(null, 'page_link', array(
		'page' => '1',
		'current' => $__vars['current'],
		'link' => $__vars['link'],
		'data' => $__vars['data'],
		'params' => $__vars['params'],
		'hash' => $__vars['hash'],
		'pageParam' => $__vars['pageParam'],
	), $__vars) . '

		';
	if ($__vars['hasSkipStart']) {
		$__finalCompiled .= '
			';
		if ($__vars['startInner'] == 3) {
			$__finalCompiled .= '
				' . $__templater->callMacro(null, 'page_link', array(
				'page' => '2',
				'current' => $__vars['current'],
				'link' => $__vars['link'],
				'data' => $__vars['data'],
				'params' => $__vars['params'],
				'hash' => $__vars['hash'],
				'pageParam' => $__vars['pageParam'],
				'pageClass' => 'pageNav-page--earlier',
			), $__vars) . '
				';
		} else {
			$__finalCompiled .= '
				<li class="pageNav-page pageNav-page--skip pageNav-page--skipStart">
					<a data-xf-init="tooltip" title="' . $__templater->filter('Go to page', array(array('for_attr', array()),), true) . '"
						data-xf-click="menu"
						role="button" tabindex="0" aria-expanded="false" aria-haspopup="true">' . $__templater->escape($__vars['xf']['language']['ellipsis']) . '</a>
					' . $__templater->callMacro(null, 'page_jump_menu', array(
				'page' => ($__vars['startInner'] - 1),
				'totalPages' => $__vars['totalPages'],
				'link' => $__vars['link'],
				'data' => $__vars['data'],
				'params' => $__vars['params'],
				'hash' => $__vars['hash'],
				'pageParam' => $__vars['pageParam'],
			), $__vars) . '
				</li>
			';
		}
		$__finalCompiled .= '
		';
	}
	$__finalCompiled .= '

		';
	if ($__templater->isTraversable($__vars['innerPages'])) {
		foreach ($__vars['innerPages'] AS $__vars['page']) {
			$__finalCompiled .= '
			' . $__templater->callMacro(null, 'page_link', array(
				'page' => $__vars['page'],
				'current' => $__vars['current'],
				'link' => $__vars['link'],
				'data' => $__vars['data'],
				'params' => $__vars['params'],
				'hash' => $__vars['hash'],
				'pageParam' => $__vars['pageParam'],
				'pageClass' => (($__vars['page'] < $__vars['current']) ? 'pageNav-page--earlier' : (($__vars['page'] > $__vars['current']) ? 'pageNav-page--later' : '')),
			), $__vars) . '
		';
		}
	}
	$__finalCompiled .= '

		';
	if ($__vars['hasSkipEnd']) {
		$__finalCompiled .= '
			';
		if (($__vars['endInner'] + 2) == $__vars['totalPages']) {
			$__finalCompiled .= '
				' . $__templater->callMacro(null, 'page_link', array(
				'page' => ($__vars['totalPages'] - 1),
				'current' => $__vars['current'],
				'link' => $__vars['link'],
				'data' => $__vars['data'],
				'params' => $__vars['params'],
				'hash' => $__vars['hash'],
				'pageParam' => $__vars['pageParam'],
				'pageClass' => 'pageNav-page--later',
			), $__vars) . '
			';
		} else {
			$__finalCompiled .= '
				<li class="pageNav-page pageNav-page--skip pageNav-page--skipEnd">
					<a data-xf-init="tooltip" title="' . $__templater->filter('Go to page', array(array('for_attr', array()),), true) . '"
						data-xf-click="menu"
						role="button" tabindex="0" aria-expanded="false" aria-haspopup="true">' . $__templater->escape($__vars['xf']['language']['ellipsis']) . '</a>
					' . $__templater->callMacro(null, 'page_jump_menu', array(
				'page' => ($__vars['endInner'] + 1),
				'totalPages' => $__vars['totalPages'],
				'link' => $__vars['link'],
				'data' => $__vars['data'],
				'params' => $__vars['params'],
				'hash' => $__vars['hash'],
				'pageParam' => $__vars['pageParam'],
			), $__vars) . '
				</li>
			';
		}
		$__finalCompiled .= '
		';
	}
	$__finalCompiled .= '

		' . $__templater->callMacro(null, 'page_link', array(
		'page' => $__vars['totalPages'],
		'current' => $__vars['current'],
		'link' => $__vars['link'],
		'data' => $__vars['data'],
		'params' => $__vars['params'],
		'hash' => $__vars['hash'],
		'pageParam' => $__vars['pageParam'],
	), $__vars) . '
	</ul>

	';
	if ($__vars['next']) {
		$__finalCompiled .= '
		<a href="' . $__templater->escape($__vars['next']) . '" class="pageNav-jump pageNav-jump--next">' . 'Next' . '</a>
	';
	}
	$__finalCompiled .= '
</div>

<div class="pageNavSimple">
	';
	if ($__vars['current'] > 1) {
		$__finalCompiled .= '
		<a href="' . $__templater->func('link', array($__vars['link'], $__vars['data'], $__vars['params'] + array($__vars['pageParam'] => 1, ), $__vars['hash'], ), true) . '"
			class="pageNavSimple-el pageNavSimple-el--first"
			data-xf-init="tooltip" title="' . $__templater->filter('First', array(array('for_attr', array()),), true) . '">
			<i aria-hidden="true"></i> <span class="u-srOnly">' . 'First' . '</span>
		</a>
		<a href="' . $__templater->func('link', array($__vars['link'], $__vars['data'], $__vars['params'] + array($__vars['pageParam'] => $__vars['current'] - 1, ), $__vars['hash'], ), true) . '" class="pageNavSimple-el pageNavSimple-el--prev">
			<i aria-hidden="true"></i> ' . 'Prev' . '
		</a>
	';
	}
	$__finalCompiled .= '

	<a class="pageNavSimple-el pageNavSimple-el--current"
		data-xf-init="tooltip" title="' . $__templater->filter('Go to page', array(array('for_attr', array()),), true) . '"
		data-xf-click="menu" role="button" tabindex="0" aria-expanded="false" aria-haspopup="true">
		' . '' . $__templater->escape($__vars['current']) . ' of ' . $__templater->escape($__vars['totalPages']) . '' . '
	</a>
	' . $__templater->callMacro(null, 'page_jump_menu', array(
		'page' => $__vars['current'],
		'totalPages' => $__vars['totalPages'],
		'link' => $__vars['link'],
		'data' => $__vars['data'],
		'params' => $__vars['params'],
		'hash' => $__vars['hash'],
		'pageParam' => $__vars['pageParam'],
	), $__vars) . '

	';
	if ($__vars['current'] < $__vars['totalPages']) {
		$__finalCompiled .= '
		<a href="' . $__templater->func('link', array($__vars['link'], $__vars['data'], $__vars['params'] + array($__vars['pageParam'] => $__vars['current'] + 1, ), $__vars['hash'], ), true) . '" class="pageNavSimple-el pageNavSimple-el--next">
			' . 'Next' . ' <i aria-hidden="true"></i>
		</a>
		<a href="' . $__templater->func('link', array($__vars['link'], $__vars['data'], $__vars['params'] + array($__vars['pageParam'] => $__vars['totalPages'], ), $__vars['hash'], ), true) . '"
			class="pageNavSimple-el pageNavSimple-el--last"
			data-xf-init="tooltip" title="' . $__templater->filter('Last', array(array('for_attr', array()),), true) . '">
			<i aria-hidden="true"></i> <span class="u-srOnly">' . 'Last' . '</span>
		</a>
	';
	}
	$__finalCompiled .= '
</div>

</nav>

' . '

';
	return $__finalCompiled;
}
);