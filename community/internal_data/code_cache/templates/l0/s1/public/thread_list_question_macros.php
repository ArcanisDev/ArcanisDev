<?php
// FROM HASH: 00c00c2478235587803c243bf7c8dc8b
return array(
'macros' => array('item' => array(
'extends' => 'thread_list_macros::item',
'extensions' => array('meta_cell' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
		<div class="structItem-cell structItem-cell--meta" title="' . $__templater->filter('First message reaction score' . $__vars['xf']['language']['label_separator'], array(array('for_attr', array()),), true) . ' ' . $__templater->filter($__vars['thread']['first_post_reaction_score'], array(array('number', array()),), true) . '">
			<dl class="pairs pairs--justified">
				<dt>' . 'Answers' . '</dt>
				<dd>' . (($__vars['thread']['discussion_type'] == 'redirect') ? '&ndash;' : $__templater->filter($__vars['thread']['reply_count'], array(array('number_short', array()),), true)) . '</dd>
			</dl>
			<dl class="pairs pairs--justified structItem-minor">
				<dt>' . 'Views' . '</dt>
				<dd>' . (($__vars['thread']['discussion_type'] == 'redirect') ? '&ndash;' : (($__vars['thread']['view_count'] > $__vars['thread']['reply_count']) ? $__templater->filter($__vars['thread']['view_count'], array(array('number_short', array()),), true) : $__templater->func('number_short', array($__vars['thread']['reply_count'] + 1, ), true))) . '</dd>
			</dl>
		</div>
	';
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->renderExtension('meta_cell', $__vars, $__extensions) . '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';

	return $__finalCompiled;
}
);