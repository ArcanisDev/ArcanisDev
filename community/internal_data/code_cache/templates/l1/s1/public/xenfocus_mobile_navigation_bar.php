<?php
// FROM HASH: 7db0c4e58648fbdf24cf578e0a5b0f22
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->func('property', array('xenfocus_mobile_navigation_bar', ), false)) {
		$__finalCompiled .= '
<div class=\'mobile-navigation-bar\'>
	<div class=\'focus-width\'>
		<ul class=\'mobile-navigation-bar__list\'>
			<li class=\'mobile-navigation-bar--forums\'>
				<a href="' . $__templater->func('link', array('forums/list', ), true) . '">
					<span class=\'mobile-navigation-bar__icon\'>' . $__templater->fontAwesome('fa-comments', array(
		)) . '</span>
					<span class=\'mobile-navigation-bar__text\'>' . 'Forums' . '</span>
				</a>
			</li>
			<li class=\'mobile-navigation-bar--whatsnew\'>
				<a href="' . $__templater->func('link', array('whats-new', ), true) . '">
					<span class=\'mobile-navigation-bar__icon\'>' . $__templater->fontAwesome('fa-file-alt', array(
		)) . '</span>
					<span class=\'mobile-navigation-bar__text\'>' . 'What\'s new' . '</span>
				</a>
			</li>
			';
		if ($__vars['xf']['visitor']['user_id']) {
			$__finalCompiled .= '
				';
			if ($__templater->method($__vars['xf']['visitor'], 'canCreateThread', array())) {
				$__finalCompiled .= '
					<li class=\'mobile-navigation-bar--postthread\'>
						<a href="' . $__templater->func('link', array('forums/create-thread', ), true) . '" data-xf-click="overlay">
							<span class=\'mobile-navigation-bar__icon\'>' . $__templater->fontAwesome('fa-edit', array(
				)) . '</span>
							<span class=\'mobile-navigation-bar__text\'>' . 'Post thread' . '</span>
						</a>
					</li>
				';
			}
			$__finalCompiled .= '
			';
		} else {
			$__finalCompiled .= '
				<li class=\'mobile-navigation-bar--login\'>
					<a href="' . $__templater->func('link', array('login', ), true) . '" rel="nofollow" data-xf-click="overlay" data-follow-redirects="on">
						<span class=\'mobile-navigation-bar__icon\'>' . $__templater->fontAwesome('fa-sign-in-alt', array(
			)) . '</span>
						<span class=\'mobile-navigation-bar__text\'>' . 'Log in' . '</span>
					</a>
				</li>
				';
			if ($__vars['xf']['options']['registrationSetup']['enabled']) {
				$__finalCompiled .= '
					<li class=\'mobile-navigation-bar--register\'>
						<a href="' . $__templater->func('link', array('register', ), true) . '" rel="nofollow" data-xf-click="overlay" data-follow-redirects="on">
							<span class=\'mobile-navigation-bar__icon\'>' . $__templater->fontAwesome('fa-user-plus', array(
				)) . '</span>
							<span class=\'mobile-navigation-bar__text\'>' . 'Register' . '</span>
						</a>
					</li>
				';
			}
			$__finalCompiled .= '
			';
		}
		$__finalCompiled .= '
			';
		if ($__templater->method($__vars['xf']['visitor'], 'canSearch', array())) {
			$__finalCompiled .= '
				<li class=\'mobile-navigation-bar--search\'>
					<a href="' . $__templater->func('link', array('search', ), true) . '">
						<span class=\'mobile-navigation-bar__icon\'>' . $__templater->fontAwesome('fa-search', array(
			)) . '</span>
						<span class=\'mobile-navigation-bar__text\'>' . 'Search' . '</span>
					</a>
				</li>
			';
		}
		$__finalCompiled .= '
		</ul>
	</div>
</div>
';
	}
	return $__finalCompiled;
}
);