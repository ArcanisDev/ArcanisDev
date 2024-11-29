<?php
// FROM HASH: 15e2de0add0520671f657acb04711e25
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.m-pageWidth(@min-width: @xf-pageEdgeSpacer)
{
	max-width: @xf-pageWidthMax;
	padding: 0 @xf-pageEdgeSpacer;
	margin: 0 auto;
}

.m-pageInset(@defaultPadding: @xf-pageEdgeSpacer)
{
	padding-left: @defaultPadding;
	padding-right: @defaultPadding;

	// iPhone X/Xr/Xs support
	@supports(padding: max(0px))
	{
		&
		{
			padding-left: ~"max(@{defaultPadding}, env(safe-area-inset-left))";
			padding-right: ~"max(@{defaultPadding}, env(safe-area-inset-right))";
		}
	}
}

.m-navElHPadding(@padding)
{
	.p-navEl-link
	{
		padding: 0 @padding;

		&.p-navEl-link--splitMenu
		{
			padding-right: ((@padding) / 8);
		}

		&.p-navEl-link--menuTrigger
		{
			padding-right: ((@padding) / 3); // equal to splitTrigger padding-right

			&:after
			{
				padding-left: ((@padding) / 4 + (@padding) / 3); // equal to splitMenu padding-right + splitTrigger padding-left
			}
		}
	}

	.p-navEl-splitTrigger
	{
		padding: 0 ((@padding) / 3);
	}
}';
	return $__finalCompiled;
}
);