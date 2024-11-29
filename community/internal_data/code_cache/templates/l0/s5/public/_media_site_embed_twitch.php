<?php
// FROM HASH: 73e0e5eee69b18e4fef33af58591ac9f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="bbMediaWrapper" data-media-site-id="' . $__templater->escape($__vars['siteId']) . '" data-media-key="' . $__templater->escape($__vars['id']) . '">
	<div class="bbMediaWrapper-inner">
		<iframe src="' . $__templater->escape($__vars['url']) . '"
			width="560" height="315"
			frameborder="0" allowfullscreen="true"
			scrolling="no"></iframe>
	</div>
</div>';
	return $__finalCompiled;
}
);