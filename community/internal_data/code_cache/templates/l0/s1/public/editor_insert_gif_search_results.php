<?php
// FROM HASH: 419e9dae7fc7d1de4df0ceb7b312dfa3
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('editor_insert_gif.less');
	$__finalCompiled .= '

';
	if ($__vars['results']) {
		$__finalCompiled .= '
	<div class="gifContainer js-gifContainer">
		';
		if ($__templater->isTraversable($__vars['results'])) {
			foreach ($__vars['results'] AS $__vars['id'] => $__vars['image']) {
				$__finalCompiled .= '
			<a class="gifContainer-item js-gif">
				<span class="gifContainer-cover">
					' . $__templater->fontAwesome('fa-spinner-third fa-3x', array(
				)) . '
				</span>
				<img src="' . $__templater->escape($__vars['image']['thumb']) . '" data-id="' . $__templater->escape($__vars['id']) . '"
					data-src="' . $__templater->escape($__vars['image']['src']) . '"
					data-insert="' . $__templater->escape($__vars['image']['insert']) . '"
					alt="' . $__templater->escape($__vars['image']['title']) . '" title="' . $__templater->escape($__vars['image']['title']) . '" />
			</a>
		';
			}
		}
		$__finalCompiled .= '

		<a class="gifContainer-item js-gifLoadMore is-loading" data-href="' . $__templater->func('link', array('editor/insert-gif/search', null, array('q' => $__vars['q'], 'offset' => $__vars['nextOffset'], ), ), true) . '">
		<span class="gifContainer-cover">
			' . $__templater->fontAwesome('fa-spinner-third fa-3x', array(
		)) . '
		</span>
		</a>
	</div>
';
	} else {
		$__finalCompiled .= '
	' . 'No results found.' . '
';
	}
	return $__finalCompiled;
}
);