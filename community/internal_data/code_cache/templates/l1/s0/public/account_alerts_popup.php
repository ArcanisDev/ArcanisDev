<?php
// FROM HASH: 5b3e84d50ae5430987ee5d520a5a532a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__templater->test($__vars['alerts'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="menu-scroller">
		<ol class="listPlain" data-xf-init="alerts-list">
			';
		if ($__templater->isTraversable($__vars['alerts'])) {
			foreach ($__vars['alerts'] AS $__vars['alert']) {
				$__finalCompiled .= '
				<li class="alert js-alert menu-row menu-row--separated menu-row--clickable ' . ($__templater->method($__vars['alert'], 'isUnreadInUi', array()) ? 'is-unread' : '') . '" data-alert-id="' . $__templater->escape($__vars['alert']['alert_id']) . '">
					<div class="fauxBlockLink">
						' . $__templater->callMacro('alert_macros', 'row', array(
					'alert' => $__vars['alert'],
				), $__vars) . '
					</div>
				</li>
			';
			}
		}
		$__finalCompiled .= '
		</ol>
	</div>
';
	} else {
		$__finalCompiled .= '
	<div class="menu-row">' . 'You have no new alerts.' . '</div>
';
	}
	return $__finalCompiled;
}
);