<?php
// FROM HASH: b26b23e3ecde9fbcb5a74a2811cd19d3
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Warnings');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add warning', array(
		'href' => $__templater->func('link', array('warnings/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
	' . $__templater->button('Add warning action', array(
		'href' => $__templater->func('link', array('warnings/actions/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

<div class="block">
	<div class="block-outer">
		' . $__templater->callMacro('filter_macros', 'quick_filter', array(
		'key' => 'warnings',
		'class' => 'block-outer-opposite',
	), $__vars) . '
	</div>
	<div class="block-container">
		<div class="block-body">
			';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['warnings'])) {
		foreach ($__vars['warnings'] AS $__vars['warning']) {
			$__compilerTemp1 .= '
					';
			$__compilerTemp2 = '';
			if ($__vars['warning']['expiry_default'] == 'never') {
				$__compilerTemp2 .= '
										' . 'Never' . '
									';
			} else {
				$__compilerTemp2 .= '
										' . $__templater->func('duration', array(($__vars['warning']['expiry_default'] ? $__vars['warning']['expiry_default'] : 1), $__vars['warning']['expiry_type'], ), true) . '
									';
			}
			$__compilerTemp1 .= $__templater->dataRow(array(
				'label' => $__templater->escape($__vars['warning']['title']),
				'href' => $__templater->func('link', array('warnings/edit', $__vars['warning'], ), false),
				'delete' => $__templater->func('link', array('warnings/delete', $__vars['warning'], ), false),
				'explain' => '
							<ul class="listInline listInline--bullet listInline--selfInline">
								<li>' . 'Warning points' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['warning']['points_default']) . '</li>
								<li>' . 'Expires' . $__vars['xf']['language']['label_separator'] . '
									' . $__compilerTemp2 . '</li>
							</ul>
						',
			), array()) . '
				';
		}
	}
	$__finalCompiled .= $__templater->dataList('
				' . $__compilerTemp1 . '
			', array(
	)) . '
		</div>
		<div class="block-footer">
			<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['warnings'], ), true) . '</span>
		</div>
	</div>
</div>

';
	if (!$__templater->test($__vars['actions'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<h2 class="block-header">' . 'Warning actions' . '</h2>
			<div class="block-body">
				';
		$__compilerTemp3 = '';
		if ($__templater->isTraversable($__vars['actions'])) {
			foreach ($__vars['actions'] AS $__vars['action']) {
				$__compilerTemp3 .= '
						';
				$__compilerTemp4 = '';
				if ($__vars['action']['action'] == 'ban') {
					$__compilerTemp4 .= '
												<li>' . 'Ban' . '</li>
											';
				} else if ($__vars['action']['action'] == 'discourage') {
					$__compilerTemp4 .= '
												<li>' . 'Discourage' . '</li>
											';
				} else if ($__vars['action']['action'] == 'groups') {
					$__compilerTemp4 .= '
												<li>' . 'Add to selected groups' . '</li>
											';
				} else {
					$__compilerTemp4 .= '
												<li>' . 'Unknown action' . '</li>
											';
				}
				$__compilerTemp5 = '';
				if ($__vars['action']['action_length_type'] == 'permanent') {
					$__compilerTemp5 .= '
												<li>' . 'Permanent' . '</li>
											';
				} else if ($__vars['action']['action_length_type'] == 'points') {
					$__compilerTemp5 .= '
												<li>' . 'While at or above points threshold' . '</li>
											';
				} else {
					$__compilerTemp5 .= '
												<li>' . 'Temporary' . '</li>
											';
				}
				$__compilerTemp3 .= $__templater->dataRow(array(
				), array(array(
					'href' => $__templater->func('link', array('warnings/actions/edit', $__vars['action'], ), false),
					'_type' => 'cell',
					'html' => '
								<div class="dataList-mainRow">
									' . 'Points' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['action']['points']) . '
									<div class="dataList-hint" dir="auto">
										<ul class="listInline listInline--bullet listInline--selfInline">
											' . $__compilerTemp4 . '

											' . $__compilerTemp5 . '
										</ul>
									</div>
								</div>
							',
				),
				array(
					'href' => $__templater->func('link', array('warnings/actions/delete', $__vars['action'], ), false),
					'_type' => 'delete',
					'html' => '',
				))) . '
					';
			}
		}
		$__finalCompiled .= $__templater->dataList('
					' . $__compilerTemp3 . '
				', array(
		)) . '
			</div>
			<!--<div class="block-footer">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['actions'], ), true) . '</span>
			</div>-->
		</div>
	</div>
';
	}
	return $__finalCompiled;
}
);