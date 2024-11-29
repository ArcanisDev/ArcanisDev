<?php
// FROM HASH: 1a893267c9e46b0ce3a4b235dbb4887d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="bbMediaWrapper" data-media-site-id="' . $__templater->escape($__vars['siteId']) . '" data-media-key="' . $__templater->escape($__vars['id']) . '">
	<div class="bbMediaWrapper-inner">
		<iframe src="https://www.dailymotion.com/embed/video/' . $__templater->escape($__vars['id']) . '?start=' . $__templater->escape($__vars['start']) . '&width=560&hideInfos=1"
				width="560" height="315"
				allowfullscreen
				frameborder="0"></iframe>
	</div>
</div>';
	return $__finalCompiled;
}
);