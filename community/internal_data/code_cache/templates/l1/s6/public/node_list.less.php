<?php
// FROM HASH: a034a20c0ed54f3973dcc7a7131c36bb
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '@_nodeList-statsCellBreakpoint: 1000px;

@media (min-width: @xf-responsiveMedium) and (max-width: 1300px)
{
	.block.block--category
	{
		.block-body
		{
			display: flex;
			flex-wrap: wrap;
			align-items: stretch;
		}
		
		.node
		{
			flex: 0 0 50%;
			max-width: 50%;
			
			&:nth-child(2n+2)
			{
				padding-left: @xf-paddingLarge;
			}
		}
	}
	
	.template-forum_view,
	.template-category_view
	{
		.p-body-pageContent
		{
			.block-body
			{
				display: flex;
				flex-wrap: wrap;
				align-items: stretch;
				
				.node
				{
					flex: 0 0 50%;
					max-width: 50%;
					
					&:nth-child(2n+2)
					{
						padding-left: @xf-paddingLarge;
					}
				}
			}
		}
	}
}
@media (min-width: 1300px)
{
	.block.block--category
	{
		.block-body {
			display: flex;
			flex-wrap: wrap;
			align-items: stretch;
		}

		.node
		{
			flex: 0 0 33.333%;
			max-width: 33.333%;
			
			padding-left: @xf-paddingMedium;
			padding-right: @xf-paddingMedium;

			&:nth-child(3n+1)
			{
				padding-left: 0;
			}

			&:nth-child(3n+3)
			{
				padding-right: 0;
			}
		}
	}
	
	.template-forum_view,
	.template-category_view
	{
		.p-body-pageContent
		{
			.block-body
			{
				display: flex;
				flex-wrap: wrap;
				align-items: stretch;

				.node
				{
					flex: 0 0 33.333%;
					max-width: 33.333%;
					
					padding-left: @xf-paddingMedium;
					padding-right: @xf-paddingMedium;

					&:nth-child(3n+1)
					{
						padding-left: 0;
					}

					&:nth-child(3n+3)
					{
						padding-right: 0;
					}
				}
			}
		}
	}
}

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
	padding-top: @xf-paddingMedium;
	padding-bottom: @xf-paddingMedium;
}

.node-body
{
	position: relative;
	display: flex;
	flex-direction: column;
	width: 100%;
	min-height: 280px;
	background: @xf-contentBg;
	background-color: @xf-nodeIconReadColor;
	background-repeat: no-repeat;
	background-position: center;
	background-size: cover;
	border-radius: @xf-blockBorderRadius;
	overflow: hidden;
	box-shadow: 0px 0px 20px 0px rgba(27, 26, 35, .3);
	
	&::before
	{
		content: \'\';
		position: absolute;
		top: 8px;
		right: 8px;
		display: block;
		clip-path: polygon(85% 15%, 15% 15%, 0 0, 100% 0, 100% 100%, 85% 85%);
		background-color: @xf-linkColor;
		opacity: .1;
		width: 25px;
		height: 25px;
		pointer-events: none;
	}
	
	&::after
	{
		content: \'\';
		position: absolute;
		top: 7px;
		right: 7px;
		bottom: 7px;
		left: 7px;
		display: block;
		pointer-events: none;
		opacity: .15;
		border: @xf-borderSize solid @xf-linkColor;
	}
}

.node-overlay
{
	position: absolute;
	top: 15%;
	left: -1px;
	z-index: 1;
	width: calc(~\'100% + 2px\');
	height: 100%;
	background: linear-gradient(to bottom, rgba(40, 40, 40, 0) 0%, rgba(15, 15, 15, 0.91) 89%, rgba(15, 15, 15, 0.93) 93%) !important;
	opacity: .93;
	pointer-events: none;
}

.node-icon
{
	display: none;
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

.node-main
{
	position: relative;
	display: table-cell;
	vertical-align: middle;
	padding: @xf-paddingLargest;
	z-index: 2;
}

.node-stats
{
	position: absolute;
	top: 15px;
	right: 20px;
	display: flex;
	flex-direction: column;
	min-width: 30px;
	color: @xf-linkColor;
	font-weight: 700;
	text-align: center;

	> dl.pairs.pairs--rows
	{
		width: 100%;
		margin: 0;

		&:last-child
		{
			margin-top: @xf-paddingMedium;
		}
		
		> dt,
		> dd
		{
			display: block;
			background-color: fade(@xf-paletteNeutral1, 60%);
			color: @xf-linkColor;
			padding: @xf-paddingMedium 0;
		}
		
		> dt
		{
			padding-bottom: 0;
			border-top-left-radius: 20px;
			border-top-right-radius: 20px;
		}
		
		> dd
		{
			font-size: 80%;
			border-bottom-left-radius: 20px;
			border-bottom-right-radius: 20px;
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
	position: relative;
	display: block;
	padding: 0 @xf-paddingLargest;

	font-size: @xf-fontSizeSmall;
	margin-top: auto;
	z-index: 2;
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

li.node-extra-icon
{
	display: none;
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
		padding: 0 @xf-paddingLargest;
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