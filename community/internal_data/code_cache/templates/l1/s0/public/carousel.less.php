<?php
// FROM HASH: 5168b749985378a0688a2d3e77b53f7b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.carousel
{
	.m-clearFix();

	margin-bottom: @xf-elementSpacer;

	&.carousel--withFooter
	{
		.lSSlideOuter
		{
			// this is used as float containment, so disable it
			overflow: visible;
		}

		.lSPager
		{
			float: left;
		}
	}
}

.carousel-body
{
	.m-listPlain();

	display: flex;
	align-items: stretch;
	overflow: hidden;

	> li
	{
		width: 100%;
		flex-grow: 1;
		flex-shrink: 0;
		display: flex;
		align-items: stretch;
	}

	// this rule will need to be repeated if we add show3 or further
	&.carousel-body--show2
	{
		> li
		{
			padding-right: @xf-paddingMedium;

			&.active + li,
			&:last-child
			{
				padding-right: 0;
			}
		}
	}

	&.carousel-body--show2 > li
	{
		width: 50%;

		@media (max-width: 700px)
		{
			width: 100%;

			&.active
			{
				padding-right: 0;
			}
		}
	}
}

.carousel-item
{
	.xf-blockBorder();
	border-radius: @xf-blockBorderRadius;
	.xf-contentBase();
	padding: @xf-blockPaddingV @xf-blockPaddingH;
	width: 100%;
	min-width: 0;
}

.carousel-footer
{
	float: right;
	font-size: @xf-fontSizeSmall;
	line-height: 20px; // this is the height of the dots for slide selection
}';
	return $__finalCompiled;
}
);