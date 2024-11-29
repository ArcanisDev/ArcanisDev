<?php
// FROM HASH: 470da051cd5b672b81c1af74dafc46f6
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->setPageParam('jsState.twitter', true);
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'src' => 'xf/embed.js',
		'min' => '1',
	));
	$__finalCompiled .= '

<div class="bbMediaJustifier bbCode-tweet"
	  data-media-site-id="' . $__templater->escape($__vars['siteId']) . '"
	  data-media-key="' . $__templater->escape($__vars['id']) . '"
	  data-xf-init="tweet"
	  data-tweet-id="' . $__templater->escape($__vars['id']) . '"
	  data-lang="' . $__templater->escape($__vars['xf']['language']['language_code']) . '"
	  data-theme="' . $__templater->func('property', array('styleType', ), true) . '"
	  ><a href="https://twitter.com/i/web/status/' . $__templater->escape($__vars['id']) . '" rel="external" target="_blank">
	<i class="fab fa-twitter" aria-hidden="true"></i> https://twitter.com/i/web/status/' . $__templater->escape($__vars['id']) . '</a></div>';
	return $__finalCompiled;
}
);