<?php
// FROM HASH: f206ebaa5d3cb9719d9167351aadd6e6
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__templater->test($__vars['posts'], 'empty', array())) {
		$__finalCompiled .= '
	' . $__templater->callMacro('activity_summary_macros', 'outer_header', array(
			'title' => $__vars['title'],
		), $__vars) . '

	';
		if ($__templater->isTraversable($__vars['posts'])) {
			foreach ($__vars['posts'] AS $__vars['post']) {
				$__finalCompiled .= '
		';
				$__vars['attribution'] = $__templater->preEscaped('
			' . ($__vars['post']['User'] ? $__templater->escape($__vars['post']['User']['username']) : $__templater->escape($__vars['post']['username'])) . ' &middot; ' . 'Thread' . $__vars['xf']['language']['label_separator'] . ' <a href="' . $__templater->func('link', array('canonical:threads/post', $__vars['post']['Thread'], array('post_id' => $__vars['post']['post_id'], ), ), true) . '">' . $__templater->escape($__vars['post']['Thread']['title']) . '</a> &middot; ' . $__templater->func('date_time', array($__vars['post']['post_date'], ), true) . '
		');
				$__finalCompiled .= '
		';
				$__vars['footer'] = $__templater->preEscaped('
			' . 'Forum' . $__vars['xf']['language']['label_separator'] . ' <a href="' . $__templater->func('link', array('canonical:forums', $__vars['post']['Thread']['Forum'], ), true) . '">' . $__templater->escape($__vars['post']['Thread']['Forum']['title']) . '</a>
		');
				$__finalCompiled .= '
		';
				$__vars['footerOpposite'] = $__templater->preEscaped('
			<a href="' . $__templater->func('link', array('canonical:threads/post', $__vars['post']['Thread'], array('post_id' => $__vars['post']['post_id'], ), ), true) . '" class="button button--link">' . 'Read more' . '</a>
		');
				$__finalCompiled .= '

		' . $__templater->callMacro('activity_summary_macros', 'block', array(
					'attribution' => $__vars['attribution'],
					'content' => $__templater->func('bb_code_type_snippet', array('emailHtml', $__vars['post']['message'], 'post', $__vars['post'], 300, ), false),
					'footer' => $__vars['footer'],
					'footerOpposite' => $__vars['footerOpposite'],
				), $__vars) . '
	';
			}
		}
		$__finalCompiled .= '
';
	}
	return $__finalCompiled;
}
);