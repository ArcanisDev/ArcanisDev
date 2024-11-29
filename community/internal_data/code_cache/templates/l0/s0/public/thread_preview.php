<?php
// FROM HASH: b0f369ea8ba4eda3653ace889137098e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->setPageParam('head.' . 'metaNoindex', $__templater->preEscaped('<meta name="robots" content="noindex" />'));
	$__finalCompiled .= '

<div class="tooltip-content-inner">
	' . $__templater->func('bb_code', array($__vars['firstPost']['message'], 'post:thread_preview', $__vars['firstPost'], array('lightbox' => false, ), ), true) . '
	<span class="tooltip-content-cover"></span>
</div>';
	return $__finalCompiled;
}
);