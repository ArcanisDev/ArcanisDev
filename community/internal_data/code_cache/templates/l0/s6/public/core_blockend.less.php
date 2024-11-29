<?php
// FROM HASH: 5245e64297fc7565b2839c83f342239d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '// This contains rules that apply to various block and block-related systems. This file should be included
// after all of the primary definitions to ensure the rules override.

.blockMessage,
.blockStatus,
.block-row
{
	p:first-child
	{
		margin-top: 0;
	}

	p:last-child
	{
		margin-bottom: 0;
	}
}

@media (max-width: @xf-responsiveEdgeSpacerRemoval)
{
	.blockMessage.blockMessage--none
	{
		margin-left: 0;
		margin-right: 0;
	}
}';
	return $__finalCompiled;
}
);