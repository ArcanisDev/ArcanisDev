<?php
// FROM HASH: 237725cdf94bc2387533bef3d8abdbf7
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Options');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['canAdd']) {
		$__compilerTemp1 .= '
		' . $__templater->button('Add option group', array(
			'href' => $__templater->func('link', array('options/groups/add', ), false),
			'icon' => 'add',
		), '', array(
		)) . '
	';
	}
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__compilerTemp1 . '
	' . $__templater->button('Show advanced options', array(
		'class' => 'acp--simple',
		'data-xf-init' => 'admin-toggle-advanced',
		'data-value' => '1',
		'data-url' => $__templater->func('link', array('account/toggle-advanced', ), false),
	), '', array(
	)) . '
');
	$__finalCompiled .= '

<div class="block">
	<div class="block-outer">
		' . $__templater->callMacro('filter_macros', 'quick_filter', array(
		'key' => 'options',
		'class' => 'block-outer-opposite',
	), $__vars) . '
	</div>
	<div class="block-container">
		<div class="block-body">
			';
	$__compilerTemp2 = '';
	if ($__templater->isTraversable($__vars['groups'])) {
		foreach ($__vars['groups'] AS $__vars['group']) {
			$__compilerTemp2 .= '
					';
			$__compilerTemp3 = array();
			if ($__templater->method($__vars['group'], 'canEdit', array())) {
				$__compilerTemp3[] = array(
					'href' => $__templater->func('link', array('options/groups/edit', $__vars['group'], ), false),
					'_type' => 'action',
					'html' => 'Edit',
				);
			}
			$__compilerTemp2 .= $__templater->dataRow(array(
				'icon' => ($__vars['group']['icon'] ?: 'fa-cogs'),
				'label' => $__templater->escape($__vars['group']['title']),
				'href' => $__templater->func('link', array('options/groups', $__vars['group'], ), false),
				'explain' => $__templater->escape($__vars['group']['description']),
				'delete' => ($__templater->method($__vars['group'], 'canEdit', array()) ? $__templater->func('link', array('options/groups/delete', $__vars['group'], ), false) : false),
				'hash' => $__vars['group']['group_id'],
				'rowclass' => ($__vars['group']['advanced'] ? 'acp--advanced' : ''),
			), $__compilerTemp3) . '
				';
		}
	}
	$__finalCompiled .= $__templater->dataList('
				' . $__compilerTemp2 . '
			', array(
	)) . '
		</div>
		<div class="block-footer">
			<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['groups'], ), true) . '</span>
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);