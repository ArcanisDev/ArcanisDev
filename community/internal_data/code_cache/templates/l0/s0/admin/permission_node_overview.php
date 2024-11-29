<?php
// FROM HASH: 926245c61e6262c99e23d274366b3394
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Node permissions');
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['nodeTree'], 'countChildren', array())) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-outer">
			' . $__templater->callMacro('filter_macros', 'quick_filter', array(
			'key' => 'nodes',
			'class' => 'block-outer-opposite',
		), $__vars) . '
		</div>
		<div class="block-container">
			<div class="block-body">
				';
		$__compilerTemp1 = '';
		$__compilerTemp2 = $__templater->method($__vars['nodeTree'], 'getFlattened', array(0, ));
		if ($__templater->isTraversable($__compilerTemp2)) {
			foreach ($__compilerTemp2 AS $__vars['treeEntry']) {
				$__compilerTemp1 .= '
						';
				$__vars['node'] = $__vars['treeEntry']['record'];
				$__compilerTemp1 .= '
						';
				$__compilerTemp3 = '';
				if ($__templater->func('callable', array($__vars['node']['Data'], 'getTypeHandler', ), false)) {
					$__compilerTemp3 .= ' (' . $__templater->escape($__templater->method($__vars['node']['Data']['TypeHandler'], 'getTypeTitle', array())) . ')';
				}
				$__compilerTemp1 .= $__templater->dataRow(array(
					'rowclass' => ($__vars['customPermissions'][$__vars['node']['node_id']] ? 'dataList-row--custom' : ''),
				), array(array(
					'class' => 'dataList-cell--min',
					'_type' => 'cell',
					'html' => $__templater->callMacro('node_list', 'node_icon', array(
					'node' => $__vars['node'],
				), $__vars),
				),
				array(
					'class' => 'dataList-cell--link dataList-cell--main',
					'hash' => $__vars['node']['node_id'],
					'_type' => 'cell',
					'html' => '
								<a href="' . $__templater->func('link', array('permissions/nodes', $__vars['node'], ), true) . '">
									<div class="u-depth' . $__templater->escape($__vars['treeEntry']['depth']) . '">
										<div class="dataList-mainRow">' . $__templater->escape($__vars['node']['title']) . ' <span class="dataList-hint" dir="auto">' . $__templater->escape($__vars['node']['NodeType']['title']) . ' ' . $__compilerTemp3 . '</span></div>
									</div>
								</a>
							',
				),
				array(
					'href' => $__templater->func('link', array('nodes/edit', $__vars['node'], ), false),
					'_type' => 'action',
					'html' => 'Edit',
				))) . '
					';
			}
		}
		$__finalCompiled .= $__templater->dataList('
					' . $__compilerTemp1 . '
				', array(
		)) . '
			</div>
			<div class="block-footer">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__templater->method($__vars['nodeTree'], 'getFlattened', array(0, )), ), true) . '</span>
			</div>
		</div>
	</div>
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'No items have been created yet.' . '</div>
';
	}
	return $__finalCompiled;
}
);