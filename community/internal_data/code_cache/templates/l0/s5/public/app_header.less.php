<?php
// FROM HASH: 61eafc096716df0d47a94fb21060d51d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '// MAIN HEADER ROW

.p-header
{
	.xf-publicHeader();

	a
	{
		color: inherit;
	}
}

.p-header-inner
{
	.m-pageWidth();
	.m-pageInset();
}

.p-header-content
{
	padding: @xf-paddingMedium 0;

	display: flex;
	flex-wrap: wrap;
	justify-content: space-between;
	align-items: center;
	max-width: 100%;
}

.p-header-logo
{
	vertical-align: middle;
	margin-right: auto;

	a
	{
		color: inherit;
		text-decoration: none;
	}

	&.p-header-logo--text
	{
		font-size: @xf-fontSizeLargest;
	}

	&.p-header-logo--image
	{
		img
		{
			vertical-align: bottom;
			max-width: 100%;
			
			// Note: this is XF template syntax, not LESS
			' . ((!$__templater->func('property', array('publicLogoHeight', ), false)) ? 'max-height: 200px;' : '') . '

			&[src$="/xenforo-logo.svg"]
			{
				height: 36px;
			}
		}
	}
}

@media (max-width: @xf-publicNavCollapseWidth)
{
	.has-js .p-header
	{
		display: none;
	}
}

@media (max-width: @xf-responsiveNarrow)
{
	.p-header-logo
	{
		max-width: 100px;

		&.p-header-logo--text
		{
			font-size: @xf-fontSizeLarge;
			font-weight: @xf-fontWeightNormal;
			.m-overflowEllipsis();
		}
	}
}
';
	return $__finalCompiled;
}
);