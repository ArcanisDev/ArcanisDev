<?php
// FROM HASH: d0707dcd29aba4709c09d34c10715ec9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="bbMediaWrapper" data-media-site-id="' . $__templater->escape($__vars['siteId']) . '" data-media-key="' . $__templater->escape($__vars['id']) . '">
	<div class="bbMediaWrapper-inner">
		<iframe src="https://player.vimeo.com/video/' . $__templater->escape($__vars['id']) . ($__vars['key'] ? ('?h=' . $__templater->escape($__vars['key'])) : '') . ($__vars['start'] ? ('#t=' . $__templater->escape($__vars['start']) . 's') : '') . '"
				width="560" height="315"
				frameborder="0" allowfullscreen="true"></iframe>
	</div>
</div>';
	return $__finalCompiled;
}
);