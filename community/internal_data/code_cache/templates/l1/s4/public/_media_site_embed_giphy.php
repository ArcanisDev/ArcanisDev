<?php
// FROM HASH: 6e48b7df26f2324a43ae6b1f808ff81d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="bbMediaWrapper" data-media-site-id="' . $__templater->escape($__vars['siteId']) . '" data-media-key="' . $__templater->escape($__vars['id']) . '">
	<div class="bbMediaWrapper-inner bbMediaWrapper-inner--4to3">
		<iframe src="https://giphy.com/embed/' . $__templater->escape($__vars['id']) . '"
			width="500"
			height="375"
			frameborder="0"
			allowfullscreen></iframe>
	</div>
</div>';
	return $__finalCompiled;
}
);