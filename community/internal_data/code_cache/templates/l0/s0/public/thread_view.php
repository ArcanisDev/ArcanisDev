<?php
// FROM HASH: a001af6216bf7c28d0e52b70f8476112
return array(
'extensions' => array('structured_data_extra_params' => function($__templater, array $__vars, $__extensions = null)
{
	return array();
},
'structured_data' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
		';
	$__vars['ldJson'] = $__templater->method($__vars['thread'], 'getLdStructuredData', array($__vars['firstPost'], $__vars['page'], $__templater->renderExtension('structured_data_extra_params', $__vars, $__extensions), ));
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
	return $__finalCompiled;
},
'content_top' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'above_messages' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'thread_action_buttons' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
						';
	if ($__vars['canInlineMod']) {
		$__finalCompiled .= '
							' . $__templater->callMacro('inline_mod_macros', 'button', array(), $__vars) . '
						';
	}
	$__finalCompiled .= '
						';
	if (($__vars['thread']['discussion_state'] == 'deleted') AND $__templater->method($__vars['thread'], 'canUndelete', array())) {
		$__finalCompiled .= '
							' . $__templater->button('
								' . 'Undelete' . '
							', array(
			'href' => $__templater->func('link', array('threads/undelete', $__vars['thread'], ), false),
			'class' => 'button--link',
			'overlay' => 'true',
		), '', array(
		)) . '
						';
	}
	$__finalCompiled .= '
						';
	if ($__templater->method($__vars['thread'], 'canApproveUnapprove', array()) AND ($__vars['thread']['discussion_state'] == 'moderated')) {
		$__finalCompiled .= '
							' . $__templater->button('
								' . 'Approve' . '
							', array(
			'href' => $__templater->func('link', array('threads/approve', $__vars['thread'], ), false),
			'class' => 'button--link',
			'overlay' => 'true',
		), '', array(
		)) . '
						';
	}
	$__finalCompiled .= '
						';
	if ($__vars['xf']['visitor']['user_id'] AND $__templater->method($__vars['thread'], 'isUnread', array())) {
		$__finalCompiled .= '
							' . $__templater->button('
									' . 'Jump to new' . '
							', array(
			'href' => ((($__vars['firstUnread'] AND $__vars['isSimpleDateDisplay'])) ? (('#post-' . $__vars['firstUnread']['post_id'])) : $__templater->func('link', array('threads/unread', $__vars['thread'], array('new' => 1, ), ), false)),
			'class' => 'button--link',
			'data-xf-click' => 'scroll-to',
			'data-silent' => 'true',
		), '', array(
		)) . '
						';
	}
	$__finalCompiled .= '
						';
	if ($__templater->method($__vars['thread'], 'canWatch', array())) {
		$__finalCompiled .= '
							';
		$__compilerTemp1 = '';
		if ($__vars['thread']['Watch'][$__vars['xf']['visitor']['user_id']]) {
			$__compilerTemp1 .= '
									' . 'Unwatch' . '
								';
		} else {
			$__compilerTemp1 .= '
									' . 'Watch' . '
								';
		}
		$__finalCompiled .= $__templater->button('
								' . $__compilerTemp1 . '
							', array(
			'href' => $__templater->func('link', array('threads/watch', $__vars['thread'], ), false),
			'class' => 'button--link',
			'data-xf-click' => 'switch-overlay',
			'data-sk-watch' => 'Watch',
			'data-sk-unwatch' => 'Unwatch',
		), '', array(
		)) . '
						';
	}
	$__finalCompiled .= '

						';
	$__compilerTemp2 = '';
	$__compilerTemp2 .= '
											' . '
											';
	if ($__templater->method($__vars['thread'], 'canEdit', array())) {
		$__compilerTemp2 .= '
												<a href="' . $__templater->func('link', array('threads/edit', $__vars['thread'], ), true) . '" data-xf-click="overlay" class="menu-linkRow">' . 'Edit thread' . '</a>
											';
	}
	$__compilerTemp2 .= '
											';
	if ($__templater->method($__vars['thread'], 'canChangeType', array()) AND ($__templater->func('count', array($__vars['creatableThreadTypes'], ), false) > 1)) {
		$__compilerTemp2 .= '
												<a href="' . $__templater->func('link', array('threads/change-type', $__vars['thread'], ), true) . '" data-xf-click="overlay" class="menu-linkRow">' . 'Change thread type' . '</a>
											';
	}
	$__compilerTemp2 .= '
											';
	if ($__templater->method($__vars['thread'], 'canLockUnlock', array())) {
		$__compilerTemp2 .= '
												<a href="' . $__templater->func('link', array('threads/quick-close', $__vars['thread'], ), true) . '"
													class="menu-linkRow"
													data-xf-click="switch"
													data-menu-closer="true">

													';
		if ($__vars['thread']['discussion_open']) {
			$__compilerTemp2 .= '
														' . 'Lock thread' . '
													';
		} else {
			$__compilerTemp2 .= '
														' . 'Unlock thread' . '
													';
		}
		$__compilerTemp2 .= '
												</a>
											';
	}
	$__compilerTemp2 .= '
											';
	if ($__templater->method($__vars['thread'], 'canStickUnstick', array())) {
		$__compilerTemp2 .= '
												<a href="' . $__templater->func('link', array('threads/quick-stick', $__vars['thread'], ), true) . '"
													class="menu-linkRow"
													data-xf-click="switch"
													data-menu-closer="true">

													';
		if ($__vars['thread']['sticky']) {
			$__compilerTemp2 .= '
														' . 'Unstick thread' . '
													';
		} else {
			$__compilerTemp2 .= '
														' . 'Stick thread' . '
													';
		}
		$__compilerTemp2 .= '
												</a>
											';
	}
	$__compilerTemp2 .= '
											';
	if ($__templater->method($__vars['thread'], 'canCreatePoll', array())) {
		$__compilerTemp2 .= '
												<a href="' . $__templater->func('link', array('threads/poll/create', $__vars['thread'], ), true) . '" data-xf-click="overlay" class="menu-linkRow">' . 'Create poll' . '</a>
											';
	}
	$__compilerTemp2 .= '
											';
	if ($__templater->method($__vars['thread'], 'canDelete', array('soft', ))) {
		$__compilerTemp2 .= '
												<a href="' . $__templater->func('link', array('threads/delete', $__vars['thread'], ), true) . '" data-xf-click="overlay" class="menu-linkRow">' . 'Delete thread' . '</a>
											';
	}
	$__compilerTemp2 .= '
											';
	if ($__templater->method($__vars['thread'], 'canMove', array())) {
		$__compilerTemp2 .= '
												<a href="' . $__templater->func('link', array('threads/move', $__vars['thread'], ), true) . '" data-xf-click="overlay" class="menu-linkRow">' . 'Move thread' . '</a>
											';
	}
	$__compilerTemp2 .= '
											';
	if ($__templater->method($__vars['thread'], 'canReplyBan', array())) {
		$__compilerTemp2 .= '
												<a href="' . $__templater->func('link', array('threads/reply-bans', $__vars['thread'], ), true) . '" data-xf-click="overlay" class="menu-linkRow">' . 'Manage reply bans' . '</a>
											';
	}
	$__compilerTemp2 .= '
											';
	if ($__templater->method($__vars['thread'], 'canViewModeratorLogs', array())) {
		$__compilerTemp2 .= '
												<a href="' . $__templater->func('link', array('threads/moderator-actions', $__vars['thread'], ), true) . '" data-xf-click="overlay" class="menu-linkRow">' . 'Moderator actions' . '</a>
											';
	}
	$__compilerTemp2 .= '
											' . '
											';
	if ($__templater->method($__vars['thread'], 'canUseInlineModeration', array())) {
		$__compilerTemp2 .= '
												<div class="menu-footer"
													data-xf-init="inline-mod"
													data-type="thread"
													data-href="' . $__templater->func('link', array('inline-mod', ), true) . '"
													data-toggle=".js-threadInlineModToggle">
													' . $__templater->formCheckBox(array(
		), array(array(
			'class' => 'js-threadInlineModToggle',
			'value' => $__vars['thread']['thread_id'],
			'label' => 'Select for moderation',
			'_type' => 'option',
		))) . '
												</div>
											';
	}
	$__compilerTemp2 .= '
											' . '
										';
	if (strlen(trim($__compilerTemp2)) > 0) {
		$__finalCompiled .= '
							<div class="buttonGroup-buttonWrapper">
								' . $__templater->button('&#8226;&#8226;&#8226;', array(
			'class' => 'button--link menuTrigger',
			'data-xf-click' => 'menu',
			'aria-expanded' => 'false',
			'aria-haspopup' => 'true',
			'title' => 'More options',
		), '', array(
		)) . '
								<div class="menu" data-menu="menu" aria-hidden="true">
									<div class="menu-content">
										<h4 class="menu-header">' . 'More options' . '</h4>
										' . $__compilerTemp2 . '
									</div>
								</div>
							</div>
						';
	}
	$__finalCompiled .= '
					';
	return $__finalCompiled;
},
'thread_actions' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
		';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
					' . $__templater->renderExtension('thread_action_buttons', $__vars, $__extensions) . '
				';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
			<div class="block-outer-opposite">
				<div class="buttonGroup">
				' . $__compilerTemp1 . '
				</div>
			</div>
		';
	}
	$__finalCompiled .= '
	';
	return $__finalCompiled;
},
'post_sort_filter_end' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'post_sort_filter' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
		';
	if ((!$__templater->test($__vars['posts'], 'empty', array()) OR $__vars['filters'])) {
		$__finalCompiled .= '
			';
		$__compilerTemp1 = '';
		$__compilerTemp1 .= '
					';
		if ($__vars['availableSorts'] AND ($__templater->func('count', array($__vars['availableSorts'], ), false) > 1)) {
			$__compilerTemp1 .= '
						';
			if ($__templater->isTraversable($__vars['availableSorts'])) {
				foreach ($__vars['availableSorts'] AS $__vars['sortKey'] => $__vars['null']) {
					$__compilerTemp1 .= '
							<a href="' . $__templater->func('link', array('threads', $__vars['thread'], $__templater->filter($__vars['pageNavFilters'], array(array('replace', array(array('order' => (($__vars['sortKey'] == $__vars['defaultOrder']) ? null : $__vars['sortKey']), ), )),), false), ), true) . '"
								class="tabs-tab ' . (($__vars['sortKey'] == $__vars['effectiveOrder']) ? 'is-active' : '') . '"
								rel="nofollow">
								' . $__templater->func('phrase_dynamic', array('thread_sort.' . $__vars['sortKey'], ), true) . '
							</a>
						';
				}
			}
			$__compilerTemp1 .= '
					';
		}
		$__compilerTemp1 .= '
					' . $__templater->renderExtension('post_sort_filter_end', $__vars, $__extensions) . '
				';
		if (strlen(trim($__compilerTemp1)) > 0) {
			$__finalCompiled .= '
				<div class="tabs tabs--standalone tabs--standalone--small tabs--standalone--inline">
				' . $__compilerTemp1 . '
				</div>
			';
		}
		$__finalCompiled .= '
		';
	}
	$__finalCompiled .= '
	';
	return $__finalCompiled;
},
'pinned_block_before' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'pinned_block_classes' => function($__templater, array $__vars, $__extensions = null)
{
	return '';
},
'pinned_outer_before' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
			' . $__templater->callMacro(null, 'thread_status', array(
		'thread' => $__vars['thread'],
		'wrapperClass' => 'block-outer',
	), $__vars) . '

			<div class="block-outer">' . $__templater->func('trim', array('
				' . $__templater->escape($__vars['threadActionsHtml']) . '
			'), false) . '</div>

			' . $__templater->callMacro(null, 'thread_custom_fields_status', array(
		'thread' => $__vars['thread'],
		'forum' => $__vars['forum'],
		'wrapperClass' => 'block-outer',
	), $__vars) . '
		';
	return $__finalCompiled;
},
'pinned_body' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
					' . $__templater->callMacro(null, ($__vars['templateOverrides']['pinned_first_post_macro'] ?: 'post_macros::post'), $__templater->combineMacroArgumentAttributes($__vars['templateOverrides']['pinned_first_post_macro_args'], array(
		'post' => $__vars['pinnedPost'],
		'thread' => $__vars['thread'],
		'highlightedPosts' => $__vars['highlightedPosts'],
	)), $__vars) . '
				';
	return $__finalCompiled;
},
'pinned_outer_after' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'above_messages_below_pinned' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'message_block_classes' => function($__templater, array $__vars, $__extensions = null)
{
	return 'block--messages';
},
'messages_block_outer' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__compilerTemp1 = '';
	if (!$__vars['isFirstPostPinned']) {
		$__compilerTemp1 .= '
				' . $__templater->escape($__vars['threadActionsHtml']) . '
			';
	}
	$__compilerTemp2 = '';
	$__compilerTemp3 = '';
	$__compilerTemp3 .= $__templater->escape($__vars['postSortFilterHtml']);
	if (strlen(trim($__compilerTemp3)) > 0) {
		$__compilerTemp2 .= '
				<div class="block-outer-opposite">
					' . $__compilerTemp3 . '
				</div>
			';
	}
	$__finalCompiled .= $__templater->func('trim', array('
		' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['totalPosts'],
		'link' => 'threads',
		'data' => $__vars['thread'],
		'params' => $__vars['pageNavFilters'],
		'hash' => $__vars['pageNavHash'],
		'wrapperclass' => 'block-outer-main',
		'perPage' => $__vars['perPage'],
	))) . '

			' . $__compilerTemp1 . '

			' . $__compilerTemp2 . '
	'), false);
	return $__finalCompiled;
},
'messages_block_outer_secondary' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'messages_block_body_before_post' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'messages_block_body_after_post' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'below_messages' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'below_quick_reply' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'below_share' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
}),
'macros' => array('thread_status' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'thread' => '!',
		'wrapperClass' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
					';
	if ($__vars['thread']['discussion_state'] == 'deleted') {
		$__compilerTemp1 .= '
						<dd class="blockStatus-message blockStatus-message--deleted">
							' . $__templater->callMacro('deletion_macros', 'notice', array(
			'log' => $__vars['thread']['DeletionLog'],
		), $__vars) . '
						</dd>
					';
	} else if ($__vars['thread']['discussion_state'] == 'moderated') {
		$__compilerTemp1 .= '
						<dd class="blockStatus-message blockStatus-message--moderated">
							' . 'Awaiting approval before being displayed publicly.' . '
						</dd>
					';
	}
	$__compilerTemp1 .= '
					';
	if (!$__vars['thread']['discussion_open']) {
		$__compilerTemp1 .= '
						<dd class="blockStatus-message blockStatus-message--locked">
							' . 'Not open for further replies.' . '
						</dd>
					';
	}
	$__compilerTemp1 .= '
				';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
		<div class="' . $__templater->escape($__vars['wrapperClass']) . '">
			<dl class="blockStatus">
				<dt>' . 'Status' . '</dt>
				' . $__compilerTemp1 . '
			</dl>
		</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'thread_custom_fields_status' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'thread' => '!',
		'forum' => '!',
		'wrapperClass' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="' . $__templater->escape($__vars['wrapperClass']) . ' js-threadStatusField">';
	$__compilerTemp1 = '';
	$__compilerTemp2 = '';
	$__compilerTemp2 .= '
					' . $__templater->callMacro('custom_fields_macros', 'custom_fields_view', array(
		'type' => 'threads',
		'group' => 'thread_status',
		'onlyInclude' => $__vars['forum']['field_cache'],
		'set' => $__vars['thread']['custom_fields'],
		'wrapperClass' => 'blockStatus-message',
	), $__vars) . '
				';
	if (strlen(trim($__compilerTemp2)) > 0) {
		$__compilerTemp1 .= '
			<div class="blockStatus blockStatus--info">
				' . $__compilerTemp2 . '
			</div>
		';
	}
	$__finalCompiled .= $__templater->func('trim', array('
		' . $__compilerTemp1 . '
	'), false) . '</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->func('prefix', array('thread', $__vars['thread'], 'escaped', ), true) . $__templater->escape($__vars['thread']['title']));
	$__templater->pageParams['pageNumber'] = $__vars['page'];
	$__finalCompiled .= '
';
	$__templater->pageParams['pageH1'] = $__templater->preEscaped($__templater->func('prefix', array('thread', $__vars['thread'], ), true) . $__templater->escape($__vars['thread']['title']));
	$__finalCompiled .= '

';
	if (!$__templater->method($__vars['thread'], 'isSearchEngineIndexable', array())) {
		$__finalCompiled .= '
	';
		$__templater->setPageParam('head.' . 'metaNoindex', $__templater->preEscaped('<meta name="robots" content="noindex" />'));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['xf']['options']['enableTagging'] AND (($__templater->method($__vars['thread'], 'canEditTags', array()) OR $__vars['thread']['tags']))) {
		$__compilerTemp1 .= '
			<li>
				' . $__templater->callMacro('tag_macros', 'list', array(
			'tags' => $__vars['thread']['tags'],
			'tagList' => 'tagList--thread-' . $__vars['thread']['thread_id'],
			'editLink' => ($__templater->method($__vars['thread'], 'canEditTags', array()) ? $__templater->func('link', array('threads/tags', $__vars['thread'], ), false) : ''),
		), $__vars) . '
			</li>
		';
	}
	$__templater->pageParams['pageDescription'] = $__templater->preEscaped('
	<ul class="listInline listInline--bullet">
		<li>
			' . $__templater->fontAwesome('fa-user', array(
		'title' => $__templater->filter('Thread starter', array(array('for_attr', array()),), false),
	)) . '
			<span class="u-srOnly">' . 'Thread starter' . '</span>

			' . $__templater->func('username_link', array($__vars['thread']['User'], false, array(
		'defaultname' => $__vars['thread']['username'],
		'class' => 'u-concealed',
	))) . '
		</li>
		<li>
			' . $__templater->fontAwesome('fa-clock', array(
		'title' => $__templater->filter('Start date', array(array('for_attr', array()),), false),
	)) . '
			<span class="u-srOnly">' . 'Start date' . '</span>

			<a href="' . $__templater->func('link', array('threads', $__vars['thread'], ), true) . '" class="u-concealed">' . $__templater->func('date_dynamic', array($__vars['thread']['post_date'], array(
	))) . '</a>
		</li>
		' . $__compilerTemp1 . '
	</ul>
');
	$__templater->pageParams['pageDescriptionMeta'] = false;
	$__finalCompiled .= '

';
	$__vars['fpSnippet'] = $__templater->func('snippet', array($__vars['firstPost']['message'], 0, array('stripBbCode' => true, ), ), false);
	$__finalCompiled .= '

' . $__templater->callMacro('metadata_macros', 'metadata', array(
		'description' => $__vars['fpSnippet'],
		'shareUrl' => $__templater->func('link', array('canonical:threads', $__vars['thread'], ), false),
		'canonicalUrl' => $__templater->func('link', array('canonical:threads', $__vars['thread'], array('page' => $__vars['page'], ), ), false),
	), $__vars) . '

';
	$__templater->setPageParam('ldJsonHtml', '
	' . '' . '
	' . $__templater->renderExtension('structured_data', $__vars, $__extensions) . '
');
	$__finalCompiled .= '

' . $__templater->renderExtension('content_top', $__vars, $__extensions) . '
' . '

';
	if ($__vars['pendingApproval']) {
		$__finalCompiled .= '
	<div class="blockMessage blockMessage--important">' . 'Your content has been submitted and will be displayed pending approval by a moderator.' . '</div>
';
	}
	$__finalCompiled .= '

';
	if ($__vars['thread']['prefix_id']) {
		$__finalCompiled .= '
	';
		$__compilerTemp2 = '';
		$__compilerTemp2 .= $__templater->func('prefix_description', array('thread', $__vars['thread']['prefix_id'], ), true);
		if (strlen(trim($__compilerTemp2)) > 0) {
			$__finalCompiled .= '
		<div class="blockMessage blockMessage--alt blockMessage--small blockMessage--close">
			' . $__compilerTemp2 . '
		</div>
	';
		}
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

' . $__templater->callMacro('forum_macros', 'forum_page_options', array(
		'forum' => $__vars['forum'],
		'thread' => $__vars['thread'],
	), $__vars) . '

';
	$__templater->breadcrumbs($__templater->method($__vars['forum'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '

';
	if ($__vars['canInlineMod'] OR $__templater->method($__vars['thread'], 'canUseInlineModeration', array())) {
		$__finalCompiled .= '
	';
		$__templater->includeJs(array(
			'src' => 'xf/inline_mod.js',
			'min' => '1',
		));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

' . $__templater->renderExtension('above_messages', $__vars, $__extensions) . '
' . $__templater->callAdsMacro('thread_view_above_messages', array(
		'thread' => $__vars['thread'],
	), $__vars) . '
' . $__templater->widgetPosition('thread_view_above_messages', array(
		'thread' => $__vars['thread'],
	)) . '

';
	$__vars['threadActionsHtml'] = $__templater->preEscaped('
	' . $__templater->renderExtension('thread_actions', $__vars, $__extensions) . '
');
	$__finalCompiled .= '

';
	$__vars['postSortFilterHtml'] = $__templater->preEscaped('
	' . $__templater->renderExtension('post_sort_filter', $__vars, $__extensions) . '
');
	$__finalCompiled .= '

';
	if ($__vars['isFirstPostPinned']) {
		$__finalCompiled .= '
	' . $__templater->renderExtension('pinned_block_before', $__vars, $__extensions) . '

	' . '
	<div class="block block--messages ' . $__templater->escape($__templater->renderExtension('pinned_block_classes', $__vars, $__extensions)) . '"
		data-xf-init="lightbox' . ($__vars['xf']['options']['selectQuotable'] ? ' select-to-quote' : '') . '"
		data-message-selector=".js-post"
		data-lb-id="thread-' . $__templater->escape($__vars['thread']['thread_id']) . '">
		' . $__templater->renderExtension('pinned_outer_before', $__vars, $__extensions) . '

		<div class="block-container">
			<div class="block-body">
				' . $__templater->renderExtension('pinned_body', $__vars, $__extensions) . '
			</div>
		</div>

		' . $__templater->renderExtension('pinned_outer_after', $__vars, $__extensions) . '
	</div>
';
	}
	$__finalCompiled .= '

' . $__templater->renderExtension('above_messages_below_pinned', $__vars, $__extensions) . '

' . '
<div class="block ' . $__templater->escape($__templater->renderExtension('message_block_classes', $__vars, $__extensions)) . '" data-xf-init="' . ($__vars['canInlineMod'] ? 'inline-mod' : '') . '" data-type="post" data-href="' . $__templater->func('link', array('inline-mod', ), true) . '" data-search-target="*">

	<span class="u-anchorTarget" id="posts"></span>

	';
	if (!$__vars['isFirstPostPinned']) {
		$__finalCompiled .= '
		' . $__templater->callMacro(null, 'thread_status', array(
			'thread' => $__vars['thread'],
			'wrapperClass' => 'block-outer',
		), $__vars) . '
	';
	}
	$__finalCompiled .= '

	<div class="block-outer">' . $__templater->renderExtension('messages_block_outer', $__vars, $__extensions) . '</div>

	' . $__templater->renderExtension('messages_block_outer_secondary', $__vars, $__extensions) . '

	';
	if (!$__vars['isFirstPostPinned']) {
		$__finalCompiled .= '
		' . $__templater->callMacro(null, 'thread_custom_fields_status', array(
			'thread' => $__vars['thread'],
			'forum' => $__vars['forum'],
			'wrapperClass' => 'block-outer',
		), $__vars) . '
	';
	}
	$__finalCompiled .= '

	<div class="block-container lbContainer"
		data-xf-init="lightbox' . ($__vars['xf']['options']['selectQuotable'] ? ' select-to-quote' : '') . '"
		data-message-selector=".js-post"
		data-lb-id="thread-' . $__templater->escape($__vars['thread']['thread_id']) . '"
		data-lb-universal="' . $__templater->escape($__vars['xf']['options']['lightBoxUniversal']) . '">

		<div class="block-body js-replyNewMessageContainer">
			';
	if (!$__templater->test($__vars['posts'], 'empty', array())) {
		$__finalCompiled .= '
				';
		if ($__templater->isTraversable($__vars['posts'])) {
			foreach ($__vars['posts'] AS $__vars['post']) {
				$__finalCompiled .= '

					' . $__templater->renderExtension('messages_block_body_before_post', $__vars, $__extensions) . '

					';
				if ($__vars['post']['message_state'] == 'deleted') {
					$__finalCompiled .= '
						' . $__templater->callMacro(null, ($__vars['templateOverrides']['post_deleted_macro'] ?: 'post_macros::post_deleted'), $__templater->combineMacroArgumentAttributes($__vars['templateOverrides']['post_deleted_macro_args'], array(
						'post' => $__vars['post'],
						'thread' => $__vars['thread'],
					)), $__vars) . '
					';
				} else {
					$__finalCompiled .= '
						' . $__templater->callMacro(null, ($__vars['templateOverrides']['post_macro'] ?: 'post_macros::post'), $__templater->combineMacroArgumentAttributes($__vars['templateOverrides']['post_macro_args'], array(
						'post' => $__vars['post'],
						'thread' => $__vars['thread'],
						'highlightedPosts' => $__vars['highlightedPosts'],
					)), $__vars) . '
					';
				}
				$__finalCompiled .= '

					' . $__templater->renderExtension('messages_block_body_after_post', $__vars, $__extensions) . '

				';
			}
		}
		$__finalCompiled .= '
			';
	} else {
		$__finalCompiled .= '
				';
		if ($__vars['filters']) {
			$__finalCompiled .= '
					<div class="message">
						<div class="message-inner">
							<div class="message-cell">
								' . 'There are no posts matching your filters.' . '
							</div>
						</div>
					</div>
				';
		}
		$__finalCompiled .= '
			';
	}
	$__finalCompiled .= '
		</div>
	</div>

	';
	$__compilerTemp3 = '';
	$__compilerTemp3 .= '
				' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['totalPosts'],
		'link' => 'threads',
		'data' => $__vars['thread'],
		'params' => $__vars['pageNavFilters'],
		'hash' => $__vars['pageNavHash'],
		'wrapperclass' => 'block-outer-main',
		'perPage' => $__vars['perPage'],
	))) . '

				' . $__templater->func('show_ignored', array(array(
		'wrapperclass' => 'block-outer-opposite',
	))) . '
				';
	if ((!$__templater->method($__vars['thread'], 'canReply', array())) AND ((!$__templater->method($__vars['thread'], 'canReplyPreReg', array())) AND (($__vars['thread']['discussion_state'] == 'visible') AND $__vars['thread']['discussion_open']))) {
		$__compilerTemp3 .= '
					<div class="block-outer-opposite">
						';
		if ($__vars['xf']['visitor']['user_id']) {
			$__compilerTemp3 .= '
							<span class="button button--wrap is-disabled">
								' . 'You have insufficient privileges to reply here.' . '
								<!-- this is not interactive so shouldn\'t be a button element -->
							</span>
						';
		} else {
			$__compilerTemp3 .= '
							' . $__templater->button('
								' . 'You must log in or register to reply here.' . '
							', array(
				'href' => $__templater->func('link', array('login', ), false),
				'class' => 'button--link button--wrap',
				'overlay' => 'true',
			), '', array(
			)) . '
						';
		}
		$__compilerTemp3 .= '
					</div>
				';
	}
	$__compilerTemp3 .= '
			';
	if (strlen(trim($__compilerTemp3)) > 0) {
		$__finalCompiled .= '
		<div class="block-outer block-outer--after">
			' . $__compilerTemp3 . '
		</div>
	';
	}
	$__finalCompiled .= '

	' . $__templater->callMacro(null, 'thread_status', array(
		'thread' => $__vars['thread'],
		'wrapperClass' => 'block-outer block-outer--after',
	), $__vars) . '
</div>

' . $__templater->callAdsMacro('thread_view_below_messages', array(
		'thread' => $__vars['thread'],
	), $__vars) . '
' . $__templater->renderExtension('below_messages', $__vars, $__extensions) . '
' . $__templater->widgetPosition('thread_view_below_messages', array(
		'thread' => $__vars['thread'],
	)) . '

';
	$__vars['isPreRegReply'] = $__templater->method($__vars['thread'], 'canReplyPreReg', array());
	$__finalCompiled .= '
';
	if ($__templater->method($__vars['thread'], 'canReply', array()) OR $__vars['isPreRegReply']) {
		$__finalCompiled .= '
	';
		$__templater->includeJs(array(
			'src' => 'xf/message.js',
			'min' => '1',
		));
		$__templater->includeJs(array(
			'src' => 'xf/captcha.js',
			'min' => '1',
		));
		$__finalCompiled .= $__templater->form('

		' . '' . '
		' . '' . '

		<div class="block-container">
			<div class="block-body">
				' . $__templater->callMacro('quick_reply_macros', 'body', array(
			'message' => $__vars['thread']['draft_reply']['message'],
			'attachmentData' => $__vars['attachmentData'],
			'forceHash' => $__vars['thread']['draft_reply']['attachment_hash'],
			'messageSelector' => '.js-post',
			'multiQuoteHref' => $__templater->func('link', array('threads/multi-quote', $__vars['thread'], ), false),
			'multiQuoteStorageKey' => 'multiQuoteThread',
			'lastDate' => $__vars['lastPost']['post_date'],
			'lastKnownDate' => $__vars['thread']['last_post_date'],
			'loadExtra' => $__vars['isSimpleDateDisplay'],
			'showGuestControls' => (!$__vars['isPreRegReply']),
			'previewUrl' => $__templater->func('link', array('threads/reply-preview', $__vars['thread'], ), false),
		), $__vars) . '
			</div>
		</div>
	', array(
			'action' => $__templater->func('link', array('threads/add-reply', $__vars['thread'], ), false),
			'ajax' => 'true',
			'draft' => $__templater->func('link', array('threads/draft', $__vars['thread'], ), false),
			'class' => 'block js-quickReply',
			'data-xf-init' => 'attachment-manager quick-reply' . ((($__templater->method($__vars['xf']['visitor'], 'isShownCaptcha', array()) AND (!$__vars['isPreRegReply']))) ? ' guest-captcha' : ''),
			'data-captcha-context' => 'xf_guest_thread_quick_reply',
			'data-message-container' => 'div[data-type=\'post\'] .js-replyNewMessageContainer',
		)) . '
';
	}
	$__finalCompiled .= '

' . $__templater->widgetPosition('thread_view_below_quick_reply', array(
		'thread' => $__vars['thread'],
	)) . '
' . $__templater->renderExtension('below_quick_reply', $__vars, $__extensions) . '

<div class="blockMessage blockMessage--none">
	' . $__templater->callMacro('share_page_macros', 'buttons', array(
		'iconic' => true,
		'label' => 'Share' . $__vars['xf']['language']['label_separator'],
	), $__vars) . '
</div>

' . $__templater->renderExtension('below_share', $__vars, $__extensions) . '

' . '

' . '

';
	$__templater->modifySidebarHtml('_xfWidgetPositionSidebarbfab7223b9688edb88e508319a9aacac', $__templater->widgetPosition('thread_view_sidebar', array(
		'thread' => $__vars['thread'],
	)), 'replace');
	return $__finalCompiled;
}
);