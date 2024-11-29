<?php
// FROM HASH: 19c9edbfba33d69b96aaecb15c7537e7
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__templater->test($__vars['changes'], 'empty', array())) {
		$__finalCompiled .= '
	<ol class="listPlain">
		';
		if ($__templater->isTraversable($__vars['changes'])) {
			foreach ($__vars['changes'] AS $__vars['change']) {
				$__finalCompiled .= '
			<li class="menu-row ' . ((!$__vars['change']['visible']) ? 'menu-row--alt' : '') . '">' . $__templater->escape($__vars['change']['old_username']) . '</li>
		';
			}
		}
		$__finalCompiled .= '
	</ol>
	';
		if ($__vars['seeMore']) {
			$__finalCompiled .= '
		<div class="menu-footer menu-footer--split">
			<div class="menu-footer-main">
				<ul class="listInline listInline--bullet">
					<li><a href="' . $__templater->func('link', array('members/username-history', $__vars['user'], ), true) . '" data-xf-click="overlay" data-menu-closer="true">' . 'See more' . '</a></li>
				</ul>
			</div>
		</div>
	';
		}
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	<div class="menu-row">' . 'No items to display' . '</div>
';
	}
	return $__finalCompiled;
}
);