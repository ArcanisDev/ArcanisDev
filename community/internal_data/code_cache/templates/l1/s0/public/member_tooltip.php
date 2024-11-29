<?php
// FROM HASH: 5b74b692c319a9d8690391759f3e1b4f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('member_tooltip.less');
	$__finalCompiled .= '

<div class="tooltip-content-inner">
	<div class="memberTooltip ' . ($__vars['user']['Profile']['banner_date'] ? 'memberTooltip--withBanner' : '') . '">
		';
	$__compilerTemp1 = '';
	$__compilerTemp2 = '';
	$__compilerTemp2 .= '
						' . '
						';
	$__compilerTemp3 = '';
	$__compilerTemp3 .= '
										' . $__templater->callMacro('member_macros', 'moderator_menu_actions', array(
		'user' => $__vars['user'],
		'context' => 'tooltip',
	), $__vars) . '
									';
	if (strlen(trim($__compilerTemp3)) > 0) {
		$__compilerTemp2 .= '
							' . $__templater->button('
								' . $__templater->fontAwesome('fa-cog', array(
		)) . '
							', array(
			'class' => 'button--link button--small menuTrigger',
			'data-xf-click' => 'menu',
			'aria-label' => 'More options',
			'aria-expanded' => 'false',
			'aria-haspopup' => 'true',
		), '', array(
		)) . '

							<div class="menu" data-menu="menu" aria-hidden="true">
								<div class="menu-content">
									<h3 class="menu-header">' . 'Moderator tools' . '</h3>
									' . $__compilerTemp3 . '
								</div>
							</div>
						';
	}
	$__compilerTemp2 .= '
						' . '
						';
	if (strlen(trim($__compilerTemp2)) > 0) {
		$__compilerTemp1 .= '
					<div class="memberTooltip-headerAction">
						' . $__compilerTemp2 . '
					</div>
				';
	}
	$__compilerTemp4 = '';
	if ($__templater->method($__vars['user'], 'hasViewableUsernameHistory', array())) {
		$__compilerTemp4 .= '
						<a class="memberTooltip-nameChangeIndicator"
							data-xf-click="menu"
							data-xf-init="tooltip"
							title="' . $__templater->filter('Username changed', array(array('for_attr', array()),), true) . '"
							role="button"
							tabindex="0"
							aria-expanded="false"
							aria-haspopup="true"
							aria-label="' . $__templater->filter('Username changed', array(array('for_attr', array()),), true) . '">' . $__templater->fontAwesome('fa-history', array(
		)) . '</a>
						<div class="menu" data-menu="menu" aria-hidden="true"
							data-href="' . $__templater->func('link', array('members/username-history', $__vars['user'], array('menu' => 1, ), ), true) . '"
							data-load-target=".js-usernameHistoryBody">
							<div class="menu-content">
								<h3 class="menu-header">' . 'Previous usernames' . '</h3>
								<div class="js-usernameHistoryBody">
									<div class="menu-row">
										' . 'Loading' . $__vars['xf']['language']['ellipsis'] . '
									</div>
								</div>
							</div>
						</div>
					';
	}
	$__compilerTemp5 = '';
	$__compilerTemp6 = '';
	$__compilerTemp6 .= $__templater->func('user_banners', array($__vars['user'], array(
	)));
	if (strlen(trim($__compilerTemp6)) > 0) {
		$__compilerTemp5 .= '
					<div class="memberTooltip-banners">
						' . $__compilerTemp6 . '
					</div>
				';
	}
	$__compilerTemp7 = '';
	$__compilerTemp8 = '';
	$__compilerTemp8 .= '
							' . $__templater->func('user_blurb', array($__vars['user'], array(
		'tag' => 'div',
	))) . '
						';
	if (strlen(trim($__compilerTemp8)) > 0) {
		$__compilerTemp7 .= '
						<div class="memberTooltip-blurb">
						' . $__compilerTemp8 . '
						</div>
					';
	}
	$__compilerTemp9 = '';
	$__compilerTemp10 = '';
	$__compilerTemp10 .= $__templater->func('user_activity', array($__vars['user']));
	if (strlen(trim($__compilerTemp10)) > 0) {
		$__compilerTemp9 .= '
						<div class="memberTooltip-blurb">
							<dl class="pairs pairs--inline">
								<dt>' . 'Last seen' . '</dt>
								<dd dir="auto">
									' . $__compilerTemp10 . '
								</dd>
							</dl>
						</div>
					';
	}
	$__finalCompiled .= $__templater->func('profile_banner', array($__vars['user'], 'm', false, array(
		'class' => 'memberTooltip-header',
		'toggle' => 'memberTooltip--withBanner',
	), '
			<span class="memberTooltip-avatar">
				' . $__templater->func('avatar', array($__vars['user'], 'm', false, array(
		'notooltip' => 'true',
	))) . '
			</span>
			<div class="memberTooltip-headerInfo">
				' . $__compilerTemp1 . '

				<h4 class="memberTooltip-name">
					<span class="memberTooltip-nameWrapper">
						' . $__templater->func('username_link', array($__vars['user'], true, array(
		'notooltip' => 'true',
	))) . '
					</span>

					' . $__compilerTemp4 . '
				</h4>

				' . $__compilerTemp5 . '

				<div class="memberTooltip-blurbContainer">
					' . $__compilerTemp7 . '

					<div class="memberTooltip-blurb">
						<dl class="pairs pairs--inline">
							<dt>' . 'Joined' . '</dt>
							<dd>' . $__templater->func('date_dynamic', array($__vars['user']['register_date'], array(
	))) . '</dd>
						</dl>
					</div>

					' . $__compilerTemp9 . '
				</div>
			</div>
		')) . '
		<div class="memberTooltip-info">
			<div class="memberTooltip-stats">
				<div class="pairJustifier">
					' . $__templater->callMacro('member_macros', 'member_stat_pairs', array(
		'user' => $__vars['user'],
		'context' => 'tooltip',
	), $__vars) . '
				</div>
			</div>
		</div>

		';
	$__compilerTemp11 = '';
	$__compilerTemp11 .= '
				' . $__templater->callMacro('member_macros', 'member_action_buttons', array(
		'user' => $__vars['user'],
		'context' => 'tooltip',
	), $__vars) . '
			';
	if (strlen(trim($__compilerTemp11)) > 0) {
		$__finalCompiled .= '
			<hr class="memberTooltip-separator" />

			<div class="memberTooltip-actions">
			' . $__compilerTemp11 . '
			</div>
		';
	}
	$__finalCompiled .= '
	</div>
</div>';
	return $__finalCompiled;
}
);