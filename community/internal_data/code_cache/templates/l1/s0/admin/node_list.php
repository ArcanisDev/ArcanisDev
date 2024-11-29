<?php
// FROM HASH: 3d3c973e66837d4463efe1813a2f1f95
return array(
'macros' => array('node_icon' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'node' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if (($__vars['node']['node_type_id'] == 'Forum') AND $__vars['node']['Data']['TypeHandler']) {
		$__finalCompiled .= '
		';
		$__vars['typeIcon'] = $__templater->method($__vars['node']['Data']['TypeHandler'], 'getTypeIconClass', array());
		$__finalCompiled .= '
		';
		if ($__vars['typeIcon']) {
			$__finalCompiled .= '
			' . $__templater->fontAwesome($__templater->escape($__vars['typeIcon']), array(
			)) . '
		';
		} else {
			$__finalCompiled .= '
			<i class="nodeIcon nodeIcon--' . $__templater->escape($__vars['node']['node_type_id']) . '"></i>
		';
		}
		$__finalCompiled .= '
	';
	} else {
		$__finalCompiled .= '
		<i class="nodeIcon nodeIcon--' . $__templater->escape($__vars['node']['node_type_id']) . '"></i>
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
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Nodes');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	<div class="buttonGroup">
		' . $__templater->button('Add node', array(
		'href' => $__templater->func('link', array('nodes/add', ), false),
		'icon' => 'add',
		'overlay' => 'true',
	), '', array(
	)) . '
		' . $__templater->button('', array(
		'href' => $__templater->func('link', array('nodes/sort', ), false),
		'icon' => 'sort',
		'overlay' => 'true',
	), '', array(
	)) . '
	</div>
');
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
				if (($__vars['node']['node_type_id'] == 'Forum') AND ($__vars['node']['Data']['TypeHandler'] AND ($__vars['node']['Data']['forum_type_id'] != 'discussion'))) {
					$__compilerTemp3 .= '
													(' . $__templater->escape($__templater->method($__vars['node']['Data']['TypeHandler'], 'getTypeTitle', array())) . ')
												';
				}
				$__compilerTemp4 = array(array(
					'class' => 'dataList-cell--min',
					'_type' => 'cell',
					'html' => '
								' . $__templater->callMacro(null, 'node_icon', array(
					'node' => $__vars['node'],
				), $__vars) . '
							',
				)
,array(
					'class' => 'dataList-cell--link dataList-cell--main',
					'hash' => $__vars['node']['node_id'],
					'_type' => 'cell',
					'html' => '
								<a href="' . $__templater->func('link', array('nodes/edit', $__vars['node'], ), true) . '">
									<div class="u-depth' . $__templater->escape($__vars['treeEntry']['depth']) . '">
										<div class="dataList-mainRow">
											' . $__templater->escape($__vars['node']['title']) . '
											<span class="dataList-hint" dir="auto">
												' . $__templater->escape($__vars['node']['NodeType']['title']) . '
												' . $__compilerTemp3 . '
											</span>
										</div>
									</div>
								</a>
							',
				)
,array(
					'class' => ($__vars['customPermissions'][$__vars['node']['node_id']] ? 'dataList-cell--highlighted' : ''),
					'href' => $__templater->func('link', array('nodes/permissions', $__vars['node'], ), false),
					'_type' => 'action',
					'html' => '
								' . 'Permissions' . '
							',
				));
				if ($__vars['moderators'][$__vars['node']['node_id']]) {
					$__compilerTemp5 = '';
					if ($__templater->isTraversable($__vars['moderators'][$__vars['node']['node_id']])) {
						foreach ($__vars['moderators'][$__vars['node']['node_id']] AS $__vars['moderator']) {
							$__compilerTemp5 .= '
												<a href="' . $__templater->func('link', array('moderators/content/edit', $__vars['moderator'], ), true) . '" class="menu-linkRow">' . $__templater->escape($__vars['moderator']['User']['username']) . '</a>
											';
						}
					}
					$__compilerTemp4[] = array(
						'class' => 'dataList-cell--action u-hideMedium',
						'label' => 'Moderators (' . $__templater->func('count', array($__vars['moderators'][$__vars['node']['node_id']], ), false) . ')',
						'_type' => 'popup',
						'html' => '

									<div class="menu" data-menu="menu" aria-hidden="true">
										<div class="menu-content">
											<h3 class="menu-header">' . 'Moderators' . '</h3>
											' . $__compilerTemp5 . '
											<hr class="menu-separator" />
											<a href="' . $__templater->func('link', array('moderators/add', null, array('type' => 'node', 'type_id' => array('node' => $__vars['node']['node_id'], ), ), ), true) . '" class="menu-linkRow">' . 'Add moderator' . '</a>
										</div>
									</div>
								',
					);
				} else {
					$__compilerTemp4[] = array(
						'href' => $__templater->func('link', array('moderators/add', null, array('type' => 'node', 'type_id' => array('node' => $__vars['node']['node_id'], ), ), ), false),
						'class' => 'u-hideMedium',
						'_type' => 'action',
						'html' => 'Add moderator',
					);
				}
				$__compilerTemp4[] = array(
					'class' => 'dataList-cell--action u-hideMedium',
					'label' => 'Add' . $__vars['xf']['language']['ellipsis'],
					'_type' => 'popup',
					'html' => '

								<div class="menu" data-menu="menu" aria-hidden="true">
									<div class="menu-content">
										<h3 class="menu-header">' . 'Add' . $__vars['xf']['language']['ellipsis'] . '</h3>
										<a href="' . $__templater->func('link', array('nodes/add', null, array('parent_node_id' => $__vars['node']['parent_node_id'], ), ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Sibling' . '</a>
										<a href="' . $__templater->func('link', array('nodes/add', null, array('parent_node_id' => $__vars['node']['node_id'], ), ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Child' . '</a>
									</div>
								</div>
							',
				);
				$__compilerTemp4[] = array(
					'href' => $__templater->func('link', array('nodes/delete', $__vars['node'], ), false),
					'_type' => 'delete',
					'html' => '',
				);
				$__compilerTemp1 .= $__templater->dataRow(array(
				), $__compilerTemp4) . '
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
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
);