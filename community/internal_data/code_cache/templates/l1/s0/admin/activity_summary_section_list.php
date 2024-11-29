<?php
// FROM HASH: e0c7aa8e73fc8589b586326b1ef0df20
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Activity summary');
	$__finalCompiled .= '

';
	if ($__vars['testSuccess'] AND $__vars['xf']['visitor']['email']) {
		$__finalCompiled .= '
	<div class="blockMessage blockMessage--success blockMessage--iconic">' . 'Test activity summary email sent to ' . $__templater->filter($__vars['xf']['visitor']['email'], array(array('email_display', array()),), true) . ' successfully.' . '</div>
';
	}
	$__finalCompiled .= '

';
	if ($__vars['isImportRunning'] AND $__vars['xf']['options']['activitySummaryEmail']['enabled']) {
		$__finalCompiled .= '
	<div class="blockMessage blockMessage--important blockMessage--iconic">
		' . 'While an import is running sending the activity summary email to inactive users is disabled.' . '
	</div>
';
	}
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if (!$__templater->test($__vars['sections'], 'empty', array()) AND $__vars['xf']['visitor']['email']) {
		$__compilerTemp1 .= '
		' . $__templater->button('Send test email', array(
			'href' => $__templater->func('link', array('activity-summary/send-test-email', ), false),
			'fa' => 'fa-envelope',
			'overlay' => 'true',
		), '', array(
		)) . '
	';
	}
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	<div class="buttonGroup">
		' . $__templater->button('Add activity summary section', array(
		'href' => $__templater->func('link', array('activity-summary/add', ), false),
		'icon' => 'add',
		'overlay' => 'true',
	), '', array(
	)) . '
		' . $__templater->button('', array(
		'href' => $__templater->func('link', array('activity-summary/sort', ), false),
		'icon' => 'sort',
		'overlay' => 'true',
	), '', array(
	)) . '
	</div>

	' . $__compilerTemp1 . '
');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['sections'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__compilerTemp2 = '';
		if ($__templater->isTraversable($__vars['sections'])) {
			foreach ($__vars['sections'] AS $__vars['section']) {
				$__compilerTemp2 .= '
						' . $__templater->dataRow(array(
					'label' => $__templater->escape($__vars['section']['title']),
					'href' => $__templater->func('link', array('activity-summary/edit', $__vars['section'], ), false),
					'delete' => $__templater->func('link', array('activity-summary/delete', $__vars['section'], ), false),
				), array(array(
					'name' => 'active[' . $__vars['section']['section_id'] . ']',
					'selected' => $__vars['section']['active'],
					'class' => 'dataList-cell--separated',
					'submit' => 'true',
					'tooltip' => 'Enable / disable \'' . $__vars['section']['title'] . '\'',
					'_type' => 'toggle',
					'html' => '',
				))) . '
					';
			}
		}
		$__finalCompiled .= $__templater->form('
		<div class="block-outer">
			' . $__templater->callMacro('filter_macros', 'quick_filter', array(
			'key' => 'activity-summary-sections',
			'class' => 'block-outer-opposite',
		), $__vars) . '
		</div>
		<div class="block-container">
			<div class="block-body">
				' . $__templater->dataList('
					' . $__compilerTemp2 . '
				', array(
		)) . '
			</div>
			<div class="block-footer">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['sections'], ), true) . '</span>
			</div>
		</div>
	', array(
			'action' => $__templater->func('link', array('activity-summary/toggle', ), false),
			'class' => 'block',
			'ajax' => 'true',
		)) . '
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'No items have been created yet.' . '</div>
';
	}
	$__finalCompiled .= '

' . $__templater->callMacro('option_macros', 'option_form_block', array(
		'options' => $__vars['options'],
	), $__vars);
	return $__finalCompiled;
}
);