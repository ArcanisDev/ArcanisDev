<?php
// FROM HASH: 0a3cf2dd3f41016b71166d9b0fce6d54
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.menuTrigger.menuTrigger--prefix
{
	text-decoration: none;
}

.menuPrefix,
.menuPrefix.label--hidden
{
	display: block;
	font-size: @xf-fontSizeSmall;
	cursor: default;
	padding: @xf-paddingMedium;
	//margin-bottom: -(@xf-paddingMedium);

	&.label--hidden
	{
		border: 1px solid @xf-borderColorFaint;
	}

	&.menuPrefix--none
	{
		color: @xf-textColorMuted;
		text-decoration: none;
	}
}';
	return $__finalCompiled;
}
);