<?php
// FROM HASH: 37281020c3e18ed8a154196fbc06bf72
return array(
'macros' => array('body' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'jsState' => null,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->callMacro('public:helper_js_global', 'body', array(
		'app' => 'admin',
		'jsState' => $__vars['jsState'],
	), $__vars) . '
	';
	$__templater->includeJs(array(
		'src' => 'xf/admin.js',
		'min' => '1',
	));
	$__finalCompiled .= '
	<script>
		jQuery.extend(true, XF.config, {
			job: {
				manualUrl: "' . $__templater->filter($__templater->func('link', array('tools/run-job', ), false), array(array('escape', array('js', )),), true) . '"
			},
			visitorCounts: null
		});
		jQuery.extend(XF.phrases, {
			cancel: "' . $__templater->filter('Cancel', array(array('escape', array('js', )),), true) . '",
			cancelling: "' . $__templater->filter('Cancelling', array(array('escape', array('js', )),), true) . '",
			no_items_matched_your_filter: "' . $__templater->filter('No items matched your filter.', array(array('escape', array('js', )),), true) . '"
		});
	</script>
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