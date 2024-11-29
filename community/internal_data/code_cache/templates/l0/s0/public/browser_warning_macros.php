<?php
// FROM HASH: 7e16dd6cf6caed0759ce0980b43e5473
return array(
'macros' => array('javascript' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<noscript class="js-jsWarning"><div class="blockMessage blockMessage--important blockMessage--iconic u-noJsOnly">' . 'JavaScript is disabled. For a better experience, please enable JavaScript in your browser before proceeding.' . '</div></noscript>
';
	return $__finalCompiled;
}
),
'browser' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="blockMessage blockMessage--important blockMessage--iconic js-browserWarning" style="display: none">' . 'You are using an out of date browser. It  may not display this or other websites correctly.<br />You should upgrade or use an <a href="https://www.google.com/chrome/" target="_blank" rel="noopener">alternative browser</a>.' . '</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
);