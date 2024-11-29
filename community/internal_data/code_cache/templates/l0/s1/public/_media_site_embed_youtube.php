<?php
// FROM HASH: 096b9f3b13aef3a79b33827fbec1c9bb
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="bbMediaWrapper" data-media-site-id="' . $__templater->escape($__vars['siteId']) . '" data-media-key="' . $__templater->escape($__vars['id']) . '">
	<div class="bbMediaWrapper-inner">
		<iframe src="https://www.youtube.com/embed/' . $__templater->escape($__vars['id']) . '?wmode=opaque' . ($__vars['start'] ? ('&start=' . $__templater->escape($__vars['start'])) : '') . ($__vars['list'] ? ('&list=' . $__templater->escape($__vars['list'])) : '') . '"
				width="560" height="315"
				frameborder="0" allowfullscreen="true"></iframe>
	</div>
</div>';
	return $__finalCompiled;
}
);