<?php
// FROM HASH: d4eec15db9a08c95fcd726789ceac7fc
return array(
'extends' => function($__templater, array $__vars) { return 'thread_view'; },
'extensions' => array('structured_data_extra_params' => function($__templater, array $__vars, $__extensions = null)
{
	return array('highlightedPosts' => $__vars['highlightedPosts'], 'suggestedSolutions' => $__vars['suggestedSolutions'], );
},
'pinned_block_classes' => function($__templater, array $__vars, $__extensions = null)
{
	return ($__vars['thread']['type_data']['solution_post_id'] ? 'block--close' : '');
},
'above_messages_below_pinned' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
	';
	if ($__vars['thread']['type_data']['solution_post_id'] AND $__vars['highlightedPosts'][$__vars['thread']['type_data']['solution_post_id']]) {
		$__finalCompiled .= '
		<div class="block" id="js-solutionHighlightBlock">
			<div class="block-container">
				<div class="block-body">
					' . $__templater->callMacro(null, 'solution', array(
			'post' => $__vars['highlightedPosts'][$__vars['thread']['type_data']['solution_post_id']],
			'thread' => $__vars['thread'],
		), $__vars) . '
				</div>
			</div>
		</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}),
'macros' => array('solution' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'post' => '!',
		'thread' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<article class="message message--simple">
		<div class="message-inner js-solutionHeader">
			<div class="message-cell message-cell--solutionHeader">
				' . 'Solution' . '
			</div>
		</div>
		<div class="message-inner">
			<div class="message-cell message-cell--user">
				' . $__templater->callMacro('message_macros', 'user_info_simple', array(
		'user' => $__vars['post']['User'],
		'fallbackName' => $__vars['post']['username'],
	), $__vars) . '
			</div>
			<div class="message-cell message-cell--main">
				<header class="message-attribution message-attribution--plain">
					<ul class="listInline listInline--bullet">
						<li class="message-attribution-user">
							' . $__templater->func('avatar', array($__vars['post']['User'], 'xxs', false, array(
	))) . '
							<h4 class="attribution">' . $__templater->func('username_link', array($__vars['post']['User'], true, array(
		'defaultname' => $__vars['post']['username'],
	))) . '</h4>
						</li>
						<li>
							<a href="' . $__templater->func('link', array('threads/post', $__vars['thread'], array('post_id' => $__vars['post']['post_id'], ), ), true) . '"
								class="u-concealed"
								data-xf-click="attribution"
								data-content-selector="#post-' . $__templater->escape($__vars['post']['post_id']) . '"
								rel="nofollow">' . $__templater->func('date_dynamic', array($__vars['post']['post_date'], array(
	))) . '</a>
						</li>
					</ul>
				</header>

				<article class="message-body">
					<div class="message-expandWrapper js-expandWatch">
						<div class="message-expandContent message-expandContent--small js-expandContent">
							' . $__templater->func('bb_code_snippet', array($__vars['post']['message'], 'post', $__vars['post'], 750, ), true) . '
						</div>
						<div class="message-expandLink"></div>
					</div>
				</article>

				<footer class="message-footer">
					<div class="message-actionBar actionBar">
						<div class="actionBar-set actionBar-set--internal">
							<a href="' . $__templater->func('link', array('threads/post', $__vars['thread'], array('post_id' => $__vars['post']['post_id'], ), ), true) . '"
								class="actionBar-action actionBar-action--view"
								data-xf-click="attribution"
								data-content-selector="#post-' . $__templater->escape($__vars['post']['post_id']) . '"
								rel="nofollow">' . 'View full post' . '</a>
						</div>
					</div>
				</footer>
			</div>
		</div>
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

' . $__templater->renderExtension('above_messages_below_pinned', $__vars, $__extensions) . '

';
	return $__finalCompiled;
}
);