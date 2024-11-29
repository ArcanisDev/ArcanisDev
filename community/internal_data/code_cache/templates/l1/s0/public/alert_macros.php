<?php
// FROM HASH: 86ddf2cce75a887308a05c318e68dc87
return array(
'macros' => array('row' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'alert' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="contentRow">
		<div class="contentRow-figure">
			' . $__templater->func('avatar', array($__vars['alert']['User'], 'xxs', false, array(
		'defaultname' => $__vars['alert']['username'],
	))) . '
		</div>
		<div class="contentRow-main contentRow-main--close">
			' . $__templater->filter($__templater->method($__vars['alert'], 'render', array()), array(array('raw', array()),), true) . '
			<div class="contentRow-minor contentRow-minor--smaller">
				' . $__templater->func('date_dynamic', array($__vars['alert']['event_date'], array(
	))) . '
				<span class="u-pullRight">
					<a href="' . $__templater->func('link', array('account/alert-toggle', null, array('alert_id' => $__vars['alert']['alert_id'], ), ), true) . '"
						data-xf-init="tooltip" data-content="' . ($__templater->method($__vars['alert'], 'isUnreadInUi', array()) ? $__templater->filter('Mark read', array(array('for_attr', array()),), true) : $__templater->filter('Mark unread', array(array('for_attr', array()),), true)) . '"
						data-read="' . $__templater->filter('Mark read', array(array('for_attr', array()),), true) . '" data-unread="' . $__templater->filter('Mark unread', array(array('for_attr', array()),), true) . '"
						class="js-alertToggle alertToggler">' . $__templater->func('trim', array('
						' . $__templater->fontAwesome('fa-circle', array(
		'class' => 'alertToggler-icon',
	)) . '
					'), false) . '</a>
				</span>
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';

	return $__finalCompiled;
}
);