<?php
// FROM HASH: 203d3dbd7abac69a108c2e1bf34f1041
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__templater->test($__vars['threads'], 'empty', array())) {
		$__finalCompiled .= '
	' . $__templater->callMacro('activity_summary_macros', 'outer_header', array(
			'title' => $__vars['title'],
		), $__vars) . '

	';
		if ($__templater->isTraversable($__vars['threads'])) {
			foreach ($__vars['threads'] AS $__vars['thread']) {
				$__finalCompiled .= '
		';
				$__vars['header'] = $__templater->preEscaped('
			<a href="' . $__templater->func('link', array('canonical:threads', $__vars['thread'], ), true) . '">' . $__templater->escape($__vars['thread']['title']) . '</a>
		');
				$__finalCompiled .= '
		';
				$__vars['attribution'] = $__templater->preEscaped('
			' . $__templater->escape($__vars['thread']['username']) . ' &middot; ' . $__templater->func('date_time', array($__vars['thread']['post_date'], ), true) . ' &middot; ' . 'Replies' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->filter($__vars['thread']['reply_count'], array(array('number_short', array()),), true) . '
		');
				$__finalCompiled .= '
		';
				$__vars['footer'] = $__templater->preEscaped('
			' . 'Forum' . $__vars['xf']['language']['label_separator'] . ' <a href="' . $__templater->func('link', array('canonical:forums', $__vars['thread']['Forum'], ), true) . '">' . $__templater->escape($__vars['thread']['Forum']['title']) . '</a>
		');
				$__finalCompiled .= '
		';
				$__vars['footerOpposite'] = $__templater->preEscaped('
			<a href="' . $__templater->func('link', array('canonical:threads', $__vars['thread'], ), true) . '" class="button button--link">' . 'Read more' . '</a>
		');
				$__finalCompiled .= '

		' . $__templater->callMacro('activity_summary_macros', 'block', array(
					'header' => $__vars['header'],
					'attribution' => $__vars['attribution'],
					'content' => $__templater->func('bb_code_type_snippet', array('emailHtml', $__vars['thread']['FirstPost']['message'], 'post', $__vars['thread']['FirstPost'], 300, ), false),
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