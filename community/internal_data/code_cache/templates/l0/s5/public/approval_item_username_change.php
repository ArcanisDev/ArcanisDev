<?php
// FROM HASH: e2430f15887bdd50d072a3c5b161e18f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if (!$__templater->test($__vars['previousChanges'], 'empty', array())) {
		$__compilerTemp1 .= '
		<br />

		';
		$__compilerTemp2 = '';
		if ($__templater->isTraversable($__vars['previousChanges'])) {
			foreach ($__vars['previousChanges'] AS $__vars['change']) {
				$__compilerTemp2 .= '
				';
				$__compilerTemp3 = '';
				if ($__vars['change']['change_reason']) {
					$__compilerTemp3 .= '
							<a role="button"
									tabindex="0"
									data-xf-init="tooltip"
									data-trigger="hover focus click"
									title="' . 'Change reason' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['change']['change_reason']) . '">' . $__templater->func('trim', array('
									' . $__templater->fontAwesome('fa-info-circle', array(
					)) . '
								'), false) . '</a>
						';
				}
				$__compilerTemp4 = '';
				if ($__vars['change']['change_state'] == 'approved') {
					$__compilerTemp4 .= '
							' . 'Approved' . '
						';
				} else if ($__vars['change']['change_state'] == 'moderated') {
					$__compilerTemp4 .= '
							' . 'Awaiting approval' . '
						';
				} else if ($__vars['change']['change_state'] == 'rejected') {
					$__compilerTemp4 .= '
							' . 'Rejected' . '
							';
					if ($__vars['change']['reject_reason']) {
						$__compilerTemp4 .= '
								<a role="button"
									tabindex="0"
									data-xf-init="tooltip"
									data-trigger="hover focus click"
									title="' . 'Reason' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['change']['reject_reason']) . '">' . $__templater->func('trim', array('
									' . $__templater->fontAwesome('fa-info-circle', array(
						)) . '
								'), false) . '</a>
							';
					}
					$__compilerTemp4 .= '
						';
				}
				$__compilerTemp2 .= $__templater->dataRow(array(
					'rowclass' => 'dataList-row--noHover',
				), array(array(
					'class' => ($__vars['change']['visible'] ? '' : 'dataList-cell--alt'),
					'_type' => 'cell',
					'html' => '
						' . $__templater->escape($__vars['change']['old_username']) . '
					',
				),
				array(
					'class' => ($__vars['change']['visible'] ? '' : 'dataList-cell--alt'),
					'_type' => 'cell',
					'html' => '
						' . $__templater->escape($__vars['change']['new_username']) . '
						' . $__compilerTemp3 . '
					',
				),
				array(
					'class' => ($__vars['change']['visible'] ? '' : 'dataList-cell--alt'),
					'_type' => 'cell',
					'html' => '
						' . $__compilerTemp4 . '
					',
				),
				array(
					'class' => ($__vars['change']['visible'] ? '' : 'dataList-cell--alt'),
					'_type' => 'cell',
					'html' => '
						' . $__templater->func('date_dynamic', array($__vars['change']['change_date'], array(
				))) . '
					',
				))) . '
			';
			}
		}
		$__compilerTemp1 .= $__templater->dataList('
			<thead>
			' . $__templater->dataRow(array(
			'rowtype' => 'subSection',
		), array(array(
			'colspan' => '4',
			'_type' => 'cell',
			'html' => 'Username change log',
		))) . '
			' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), array(array(
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
		))) . '
			</thead>
			<tbody class="dataList-rowGroup">
			' . $__compilerTemp2 . '
			</tbody>
		', array(
			'data-xf-init' => 'responsive-data-list',
			'class' => 'dataList--separated',
		)) . '
	';
	}
	$__vars['messageHtml'] = $__templater->preEscaped($__templater->func('trim', array('

	<div class="pairWrapper pairWrapper--spaced">
		<dl class="pairs pairs--columns pairs--fixedSmall">
			<dt>' . 'Current username' . '</dt>
			<dd>' . $__templater->escape($__vars['content']['old_username']) . '</dd>
		</dl>

		<dl class="pairs pairs--columns pairs--fixedSmall">
			<dt>' . 'New username' . '</dt>
			<dd>' . $__templater->escape($__vars['content']['new_username']) . '</dd>
		</dl>

		<dl class="pairs pairs--columns pairs--fixedSmall">
			<dt>' . 'Change reason' . '</dt>
			<dd>' . $__templater->filter($__vars['content']['change_reason'], array(array('nl2br', array()),), true) . '</dd>
		</dl>
	</div>

	' . $__compilerTemp1 . '

'), false));
	$__finalCompiled .= '

';
	$__vars['actionsHtml'] = $__templater->preEscaped('

	' . $__templater->formRadio(array(
		'name' => 'queue[' . $__vars['unapprovedItem']['content_type'] . '][' . $__vars['unapprovedItem']['content_id'] . ']',
	), array(array(
		'value' => '',
		'checked' => 'checked',
		'label' => 'Do nothing',
		'data-xf-click' => 'approval-control',
		'_type' => 'option',
	),
	array(
		'value' => 'approve',
		'label' => 'Approve',
		'data-xf-click' => 'approval-control',
		'_type' => 'option',
	),
	array(
		'value' => 'reject',
		'label' => 'Reject with reason' . $__vars['xf']['language']['label_separator'],
		'data-xf-click' => 'approval-control',
		'_dependent' => array($__templater->formTextBox(array(
		'name' => 'reason[' . $__vars['unapprovedItem']['content_type'] . '][' . $__vars['unapprovedItem']['content_id'] . ']',
		'maxlength' => '100',
		'placeholder' => 'Optional',
	))),
		'html' => '
				<div class="formRow-explain">' . 'This will be shown to the user if provided.' . '</div>
			',
		'_type' => 'option',
	))) . '

	' . $__templater->formCheckBox(array(
	), array(array(
		'name' => 'notify[' . $__vars['unapprovedItem']['content_type'] . '][' . $__vars['unapprovedItem']['content_id'] . ']',
		'value' => '1',
		'checked' => true,
		'label' => '
			' . 'Notify user if action was taken' . '
		',
		'_type' => 'option',
	))) . '

');
	$__finalCompiled .= '

' . $__templater->callMacro('approval_queue_macros', 'item_message_type', array(
		'content' => $__vars['content'],
		'contentDate' => $__vars['content']['change_date'],
		'user' => $__vars['content']['User'],
		'messageHtml' => $__vars['messageHtml'],
		'typePhraseHtml' => 'Username change',
		'actionsHtml' => $__vars['actionsHtml'],
	), $__vars);
	return $__finalCompiled;
}
);