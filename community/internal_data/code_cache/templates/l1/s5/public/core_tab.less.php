<?php
// FROM HASH: d1b36b88418611dc237bb4a91857b532
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '// ################################## TABS ####################################

.tabs
{
	display: flex;

	&.tabs--wrappable
	{
		flex-wrap: wrap;
	}

	&.tabs--right
	{
		float: right;
		position: relative;
		margin-left: auto;
		align-self: center;
		white-space: nowrap;
	}
}

.tabs-tab
{
	display: inline-block;
	cursor: pointer;
	white-space: nowrap;
	color: inherit;
	font-weight: inherit;
	text-decoration: none;
	.m-transition();

	&:hover
	{
		text-decoration: none;
	}
}

.tabs-extra
{
	position: relative;
	margin-left: auto;
	padding: 0 @xf-blockPaddingH 0 @xf-paddingMedium;
	align-self: center;
	white-space: nowrap;

	&.tabs-extra--minor
	{
		font-size: @xf-fontSizeSmall;
	}

	a
	{
		color: inherit;
		text-decoration: none;
		display: block;
		padding: @xf-paddingMedium;
		margin-right: -@xf-paddingMedium;
	}
}

.tabPanes
{
	.m-listPlain();

	> li
	{
		display: none;

		&.is-active
		{
			display: block;
		}
	}
}

// ################################# OUTER TABS #########################

.tabs--standalone
{
	padding: 0;
	margin-bottom: @xf-elementSpacer;
	font-weight: @xf-fontWeightNormal;
	.xf-blockBorder();
	.xf-standaloneTab();
	.m-tabsTogether(xf-default(@xf-standaloneTab--font-size, @xf-fontSizeNormal));

	&.tabs--standalone--closer
	{
		margin-bottom: @xf-paddingMedium;
	}

	&.tabs--standalone--small
	{
		.m-tabsTogether(@xf-fontSizeSmall);
	}

	&.tabs--standalone--inline
	{
		display: inline-block;
		margin-bottom: 0;
	}

	.tabs-tab
	{
		padding: @xf-blockPaddingV @xf-blockPaddingH max(0px, @xf-blockPaddingV - @xf-borderSizeFeature);
		border-bottom: @xf-borderSizeFeature solid transparent;

		&:hover
		{
			color: @xf-standaloneTabSelected--color;
		}

		&.is-active
		{
			.xf-standaloneTabSelected();
		}
	}

	.hScroller-action
	{
		.m-hScrollerActionColorVariation(
			xf-default(@xf-standaloneTab--background-color, transparent),
			xf-default(@xf-standaloneTab--color, ~""),
			xf-default(@xf-standaloneTabSelected--color, ~"")
		);
	}
}

@media (max-width: @xf-responsiveEdgeSpacerRemoval)
{
	.tabs--standalone
	{
		margin-left: -@xf-pageEdgeSpacer;
		margin-right: -@xf-pageEdgeSpacer;
		border-radius: 0;

		.tabs--standalone:not(.tabs--right)
		{
			border-left: none;
			border-right: none;
		}

		.tabs--right&
		{
			margin: 0;
		}
	}
}';
	return $__finalCompiled;
}
);