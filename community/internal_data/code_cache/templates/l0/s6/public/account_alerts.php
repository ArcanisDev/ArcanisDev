<?php
// FROM HASH: ac9780edee8416c331b3933b754c0ba4
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Alerts');
	$__finalCompiled .= '

';
	$__templater->wrapTemplate('account_wrapper', $__vars);
	$__finalCompiled .= '

<div class="block">
	<div class="block-outer">' . $__templater->func('trim', array('
		<div class="block-outer-opposite">
			<div class="buttonGroup">
				' . $__templater->button('
					' . 'Mark read' . '
				', array(
		'href' => $__templater->func('link', array('account/alerts/mark-read', ), false),
		'class' => 'button--link',
		'overlay' => 'true',
	), '', array(
	)) . '
			</div>
		</div>
	'), false) . '</div>

	<div class="block-container">
		<div class="block-body">
			';
	if (!$__templater->test($__vars['alerts'], 'empty', array())) {
		$__finalCompiled .= '
				<ol class="listPlain" data-xf-init="alerts-list">
				';
		if ($__templater->isTraversable($__vars['alerts'])) {
			foreach ($__vars['alerts'] AS $__vars['alert']) {
				$__finalCompiled .= '
					<li data-alert-id="' . $__templater->escape($__vars['alert']['alert_id']) . '"
						class="alert js-alert block-row block-row--separated ' . ($__templater->method($__vars['alert'], 'isUnreadInUi', array()) ? 'is-unread' : '') . '">
						' . $__templater->callMacro('alert_macros', 'row', array(
					'alert' => $__vars['alert'],
				), $__vars) . '
					</li>
				';
			}
		}
		$__finalCompiled .= '
				</ol>
			';
	} else if ($__vars['page'] <= 1) {
		$__finalCompiled .= '
				<div class="block-row">' . 'You do not have any recent alerts.' . '</div>
			';
	} else {
		$__finalCompiled .= '
				<div class="block-row">' . 'No alerts can be shown. Please select a different page.' . '</div>
			';
	}
	$__finalCompiled .= '
		</div>
	</div>

	' . $__templater->func('page_nav', array(array(
		'link' => 'account/alerts',
		'page' => $__vars['page'],
		'total' => $__vars['totalAlerts'],
		'wrapperclass' => 'block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	))) . '
</div>';
	return $__finalCompiled;
}
);