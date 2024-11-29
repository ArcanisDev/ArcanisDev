<?php
// FROM HASH: aae6a5a3542f624f4f70cb7cff012de8
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Username change log');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	$__compilerTemp2 = true;
	if ($__templater->isTraversable($__vars['entries'])) {
		foreach ($__vars['entries'] AS $__vars['entry']) {
			$__compilerTemp2 = false;
			$__compilerTemp1 .= '
					';
			$__compilerTemp3 = '';
			if ($__vars['entry']['change_reason']) {
				$__compilerTemp3 .= '
								<a role="button"
									tabindex="0"
									data-xf-init="tooltip"
									data-trigger="hover focus click"
									title="' . 'Change reason' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['entry']['change_reason']) . '">' . $__templater->func('trim', array('
									' . $__templater->fontAwesome('fa-info-circle', array(
				)) . '
								'), false) . '</a>
							';
			}
			$__compilerTemp4 = '';
			if ($__vars['entry']['change_state'] == 'approved') {
				$__compilerTemp4 .= '
								' . 'Approved' . '
							';
			} else if ($__vars['entry']['change_state'] == 'moderated') {
				$__compilerTemp4 .= '
								' . 'Awaiting approval' . '
							';
			} else if ($__vars['entry']['change_state'] == 'rejected') {
				$__compilerTemp4 .= '
								' . 'Rejected' . '
								';
				if ($__vars['entry']['reject_reason']) {
					$__compilerTemp4 .= '
									<a role="button"
										tabindex="0"
										data-xf-init="tooltip"
										data-trigger="hover focus click"
										title="' . 'Reason' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['entry']['reject_reason']) . '">' . $__templater->func('trim', array('
										' . $__templater->fontAwesome('fa-info-circle', array(
					)) . '
									'), false) . '</a>
								';
				}
				$__compilerTemp4 .= '
							';
			}
			$__compilerTemp1 .= $__templater->dataRow(array(
				'rowclass' => 'dataList-row--noHover',
			), array(array(
				'class' => 'dataList-cell--min dataList-cell--image dataList-cell--imageSmall',
				'href' => $__templater->func('link', array('users/edit', $__vars['entry']['User'], ), false),
				'data-xf-init' => 'tooltip',
				'title' => 'Current username' . $__vars['xf']['language']['label_separator'] . ' ' . $__vars['entry']['User']['username'],
				'_type' => 'cell',
				'html' => '
							' . $__templater->func('avatar', array($__vars['entry']['User'], 's', false, array(
				'href' => '',
			))) . '
						',
			),
			array(
				'_type' => 'cell',
				'html' => '
							' . $__templater->escape($__vars['entry']['old_username']) . '
						',
			),
			array(
				'_type' => 'cell',
				'html' => '
							' . $__templater->escape($__vars['entry']['new_username']) . '
							' . $__compilerTemp3 . '
						',
			),
			array(
				'_type' => 'cell',
				'html' => '
							' . $__compilerTemp4 . '
						',
			),
			array(
				'_type' => 'cell',
				'html' => '
							' . $__templater->func('date_dynamic', array($__vars['entry']['change_date'], array(
			))) . '
						',
			),
			array(
				'name' => 'visible[' . $__vars['entry']['change_id'] . ']',
				'selected' => $__vars['entry']['visible'],
				'class' => 'dataList-cell--separated',
				'submit' => 'true',
				'tooltip' => 'Toggle visibility',
				'_type' => 'toggle',
				'html' => '',
			),
			array(
				'href' => $__templater->func('link', array('logs/username-change', $__vars['entry'], ), false),
				'overlay' => 'true',
				'_type' => 'action',
				'html' => '
							' . 'View' . '
						',
			))) . '
				';
		}
	}
	if ($__compilerTemp2) {
		$__compilerTemp1 .= '
					' . $__templater->dataRow(array(
		), array(array(
			'colspan' => '7',
			'_type' => 'cell',
			'html' => 'No entries have been logged.',
		))) . '
				';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->dataList('
				' . $__templater->dataRow(array(
		'rowtype' => 'header',
	), array(array(
		'class' => 'dataList-cell--min',
		'_type' => 'cell',
		'html' => '&nbsp;',
	),
	array(
		'_type' => 'cell',
		'html' => 'Old username',
	),
	array(
		'_type' => 'cell',
		'html' => 'New username',
	),
	array(
		'_type' => 'cell',
		'html' => 'Change state',
	),
	array(
		'_type' => 'cell',
		'html' => 'Date',
	),
	array(
		'class' => 'dataList-cell--min',
		'colspan' => '2',
		'_type' => 'cell',
		'html' => '&nbsp;',
	))) . '

				' . $__compilerTemp1 . '
			', array(
		'data-xf-init' => 'responsive-data-list',
	)) . '
		</div>
	</div>
	' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'logs/username-change',
		'wrapperclass' => 'block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	))) . '
', array(
		'action' => $__templater->func('link', array('logs/username-change/toggle', ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);