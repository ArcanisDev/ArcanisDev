<?php
// FROM HASH: 78ea5b40f2af8208cb37f386723e7dde
return array(
'extends' => function($__templater, array $__vars) { return 'forum_view'; },
'extensions' => array('thread_list_block_classes' => function($__templater, array $__vars, $__extensions = null)
{
	return 'block--articles
	' . (((($__vars['forum']['type_config']['display_style'] != 'full') AND $__templater->method($__vars['forum'], 'canViewThreadContent', array()))) ? 'block--messages' : '') . '
	' . (((($__vars['forum']['type_config']['display_style'] == 'preview') AND $__templater->method($__vars['forum'], 'canViewThreadContent', array()))) ? 'block--previews' : '') . '
	' . (((($__vars['forum']['type_config']['display_style'] == 'expanded') AND $__templater->method($__vars['forum'], 'canViewThreadContent', array()))) ? 'block--expanded' : '');
},
'thread_list' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '

	';
	if (($__vars['forum']['type_config']['display_style'] != 'full') AND $__templater->method($__vars['forum'], 'canViewThreadContent', array())) {
		$__finalCompiled .= '
		';
		$__templater->includeCss('message.less');
		$__finalCompiled .= '

		';
		if (!$__templater->test($__vars['stickyThreads'], 'empty', array()) OR !$__templater->test($__vars['threads'], 'empty', array())) {
			$__finalCompiled .= '
			';
			if (!$__templater->test($__vars['stickyThreads'], 'empty', array())) {
				$__finalCompiled .= '
				';
				if ($__templater->isTraversable($__vars['stickyThreads'])) {
					foreach ($__vars['stickyThreads'] AS $__vars['thread']) {
						$__finalCompiled .= '
					' . $__templater->callMacro(null, 'article_helper', $__templater->combineMacroArgumentAttributes($__vars['templateOverrides']['thread_list_macro_args'], array(
							'thread' => $__vars['thread'],
							'post' => $__vars['thread']['FirstPost'],
							'forum' => $__vars['forum'],
						)), $__vars) . '
				';
					}
				}
				$__finalCompiled .= '
			';
			}
			$__finalCompiled .= '

			';
			if (!$__templater->test($__vars['threads'], 'empty', array())) {
				$__finalCompiled .= '
				';
				if ($__templater->isTraversable($__vars['threads'])) {
					foreach ($__vars['threads'] AS $__vars['thread']) {
						$__finalCompiled .= '
					' . $__templater->callMacro(null, 'article_helper', $__templater->combineMacroArgumentAttributes($__vars['templateOverrides']['thread_list_macro_args'], array(
							'thread' => $__vars['thread'],
							'post' => $__vars['thread']['FirstPost'],
							'forum' => $__vars['forum'],
						)), $__vars) . '
				';
					}
				}
				$__finalCompiled .= '

				';
				if ($__vars['showDateLimitDisabler']) {
					$__finalCompiled .= '
					<div class="structItem structItem--note">
						<div class="structItem-cell">
							<a href="' . $__templater->func('link', array('forums', $__vars['forum'], array('page' => $__vars['page'], 'no_date_limit' => 1, ) + $__vars['filters'], ), true) . '">
								' . 'Show older items' . '
							</a>
						</div>
					</div>
				';
				}
				$__finalCompiled .= '
			';
			}
			$__finalCompiled .= '
		';
		} else if ($__vars['filters']) {
			$__finalCompiled .= '
			<div class="message js-emptyThreadList">
				<div class="message-inner">
					<div class="message-cell message-cell--main">
						' . 'There are no threads matching your filters.' . '
					</div>
				</div>
			</div>
		';
		} else if ($__vars['showDateLimitDisabler']) {
			$__finalCompiled .= '
			<div class="message js-emptyThreadList">
				<div class="message-inner">
					<div class="message-cell message-cell--main">
						' . 'There are no threads to display.' . '

						<div style="margin-top: 1em">
							<a href="' . $__templater->func('link', array('forums', $__vars['forum'], array('page' => $__vars['page'], 'no_date_limit' => 1, ) + $__vars['filters'], ), true) . '">
								' . 'Show older items' . '
							</a>
						</div>
					</div>
				</div>
			</div>
		';
		} else {
			$__finalCompiled .= '
			<div class="message js-emptyThreadList">
				<div class="message-inner">
					<div class="message-cell message-cell--main">
						' . 'There are no threads in this forum.' . '
					</div>
				</div>
			</div>
		';
		}
		$__finalCompiled .= '
	';
	} else {
		$__finalCompiled .= '
		' . $__templater->renderExtensionParent($__vars, null, $__extensions) . '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}),
'macros' => array('article_helper' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'thread' => '!',
		'post' => '!',
		'forum' => '!',
		'allowInlineMod' => true,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	if ($__vars['forum']['type_config']['display_style'] == 'expanded') {
		$__finalCompiled .= '
		' . $__templater->callMacro(null, 'post_article_macros::article', $__templater->combineMacroArgumentAttributes($__vars['templateOverrides']['thread_list_macro_args'], array(
			'thread' => $__vars['thread'],
			'post' => $__vars['thread']['FirstPost'],
			'forum' => $__vars['forum'],
			'isListItem' => true,
		)), $__vars) . '
	';
	} else {
		$__finalCompiled .= '
		' . $__templater->callMacro(null, 'post_article_macros::article_preview', $__templater->combineMacroArgumentAttributes($__vars['templateOverrides']['thread_list_macro_args'], array(
			'thread' => $__vars['thread'],
			'post' => $__vars['thread']['FirstPost'],
			'forum' => $__vars['forum'],
		)), $__vars) . '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . '

' . $__templater->renderExtension('thread_list', $__vars, $__extensions) . '

';
	return $__finalCompiled;
}
);