<?php
// FROM HASH: c989f5891a4bee3899495c3a53eaf9bf
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
	height: 100%;
	background: @xf-contentBg;
	border-radius: @xf-blockBorderRadius;
	overflow: hidden;
	box-shadow: 0px 0px 20px 0px rgba(27, 26, 35, .3);
}

.node-icon
{
	position: relative;
	text-align: center;
	width: 100%;
	height: 200px;
	mask-image: url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'250\' height=\'238\' viewBox=\'0 0 250 238\'%3E%3Cdefs/%3E%3Cpath fill=\'%23000\' fill-rule=\'evenodd\' d=\'M0 0h250v223l-15 15H0z\'/%3E%3C/svg%3E");
	mask-position: bottom;
	mask-repeat: no-repeat;
	mask-size: cover;

	i
	{
		display: block;
		width: 100%;
		height: 200px;
		line-height: 200px;
		background: fade(@xf-nodeIconReadColor, 15%);
		color: @xf-nodeIconReadColor;
		font-size: 48px;
		
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
	width: 100%;
	height: 200px;
	filter: drop-shadow(@xf-nodeIconReadColor 0px 3px 0px);
	padding-bottom: 3px;
	
	&-inner
	{
		position: relative;
		display: block;
		width: 100%;
		height: 100%;
		mask-image: url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'250\' height=\'238\' viewBox=\'0 0 250 238\'%3E%3Cdefs/%3E%3Cpath fill=\'%23000\' fill-rule=\'evenodd\' d=\'M0 0h250v223l-15 15H0z\'/%3E%3C/svg%3E");
		mask-position: bottom;
		mask-repeat: no-repeat;
		mask-size: cover;
	}
	
	i
	{
		display: block;
		width: 100%;
		height: 200px;
		background-color: @xf-nodeIconReadColor;
		background-repeat: no-repeat;
		background-position: center;
		background-size: cover;
	}
}

.node-main
{
	padding: @xf-paddingLargest @xf-paddingLargest @xf-paddingLarge @xf-paddingLargest;
}

.node-stats
{
	position: absolute;
	top: 6px;
	right: 10px;
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
	display: block;
	padding: @xf-paddingLargest;

	font-size: @xf-fontSizeSmall;
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
		padding: 0 @xf-paddingLargest @xf-paddingLarge;
	}

	.node-extra-row
	{
		display: inline-block;
		vertical-align: middle;
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