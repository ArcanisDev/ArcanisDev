<?php
// FROM HASH: 197c66ae242eac8e046103369bbe4d32
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '@_nodeList-statsCellBreakpoint: 1000px;

.block.block--category
{
	.block-container
	{
		background: none;
		border: none;
		box-shadow: none;
	}
	
	.block-header
	{
		.block-desc
		{
			color: fade(@xf-textColorEmphasized, 80%);
		}
	}
}

.node
{
	position: relative;
	
	&::before
	{
		content: \'\';
		display: block;
		position: absolute;
		top: 8px;
		right: 8px;
		clip-path: polygon(85% 15%, 15% 15%, 0 0, 100% 0, 100% 100%, 85% 85%);
		background-color: currentColor;
		opacity: .1;
		width: 25px;
		height: 25px;
		pointer-events: none;
	}
	
	& + .node
	{
		margin-top: @xf-paddingLarge;
	}
}

.node-body
{
	display: table;
	table-layout: fixed;
	width: 100%;
	background: @xf-contentBg;
	padding-left: @xf-paddingLarge;
	border-radius: @xf-blockBorderRadius;
	box-shadow: 0px 0px 20px 0px rgba(27, 26, 35, .3);
}

.node-icon
{
	display: table-cell;
	vertical-align: middle;
	text-align: center;
	width: 80px;
	padding: @xf-paddingLarge 0 @xf-paddingLarge @xf-paddingLarge;

	i
	{
		display: block;
		width: 70px;
		height: 70px;
		line-height: 70px;
		background: fade(@xf-nodeIconReadColor, 15%);
		color: @xf-nodeIconReadColor;
		font-size: 28px;
		border-radius: 50%;
		
		.node--unread &
		{
			background: fade(@xf-nodeIconUnreadColor, 80%);
			color: @xf-textColorEmphasized;
		}

		&:before
		{
			.m-faBase();
			font-weight: 700;
		}

		.node--category &:before
		{
			.m-faContent(@fa-var-comments);
		}
		
		.node--forum &:before
		{
			.m-faContent(@fa-var-' . $__templater->func('property', array('dt_node_icon', ), true) . ');
		}

		.node--search &::before
		{
			.m-faContent(@fa-var-search);
		}

		.node--page &:before
		{
			.m-faContent(@fa-var-' . $__templater->func('property', array('dt_page_node_icon', ), true) . ', .86em);
		}

		.node--link &:before
		{
			.m-faContent(@fa-var-' . $__templater->func('property', array('dt_link_node_icon', ), true) . ', .93em);
		}
	}
}

.node-img
{
	display: table-cell;
	vertical-align: middle;
	width: 80px;
	height: 70px;
	padding: @xf-paddingLargest 0 @xf-paddingLargest @xf-paddingLarge;
	
	i {
		display: block;
		width: 100%;
		height: 70px;
		background-color: @xf-nodeIconReadColor;
		background-repeat: no-repeat;
		background-position: center;
		background-size: cover;
		border-radius: 50%;
	}
}

.node-main
{
	display: table-cell;
	vertical-align: middle;
	padding: @xf-paddingLarge @xf-paddingLargest @xf-paddingLarge @xf-elementSpacer;
}

.node-info
{
	display: table-cell;
	width: 300px;
	padding: @xf-paddingLarge;
}

.node-stats
{
	padding: @xf-paddingLarge 0;
	overflow: hidden;

	> dl.pairs.pairs--rows
	{
		width: 50%;
		float: left;
		margin: 0;
		padding: 0 @xf-paddingMedium/2;

		&:first-child
		{
			padding-left: 0;
		}

		&:last-child
		{
			padding-right: 0;
		}
		
		> dt
		{
			color: @xf-textColor;
			font-size: 90%;
			font-weight: 500;
			text-transform: uppercase;
		}
		
		> dd
		{
			color: @xf-linkColor;
			font-size: @xf-fontSizeLargest;
			font-weight: 500;
		}
	}

	&.node-stats--single
	{
		width: 100px;

		> dl.pairs.pairs--rows
		{
			width: 100%;
			float: none;
		}
	}

	&.node-stats--triple
	{
		width: 240px;

		> dl.pairs.pairs--rows
		{
			width: 33.333%;
		}
	}

	@media (max-width: @_nodeList-statsCellBreakpoint)
	{
		display: none;
	}
}

@_nodeExtra-avatarSize: 19px;

.node-extra
{
	display: block;
	padding: @xf-paddingLarge 0;

	font-size: @xf-fontSizeSmall;
	border-top: @xf-borderSize solid @xf-borderColor;
}

.node-extra-row
{
	.m-overflowEllipsis();
	color: @xf-textColorMuted;
	
	&:last-child
	{
		padding-top: @xf-paddingMedium;
	}
}

.node-extra-icon
{
	padding-right: @xf-paddingLarge;

	.avatar
	{
		.m-avatarSize(@_nodeExtra-avatarSize);
	}
}

.node-title
{
	margin: 0;
	padding: 0;
	font-size: @xf-fontSizeLarger;
	font-weight: 500;

	.node--unread &
	{
		font-weight: @xf-fontWeightHeavy;
	}
}

.node-description
{
	font-size: @xf-fontSizeSmall;
	color: @xf-textColorDimmed;
	padding-top: @xf-paddingSmall;

	&.node-description--tooltip
	{
		.has-js:not(.has-touchevents) &
		{
			display: none;
		}
	}
}

.node-meta
{
	font-size: @xf-fontSizeSmall;
}

.node-statsMeta
{
	display: none;

	@media (max-width: @_nodeList-statsCellBreakpoint)
	{
		display: inline;
	}
}

.node-bonus
{
	font-size: @xf-fontSizeSmall;
	color: @xf-textColorMuted;
	text-align: right;
}

.node-subNodesFlat
{
	font-size: @xf-fontSizeSmall;
	margin-top: .3em;

	.node-subNodesLabel
	{
		display: none;
	}
}

.node-subNodeMenu
{
	display: inline;

	.menuTrigger
	{
		color: @xf-textColorMuted;
	}
}

@media (max-width: @xf-responsiveWide)
{
	.node-extra
	{
		border-top: none;
	}
}

@media (max-width: @xf-responsiveMedium)
{
	.node-main
	{
		display: block;
		width: auto;

		.node--link &,
		.node--page &
		{
			// #168882: we only display the title for these types
			// so keep these as table-cells for vertical alignment
			display: table-cell;
		}
	}

	.node-info
	{
		display: block;
		width: auto;
		// this gives an equivalent of medium padding between main and extra, with main still having large
		margin-top: (@xf-paddingMedium - @xf-paddingLarge);
		padding-top: 0;
		padding-left: 20px;
	}
	
	.node-extra
	{
		padding: @xf-paddingMedium 0;
	}

	.node-extra-row
	{
		display: inline-block;
		vertical-align: bottom;
		max-width: 100%;
	}

	.node-extra-icon
	{
		display: none;
	}

	.node-description,
	.node-stats,
	.node-subNodesFlat
	{
		display: none;
	}
}

@media (max-width: @xf-responsiveNarrow)
{
	.node-subNodeMenu
	{
		display: none;
	}
}

.subNodeLink
{
	&:before,
	.subNodeLink-icon
	{
		display: inline-block;
		width: 1.28571429em;
		margin-right: .3em;
		text-decoration: none;
		text-align: center;

		color: rgba(255, 255, 255, 0.45);
	}

	&:before
	{
		.m-faBase();
	}

	&:hover:before
	{
		&:before,
		.subNodeLink-icon
		{
			text-decoration: none;
		}
	}

	&.subNodeLink--unread
	{
		font-weight: @xf-fontWeightHeavy;

		&:before,
		.subNodeLink-icon
		{
			color: @xf-nodeIconUnreadColor;
		}
	}

	&.subNodeLink--category:before
	{
		.m-faContent(@fa-var-comments);
	}

	&.subNodeLink--page:before
	{
		.m-faContent(@fa-var-file-alt);
	}

	&.subNodeLink--link:before
	{
		.m-faContent(@fa-var-link);
	}

	&.subNodeLink--search::before
	{
		.m-faContent(@fa-var-search);
	}
}

.node-subNodeFlatList
{
	.m-listPlain();
	.m-clearFix();

	> li
	{
		display: inline-block;
		margin-right: 1em;

		&:last-child
		{
			margin-right: 0;
		}
	}

	ol,
	ul,
	.node-subNodes
	{
		display: none;
	}
}

.subNodeMenu
{
	.m-listPlain();

	ol,
	ul
	{
		.m-listPlain();
	}

	.subNodeLink
	{
		display: block;
		padding: @xf-blockPaddingV @xf-blockPaddingH;
		color: @xf-menuLinkRow--color;
		text-decoration: none;
		cursor: pointer;

		&:hover
		{
			.xf-menuLinkRowSelected();
		}
	}

	li li .subNodeLink { padding-left: 1.5em; }
	li li li .subNodeLink { padding-left: 3em; }
	li li li li .subNodeLink { padding-left: 4.5em; }
	li li li li li .subNodeLink { padding-left: 6em; }
	li li li li li li .subNodeLink { padding-left: 7.5em; }
}';
	return $__finalCompiled;
}
);