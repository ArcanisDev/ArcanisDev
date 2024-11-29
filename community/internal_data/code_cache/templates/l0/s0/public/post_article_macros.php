<?php
// FROM HASH: 689c1b34a5c4b93abcfd27c4d60c294b
return array(
'macros' => array('article' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'post' => '!',
		'thread' => '!',
		'forum' => null,
		'isExpanded' => true,
		'isListItem' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '


	';
	$__templater->includeCss('message.less');
	$__finalCompiled .= '
	<article class="message message--article js-post js-inlineModContainer
		' . (($__vars['thread']['discussion_state'] == 'moderated') ? 'is-moderated' : '') . '
		' . (($__vars['thread']['discussion_state'] == 'deleted') ? 'is-deleted' : '') . '"
		data-author="' . ($__templater->escape($__vars['post']['User']['username']) ?: $__templater->escape($__vars['post']['username'])) . '"
		data-content="post-' . $__templater->escape($__vars['post']['post_id']) . '"
		id="js-post-' . $__templater->escape($__vars['post']['post_id']) . '">

		<span class="u-anchorTarget" id="post-' . $__templater->escape($__vars['post']['post_id']) . '"></span>
		<div class="message-inner">
			<div class="message-cell message-cell--main">
				<div class="message-expandWrapper js-expandWatch ' . ($__vars['isExpanded'] ? 'is-expanded' : '') . '">
					<div class="message-expandContent js-expandContent">
						<div class="message-main js-quickEditTarget">

							';
	if ($__vars['isListItem']) {
		$__finalCompiled .= '
								<h2 class="article-title">
									';
		if ($__vars['thread']['discussion_state'] == 'moderated') {
			$__finalCompiled .= '
										' . $__templater->fontAwesome('fa-shield', array(
				'class' => 'structItem-status--moderated',
				'aria-hidden' => 'true',
				'title' => $__templater->filter('Awaiting approval', array(array('for_attr', array()),), false),
			)) . '
										<span class="u-srOnly">' . 'Awaiting approval' . '</span>
									';
		} else if ($__vars['thread']['discussion_state'] == 'deleted') {
			$__finalCompiled .= '
										<i class="structItem-status structItem-status--deleted" aria-hidden="true" title="' . $__templater->filter('Deleted', array(array('for_attr', array()),), true) . '"></i>
										<span class="u-srOnly">' . 'Deleted' . '</span>
									';
		}
		$__finalCompiled .= '
									';
		if ($__vars['thread']['prefix_id']) {
			$__finalCompiled .= '
										';
			if ($__vars['forum']) {
				$__finalCompiled .= '
											<a href="' . $__templater->func('link', array('forums', $__vars['forum'], array('prefix_id' => $__vars['thread']['prefix_id'], ), ), true) . '" class="labelLink" rel="nofollow">' . $__templater->func('prefix', array('thread', $__vars['thread'], 'html', '', ), true) . '</a>
										';
			} else {
				$__finalCompiled .= '
											' . $__templater->func('prefix', array('thread', $__vars['thread'], 'html', '', ), true) . '
										';
			}
			$__finalCompiled .= '
									';
		}
		$__finalCompiled .= '
									<a href="' . $__templater->func('link', array('threads' . ((($__templater->method($__vars['thread'], 'isUnread', array()) AND (!$__vars['forceRead']))) ? '/unread' : ''), $__vars['thread'], ), true) . '">' . $__templater->escape($__vars['thread']['title']) . '</a>
								</h2>
							';
	}
	$__finalCompiled .= '

							' . $__templater->callMacro(null, 'post_macros::post_attribution', array(
		'post' => $__vars['post'],
		'thread' => $__vars['thread'],
		'mainClass' => 'listInline--bullet',
		'showPosition' => false,
		'showReplyCount' => ($__vars['isListItem'] ? false : true),
		'showUser' => $__vars['isListItem'],
		'showThreadUnreadIndicator' => $__vars['isListItem'],
		'showThreadStateIcons' => $__vars['isListItem'],
	), $__vars) . '

							' . $__templater->callMacro(null, 'post_macros::post_notices', array(
		'post' => $__vars['post'],
		'thread' => $__vars['thread'],
	), $__vars) . '

							<div class="message-content js-messageContent">
								' . $__templater->callMacro(null, 'post_macros::post_user_content', array(
		'post' => $__vars['post'],
		'thread' => $__vars['thread'],
		'snippet' => ($__vars['isListItem'] ? $__vars['thread']['Forum']['type_config']['expanded_snippet'] : false),
		'displayAds' => (!$__vars['isListItem']),
	), $__vars) . '

								' . $__templater->callMacro(null, 'post_macros::post_last_edit', array(
		'post' => $__vars['post'],
	), $__vars) . '
							</div>

							';
	if ($__vars['isListItem']) {
		$__finalCompiled .= '
								' . $__templater->callMacro(null, 'list_item_footer', array(
			'post' => $__vars['post'],
			'thread' => $__vars['thread'],
			'snippet' => $__vars['thread']['Forum']['type_config']['expanded_snippet'],
		), $__vars) . '

								';
		$__vars['ldJson'] = ($__vars['post'] ? $__templater->method($__vars['thread'], 'getLdStructuredData', array($__vars['post'], )) : null);
		$__finalCompiled .= '
								';
		if ($__vars['ldJson']) {
			$__finalCompiled .= '
									<script type="application/ld+json">
										' . $__templater->filter($__vars['ldJson'], array(array('json', array(true, )),array('raw', array()),), true) . '
									</script>
								';
		}
		$__finalCompiled .= '
							';
	} else {
		$__finalCompiled .= '
								' . $__templater->callMacro(null, 'post_macros::post_footer', array(
			'post' => $__vars['post'],
			'thread' => $__vars['thread'],
		), $__vars) . '
							';
	}
	$__finalCompiled .= '

						</div>
					</div>
					<div class="message-expandLink js-expandLink"><a role="button" tabindex="0">' . 'Click to expand...' . '</a></div>
				</div>
			</div>
		</div>

		';
	if (!$__vars['isListItem']) {
		$__finalCompiled .= '
			<aside class="message-articleUserInfo">
				<div class="message-cell">
					' . $__templater->callMacro(null, 'author_info', array(
			'user' => $__vars['post']['User'],
			'fallbackName' => $__vars['post']['username'],
		), $__vars) . '
				</div>
			</aside>
		';
	}
	$__finalCompiled .= '

	</article>

	';
	if (!$__vars['isListItem']) {
		$__finalCompiled .= '
		' . $__templater->callAdsMacro('post_below_container', array(
			'post' => $__vars['post'],
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'list_item_footer' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'post' => '!',
		'thread' => '!',
		'snippet' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__vars['link'] = $__templater->func('link', array('threads', $__vars['thread'], ), false);
	$__finalCompiled .= '
	';
	$__vars['linkUnread'] = $__templater->func('link', array('threads' . ($__templater->method($__vars['thread'], 'isUnread', array()) ? '/unread' : ''), $__vars['thread'], ), false);
	$__finalCompiled .= '

	<footer class="message-footer">
		<div class="message-actionBar actionBar">
			';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
						';
	if ($__vars['thread']['reply_count']) {
		$__compilerTemp1 .= '
							<a href="' . $__templater->escape($__vars['linkUnread']) . '" class="actionBar-action actionBar-action--replies">
								' . $__templater->fontAwesome('fa-comment', array(
			'class' => 'u-spaceAfter',
		)) . 'Replies' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->filter($__vars['thread']['reply_count'], array(array('number', array()),), true) . '</a>
						';
	}
	$__compilerTemp1 .= '
						';
	if ($__templater->method($__vars['thread'], 'canUseInlineModeration', array())) {
		$__compilerTemp1 .= '
							<span class="actionBar-action actionBar-action--inlineMod">' . $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'value' => $__vars['thread']['thread_id'],
			'class' => 'js-inlineModToggle',
			'data-xf-init' => 'tooltip',
			'title' => 'Select for moderation',
			'label' => 'Select for moderation',
			'hiddenlabel' => 'true',
			'_type' => 'option',
		))) . '</span>
						';
	}
	$__compilerTemp1 .= '
					';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
				<div class="actionBar-set actionBar-set--external">
					' . $__compilerTemp1 . '
				</div>
			';
	}
	$__finalCompiled .= '
			';
	$__compilerTemp2 = '';
	$__compilerTemp2 .= '
						';
	if ($__vars['snippet']) {
		$__compilerTemp2 .= '
							<a href="' . $__templater->escape($__vars['link']) . '" class="actionBar-action actionBar-action--threadLink">
								' . 'View full article' . ' &raquo;</a>
						';
	}
	$__compilerTemp2 .= '
					';
	if (strlen(trim($__compilerTemp2)) > 0) {
		$__finalCompiled .= '
				<div class="actionBar-set actionBar-set--internal">
					' . $__compilerTemp2 . '
				</div>
			';
	}
	$__finalCompiled .= '
		</div>
	</footer>
';
	return $__finalCompiled;
}
),
'author_info' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'user' => '!',
		'fallbackName' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="contentRow">
		<div class="contentRow-figure">
			' . $__templater->func('avatar', array($__vars['user'], 'm', false, array(
		'defaultname' => $__vars['fallbackName'],
	))) . '
		</div>
		<div class="contentRow-main">

			<div class="message-articleUserFirstLine">
				<div class="message-articleWrittenBy u-srOnly">' . 'Written by' . '</div>
				<h3 class="message-articleUserName">
					' . $__templater->func('username_link', array($__vars['user'], true, array(
		'defaultname' => $__vars['fallbackName'],
	))) . '
				</h3>

				';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
							' . $__templater->func('user_blurb', array($__vars['user'], array(
		'tag' => 'div',
	))) . '
						';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
					<div class="message-articleUserBlurb">
						' . $__compilerTemp1 . '
					</div>
				';
	}
	$__finalCompiled .= '
			</div>

			';
	$__compilerTemp2 = '';
	$__compilerTemp2 .= '
						';
	if ($__vars['user']['Profile']['about'] != '') {
		$__compilerTemp2 .= '
							' . $__templater->func('bb_code', array($__vars['user']['Profile']['about'], 'user:about', $__vars['user'], ), true) . '
						';
	}
	$__compilerTemp2 .= '
					';
	if (strlen(trim($__compilerTemp2)) > 0) {
		$__finalCompiled .= '
				<div class="message-articleUserAbout">
					' . $__compilerTemp2 . '
				</div>
			';
	}
	$__finalCompiled .= '

			';
	$__compilerTemp3 = '';
	$__compilerTemp3 .= $__templater->func('user_banners', array($__vars['user'], array(
	)));
	if (strlen(trim($__compilerTemp3)) > 0) {
		$__finalCompiled .= '
				<div class="message-articleUserBanners">
					' . $__compilerTemp3 . '
				</div>
			';
	}
	$__finalCompiled .= '

			<div class="message-articleUserStats">
				<ul class="listInline listInline--bullet">
					' . '
					<li><dl class="pairs pairs--inline">
						<dt>' . 'Messages' . '</dt>
						<dd>' . $__templater->filter($__vars['user']['message_count'], array(array('number', array()),), true) . '</dd>
					</dl></li>
					' . '
					<li><dl class="pairs pairs--inline">
						<dt>' . 'Reaction score' . '</dt>
						<dd>' . $__templater->filter($__vars['user']['reaction_score'], array(array('number', array()),), true) . '</dd>
					</dl></li>
					' . '
					' . '
					';
	if ($__vars['xf']['options']['enableTrophies']) {
		$__finalCompiled .= '
						<li><dl class="pairs pairs--inline">
							<dt>' . 'Points' . '</dt>
							<dd>' . $__templater->filter($__vars['user']['trophy_points'], array(array('number', array()),), true) . '</dd>
						</dl></li>
					';
	}
	$__finalCompiled .= '
					' . '
				</ul>
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'article_preview' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'thread' => '!',
		'post' => '!',
		'forum' => '!',
		'allowInlineMod' => true,
	); },
'extensions' => array('status_new' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
							';
	if ($__templater->method($__vars['thread'], 'isUnread', array())) {
		$__finalCompiled .= '
								<li><span class="message-newIndicator" title="' . ((!$__templater->method($__vars['post'], 'isUnread', array())) ? 'New replies' : '') . '">' . 'New' . '</span></li>
							';
	}
	$__finalCompiled .= '
						';
	return $__finalCompiled;
},
'status_watch' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
							';
	if ($__vars['xf']['visitor']['user_id'] AND $__vars['thread']['Watch'][$__vars['xf']['visitor']['user_id']]) {
		$__finalCompiled .= '
								<li>
									<i class="structItem-status structItem-status--watched" aria-hidden="true" title="' . $__templater->filter('Thread watched', array(array('for_attr', array()),), true) . '"></i>
									<span class="u-srOnly">' . 'Thread watched' . '</span>
								</li>
								';
	} else if ((!$__vars['forum']) AND $__vars['thread']['Forum']['Watch'][$__vars['xf']['visitor']['user_id']]) {
		$__finalCompiled .= '
								<li>
									<i class="structItem-status structItem-status--watched" aria-hidden="true" title="' . $__templater->filter('Forum watched', array(array('for_attr', array()),), true) . '"></i>
									<span class="u-srOnly">' . 'Forum watched' . '</span>
								</li>
							';
	}
	$__finalCompiled .= '
						';
	return $__finalCompiled;
},
'status_state' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
							';
	if ($__vars['thread']['discussion_state'] == 'moderated') {
		$__finalCompiled .= '
								<li>
									<i class="structItem-status structItem-status--moderated" aria-hidden="true" title="' . $__templater->filter('Awaiting approval', array(array('for_attr', array()),), true) . '"></i>
									<span class="u-srOnly">' . 'Awaiting approval' . '</span>
								</li>
							';
	}
	$__finalCompiled .= '
							';
	if ($__vars['thread']['discussion_state'] == 'deleted') {
		$__finalCompiled .= '
								<li>
									<i class="structItem-status structItem-status--deleted" aria-hidden="true" title="' . $__templater->filter('Deleted', array(array('for_attr', array()),), true) . '"></i>
									<span class="u-srOnly">' . 'Deleted' . '</span>
								</li>
							';
	}
	$__finalCompiled .= '
							';
	if (!$__vars['thread']['discussion_open']) {
		$__finalCompiled .= '
								<li>
									<i class="structItem-status structItem-status--locked" aria-hidden="true" title="' . $__templater->filter('Locked', array(array('for_attr', array()),), true) . '"></i>
									<span class="u-srOnly">' . 'Locked' . '</span>
								</li>
							';
	}
	$__finalCompiled .= '
						';
	return $__finalCompiled;
},
'status_sticky' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
							';
	if ($__vars['thread']['sticky']) {
		$__finalCompiled .= '
								<li>
									<i class="structItem-status structItem-status--sticky" aria-hidden="true" title="' . $__templater->filter('Sticky', array(array('for_attr', array()),), true) . '"></i>
									<span class="u-srOnly">' . 'Sticky' . '</span>
								</li>
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

	';
	$__vars['link'] = $__templater->func('link', array('threads', $__vars['thread'], ), false);
	$__finalCompiled .= '
	';
	$__vars['linkUnread'] = $__templater->func('link', array('threads' . ($__templater->method($__vars['thread'], 'isUnread', array()) ? '/unread' : ''), $__vars['thread'], ), false);
	$__finalCompiled .= '
	';
	$__vars['username'] = $__templater->preEscaped($__templater->func('username_link', array($__vars['thread']['User'], false, array(
		'defaultname' => $__vars['thread']['username'],
		'class' => 'u-concealed',
	))));
	$__finalCompiled .= '
	';
	$__vars['ldJson'] = ($__vars['post'] ? $__templater->method($__vars['thread'], 'getLdStructuredData', array($__vars['post'], )) : null);
	$__finalCompiled .= '

	<article class="message message--article message--articlePreview ' . (($__vars['thread']['discussion_state'] == 'moderated') ? 'is-moderated' : '') . (($__vars['thread']['discussion_state'] == 'deleted') ? 'is-deleted' : '') . ' js-inlineModContainer js-threadListItem-' . $__templater->escape($__vars['thread']['thread_id']) . '">
		<div class="articlePreview-main">
			';
	if ($__vars['thread']['cover_image']) {
		$__finalCompiled .= '
				<a href="' . $__templater->escape($__vars['linkUnread']) . '" class="articlePreview-image" style="background-image: url(\'' . $__templater->escape($__vars['thread']['cover_image']) . '\')" aria-hidden="true" tabindex="-1">&nbsp;</a>
			';
	}
	$__finalCompiled .= '
			<div class="articlePreview-text">
				<div class="articlePreview-headline">
					<h2 class="articlePreview-title">
						';
	if ($__vars['thread']['discussion_state'] == 'moderated') {
		$__finalCompiled .= '
							' . $__templater->fontAwesome('fa-shield', array(
			'class' => 'structItem-status--moderated',
			'aria-hidden' => 'true',
			'title' => $__templater->filter('Awaiting approval', array(array('for_attr', array()),), false),
		)) . '
							<span class="u-srOnly">' . 'Awaiting approval' . '</span>
						';
	} else if ($__vars['thread']['discussion_state'] == 'deleted') {
		$__finalCompiled .= '
							<i class="structItem-status structItem-status--deleted" aria-hidden="true" title="' . $__templater->filter('Deleted', array(array('for_attr', array()),), true) . '"></i>
							<span class="u-srOnly">' . 'Deleted' . '</span>
						';
	}
	$__finalCompiled .= '
						';
	if ($__vars['thread']['prefix_id']) {
		$__finalCompiled .= '
							';
		if ($__vars['forum']) {
			$__finalCompiled .= '
								<a href="' . $__templater->func('link', array('forums', $__vars['forum'], array('prefix_id' => $__vars['thread']['prefix_id'], ), ), true) . '" class="labelLink" rel="nofollow">' . $__templater->func('prefix', array('thread', $__vars['thread'], 'html', '', ), true) . '</a>
								';
		} else {
			$__finalCompiled .= '
								' . $__templater->func('prefix', array('thread', $__vars['thread'], 'html', '', ), true) . '
							';
		}
		$__finalCompiled .= '
						';
	}
	$__finalCompiled .= '
						<a href="' . $__templater->escape($__vars['linkUnread']) . '">' . $__templater->escape($__vars['thread']['title']) . '</a>
					</h2>
				</div>
				<div class="articlePreview-content">
					<div class="message-content js-messageContent" data-xf-init="lightbox">
						<div class="message-userContent lbContainer js-lbContainer"
							data-lb-id="post-' . $__templater->escape($__vars['post']['post_id']) . '"
							data-lb-caption-desc="' . ($__vars['post']['User'] ? $__templater->escape($__vars['post']['User']['username']) : $__templater->escape($__vars['post']['username'])) . ' &middot; ' . $__templater->func('date_time', array($__vars['post']['post_date'], ), true) . '">
							<article class="message-body">
								' . $__templater->func('snippet', array($__vars['post']['message'], 750, array('stripQuote' => true, 'bbWrapper' => true, ), ), true) . '
							</article>
						</div>
					</div>
				</div>
				<div class="articlePreview-links">
					<ul class="articlePreview-statuses">
						' . $__templater->renderExtension('status_new', $__vars, $__extensions) . '

						' . $__templater->renderExtension('status_watch', $__vars, $__extensions) . '

						' . $__templater->renderExtension('status_state', $__vars, $__extensions) . '

						' . $__templater->renderExtension('status_sticky', $__vars, $__extensions) . '
					</ul>

					<a href="' . $__templater->escape($__vars['link']) . '">' . 'View full article' . ' &raquo;</a>
				</div>
			</div>
		</div>
		<footer class="articlePreview-footer">
			<ul class="articlePreview-meta listPlain">
				<li>' . $__templater->func('avatar', array($__vars['thread']['User'], 'xxs', false, array(
		'defaultname' => $__vars['thread']['username'],
	))) . '</li>
				<li class="articlePreview-by">' . 'By ' . $__templater->escape($__vars['username']) . '' . '</li>
				<li><a href="' . $__templater->escape($__vars['link']) . '" class="u-concealed" rel="nofollow">' . $__templater->func('date_dynamic', array($__vars['thread']['post_date'], array(
	))) . '</a></li>
				<li class="u-flexStretch"><a href="' . $__templater->func('link', array('threads/post', $__vars['thread'], array('post_id' => $__vars['post']['post_id'], ), ), true) . '"
					class="u-concealed"
					data-xf-init="share-tooltip"
					data-href="' . $__templater->func('link', array('posts/share', $__vars['post'], ), true) . '"
					aria-label="' . $__templater->filter('Share', array(array('for_attr', array()),), true) . '"
					rel="nofollow">
					' . $__templater->fontAwesome('fa-share-alt', array(
	)) . '
				</a></li>
				';
	if ($__vars['thread']['reply_count']) {
		$__finalCompiled .= '
					<li class="articlePreview-replies"><a href="' . $__templater->escape($__vars['linkUnread']) . '"
						title="' . 'Replies' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->filter($__vars['thread']['reply_count'], array(array('number', array()),), true) . '">
						' . $__templater->fontAwesome('fa-comment', array(
			'class' => 'u-spaceAfter',
		)) . '<span class="articlePreview-repliesLabel">' . 'Replies' . $__vars['xf']['language']['label_separator'] . ' </span>' . $__templater->filter($__vars['thread']['reply_count'], array(array('number', array()),), true) . '</a></li>
				';
	}
	$__finalCompiled .= '
				';
	if ($__vars['allowInlineMod'] AND $__templater->method($__vars['thread'], 'canUseInlineModeration', array())) {
		$__finalCompiled .= '
					<li>' . $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'value' => $__vars['thread']['thread_id'],
			'class' => 'js-inlineModToggle',
			'data-xf-init' => 'tooltip',
			'title' => 'Select for moderation',
			'label' => 'Select for moderation',
			'hiddenlabel' => 'true',
			'_type' => 'option',
		))) . '</li>
				';
	}
	$__finalCompiled .= '
			</ul>
		</footer>

		';
	if ($__vars['ldJson']) {
		$__finalCompiled .= '
			<script type="application/ld+json">
				' . $__templater->filter($__vars['ldJson'], array(array('json', array(true, )),array('raw', array()),), true) . '
			</script>
		';
	}
	$__finalCompiled .= '
	</article>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . '

' . '

';
	return $__finalCompiled;
}
);