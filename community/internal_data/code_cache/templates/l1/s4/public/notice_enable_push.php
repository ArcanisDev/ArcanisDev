<?php
// FROM HASH: d331a18fcbad755dd9b3f65d25b3483a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<a href="javascript:" class="notice-dismiss js-enablePushDismiss" aria-label="' . $__templater->filter('Dismiss notice', array(array('for_attr', array()),), true) . '"></a>

<div data-xf-init="push-cta">
	<div class="u-alignCenter">
		<div class="js-initialMessage">
			' . '' . $__templater->escape($__vars['xf']['options']['boardTitle']) . ' would like your permission to <a href="' . $__templater->func('link', array('account/preferences', ), true) . '" class="js-enablePushLink">enable push notifications</a>.' . '
		</div>
		<div class="js-dismissMessage" style="display: none">
			' . 'We strongly recommend enabling push notifications on this device so that you can be kept up-to-date with site activity.' . '
			<ul class="listInline listInline--bullet" style="margin-top: 5px">
				<li><a href="' . $__templater->func('link', array('account/preferences', ), true) . '" class="js-enablePushLink">' . 'Enable notifications' . '</a></li>
				<li><a href="javascript:" class="js-dismissTemp">' . 'Ask me another time' . '</a></li>
				<li><a href="javascript:" class="js-dismissPerm">' . 'Never ask again' . '</a></li>
			</ul>
		</div>
	</div>
</div>

';
	$__templater->inlineJs('
	jQuery.extend(true, XF.config, {
		skipPushNotificationSubscription: true
	});
');
	return $__finalCompiled;
}
);