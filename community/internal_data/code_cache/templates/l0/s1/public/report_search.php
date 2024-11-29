<?php
// FROM HASH: 61d76452af4a03c150169e82fe494718
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('' . $__templater->escape($__vars['user']['username']) . '\'s reported content');
	$__finalCompiled .= '

';
	$__templater->breadcrumb($__templater->preEscaped('Reports'), $__templater->func('link', array('reports', ), false), array(
	));
	$__finalCompiled .= '

<div class="block">
	<div class="block-outer">' . $__templater->func('trim', array('
		' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'reports/search',
		'params' => array('username' => $__vars['user']['username'], ),
		'wrapperclass' => 'block-outer-main',
		'perPage' => $__vars['perPage'],
	))) . '
	'), false) . '</div>

	<div class="block-container">
		<div class="block-body">
			<div class="structItemContainer">
				';
	if ($__templater->isTraversable($__vars['reports'])) {
		foreach ($__vars['reports'] AS $__vars['report']) {
			$__finalCompiled .= '
					' . $__templater->callMacro('report_list_macros', 'item', array(
				'report' => $__vars['report'],
			), $__vars) . '
				';
		}
	}
	$__finalCompiled .= '
			</div>
		</div>
	</div>

	<div class="block-outer block-outer--after">
		' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'reports/search',
		'params' => array('username' => $__vars['user']['username'], ),
		'wrapperclass' => 'block-outer-main',
		'perPage' => $__vars['perPage'],
	))) . '
		' . $__templater->func('show_ignored', array(array(
		'wrapperclass' => 'block-outer-opposite',
	))) . '
	</div>
</div>';
	return $__finalCompiled;
}
);