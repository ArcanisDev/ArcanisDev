<?php
// FROM HASH: 083b1a3829a572036e1e0d4f76423f61
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Activity summary definitions');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add activity summary definition', array(
		'href' => $__templater->func('link', array('activity-summary/definitions/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['definitions'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-outer">
			' . $__templater->callMacro('filter_macros', 'quick_filter', array(
			'key' => 'activity-summary-definitions',
			'class' => 'block-outer-opposite',
		), $__vars) . '
		</div>
		<div class="block-container">
			<div class="block-body">
				';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['definitions'])) {
			foreach ($__vars['definitions'] AS $__vars['definition']) {
				$__compilerTemp1 .= '
						' . $__templater->dataRow(array(
					'label' => $__templater->escape($__vars['definition']['title']),
					'hint' => $__templater->escape($__vars['definition']['definition_class']),
					'explain' => $__templater->escape($__vars['definition']['description']),
					'href' => $__templater->func('link', array('activity-summary/definitions/edit', $__vars['definition'], ), false),
					'delete' => $__templater->func('link', array('activity-summary/definitions/delete', $__vars['definition'], ), false),
				), array(array(
					'href' => $__templater->func('link', array('activity-summary/add', null, array('definition_id' => $__vars['definition']['definition_id'], ), ), false),
					'_type' => 'action',
					'html' => '
								' . 'Add activity summary' . '
							',
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
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['definitions'], ), true) . '</span>
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