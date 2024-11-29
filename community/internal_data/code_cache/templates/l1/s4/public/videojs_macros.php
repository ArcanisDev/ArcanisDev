<?php
// FROM HASH: 1fbb0829e021480b0fb06846d3553906
return array(
'macros' => array('setup' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeCss('videojs.css');
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'prod' => 'xf/video_player-compiled.js',
		'dev' => 'vendor/videojs/video.js, xf/video_player.js',
	));
	$__finalCompiled .= '
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