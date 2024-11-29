<?php
// FROM HASH: e220bafedd860b796aedb48589db80bb
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '// ###################################### MENUS ######################

@_menu-arrowSize: 8px;
@_menu-edgePadding: @xf-pageEdgeSpacer;
@_menu-paddingV: @xf-paddingMedium;
@_menu-closePaddingH: @xf-paddingLarge;
@_menu-paddingH: @xf-paddingLargest;

.menuTrigger
{
	cursor: pointer;

	&:after
	{
		.m-menuGadget();
	}
}

.menuOutsideClicker
{
	position: fixed;
	display: none;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	z-index: 2; // above non set stuff but below anything intentionally set

	&.is-active
	{
		display: block;
		-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
	}
}

.menu
{
	.m-transitionCubic();

	position: absolute;
	z-index: @zIndex-2;
	margin: @_menu-arrowSize 0 0;
	min-width: 240px;
	max-width: 320px;
	border-radius: @xf-menuBorderRadius;

	.m-dropShadow(0, 0, 30px, 0, .12);

	&.menu--structural
	{
		margin-top: 0;

		// when menus nudge up against structure, the joined corner should not be radiused
		&.menu--left
		{
			border-top-left-radius: 0;
		}
		&.menu--right
		{
			border-top-right-radius: 0;
		}
	}

	&.menu--superWide
	{
		width: 75%;
		max-width: calc(~\'100% - @{xf-pageEdgeSpacer}\');
	}

	&.menu--veryWide
	{
		width: 500px;
		max-width: calc(~\'100% - @{xf-pageEdgeSpacer}\');
	}

	&.menu--wide
	{
		width: 350px;
		max-width: calc(~\'100% - @{xf-pageEdgeSpacer}\');
	}

	&.menu--medium
	{
		width: 300px;
		max-width: calc(~\'100% - @{xf-pageEdgeSpacer}\');
	}

	&.menu--potentialFixed
	{
		z-index: @zIndex-4;
	}
}

.menu-arrow
{
	display: none;
	position: absolute;
	width: 0;
	height: 0;
	border: 0 solid transparent;

	top: -@_menu-arrowSize;
	-ltr-rtl-left: 50%;
	-ltr-rtl-margin-left: -@_menu-arrowSize;
	.m-triangleUp(@xf-menuFeatureBorderColor, @_menu-arrowSize);

	.menu--structural &
	{
		top: -@_menu-arrowSize;
	}

	.menu--up &
	{
		display: none;
	}
}

.menu-content
{
	margin: 0;
	padding: 0;
	list-style: none;
	text-align: left;
	.xf-menu();
	border-radius: @xf-menuBorderRadius;

	// when menus nudge up against structure, the joined corner should not be radiused
	.menu--structural.menu--left &
	{
		border-top-left-radius: 0;
	}
	.menu--structural.menu--right &
	{
		border-top-right-radius: 0;
	}

	// potentially fixed menus
	.menu--potentialFixed &
	{
		overflow: auto;
		max-height: 450px;
		max-height: 80vh;
	}

	> :last-child
	{
		border-bottom-left-radius: @xf-menuBorderRadius;
		border-bottom-right-radius: @xf-menuBorderRadius;
	}
}

.menu--pageJump
{
	width: auto;
	min-width: 0;
}

.menu-header
{
	position: relative;
	padding: @xf-blockPaddingV @_menu-paddingH;
	margin: 0;
	font-weight: @xf-fontWeightNormal;
	text-decoration: none;
	.xf-menuHeader();

	.m-clearFix();
	.m-hiddenLinks();

	&.menu-header--small
	{
		font-size: @xf-fontSizeNormal;
	}

	&.menu-header--sticky
	{
		position: sticky;
		top: 0;
	}

	.menu-desc
	{
		color: fade(@xf-menuHeader--color, 70);
		.m-textColoredLinks();
	}
	
	&::after
	{
		content: \'\';
		height: 3px;
		width: 35px;
		background-color: currentColor;
		display: block;
		clip-path: polygon(0 0,calc(100% - 5px) 0,100% 100%,100% 100%,0 100%);
		margin-top: @xf-paddingMedium;
	}
}

.menu-desc
{
	display: block;
	font-size: @xf-fontSizeSmaller;
	font-weight: @xf-fontWeightNormal;
}

.menu-tabHeader
{
	padding: 0;
	margin: 0;
	font-weight: @xf-fontWeightNormal;
	text-decoration: none;
	.xf-menuTabHeader();
	.m-tabsTogether(xf-default(@xf-menuTabHeader--font-size, @xf-fontSizeNormal));

	.tabs-tab
	{
		position: relative;
		padding: @xf-blockPaddingV @_menu-paddingH (@xf-blockPaddingV + 5);
		
		&::after
		{
			content: \'\';
			width: auto;
			height: 3px;
			position: absolute;
			right: 4px;
			bottom: 0;
			left: 4px;
			background-color: @xf-menuTabHeaderSelected--border-color;
			pointer-events: none;
			transform: translate3d(0,0,0) scaleY(1);
			transform-origin: center bottom;
			will-change: transform;
			opacity: 0;
			border-radius: 500px 500px 0 0;
		}

		&:hover
		{
			color: @xf-blockMinorTabHeaderSelected--color;
		}

		&.is-active
		{
			.xf-menuTabHeaderSelected();
			
			&::after
			{
				opacity: 1;
			}
		}
	}

	.tabs-text
	{
		padding: @xf-blockPaddingV @_menu-paddingH max(0px, @xf-blockPaddingV - @xf-borderSizeFeature);
		border-bottom: @xf-borderSizeFeature solid transparent;
	}

	.hScroller-action
	{
		.m-hScrollerActionColorVariation(
			xf-default(@xf-menuTabHeader--background-color, transparent),
			xf-default(@xf-menuTabHeader--color, ~""),
			xf-default(@xf-blockMinorTabHeaderSelected--color, ~"")
		);
	}
}

.menu-scroller
{
	overflow: auto;
	max-height: 300px;
	max-height: 60vh;
	-webkit-overflow-scrolling: touch;

	.menu-row + &
	{
		border-top: @xf-borderSize solid @xf-borderColorLight;
	}
}

.menu-row
{
	margin: 0;
	padding: @_menu-paddingV @_menu-paddingH;
	border-radius: @xf-menuBorderRadius;
	.m-clearFix();

	&.menu-row--alt
	{
		.xf-contentAltBase();
	}

	&.menu-row--highlighted
	{
		background: fade(@xf-contentAltBg, 50%);
		color: @xf-contentAltBase--color;
	}

	&.menu-row--close
	{
		padding-left: @_menu-closePaddingH;
		padding-right: @_menu-closePaddingH;
	}

	&.menu-row--separated
	{
		+ .menu-row
		{
			border-top: @xf-borderSize solid @xf-borderColorLight;
		}
	}

	&.menu-row--clickable:hover
	{
		background: @xf-contentAltBg;
	}

	&:empty
	{
		padding: 0;
	}
}

.menu-linkRow
{
	display: block;
	padding: @_menu-paddingV @_menu-paddingH @_menu-paddingV (@_menu-paddingH) - (@xf-borderSizeFeature);
	.xf-menuLinkRow();

	&.menu-linkRow--alt
	{
		.xf-contentAltBase();
	}

	&.is-selected,
	&:hover,
	&:focus
	{
		.xf-menuLinkRowSelected();

		&:focus
		{
			outline: 0;
		}

		&.is-selected
		{
			border-left-color: @xf-borderColorFeature;
		}
	}

	&.is-hidden
	{
		display: none;
	}

	i[aria-hidden=true]
	{
		font-size: @xf-fontSizeSmall;
		display: inline-block;
		width: 23px; // about 1.75em at this font size

		& ~ .menu-linkRow-hint
		{
			padding-left: 23px;
		}
	}

	&:hover i[aria-hidden=true]:after
	{
		color: @xf-linkHoverColor;
	}
}

.menu-linkRow-hint
{
	font-style: inherit;
	font-size: @xf-fontSizeSmallest;
	color: @xf-textColorMuted;
	display: block;
}

.menu-separator
{
	margin: 0 (@_menu-paddingH) / 2;
	padding: 0;
	border: none;
	border-top: @xf-borderSize solid @xf-borderColorLight;

	&.menu-separator--hard
	{
		margin: 0;
	}

	& + .menu-separator,
	&:last-child
	{
		display: none;
	}
}

.menu-footer
{
	padding: @xf-blockPaddingV @_menu-paddingH;
	.xf-menuFooter();
	.m-clearFix();

	&.menu-footer--close
	{
		padding-left: @_menu-closePaddingH;
		padding-right: @_menu-closePaddingH;
	}

	&:not(.menu-footer--split)
	{
		.menu-footer-counter
		{
			float: left;
		}

		.menu-footer-controls
		{
			float: right;
		}
	}

	&.menu-footer--split
	{
		display: flex;
		align-items: center;

		.menu-footer-main,
		.menu-footer-counter
		{
			flex-grow: 1;
		}

		.menu-footer-select:not(:last-child)
		{
			margin: 0 1em;
		}

		.menu-footer-opposite,
		.menu-footer-controls
		{
			margin-left: auto;
		}
	}
}

.menu .block
{
	margin: 0;

	.block-container
	{
		color: inherit;
		background: none;
		border: none;
		border-radius: 0;

		> .block-header:first-child
		{
			display: none;
		}
	}

	.block-body
	{
		border-radius: 0;
	}
}';
	return $__finalCompiled;
}
);