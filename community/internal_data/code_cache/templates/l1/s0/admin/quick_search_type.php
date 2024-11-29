<?php
// FROM HASH: 86c4ecc3b08ed999429095a8c05bf4be
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<dl class="p-quickSearchResultSet">
	<dt>' . $__templater->escape($__vars['typeName']) . '</dt>
	<dd>
		<ul class="p-quickSearchResultList">
		';
	if ($__templater->isTraversable($__vars['results'])) {
		foreach ($__vars['results'] AS $__vars['result']) {
			$__finalCompiled .= '
			<li>
				<a href="' . $__templater->escape($__vars['result']['link']) . '">
					' . $__templater->escape($__vars['result']['title']) . '
					';
			if (!$__templater->test($__vars['result']['extra'], 'empty', array())) {
				$__finalCompiled .= '<span class="p-quickSearchResult-extra">' . $__templater->escape($__vars['result']['extra']) . '</span>';
			}
			$__finalCompiled .= '
					';
			if (!$__templater->test($__vars['result']['meta'], 'empty', array())) {
				$__finalCompiled .= '<span class="p-quickSearchResult-meta">' . $__templater->escape($__vars['result']['meta']) . '</span>';
			}
			$__finalCompiled .= '
				</a>
			</li>
		';
		}
	}
	$__finalCompiled .= '
		</ul>
	</dd>
</dl>';
	return $__finalCompiled;
}
);