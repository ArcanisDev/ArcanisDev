<?php
// FROM HASH: d33c2eaa7d0c532a2ff8580f0a81e629
return array(
'macros' => array('attribution' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'profilePost' => '!',
		'showTargetUser' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__vars['showTargetUser'] AND ($__vars['profilePost']['user_id'] != $__vars['profilePost']['profile_user_id'])) {
		$__finalCompiled .= '
		' . $__templater->func('username_link', array($__vars['profilePost']['User'], true, array(
			'defaultname' => $__vars['profilePost']['username'],
			'aria-hidden' => 'true',
		))) . '
		' . $__templater->fontAwesome(($__vars['xf']['isRtl'] ? 'fa-caret-left' : 'fa-caret-right') . ' u-muted', array(
		)) . '
		' . $__templater->func('username_link', array($__vars['profilePost']['ProfileUser'], true, array(
			'defaultname' => 'Unknown',
			'aria-hidden' => 'true',
		))) . '
		<span class="u-srOnly">' . '' . ($__templater->escape($__vars['profilePost']['User']['username']) ?: $__templater->escape($__vars['profilePost']['username'])) . ' wrote on ' . ($__templater->escape($__vars['profilePost']['ProfileUser']['username']) ?: 'Unknown') . '\'s profile.' . '</span>
	';
	} else {
		$__finalCompiled .= '
		' . $__templater->func('username_link', array($__vars['profilePost']['User'], true, array(
			'defaultname' => $__vars['profilePost']['username'],
		))) . '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'profile_post' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'profilePost' => '!',
		'attachmentData' => null,
		'showTargetUser' => false,
		'allowInlineMod' => true,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__templater->includeCss('message.less');
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'src' => 'xf/comment.js',
		'min' => '1',
	));
	$__finalCompiled .= '

	<article class="message message--simple ' . ($__templater->method($__vars['profilePost'], 'isIgnored', array()) ? 'is-ignored' : '') . ' js-inlineModContainer"
		data-author="' . ($__templater->escape($__vars['profilePost']['User']['username']) ?: $__templater->escape($__vars['profilePost']['username'])) . '"
		data-content="profile-post-' . $__templater->escape($__vars['profilePost']['profile_post_id']) . '"
		id="js-profilePost-' . $__templater->escape($__vars['profilePost']['profile_post_id']) . '">

		<span class="u-anchorTarget" id="profile-post-' . $__templater->escape($__vars['profilePost']['profile_post_id']) . '"></span>
		<div class="message-inner">
			<div class="message-cell message-cell--user">
				' . $__templater->callMacro('message_macros', 'user_info_simple', array(
		'user' => $__vars['profilePost']['User'],
		'fallbackName' => $__vars['profilePost']['username'],
	), $__vars) . '
			</div>
			<div class="message-cell message-cell--main">
				<div class="message-main js-quickEditTarget">
					<div class="message-content js-messageContent">
						<header class="message-attribution message-attribution--plain">
							<ul class="listInline listInline--bullet">
								<li class="message-attribution-user">
									' . $__templater->func('avatar', array($__vars['profilePost']['User'], 'xxs', false, array(
	))) . '
									<h4 class="attribution">' . $__templater->callMacro(null, 'attribution', array(
		'profilePost' => $__vars['profilePost'],
		'showTargetUser' => $__vars['showTargetUser'],
	), $__vars) . '</h4>
								</li>
								<li><a href="' . $__templater->func('link', array('profile-posts', $__vars['profilePost'], ), true) . '" class="u-concealed" rel="nofollow">' . $__templater->func('date_dynamic', array($__vars['profilePost']['post_date'], array(
	))) . '</a></li>
							</ul>
						</header>

						';
	if ($__vars['profilePost']['message_state'] == 'deleted') {
		$__finalCompiled .= '
							<div class="messageNotice messageNotice--deleted">
								' . $__templater->callMacro('deletion_macros', 'notice', array(
			'log' => $__vars['profilePost']['DeletionLog'],
		), $__vars) . '
							</div>
						';
	} else if ($__vars['profilePost']['message_state'] == 'moderated') {
		$__finalCompiled .= '
							<div class="messageNotice messageNotice--moderated">
								' . 'This message is awaiting moderator approval, and is invisible to normal visitors.' . '
							</div>
						';
	}
	$__finalCompiled .= '
						';
	if ($__vars['profilePost']['warning_message']) {
		$__finalCompiled .= '
							<div class="messageNotice messageNotice--warning">
								' . $__templater->escape($__vars['profilePost']['warning_message']) . '
							</div>
						';
	}
	$__finalCompiled .= '
						';
	if ($__templater->method($__vars['profilePost'], 'isIgnored', array())) {
		$__finalCompiled .= '
							<div class="messageNotice messageNotice--ignored">
								' . 'You are ignoring content by this member.' . '
							</div>
						';
	}
	$__finalCompiled .= '

						<div class="lbContainer js-lbContainer"
							data-lb-id="profile-post-' . $__templater->escape($__vars['profilePost']['profile_post_id']) . '"
							data-lb-caption-desc="' . ($__vars['profilePost']['User'] ? $__templater->escape($__vars['profilePost']['User']['username']) : $__templater->escape($__vars['profilePost']['username'])) . ' &middot; ' . $__templater->func('date_time', array($__vars['profilePost']['post_date'], ), true) . '">
							<article class="message-body">
								' . $__templater->func('bb_code', array($__vars['profilePost']['message'], 'profile_post', $__vars['profilePost'], ), true) . '
							</article>

							';
	if ($__vars['profilePost']['attach_count']) {
		$__finalCompiled .= '
								' . $__templater->callMacro('message_macros', 'attachments', array(
			'attachments' => $__vars['profilePost']['Attachments'],
			'message' => $__vars['profilePost'],
			'canView' => $__templater->method($__vars['xf']['visitor'], 'hasPermission', array('profilePost', 'viewAttachment', )),
		), $__vars) . '
							';
	}
	$__finalCompiled .= '
						</div>
					</div>

					<footer class="message-footer">
						<div class="message-actionBar actionBar">
							';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
									' . $__templater->func('react', array(array(
		'content' => $__vars['profilePost'],
		'link' => 'profile-posts/react',
		'list' => '< .message | .js-reactionsList',
	))) . '

									';
	if ($__templater->method($__vars['profilePost'], 'canComment', array()) AND $__templater->func('property', array('profilePostCommentToggle', ), false)) {
		$__compilerTemp1 .= '
										<a class="actionBar-action actionBar-action--reply"
											data-xf-click="comment-toggle"
											data-target=".js-commentsTarget-' . $__templater->escape($__vars['profilePost']['profile_post_id']) . '"
											data-scroll-to="true"
											role="button"
											tabindex="0">' . 'Comment' . '</a>
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
	if ($__vars['allowInlineMod'] AND $__templater->method($__vars['profilePost'], 'canUseInlineModeration', array())) {
		$__compilerTemp2 .= '
										<span class="actionBar-action actionBar-action--inlineMod">
											' . $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'value' => $__vars['profilePost']['profile_post_id'],
			'class' => 'js-inlineModToggle',
			'data-xf-init' => 'tooltip',
			'title' => 'Select for moderation',
			'label' => 'Select for moderation',
			'hiddenlabel' => 'true',
			'_type' => 'option',
		))) . '
										</span>
									';
	}
	$__compilerTemp2 .= '
									';
	if ($__templater->method($__vars['profilePost'], 'canReport', array())) {
		$__compilerTemp2 .= '
										<a href="' . $__templater->func('link', array('profile-posts/report', $__vars['profilePost'], ), true) . '" class="actionBar-action actionBar-action--report" data-xf-click="overlay">' . 'Report' . '</a>
									';
	}
	$__compilerTemp2 .= '

									';
	$__vars['hasActionBarMenu'] = false;
	$__compilerTemp2 .= '
									';
	if ($__templater->method($__vars['profilePost'], 'canEdit', array())) {
		$__compilerTemp2 .= '
										';
		$__templater->includeJs(array(
			'src' => 'xf/message.js',
			'min' => '1',
		));
		$__compilerTemp2 .= '
										<a href="' . $__templater->func('link', array('profile-posts/edit', $__vars['profilePost'], ), true) . '"
											class="actionBar-action actionBar-action--edit actionBar-action--menuItem"
											data-xf-click="quick-edit"
											data-editor-target="#js-profilePost-' . $__templater->escape($__vars['profilePost']['profile_post_id']) . ' .js-quickEditTarget"
											data-no-inline-mod="' . ((!$__vars['allowInlineMod']) ? 1 : 0) . '"
											data-menu-closer="true">' . 'Edit' . '</a>
										';
		$__vars['hasActionBarMenu'] = true;
		$__compilerTemp2 .= '
									';
	}
	$__compilerTemp2 .= '
									';
	if ($__templater->method($__vars['profilePost'], 'canDelete', array('soft', ))) {
		$__compilerTemp2 .= '
										<a href="' . $__templater->func('link', array('profile-posts/delete', $__vars['profilePost'], ), true) . '"
											class="actionBar-action actionBar-action--delete actionBar-action--menuItem"
											data-xf-click="overlay">' . 'Delete' . '</a>
										';
		$__vars['hasActionBarMenu'] = true;
		$__compilerTemp2 .= '
									';
	}
	$__compilerTemp2 .= '
									';
	if (($__vars['profilePost']['message_state'] == 'deleted') AND $__templater->method($__vars['profilePost'], 'canUndelete', array())) {
		$__compilerTemp2 .= '
										<a href="' . $__templater->func('link', array('profile-posts/undelete', $__vars['profilePost'], ), true) . '" data-xf-click="overlay"
											class="actionBar-action actionBar-action--undelete actionBar-action--menuItem">' . 'Undelete' . '</a>
										';
		$__vars['hasActionBarMenu'] = true;
		$__compilerTemp2 .= '
									';
	}
	$__compilerTemp2 .= '
									';
	if ($__templater->method($__vars['profilePost'], 'canCleanSpam', array())) {
		$__compilerTemp2 .= '
										<a href="' . $__templater->func('link', array('spam-cleaner', $__vars['profilePost'], ), true) . '"
											class="actionBar-action actionBar-action--spam actionBar-action--menuItem"
											data-xf-click="overlay">' . 'Spam' . '</a>
										';
		$__vars['hasActionBarMenu'] = true;
		$__compilerTemp2 .= '
									';
	}
	$__compilerTemp2 .= '
									';
	if ($__templater->method($__vars['xf']['visitor'], 'canViewIps', array()) AND $__vars['profilePost']['ip_id']) {
		$__compilerTemp2 .= '
										<a href="' . $__templater->func('link', array('profile-posts/ip', $__vars['profilePost'], ), true) . '"
											class="actionBar-action actionBar-action--ip actionBar-action--menuItem"
											data-xf-click="overlay">' . 'IP' . '</a>
										';
		$__vars['hasActionBarMenu'] = true;
		$__compilerTemp2 .= '
									';
	}
	$__compilerTemp2 .= '
									';
	if ($__templater->method($__vars['profilePost'], 'canWarn', array())) {
		$__compilerTemp2 .= '
										<a href="' . $__templater->func('link', array('profile-posts/warn', $__vars['profilePost'], ), true) . '"
											class="actionBar-action actionBar-action--warn actionBar-action--menuItem">' . 'Warn' . '</a>
										';
		$__vars['hasActionBarMenu'] = true;
		$__compilerTemp2 .= '
									';
	} else if ($__vars['profilePost']['warning_id'] AND $__templater->method($__vars['xf']['visitor'], 'canViewWarnings', array())) {
		$__compilerTemp2 .= '
										<a href="' . $__templater->func('link', array('warnings', array('warning_id' => $__vars['profilePost']['warning_id'], ), ), true) . '"
											class="actionBar-action actionBar-action--warn actionBar-action--menuItem"
											data-xf-click="overlay">' . 'View warning' . '</a>
										';
		$__vars['hasActionBarMenu'] = true;
		$__compilerTemp2 .= '
									';
	}
	$__compilerTemp2 .= '

									';
	if ($__vars['hasActionBarMenu']) {
		$__compilerTemp2 .= '
										<a class="actionBar-action actionBar-action--menuTrigger"
											data-xf-click="menu"
											title="' . $__templater->filter('More options', array(array('for_attr', array()),), true) . '"
											role="button"
											tabindex="0"
											aria-expanded="false"
											aria-haspopup="true">&#8226;&#8226;&#8226;</a>
										<div class="menu" data-menu="menu" aria-hidden="true" data-menu-builder="actionBar">
											<div class="menu-content">
												<h4 class="menu-header">' . 'More options' . '</h4>
												<div class="js-menuBuilderTarget"></div>
											</div>
										</div>
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

						<section class="message-responses js-messageResponses">
							<div class="message-responseRow message-responseRow--reactions js-reactionsList ' . ($__vars['profilePost']['reactions'] ? 'is-active' : '') . '">';
	if ($__vars['profilePost']['reactions']) {
		$__finalCompiled .= '
								' . $__templater->func('reactions', array($__vars['profilePost'], 'profile-posts/reactions', array())) . '
							';
	}
	$__finalCompiled .= '</div>

							';
	if (!$__templater->test($__vars['profilePost']['LatestComments'], 'empty', array())) {
		$__finalCompiled .= '
								';
		if ($__templater->method($__vars['profilePost'], 'hasMoreComments', array())) {
			$__finalCompiled .= '
									<div class="message-responseRow u-jsOnly js-commentLoader">
										<a href="' . $__templater->func('link', array('profile-posts/load-previous', $__vars['profilePost'], array('before' => $__templater->arrayKey($__templater->method($__vars['profilePost']['LatestComments'], 'first', array()), 'comment_date'), ), ), true) . '"
											data-xf-click="comment-loader"
											data-container=".js-commentLoader"
											rel="nofollow">' . 'View previous comments' . $__vars['xf']['language']['ellipsis'] . '</a>
									</div>
								';
		}
		$__finalCompiled .= '
								<div class="js-replyNewMessageContainer">
									';
		if ($__templater->isTraversable($__vars['profilePost']['LatestComments'])) {
			foreach ($__vars['profilePost']['LatestComments'] AS $__vars['comment']) {
				$__finalCompiled .= '
										' . $__templater->callMacro(null, (($__vars['comment']['message_state'] == 'deleted') ? 'comment_deleted' : 'comment'), array(
					'comment' => $__vars['comment'],
					'profilePost' => $__vars['profilePost'],
				), $__vars) . '
									';
			}
		}
		$__finalCompiled .= '
								</div>
							';
	} else {
		$__finalCompiled .= '
								<div class="js-replyNewMessageContainer"></div>
							';
	}
	$__finalCompiled .= '

							';
	if ($__templater->method($__vars['profilePost'], 'canComment', array())) {
		$__finalCompiled .= '
								';
		$__templater->includeJs(array(
			'src' => 'xf/message.js',
			'min' => '1',
		));
		$__finalCompiled .= '
								<div class="message-responseRow js-commentsTarget-' . $__templater->escape($__vars['profilePost']['profile_post_id']) . ' ' . ($__templater->func('property', array('profilePostCommentToggle', ), false) ? 'toggleTarget' : '') . '">
									';
		$__vars['lastProfilePostComment'] = $__templater->filter($__vars['profilePost']['LatestComments'], array(array('last', array()),), false);
		$__finalCompiled .= $__templater->form('
										<div class="comment-inner">
											<span class="comment-avatar">
												' . $__templater->func('avatar', array($__vars['xf']['visitor'], 'xxs', false, array(
		))) . '
											</span>
											<div class="comment-main">
												<div class="editorPlaceholder" data-xf-click="editor-placeholder">
													<div class="editorPlaceholder-editor is-hidden">
														' . $__templater->callMacro('quick_reply_macros', 'editor', array(
			'attachmentData' => $__vars['attachmentData'],
			'minHeight' => '40',
			'placeholder' => 'Write a comment' . $__vars['xf']['language']['ellipsis'],
			'submitText' => 'Post comment',
			'deferred' => true,
			'simpleSubmit' => true,
		), $__vars) . '
													</div>
													<div class="editorPlaceholder-placeholder">
														<div class="input"><span class="u-muted"> ' . 'Write a comment' . $__vars['xf']['language']['ellipsis'] . '</span></div>
													</div>
												</div>
											</div>
										</div>
										' . '' . '
										' . $__templater->formHiddenVal('last_date', $__vars['lastProfilePostComment']['comment_date'], array(
		)) . '
									', array(
			'action' => $__templater->func('link', array('profile-posts/add-comment', $__vars['profilePost'], ), false),
			'ajax' => 'true',
			'class' => 'comment',
			'data-xf-init' => 'attachment-manager quick-reply',
			'data-message-container' => '< .js-messageResponses | .js-replyNewMessageContainer',
		)) . '
								</div>
							';
	}
	$__finalCompiled .= '
						</section>
					</footer>
				</div>
			</div>
		</div>
	</article>
';
	return $__finalCompiled;
}
),
'profile_post_deleted' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'profilePost' => '!',
		'showTargetUser' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__templater->includeCss('message.less');
	$__finalCompiled .= '
	<div class="message message--simple' . ($__templater->method($__vars['profilePost'], 'isIgnored', array()) ? ' is-ignored' : '') . ' js-inlineModContainer"
		data-author="' . ($__templater->escape($__vars['profilePost']['User']['username']) ?: $__templater->escape($__vars['profilePost']['username'])) . '"
		data-content="profile-post-' . $__templater->escape($__vars['profilePost']['profile_post_id']) . '">

		<span class="u-anchorTarget" id="profile-post-' . $__templater->escape($__vars['profilePost']['profile_post_id']) . '"></span>
		<div class="message-inner">
			<div class="message-cell message-cell--user">
				' . $__templater->callMacro('message_macros', 'user_info_simple', array(
		'user' => $__vars['profilePost']['User'],
		'fallbackName' => $__vars['profilePost']['username'],
	), $__vars) . '
			</div>
			<div class="message-cell message-cell--main">
				<div class="message-attribution message-attribution--plain">
					<ul class="listInline listInline--bullet">
						<li class="message-attribution-user">
							' . $__templater->func('avatar', array($__vars['profilePost']['User'], 'xxs', false, array(
	))) . '
							<h4 class="attribution">' . $__templater->callMacro(null, 'attribution', array(
		'profilePost' => $__vars['profilePost'],
		'showTargetUser' => $__vars['showTargetUser'],
	), $__vars) . '</h4>
						</li>
						<li>' . $__templater->func('date_dynamic', array($__vars['profilePost']['post_date'], array(
	))) . '</li>
					</ul>
				</div>

				<div class="messageNotice messageNotice--deleted">
					' . $__templater->callMacro('deletion_macros', 'notice', array(
		'log' => $__vars['profilePost']['DeletionLog'],
	), $__vars) . '

					<a href="' . $__templater->func('link', array('profile-posts/show', $__vars['profilePost'], ), true) . '" class="u-jsOnly" data-xf-click="inserter" data-replace="[data-content=profile-post-' . $__templater->escape($__vars['profilePost']['profile_post_id']) . ']">' . 'Show' . $__vars['xf']['language']['ellipsis'] . '</a>

					';
	if ($__templater->method($__vars['profilePost'], 'canUseInlineModeration', array())) {
		$__finalCompiled .= '
						<span style="display: none">
							<!-- this can be actioned on the full post -->
							' . $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'value' => $__vars['profilePost']['profile_post_id'],
			'class' => 'js-inlineModToggle',
			'hiddenlabel' => 'true',
			'_type' => 'option',
		))) . '
						</span>
					';
	}
	$__finalCompiled .= '
				</div>
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'profile_post_simple' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'profilePost' => '!',
		'limitHeight' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	<div class="contentRow">
		<div class="contentRow-figure">
			' . $__templater->func('avatar', array($__vars['profilePost']['User'], 'xxs', false, array(
		'defaultname' => $__vars['profilePost']['username'],
	))) . '
		</div>
		<div class="contentRow-main contentRow-main--close">
			<div class="contentRow-lesser">
				' . $__templater->callMacro(null, 'attribution', array(
		'profilePost' => $__vars['profilePost'],
		'showTargetUser' => true,
	), $__vars) . '
			</div>

			';
	if ($__vars['limitHeight']) {
		$__finalCompiled .= '
				<div class="contentRow-faderContainer">
					<div class="contentRow-faderContent">
						' . $__templater->func('bb_code', array($__vars['profilePost']['message'], 'profile_post', $__vars['profilePost'], array('simpleUnfurl' => true, ), ), true) . '
					</div>
					<div class="contentRow-fader"></div>
				</div>
			';
	} else {
		$__finalCompiled .= '
				' . $__templater->func('bb_code', array($__vars['profilePost']['message'], 'profile_post', $__vars['profilePost'], array('simpleUnfurl' => true, ), ), true) . '
			';
	}
	$__finalCompiled .= '

			<div class="contentRow-minor">
				<a href="' . $__templater->func('link', array('profile-posts', $__vars['profilePost'], ), true) . '" rel="nofollow" class="u-concealed">' . $__templater->func('date_dynamic', array($__vars['profilePost']['post_date'], array(
	))) . '</a>
				<a href="' . $__templater->func('link', array('profile-posts', $__vars['profilePost'], ), true) . '" rel="nofollow" class="contentRow-extra" data-xf-click="overlay" data-xf-init="tooltip" title="' . $__templater->filter('Interact', array(array('for_attr', array()),), true) . '">&#8226;&#8226;&#8226;</a>
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'comment' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'comment' => '!',
		'profilePost' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__templater->includeCss('message.less');
	$__finalCompiled .= '

	<div class="message-responseRow ' . ($__templater->method($__vars['comment'], 'isIgnored', array()) ? 'is-ignored' : '') . '">
		<div class="comment"
			data-author="' . $__templater->escape($__vars['comment']['User']['username']) . '"
			data-content="profile-post-comment-' . $__templater->escape($__vars['comment']['profile_post_comment_id']) . '"
			id="js-profilePostComment-' . $__templater->escape($__vars['comment']['profile_post_comment_id']) . '">

			<div class="comment-inner">
				<span class="comment-avatar">
					' . $__templater->func('avatar', array($__vars['comment']['User'], 'xxs', false, array(
		'defaultname' => $__vars['comment']['username'],
	))) . '
				</span>
				<div class="comment-main">
					<span class="u-anchorTarget" id="profile-post-comment-' . $__templater->escape($__vars['comment']['profile_post_comment_id']) . '"></span>
					<div class="js-quickEditTargetComment">
						<div class="comment-content">
							';
	if ($__vars['comment']['message_state'] == 'deleted') {
		$__finalCompiled .= '
								<div class="messageNotice messageNotice--deleted">
									' . $__templater->callMacro('deletion_macros', 'notice', array(
			'log' => $__vars['comment']['DeletionLog'],
		), $__vars) . '
								</div>
							';
	} else if ($__vars['comment']['message_state'] == 'moderated') {
		$__finalCompiled .= '
								<div class="messageNotice messageNotice--moderated">
									' . 'This message is awaiting moderator approval, and is invisible to normal visitors.' . '
								</div>
							';
	}
	$__finalCompiled .= '
							';
	if ($__vars['comment']['warning_message']) {
		$__finalCompiled .= '
								<div class="messageNotice messageNotice--warning">
									' . $__templater->escape($__vars['comment']['warning_message']) . '
								</div>
							';
	}
	$__finalCompiled .= '
							';
	if ($__templater->method($__vars['comment'], 'isIgnored', array())) {
		$__finalCompiled .= '
								<div class="messageNotice messageNotice--ignored">
									' . 'You are ignoring content by this member.' . '
								</div>
							';
	}
	$__finalCompiled .= '

							<div class="comment-contentWrapper">
								' . $__templater->func('username_link', array($__vars['comment']['User'], true, array(
		'defaultname' => $__vars['comment']['username'],
		'class' => 'comment-user',
	))) . '
								<div class="lbContainer js-lbContainer"
									data-lb-id="profile-post-comment-' . $__templater->escape($__vars['comment']['profile_post_comment_id']) . '"
									data-lb-caption-desc="' . ($__vars['comment']['User'] ? $__templater->escape($__vars['comment']['User']['username']) : $__templater->escape($__vars['comment']['username'])) . ' &middot; ' . $__templater->func('date_time', array($__vars['comment']['comment_date'], ), true) . '">
									<article class="comment-body">
										' . $__templater->func('bb_code', array($__vars['comment']['message'], 'profile_post_comment', $__vars['comment'], ), true) . '
									</article>
									';
	if ($__vars['comment']['attach_count']) {
		$__finalCompiled .= '
										' . $__templater->callMacro('message_macros', 'attachments', array(
			'attachments' => $__vars['comment']['Attachments'],
			'message' => $__vars['comment'],
			'canView' => $__templater->method($__vars['xf']['visitor'], 'hasPermission', array('profilePost', 'viewAttachment', )),
		), $__vars) . '
									';
	}
	$__finalCompiled .= '
								</div>
							</div>
						</div>

						<footer class="comment-footer">
							<div class="comment-actionBar actionBar">
								<div class="actionBar-set actionBar-set--internal">
									<span class="actionBar-action">' . $__templater->func('date_dynamic', array($__vars['comment']['comment_date'], array(
	))) . '</span>
									';
	if ($__templater->method($__vars['comment'], 'canReport', array())) {
		$__finalCompiled .= '
										<a href="' . $__templater->func('link', array('profile-posts/comments/report', $__vars['comment'], ), true) . '"
											class="actionBar-action actionBar-action--report"
											data-xf-click="overlay">' . 'Report' . '</a>
									';
	}
	$__finalCompiled .= '

									';
	$__vars['hasActionBarMenu'] = false;
	$__finalCompiled .= '
									';
	if ($__templater->method($__vars['comment'], 'canEdit', array())) {
		$__finalCompiled .= '
										';
		$__templater->includeJs(array(
			'src' => 'xf/message.js',
			'min' => '1',
		));
		$__finalCompiled .= '
										<a href="' . $__templater->func('link', array('profile-posts/comments/edit', $__vars['comment'], ), true) . '"
											class="actionBar-action actionBar-action--edit actionBar-action--menuItem"
											data-xf-click="quick-edit"
											data-editor-target="#js-profilePostComment-' . $__templater->escape($__vars['comment']['profile_post_comment_id']) . ' .js-quickEditTargetComment"
											data-menu-closer="true">' . 'Edit' . '</a>
										';
		$__vars['hasActionBarMenu'] = true;
		$__finalCompiled .= '
									';
	}
	$__finalCompiled .= '
									';
	if ($__templater->method($__vars['comment'], 'canDelete', array('soft', ))) {
		$__finalCompiled .= '
										<a href="' . $__templater->func('link', array('profile-posts/comments/delete', $__vars['comment'], ), true) . '"
											class="actionBar-action actionBar-action--delete actionBar-action--menuItem"
											data-xf-click="overlay">' . 'Delete' . '</a>
										';
		$__vars['hasActionBarMenu'] = true;
		$__finalCompiled .= '
									';
	}
	$__finalCompiled .= '
									';
	if (($__vars['comment']['message_state'] == 'deleted') AND $__templater->method($__vars['comment'], 'canUndelete', array())) {
		$__finalCompiled .= '
										<a href="' . $__templater->func('link', array('profile-posts/comments/undelete', $__vars['comment'], ), true) . '" data-xf-click="overlay"
											class="actionBar-action actionBar-action--undelete actionBar-action--menuItem">' . 'Undelete' . '</a>
										';
		$__vars['hasActionBarMenu'] = true;
		$__finalCompiled .= '
									';
	}
	$__finalCompiled .= '
									';
	if ($__templater->method($__vars['comment'], 'canCleanSpam', array())) {
		$__finalCompiled .= '
										<a href="' . $__templater->func('link', array('spam-cleaner', $__vars['comment'], ), true) . '"
											class="actionBar-action actionBar-action--spam actionBar-action--menuItem"
											data-xf-click="overlay">' . 'Spam' . '</a>
										';
		$__vars['hasActionBarMenu'] = true;
		$__finalCompiled .= '
									';
	}
	$__finalCompiled .= '
									';
	if ($__templater->method($__vars['xf']['visitor'], 'canViewIps', array()) AND $__vars['comment']['ip_id']) {
		$__finalCompiled .= '
										<a href="' . $__templater->func('link', array('profile-posts/comments/ip', $__vars['comment'], ), true) . '"
											class="actionBar-action actionBar-action--ip actionBar-action--menuItem"
											data-xf-click="overlay">' . 'IP' . '</a>
										';
		$__vars['hasActionBarMenu'] = true;
		$__finalCompiled .= '
									';
	}
	$__finalCompiled .= '
									';
	if ($__templater->method($__vars['comment'], 'canWarn', array())) {
		$__finalCompiled .= '
										<a href="' . $__templater->func('link', array('profile-posts/comments/warn', $__vars['comment'], ), true) . '"
											class="actionBar-action actionBar-action--warn actionBar-action--menuItem">' . 'Warn' . '</a>
										';
		$__vars['hasActionBarMenu'] = true;
		$__finalCompiled .= '
									';
	} else if ($__vars['comment']['warning_id'] AND $__templater->method($__vars['xf']['visitor'], 'canViewWarnings', array())) {
		$__finalCompiled .= '
										<a href="' . $__templater->func('link', array('warnings', array('warning_id' => $__vars['comment']['warning_id'], ), ), true) . '"
											class="actionBar-action actionBar-action--warn actionBar-action--menuItem"
											data-xf-click="overlay">' . 'View warning' . '</a>
										';
		$__vars['hasActionBarMenu'] = true;
		$__finalCompiled .= '
									';
	}
	$__finalCompiled .= '
									';
	if ($__templater->method($__vars['comment'], 'canApproveUnapprove', array())) {
		$__finalCompiled .= '
										';
		if ($__vars['comment']['message_state'] == 'moderated') {
			$__finalCompiled .= '
											<a href="' . $__templater->func('link', array('profile-posts/comments/approve', $__vars['comment'], array('t' => $__templater->func('csrf_token', array(), false), ), ), true) . '"
												class="actionBar-action actionBar-action--approve actionBar-action--menuItem">' . 'Approve' . '</a>
											';
			$__vars['hasActionBarMenu'] = true;
			$__finalCompiled .= '
										';
		} else if ($__vars['comment']['message_state'] == 'visible') {
			$__finalCompiled .= '
											<a href="' . $__templater->func('link', array('profile-posts/comments/unapprove', $__vars['comment'], array('t' => $__templater->func('csrf_token', array(), false), ), ), true) . '"
												class="actionBar-action actionBar-action--unapprove actionBar-action--menuItem">' . 'Unapprove' . '</a>
											';
			$__vars['hasActionBarMenu'] = true;
			$__finalCompiled .= '
										';
		}
		$__finalCompiled .= '
									';
	}
	$__finalCompiled .= '

									';
	if ($__vars['hasActionBarMenu']) {
		$__finalCompiled .= '
										<a class="actionBar-action actionBar-action--menuTrigger"
											data-xf-click="menu"
											title="' . $__templater->filter('More options', array(array('for_attr', array()),), true) . '"
											role="button"
											tabindex="0"
											aria-expanded="false"
											aria-haspopup="true">&#8226;&#8226;&#8226;</a>
										<div class="menu" data-menu="menu" aria-hidden="true" data-menu-builder="actionBar">
											<div class="menu-content">
												<h4 class="menu-header">' . 'More options' . '</h4>
												<div class="js-menuBuilderTarget"></div>
											</div>
										</div>
									';
	}
	$__finalCompiled .= '
								</div>
								';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
										' . $__templater->func('react', array(array(
		'content' => $__vars['comment'],
		'link' => 'profile-posts/comments/react',
		'list' => '< .comment | .js-commentReactionsList',
	))) . '
									';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
									<div class="actionBar-set actionBar-set--external">
									' . $__compilerTemp1 . '
									</div>
								';
	}
	$__finalCompiled .= '
							</div>

							<div class="comment-reactions js-commentReactionsList ' . ($__vars['comment']['reactions'] ? 'is-active' : '') . '">';
	if ($__vars['comment']['reactions']) {
		$__finalCompiled .= '
								' . $__templater->func('reactions', array($__vars['comment'], 'profile-posts/comments/reactions', array())) . '
							';
	}
	$__finalCompiled .= '</div>
						</footer>

					</div>
				</div>
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'comment_deleted' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'comment' => '!',
		'profilePost' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	<div class="message-responseRow">
		<div class="comment' . ($__templater->method($__vars['comment'], 'isIgnored', array()) ? ' is-ignored' : '') . '"
			data-author="' . $__templater->escape($__vars['comment']['User']['username']) . '"
			data-content="profile-post-comment-' . $__templater->escape($__vars['comment']['profile_post_comment_id']) . '">

			<div class="comment-inner">
				<span class="comment-avatar">
					' . $__templater->func('avatar', array($__vars['comment']['User'], 'xxs', false, array(
		'defaultname' => $__vars['comment']['username'],
	))) . '
				</span>
				<div class="comment-main">
					<span class="u-anchorTarget" id="profile-post-comment-' . $__templater->escape($__vars['comment']['profile_post_comment_id']) . '"></span>
					<div class="comment-content">
						<div class="messageNotice messageNotice--deleted">
							' . $__templater->callMacro('deletion_macros', 'notice', array(
		'log' => $__vars['comment']['DeletionLog'],
	), $__vars) . '

							<a href="' . $__templater->func('link', array('profile-posts/comments/show', $__vars['comment'], ), true) . '" class="u-jsOnly"
								data-xf-click="inserter"
								data-replace="[data-content=profile-post-comment-' . $__templater->escape($__vars['comment']['profile_post_comment_id']) . ']">' . 'Show' . $__vars['xf']['language']['ellipsis'] . '</a>
						</div>
					</div>

					<div class="comment-actionBar actionBar">
						<div class="actionBar-set actionBar-set--internal">
							<span class="actionBar-action">
								' . $__templater->func('date_dynamic', array($__vars['comment']['comment_date'], array(
	))) . '
								<span role="presentation" aria-hidden="true">&middot;</span>
								' . $__templater->func('username_link', array($__vars['comment']['User'], false, array(
		'defaultname' => $__vars['comment']['username'],
		'class' => 'u-concealed',
	))) . '
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'quick_post' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'user' => '!',
		'containerSelector' => '!',
		'lastDate' => '!',
		'attachmentData' => null,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'src' => 'xf/message.js',
		'min' => '1',
	));
	$__finalCompiled .= '

	' . $__templater->form('

		' . $__templater->callMacro('quick_reply_macros', 'body', array(
		'attachmentData' => $__vars['attachmentData'],
		'simple' => true,
		'placeholder' => (($__vars['xf']['visitor']['user_id'] == $__vars['user']['user_id']) ? 'Update your status' . $__vars['xf']['language']['ellipsis'] : 'Write something' . $__vars['xf']['language']['ellipsis']),
		'submitText' => 'Post',
		'lastDate' => $__vars['lastDate'],
		'lastKnownDate' => $__vars['lastDate'],
		'minHeight' => '40',
		'deferred' => true,
		'simpleSubmit' => true . ' ',
	), $__vars) . '
	', array(
		'action' => $__templater->func('link', array('members/post', $__vars['user'], ), false),
		'ajax' => 'true',
		'class' => 'message-spacer js-quickReply',
		'data-xf-init' => 'attachment-manager quick-reply',
		'data-message-container' => $__vars['containerSelector'],
		'data-ascending' => '0',
	)) . '
';
	return $__finalCompiled;
}
),
'submit' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'user' => '!',
		'lastDate' => '!',
		'containerSelector' => '!',
		'style' => 'full',
		'context' => 'user',
		'attachmentData' => null,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'src' => 'xf/message.js',
		'min' => '1',
	));
	$__finalCompiled .= '

	';
	$__vars['placeholder'] = (($__vars['xf']['visitor']['user_id'] == $__vars['user']['user_id']) ? 'Update your status' . $__vars['xf']['language']['ellipsis'] : 'Write something' . $__vars['xf']['language']['ellipsis']);
	$__finalCompiled .= '

	';
	$__compilerTemp1 = '';
	if ($__vars['style'] == 'full') {
		$__compilerTemp1 .= '
			' . $__templater->callMacro('quick_reply_macros', 'body', array(
			'attachmentData' => $__vars['attachmentData'],
			'simple' => true,
			'placeholder' => $__vars['placeholder'],
			'submitText' => 'Post',
			'lastDate' => $__vars['lastDate'],
			'lastKnownDate' => $__vars['lastDate'],
			'minHeight' => '40',
			'deferred' => true,
			'simpleSubmit' => true . ' ',
		), $__vars) . '
		';
	} else {
		$__compilerTemp1 .= '
			<div>
				<span class="u-srOnly" id="ctrl_message">' . 'Update your status' . $__vars['xf']['language']['label_separator'] . '</span>

				' . $__templater->formTextArea(array(
			'name' => 'message',
			'autosize' => 'true',
			'rows' => '1',
			'maxlength' => $__vars['xf']['options']['profilePostMaxLength'],
			'class' => 'js-editor',
			'data-xf-init' => 'focus-trigger user-mentioner emoji-completer',
			'data-display' => '< :next',
			'aria-labelledby' => 'ctrl_message',
			'placeholder' => $__vars['placeholder'],
		)) . '

				<div class="u-hidden u-hidden--transition u-inputSpacer">
					' . $__templater->button('Post', array(
			'type' => 'submit',
			'class' => 'button--primary',
			'icon' => 'reply',
		), '', array(
		)) . '
				</div>

				' . '
				' . $__templater->formHiddenVal('last_date', $__vars['lastDate'], array(
			'autocomplete' => 'off',
		)) . '
			</div>
		';
	}
	$__finalCompiled .= $__templater->form('

		' . $__compilerTemp1 . '

		' . $__templater->formHiddenVal('style', $__vars['style'], array(
	)) . '
		' . $__templater->formHiddenVal('context', $__vars['context'], array(
	)) . '
	', array(
		'action' => $__templater->func('link', array('members/post', $__vars['user'], ), false),
		'ajax' => 'true',
		'class' => (($__vars['style'] == 'full') ? 'message message--simple' : 'block-row') . ' js-quickReply',
		'data-xf-init' => (($__vars['style'] == 'full') ? 'attachment-manager' : '') . ' quick-reply',
		'data-message-container' => $__vars['containerSelector'],
		'data-ascending' => '0',
	)) . '
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

' . '

' . '

' . '

' . '

';
	return $__finalCompiled;
}
);