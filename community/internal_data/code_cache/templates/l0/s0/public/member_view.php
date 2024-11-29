<?php
// FROM HASH: 820358ca2b7d42581a6aba1e5934693e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['user']['username']));
	$__templater->pageParams['pageNumber'] = $__vars['page'];
	$__finalCompiled .= '
';
	$__templater->pageParams['noH1'] = true;
	$__finalCompiled .= '

';
	if (!$__templater->method($__vars['user'], 'isSearchEngineIndexable', array())) {
		$__finalCompiled .= '
	';
		$__templater->setPageParam('head.' . 'metaNoindex', $__templater->preEscaped('<meta name="robots" content="noindex" />'));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

' . $__templater->callMacro('metadata_macros', 'metadata', array(
		'shareUrl' => $__templater->func('link', array('canonical:members', $__vars['user'], ), false),
		'canonicalUrl' => $__templater->func('link', array('canonical:members', $__vars['user'], array('page' => $__vars['page'], ), ), false),
		'imageUrl' => $__templater->method($__vars['user'], 'getAvatarUrl', array('o', null, true, )),
	), $__vars) . '

';
	$__templater->setPageParam('ldJsonHtml', '
	<script type="application/ld+json">
		' . $__templater->filter($__templater->method($__vars['user'], 'getLdStructuredData', array()), array(array('json', array(true, )),array('raw', array()),), true) . '
	</script>
');
	$__finalCompiled .= '

';
	$__templater->includeCss('member.less');
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<div class="block-body">
			<div class="memberHeader ' . ($__vars['user']['Profile']['banner_date'] ? 'memberHeader--withBanner' : '') . '">
				';
	$__compilerTemp1 = '';
	if (($__vars['user']['user_id'] == $__vars['xf']['visitor']['user_id']) AND $__templater->method($__vars['xf']['visitor'], 'canUploadAvatar', array())) {
		$__compilerTemp1 .= '
									<a class="avatarWrapper-update" href="' . $__templater->func('link', array('account/avatar', ), true) . '" data-xf-click="overlay"><span>' . 'Edit' . '</span></a>
								';
	}
	$__compilerTemp2 = '';
	$__compilerTemp3 = '';
	$__compilerTemp3 .= '
								' . '
								';
	$__compilerTemp4 = '';
	$__compilerTemp4 .= '
											';
	if ($__templater->method($__vars['user'], 'canBeReported', array())) {
		$__compilerTemp4 .= '
												' . $__templater->button('
													' . 'Report' . '
												', array(
			'href' => $__templater->func('link', array('members/report', $__vars['user'], ), false),
			'class' => 'button--link',
			'overlay' => 'true',
		), '', array(
		)) . '
											';
	}
	$__compilerTemp4 .= '
											';
	if (($__vars['user']['user_id'] == $__vars['xf']['visitor']['user_id']) AND $__templater->method($__vars['xf']['visitor'], 'canUploadProfileBanner', array())) {
		$__compilerTemp4 .= '
												' . $__templater->button('
													' . 'Edit profile banner' . '
												', array(
			'href' => $__templater->func('link', array('account/banner', ), false),
			'class' => 'button--link',
			'overlay' => 'true',
		), '', array(
		)) . '
											';
	}
	$__compilerTemp4 .= '
											';
	$__compilerTemp5 = '';
	$__compilerTemp5 .= '
																' . $__templater->callMacro('member_macros', 'moderator_menu_actions', array(
		'user' => $__vars['user'],
		'context' => 'profile',
	), $__vars) . '
															';
	if (strlen(trim($__compilerTemp5)) > 0) {
		$__compilerTemp4 .= '
												<div class="buttonGroup-buttonWrapper">
													' . $__templater->button('Moderator tools', array(
			'class' => 'button--link menuTrigger',
			'data-xf-click' => 'menu',
			'aria-expanded' => 'false',
			'aria-haspopup' => 'true',
		), '', array(
		)) . '
													<div class="menu" data-menu="menu" aria-hidden="true">
														<div class="menu-content">
															<h3 class="menu-header">' . 'Moderator tools' . '</h3>
															' . $__compilerTemp5 . '
														</div>
													</div>
												</div>
											';
	}
	$__compilerTemp4 .= '
										';
	if (strlen(trim($__compilerTemp4)) > 0) {
		$__compilerTemp3 .= '
									<div class="buttonGroup">
										' . $__compilerTemp4 . '
									</div>
								';
	}
	$__compilerTemp3 .= '
								' . '
								';
	if (strlen(trim($__compilerTemp3)) > 0) {
		$__compilerTemp2 .= '
							<div class="memberHeader-actionTop">
								' . $__compilerTemp3 . '
							</div>
						';
	}
	$__compilerTemp6 = '';
	if ($__templater->method($__vars['user'], 'hasViewableUsernameHistory', array())) {
		$__compilerTemp6 .= '
								<a class="memberHeader-nameChangeIndicator"
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
	$__compilerTemp7 = '';
	$__compilerTemp8 = '';
	$__compilerTemp8 .= $__templater->func('user_banners', array($__vars['user'], array(
	)));
	if (strlen(trim($__compilerTemp8)) > 0) {
		$__compilerTemp7 .= '
							<div class="memberHeader-banners">
								' . $__compilerTemp8 . '
							</div>
						';
	}
	$__compilerTemp9 = '';
	$__compilerTemp10 = '';
	$__compilerTemp10 .= $__templater->func('user_activity', array($__vars['user']));
	if (strlen(trim($__compilerTemp10)) > 0) {
		$__compilerTemp9 .= '
								<div class="memberHeader-blurb">
									<dl class="pairs pairs--inline">
										<dt>' . 'Last seen' . '</dt>
										<dd dir="auto">
											' . $__compilerTemp10 . '
										</dd>
									</dl>
								</div>
							';
	}
	$__finalCompiled .= $__templater->func('profile_banner', array($__vars['user'], 'l', false, array(
		'class' => 'memberHeader-main',
		'toggle' => 'memberHeader--withBanner',
	), '
					<div class="memberHeader-mainContent">
						<span class="memberHeader-avatar">
							<span class="avatarWrapper">
								' . $__templater->func('avatar', array($__vars['user'], 'l', false, array(
		'href' => ($__templater->method($__vars['user'], 'getAvatarUrl', array('o', )) ?: ''),
	))) . '
								' . $__compilerTemp1 . '
							</span>
						</span>
						<div class="memberHeader-content memberHeader-content--info">
						' . $__compilerTemp2 . '

						<h1 class="memberHeader-name">
							<span class="memberHeader-nameWrapper">
								' . $__templater->func('username_link', array($__vars['user'], true, array(
		'href' => '',
	))) . '
							</span>
							' . $__compilerTemp6 . '
						</h1>

						' . $__compilerTemp7 . '

						<div class="memberHeader-blurbContainer">
							' . $__templater->func('user_blurb', array($__vars['user'], array(
		'tag' => 'div',
		'class' => 'memberHeader-blurb',
	))) . '

							<div class="memberHeader-blurb">
								<dl class="pairs pairs--inline">
									<dt>' . 'Joined' . '</dt>
									<dd>' . $__templater->func('date_dynamic', array($__vars['user']['register_date'], array(
	))) . '</dd>
								</dl>
							</div>

							' . $__compilerTemp9 . '
						</div>
					</div>
					</div>
				')) . '

				<div class="memberHeader-content">
					<div class="memberHeader-stats">
						<div class="pairJustifier">
							' . $__templater->callMacro('member_macros', 'member_stat_pairs', array(
		'user' => $__vars['user'],
		'context' => 'profile',
	), $__vars) . '
						</div>
					</div>

					';
	$__compilerTemp11 = '';
	$__compilerTemp11 .= '
								' . $__templater->callMacro('member_macros', 'member_action_buttons', array(
		'user' => $__vars['user'],
		'context' => 'profile',
	), $__vars) . '
							';
	if (strlen(trim($__compilerTemp11)) > 0) {
		$__finalCompiled .= '
						<hr class="memberHeader-separator" />

						<div class="memberHeader-buttons">
							' . $__compilerTemp11 . '
						</div>
					';
	}
	$__finalCompiled .= '
				</div>

			</div>
		</div>
		<h2 class="block-tabHeader block-tabHeader--memberTabs tabs hScroller"
			data-xf-init="tabs h-scroller"
			data-panes=".js-memberTabPanes"
			data-state="replace"
			role="tablist">
			<span class="hScroller-scroll">
				' . '
				';
	if ($__templater->method($__vars['user'], 'canViewPostsOnProfile', array())) {
		$__finalCompiled .= '
					<a href="' . $__templater->func('link', array('members', $__vars['user'], ), true) . '"
						class="tabs-tab is-active"
						role="tab"
						aria-controls="profile-posts">' . 'Profile posts' . '</a>
				';
	}
	$__finalCompiled .= '

				';
	if ($__templater->method($__vars['user'], 'canViewLatestActivity', array())) {
		$__finalCompiled .= '
					';
		if (!$__templater->method($__vars['user'], 'canViewPostsOnProfile', array())) {
			$__finalCompiled .= '
						<a href="' . $__templater->func('link', array('members', $__vars['user'], ), true) . '"
							class="tabs-tab is-active"
							role="tab"
							aria-controls="latest-activity">' . 'Latest activity' . '</a>
					';
		} else {
			$__finalCompiled .= '
						<a href="' . $__templater->func('link', array('members/latest-activity', $__vars['user'], ), true) . '"
							rel="nofollow"
							class="tabs-tab"
							id="latest-activity"
							role="tab">' . 'Latest activity' . '</a>
					';
		}
		$__finalCompiled .= '
				';
	}
	$__finalCompiled .= '

				<a href="' . $__templater->func('link', array('members/recent-content', $__vars['user'], ), true) . '"
					rel="nofollow"
					class="tabs-tab"
					id="recent-content"
					role="tab">' . 'Postings' . '</a>

				' . '

				<a href="' . $__templater->func('link', array('members/about', $__vars['user'], ), true) . '"
					class="tabs-tab"
					id="about"
					role="tab">' . 'About' . '</a>

				';
	if ($__templater->method($__vars['xf']['visitor'], 'canViewWarnings', array()) AND $__vars['user']['warning_count']) {
		$__finalCompiled .= '
					<a href="' . $__templater->func('link', array('members/warnings', $__vars['user'], ), true) . '"
						class="tabs-tab"
						id="warnings"
						role="tab">' . 'Warnings' . '</a>
				';
	}
	$__finalCompiled .= '
				' . '
			</span>
		</h2>
	</div>
</div>

' . $__templater->callAdsMacro('member_view_below_tabs', array(
		'user' => $__vars['user'],
	), $__vars) . '

<ul class="tabPanes js-memberTabPanes">
	' . '
	';
	if ($__templater->method($__vars['user'], 'canViewPostsOnProfile', array())) {
		$__finalCompiled .= '
		<li class="is-active" role="tabpanel" id="profile-posts">
			';
		$__templater->includeJs(array(
			'src' => 'xf/inline_mod.js',
			'min' => '1',
		));
		$__finalCompiled .= '

			' . $__templater->callMacro('lightbox_macros', 'setup', array(
			'canViewAttachments' => $__vars['canViewAttachments'],
		), $__vars) . '

			<div class="block block--messages"
				data-xf-init="lightbox inline-mod"
				data-type="profile_post"
				data-href="' . $__templater->func('link', array('inline-mod', ), true) . '">

				<div class="block-container">
					<div class="block-body js-replyNewMessageContainer">
						';
		if ($__templater->method($__vars['user'], 'canPostOnProfile', array())) {
			$__finalCompiled .= '
							';
			$__vars['firstProfilePost'] = $__templater->filter($__vars['profilePosts'], array(array('first', array()),), false);
			$__finalCompiled .= '
							' . $__templater->callMacro('profile_post_macros', 'quick_post', array(
				'user' => $__vars['user'],
				'lastDate' => ($__vars['firstProfilePost']['post_date'] ?: 0),
				'containerSelector' => '< .js-replyNewMessageContainer',
				'attachmentData' => $__vars['attachmentData'],
			), $__vars) . '
						';
		}
		$__finalCompiled .= '

						';
		if (!$__templater->test($__vars['profilePosts'], 'empty', array())) {
			$__finalCompiled .= '
							';
			if ($__templater->isTraversable($__vars['profilePosts'])) {
				foreach ($__vars['profilePosts'] AS $__vars['profilePost']) {
					$__finalCompiled .= '
								' . $__templater->callMacro('profile_post_macros', (($__vars['profilePost']['message_state'] == 'deleted') ? 'profile_post_deleted' : 'profile_post'), array(
						'attachmentData' => $__vars['profilePostAttachData'][$__vars['profilePost']['profile_post_id']],
						'profilePost' => $__vars['profilePost'],
					), $__vars) . '
							';
				}
			}
			$__finalCompiled .= '
						';
		} else {
			$__finalCompiled .= '
							<div class="block-row js-replyNoMessages">' . 'There are no messages on ' . $__templater->escape($__vars['user']['username']) . '\'s profile yet.' . '</div>
						';
		}
		$__finalCompiled .= '
					</div>
				</div>

				<div class="block-outer block-outer--after">
					' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'link' => 'members',
			'data' => $__vars['user'],
			'wrapperclass' => 'block-outer-main',
			'perPage' => $__vars['perPage'],
		))) . '
					<div class="block-outer-opposite">
						' . $__templater->func('show_ignored', array(array(
		))) . '
						';
		if ($__vars['canInlineMod']) {
			$__finalCompiled .= '
							' . $__templater->callMacro('inline_mod_macros', 'button', array(), $__vars) . '
						';
		}
		$__finalCompiled .= '
					</div>
				</div>
			</div>
		</li>
	';
	}
	$__finalCompiled .= '

	';
	if ($__templater->method($__vars['user'], 'canViewLatestActivity', array())) {
		$__finalCompiled .= '
		';
		if (!$__templater->method($__vars['user'], 'canViewPostsOnProfile', array())) {
			$__finalCompiled .= '
			<li class="is-active" role="tabpanel" id="latest-activity">
				<div class="block">
					<div class="block-container">
						';
			if (!$__templater->test($__vars['newsFeedItems'], 'empty', array())) {
				$__finalCompiled .= '
							<ul class="block-body js-newsFeedTarget">
								';
				if ($__templater->isTraversable($__vars['newsFeedItems'])) {
					foreach ($__vars['newsFeedItems'] AS $__vars['item']) {
						$__finalCompiled .= '
									' . $__templater->callMacro('news_feed_macros', 'feed_row', array(
							'item' => $__vars['item'],
						), $__vars) . '
								';
					}
				}
				$__finalCompiled .= '
							</ul>
							<div class="block-footer js-newsFeedLoadMore">
								<span class="block-footer-controls">' . $__templater->button('
									' . 'Show older items' . '
								', array(
					'href' => $__templater->func('link', array('members/latest-activity', $__vars['user'], array('before_id' => $__vars['newsFeedOldestItemId'], ), ), false),
					'data-xf-click' => 'inserter',
					'data-append' => '.js-newsFeedTarget',
					'data-replace' => '.js-newsFeedLoadMore',
				), '', array(
				)) . '</span>
							</div>
							';
			} else {
				$__finalCompiled .= '
							<div class="block-body js-newsFeedTarget">
								<div class="block-row">' . 'The news feed is currently empty.' . '</div>
							</div>
						';
			}
			$__finalCompiled .= '
					</div>

					<div class="block-outer block-outer--after">
						<div class="block-outer-opposite">
							' . $__templater->func('show_ignored', array(array(
			))) . '
						</div>
					</div>
				</div>
			</li>
		';
		} else {
			$__finalCompiled .= '
			<li data-href="' . $__templater->func('link', array('members/latest-activity', $__vars['user'], ), true) . '" role="tabpanel" aria-labelledby="latest-activity">
				<div class="blockMessage">' . 'Loading' . $__vars['xf']['language']['ellipsis'] . '</div>
			</li>
		';
		}
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '

	<li data-href="' . $__templater->func('link', array('members/recent-content', $__vars['user'], ), true) . '" role="tabpanel" aria-labelledby="recent-content">
		<div class="blockMessage">' . 'Loading' . $__vars['xf']['language']['ellipsis'] . '</div>
	</li>

	' . '

	<li data-href="' . $__templater->func('link', array('members/about', $__vars['user'], ), true) . '" role="tabpanel" aria-labelledby="about">
		<div class="blockMessage">' . 'Loading' . $__vars['xf']['language']['ellipsis'] . '</div>
	</li>

	';
	if ($__templater->method($__vars['xf']['visitor'], 'canViewWarnings', array()) AND $__vars['user']['warning_count']) {
		$__finalCompiled .= '
		<li data-href="' . $__templater->func('link', array('members/warnings', $__vars['user'], ), true) . '" role="tabpanel" aria-labelledby="warnings">
			<div class="blockMessage">' . 'Loading' . $__vars['xf']['language']['ellipsis'] . '</div>
		</li>
	';
	}
	$__finalCompiled .= '
	' . '
</ul>

';
	$__templater->modifySidebarHtml('_xfWidgetPositionSidebarfeaef3b7c6b482f185e4871860a95125', $__templater->widgetPosition('member_view_sidebar', array(
		'user' => $__vars['user'],
	)), 'replace');
	return $__finalCompiled;
}
);