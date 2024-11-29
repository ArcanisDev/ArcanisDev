<?php
// FROM HASH: e89d4ad1810ca4c60952df67078579bb
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->setPageParam('jsState.pinterest', true);
	$__finalCompiled .= '

<div class="bbMediaJustifier" data-media-site-id="' . $__templater->escape($__vars['siteId']) . '" data-media-key="' . $__templater->escape($__vars['id']) . '">
	<a data-pin-do="embedPin"
		data-pin-width="large"
		href="https://www.pinterest.com/pin/' . $__templater->escape($__vars['idDigits']) . '/">
		<i class="fab fa-pinterest-square" aria-hidden="true"></i> https://www.pinterest.com/pin/' . $__templater->escape($__vars['idDigits']) . '/</a>
</div>';
	return $__finalCompiled;
}
);