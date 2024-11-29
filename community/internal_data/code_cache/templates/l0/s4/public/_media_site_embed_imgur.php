<?php
// FROM HASH: 1d7d2559f1711860f0750727d0101d96
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->setPageParam('jsState.imgur', true);
	$__finalCompiled .= '

<div class="bbMediaWrapper" data-media-site-id="' . $__templater->escape($__vars['siteId']) . '" data-media-key="' . $__templater->escape($__vars['idSlash']) . '">
	<blockquote class="imgur-embed-pub" lang="en" data-id="' . $__templater->escape($__vars['idRaw']) . '">
		<a href="https://imgur.com/' . $__templater->escape($__vars['idSlash']) . '" rel="external" target="_blank">https://imgur.com/' . $__templater->escape($__vars['idSlash']) . '</a>
	</blockquote>
</div>';
	return $__finalCompiled;
}
);