<?php
// FROM HASH: c52d78fbb12d28d202bfee9ea253a44c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= 'a:link
{
	-webkit-tap-highlight-color: fade(@xf-paletteColor1, 30%);
}

::selection { background-color: fade(@xf-paletteColor1, 80%);color: #fff; }
::-moz-selection { background-color: fade(@xf-paletteColor1, 80%);color: #fff; }

.fr-popup .fr-color-set > span:hover
{
	transform: scale(1.2,1.2);
}

.link.link--external
{
	color: @xf-bbCodeBlockTitle--color;
	
	&:hover
	{
		color: @xf-paletteColor1;
	}
}

.editorSmilies .smilie
{
	opacity: 0.5;
	.m-transition(all, 0.2s);
	
	&:hover
	{
		opacity: 1.0;
		transform: scale(1.3);
	}
}

.p-breadcrumbs > li:last-child::after
{
	display: none;
}

.animate-pulse
{
    -webkit-animation: pulse 2s infinite linear;
    animation: pulse 2s infinite linear;
}

@keyframes pulse
{
  0% {transform: scale(1);}
  15% {transform: scale(1.3);}
  30% {transform: scale(1);}
  45% {transform: scale(1.3);}
  60% {transform: scale(1);} 
}

.js-bookmarksMenuBody .contentRow-title
{
	font-size: @xf-fontSizeNormal;
}

.p-breadcrumbs--container,
.p-breadcrumbs.p-breadcrumbs--bottom
{
	
}

.p-breadcrumbs--container
{
	margin-bottom: @xf-elementSpacer;
	
	.p-breadcrumbs
	{
		margin-bottom: 0;
	}
}

.block.block--treeEntryChooser
{
	.block-container
	{
		margin: @xf-paddingLarge @xf-paddingLargest;
	}
}

.block.block--category
{
	.block-header a
	{
		.xf-dt_category_header();
	}
}

.p-body-sidebar
{
	.xf-dt_sidebar_styling();
	
	.block-container
	{
		.xf-dt_widget_wrapper();
	}
	.block-minorHeader
	{
		.xf-dt_widget_header();
	}
}

.p-footer-copyright
{
	.fa-heart
	{
		color: red;
	}
}

.select2-results__options li
{
	.xf-menuLinkRow();
}

.select2-container .select2-results__option.select2-results__option--highlighted
{
	.xf-menuLinkRowSelected();
}

// ################ Templates Enhancemnts ################

.badge,
.badgeContainer:after
{
	min-width: 12px;
	height: 16px;
	line-height: 14px;
	text-align: center;
	white-space: nowrap;
	word-wrap: normal;
	padding: 0 2px;
	margin: -2px 0;
}

@keyframes fa-bell-ring {
 0% {
  transform:rotate(-15deg)
 }
 2% {
  transform:rotate(15deg)
 }
 4% {
  transform:rotate(-18deg)
 }
 6% {
  transform:rotate(18deg)
 }
 8% {
  transform:rotate(-22deg)
 }
 10% {
  transform:rotate(22deg)
 }
 12% {
  transform:rotate(-18deg)
 }
 14% {
  transform:rotate(18deg)
 }
 16% {
  transform:rotate(-12deg)
 }
 18% {
  transform:rotate(12deg)
 }
 20%,
 100% {
  transform:rotate(0deg)
 }
}

.p-navgroup-link--alerts.badgeContainer--highlighted i::after
{
	animation: fa-bell-ring 5s ease 10s 6;
	transform-origin: 50% 0;
}

.blockLink
{
	&:hover
	{
		.xf-contentAltBase();
	}
}

.filterBar-menuTrigger
{
	color: @xf-textColorEmphasized;
	
	&:hover
	{
		color: inherit;
	}
}

.label
{
	&.label--primary
	{
		.m-labelVariation(@xf-textColorEmphasized, @xf-paletteColor1, @xf-paletteColor1);
	}
}

.tooltip-content
{
	.tooltip--preview &
	{
		.m-dropShadow(0, 0, 30px, 0, .12);
	}
	
	.tooltip--bookmark &,
	.tooltip--member &,
	.tooltip--share &
	{
		.m-dropShadow(0, 0, 30px, 0, .12);
	}
}

.tabs--standalone
{
	.tabs-tab
	{
		position: relative;
		padding: @xf-blockPaddingV @xf-blockPaddingH (@xf-blockPaddingV + 4);
		border-bottom: none;
		
		&::after
		{
			content: \'\';
			width: auto;
			height: 4px;
			position: absolute;
			right: 4px;
			bottom: 0;
			left: 4px;
			background-color: currentColor;
			pointer-events: none;
			transform: translate3d(0,0,0) scaleY(1);
			transform-origin: center bottom;
			will-change: transform;
			opacity: 0;
			border-radius: 500px 500px 0 0;
		}
		
		&.is-active
		{
			&::after
			{
				opacity: 1;
			}
		}
	}
}

.block
{
	&.block--treeEntryChooser
	{
		.block-desc
		{
			color: fade(@xf-majorHeadingTextColor, 60%);
		}
	}
}

.block-header
{
	.block-desc
	{
		';
	if ($__templater->func('property', array('dt_category_header', ), false)) {
		$__finalCompiled .= '
			color: fade(@xf-dt_category_header--color, 70);
		';
	} else {
		$__finalCompiled .= '
			color: fade(@xf-majorHeadingTextColor, 60%);
		';
	}
	$__finalCompiled .= '
	}
}

.block-tabHeader
{
	.tabs-tab
	{
		position: relative;
		padding: @xf-paddingLargest @xf-blockPaddingH (@xf-paddingLargest + 4);
		border-bottom: none;
		
		&::after
		{
			content: \'\';
			width: auto;
			height: 4px;
			position: absolute;
			right: 4px;
			bottom: 0;
			left: 4px;
			background-color: currentColor;
			pointer-events: none;
			transform: translate3d(0,0,0) scaleY(1);
			transform-origin: center bottom;
			will-change: transform;
			opacity: 0;
			border-radius: 500px 500px 0 0;
		}
		
		&.is-active
		{
			&::after
			{
				opacity: 1;
			}
		}
		
		&:hover
		{
			background: @xf-blockTabHeaderBg;
			
			&::after
			{
				opacity: 1;
			}
		}
	}
}

.block-row
{
	&.block-row--clickable:hover
	{
		.xf-contentAltBase();
	}
}

.inputGroup
{
	&.inputGroup--joined
	{
		.input
		{
			&:first-child
			{
				border-top-left-radius: @xf-input--border-radius;
				border-bottom-left-radius: @xf-input--border-radius;
			}
			
			&:last-child
			{
				border-top-right-radius: @xf-input--border-radius;
				border-bottom-right-radius: @xf-input--border-radius;
			}
		}
		
		.inputGroup-text
		{
			&:first-child
			{
				border-top-left-radius: @xf-input--border-radius;
				border-bottom-left-radius: @xf-input--border-radius;
			}
			
			&:last-child
			{
				border-top-right-radius: @xf-input--border-radius;
				border-bottom-right-radius: @xf-input--border-radius;
			}
		}
	}
}

.inputNumber-button
{
	.inputGroup.inputGroup--joined &
	{
		&:hover,
		&:active,
		&:focus
		{
			.xf-contentHighlightBase();
		}
	}
}

.notice
{
	&.notice--primary
	{
		border-color: @xf-borderColorHighlight;
	}
	
	&.notice--accent
	{
		border-color: @xf-borderColorAccentContent;
	}
}

.bbWrapper .bbCodeBlock--unfurl
{
	.xf-contentAltBase();
}

.overlay-container
{
	transform: translateY(-10px);
	transition: cubic-bezier(0.4, 0, 0.2, 1) 0.26s transform, cubic-bezier(0.4, 0, 0.2, 1) 0.26s opacity;
	
	&.is-active
	{
		transform: translateY(0);
	}
}

.overlay
{
	border: none;
	.m-dropShadow(0, 5px, 15px, 0, .2);
}

.overlay-titleCloser
{
	color: @xf-overlayHeader--color;
	
	&:hover
	{
		color: inherit;
	}
}

.overlay-content
{
	.listColumns > li
	{
		padding: 0 @xf-paddingLarge;
	}
}

.structItemContainer .structItem
{
	background: @xf-contentAltBg;
	border-top: none;
	border-radius: @xf-blockBorderRadius;
	margin: @xf-paddingMedium 0;
}

.structItem-cell .structItem-title
{
	font-size: @xf-fontSizeNormal;
}

.fr-box.bbWrapper.fr-basic
{
	border-color: @xf-borderColor;
	
	&.is-focused,
	&.is-preview,
	&.is-preview .fr-toolbar .fr-btn-grp.rte-tab--preview
	{
		border-color: @xf-paletteAccent1;
	}
}

.menu .alert.is-unread
{
	.xf-contentAltBase();
}

.message-content .messageNotice
{
	&::before
	{
		color: fade(@xf-contentHighlightBase--color, 65%);
	}
	
	&.messageNotice--highlighted
	{
		a,
		&::before
		{
			color: fade(@xf-contentHighlightBase--color, 65%);
		}

	}
}

.p-body .pollResult.pollResult--showVoters:hover
{
	.xf-contentAltBase();
}

// ################ Theme Enhancements ################

.p-nav
{
	.p-header-logo
	{
		margin-right: 35px;
		margin-left: @xf-paddingLarge;
	}
}
.p-nav-list .p-navEl
{
	position: relative;
	
	&::before
	{
		content: \'\';
		display: block;
		position: absolute;
		background-color: @xf-publicNavSelected--color;
		bottom: 0;
		left: 4px;
		right: 4px;
		height: 4px;
		width: auto;
		border-radius: 500px 500px 0 0;
		opacity: 0;
		.m-transition();
		transform: translate3d(0, 0, 0) scaleY(0);
		will-change: transform, opacity;
		transform-origin: center bottom;
		pointer-events: none;
	}
	
	&:hover,
	&.is-selected
	{
		&::before
		{
			opacity: 1;
			transform: translate3d(0, 0, 0) scaleY(1);
		}
	}
}

.menu-linkRow
{
	position: relative;
	
	&::before
	{
		content: \'\';
		display: block;
		height: 0;
		width: 3px;
		transition: inherit;
		position: absolute;
		left: -10px;
		bottom: 0;
		border-radius: 0 500px 500px 0;
		.m-transition(height);
	}
}

.block-container
{
	&--none
	{
		box-shadow: none;
	}
}

.avatar:not(.avatar--default--dynamic)
{
	position: relative;
	overflow: initial;
	margin: @xf-paddingSmall;

	img
	{
		position: relative;
		box-shadow: 0 0 0 3px rgb(37, 40, 54);
		.m-transition();
		z-index: 2;
	}

	&:hover
	{
		img
		{
			box-shadow: 0 0 0 0 rgb(37, 40, 54);
		}
	}

	&::after
	{
		content: \'\';
		display: block;
		width: calc(~\'100% + 10px\');
		height: calc(~\'100% + 10px\');
		background: linear-gradient(45deg,@xf-paletteColor1,@xf-paletteAccent1);
		position: absolute;
		top: -5px;
		border-radius: 500px;
		z-index: 1;
		left: -5px;
	}
}

.avatar.avatar--xs
{
	&::after
	{
		display: none;
	}
}

.menu-linkRow:hover
{
	&::before
	{
		height: 100%;
		background-color: @xf-menuLinkRowSelected--color;
	}
}

.button
{
	margin: @xf-paddingMedium;
	
	&::before
	{
		content: \'\';
		display: block;
		width: 15px;
		height: 15px;
		background-color: rgba(0, 0, 0, 0.15);
		position: absolute;
		bottom: 2px;
		right: 2px;
		pointer-events: none;
		transform: translate3d(0, 0, 0) scale(1);
		transform-origin: right bottom;
		transition: transform .2s ease-in-out, opacity .2s ease-in-out;
		clip-path: polygon(100% 0, 100% 100%, 0% 100%);
	}
	
	&::after
	{
		content: \'\';
		display: block;
		top: -4px;
		right: -4px;
		bottom: -4px;
		left: -4px;
		pointer-events: none;
		border: 1px solid @xf-buttonTextColor;
		position: absolute;
		opacity: .15;
		border-radius: @xf-buttonBase--border-radius;
		transition: clip-path .2s ease-in-out, transform .2s ease-in-out, opacity .2s ease-in-out, -webkit-clip-path .2s ease-in-out;
		transform-origin: center;
		transform: translate3d(0, 0, 0);
	}
	
	&:hover
	{
		&::before
		{
			transform: translate3d(0, 0, 0) scale(1.5);
		}
		
		&::after
		{
			opacity: .25;
			clip-path: polygon(100% 0, 100% calc(100% - 25px), calc(100% - 25px) 100%, 0 100%, 0 0);
		}
	}
}

.button.button--link, a.button.button--link
{
	margin: 0;
	
	&::after
	{
		display: none;
	}
}

.p-body-sidebar
{
	.block-minorHeader
	{
		&::before
		{
			content: \'\';
			height: 5px;
			width: 55px;
			background-color: currentColor;
			display: inline-block;
			position: absolute;
			bottom: 0;
			clip-path: polygon(0 0,calc(100% - 5px) 0,100% 100%,100% 100%,0 100%);
			right: 0;
			transform: scaleX(-1);
			opacity: .15;
		}
	}
	
	.block-body
	{
		padding: @xf-paddingLarge;
		
		&.block-row
		{
			margin: @xf-paddingLarge;
		}
	}
	
	.block-row
	{
		background: @xf-contentAltBg;
		border-radius: @xf-blockBorderRadius;
		margin-top: @xf-paddingMedium;
	}
}

.block-container--discussion
{
	background: none;
	border: none;
	box-shadow: none;
	
	.block-filterBar
	{
		display: flex;
		flex-wrap: wrap;
		align-items: center;
		padding-left: 0;
		padding-right: 0;
	}
	
	.block-outer-opposite
	{
		margin-right: auto;
	}
	
	.block-body
	{
		background: @xf-contentBg;
		padding: @xf-paddingLarge;
		border-radius: @xf-blockBorderRadius;
	}
}

.p-body-content .fr-box.fr-basic .fr-toolbar.fr-top
{
	background: @xf-contentAltBg;
	padding: @xf-paddingMedium;
	border-bottom: @xf-borderSize solid @xf-borderColor;
	
	.fr-btn-grp
	{
		background: @xf-contentBg;
		padding: 2px @xf-paddingMedium;
		border: @xf-borderSize solid @xf-borderColor;
		border-radius: @xf-blockBorderRadius;
		margin-right: @xf-paddingSmall;
	}
}

.message-userContent
{
	background-color: rgba(0,0,0,.085);
	padding: @xf-paddingMedium @xf-paddingLargest @xf-paddingLargest;
	border-radius: @xf-blockBorderRadius;
}

.fr-box.bbWrapper.fr-basic.is-focused
{
	border-color: @xf-borderColorHeavy;
}

.p-footer
{
	.p-footer-linkList
	{
		display: flex;
		flex-wrap: wrap;
		justify-content: center;
	}
	
	.p-footer-row-main
	{
		float: none;
	}
}';
	return $__finalCompiled;
}
);