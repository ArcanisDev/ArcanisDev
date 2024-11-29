<?php
// FROM HASH: 8883e252dda76f8f81f999d11160768d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->setPageParam('template', 'OFFLINE_CONTAINER');
	$__finalCompiled .= '
';
	$__templater->setPageParam('css', $__templater->filter($__vars['css'], array(array('raw', array()),), true));
	$__finalCompiled .= '

';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Page could not be loaded');
	$__finalCompiled .= '

<div class="p-offline-main">
	' . 'The requested page could not be loaded.

<ul>
	<li>Check your internet connection and try again.</li>
	<li>Certain browser extensions, such as ad blockers, may block pages unexpectedly. Disable these and try again.</li>
	<li>' . ($__templater->escape($__vars['xf']['options']['boardShortTitle']) ?: $__templater->escape($__vars['xf']['options']['boardTitle'])) . ' may be temporarily unavailable. Please check back later.</li>
</ul>' . '

	<a href="javascript:window.location.reload();" class="button">' . 'Reload' . '</a>
</div>

<script>
	window.addEventListener(\'online\', function()
	{
		window.location.reload();
	});
</script>';
	return $__finalCompiled;
}
);