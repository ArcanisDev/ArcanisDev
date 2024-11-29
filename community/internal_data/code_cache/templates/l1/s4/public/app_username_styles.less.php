<?php
// FROM HASH: b40c07e885b7a7d2af0d863e6e0bcd9f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.username--invisible
{
	color: @xf-textColorMuted;
}

.username--banned
{
	text-decoration: line-through;
}

';
	if ($__templater->isTraversable($__vars['displayStyles'])) {
		foreach ($__vars['displayStyles'] AS $__vars['id'] => $__vars['style']) {
			if ($__vars['style']['username_css']) {
				$__finalCompiled .= '
	.username--style' . $__templater->escape($__vars['id']) . '
	{
		' . $__templater->filter($__vars['style']['username_css'], array(array('raw', array()),), true) . '
	}
';
			}
		}
	}
	return $__finalCompiled;
}
);