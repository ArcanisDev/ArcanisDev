<?php
// FROM HASH: 8638fc723efba1afa291fbc84b926dc2
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->includeTemplate('fancybox.less', $__vars) . '

/** XF fancybox overrides **/

body.compensate-for-scrollbar
{
	margin-right: 0 !important;
	// XF handles this
}

.fancybox-container
{
	z-index: @zIndex-7;
}

// RTL support
.fancybox-infobar,
.fancybox-toolbar,
.fancybox-caption,
.fancybox-navigation .fancybox-button
{
	direction: inherit;
}

.fancybox-slide--image .fancybox-content
{
	-ltr-rtl-left: 0;
}

.fancybox-slide--video .fancybox-content
{
	iframe
	{
		background: transparent;
		border: 0;
		display: block;
		height: 100%;
		margin: 0;
		overflow: hidden;
		padding: 0;
		width: 100%;
	}
}

.fancybox-slide--embed .fancybox-content
{
	box-shadow: none;
	background: transparent;
	padding: 0;

	.bbMediaWrapper, .bbMediaJustifier, .bbOembed
	{
		margin-left: auto;
		margin-right: auto;
	}

	.bbMediaWrapper-inner
	{
		position: static;
	}

	iframe
	{
		margin-bottom: 0;
	}
}

.fancybox-progress
{
	background: @xf-globalActionColor;
}

// backdrop filter niceness

.fancybox-inner
{
	.m-backdropFilter(blur(0px));
}

.fancybox-is-open
{
	.fancybox-inner
	{
		.m-backdropFilter(blur(5px));
	}
}

// box shadow for main image

.fancybox-content
{
	box-shadow: 5px 5px 15px rgba(0, 0, 0, .5);
}

// bigger, square thumbs

.fancybox-container
{
	--fancybox-thumb-size: 150px;

	// show smaller thumbs on smaller displays (including landscape orientation)
	@media (max-width: @xf-responsiveNarrow), (max-height: @xf-responsiveNarrow)
	{
		--fancybox-thumb-size: 75px;
	}
}

.fancybox-thumbs__list a
{
	width: var(--fancybox-thumb-size);
	height: var(--fancybox-thumb-size);

	&::before
	{
		border: 2px solid #eee;
		background: radial-gradient(transparent, rgba(0,0,0,0.75));
	}
}

.fancybox-show-thumbs .fancybox-inner
{
	right: 0;
	bottom: var(--fancybox-thumb-size);
}

// custom button icons
.fancybox-button
{
	> i
	{
		.m-faBase();

		display: block;
		height: 100%;
		overflow: visible;
		position: relative;
		width: 100%;
	}

	.fancybox-is-zoomable &.fancybox-button--zoom,
	&.fancybox-button--zoom[disabled]
	{
		> i
		{
			.m-faBefore(@fa-var-search-plus);

			&:nth-child(1)
			{
				display: block;
			}

			&:nth-child(2)
			{
				display: none;
			}
		}
	}

	.fancybox-can-pan &.fancybox-button--zoom
	{
		> i
		{
			.m-faBefore(@fa-var-search-minus);

			&:nth-child(1)
			{
				display: none;
			}

			&:nth-child(2)
			{
				display: block;
			}
		}
	}

	&.fancybox-button--nw
	{
		> i
		{
			.m-faBefore(@fa-var-external-link);
		}
	}

	&.fancybox-button--fsenter
	{
		> i
		{
			.m-faBefore(@fa-var-expand);

			&:nth-child(2)
			{
				display: none;
			}
		}
	}

	&.fancybox-button--fsexit
	{
		> i
		{
			.m-faBefore(@fa-var-compress);

			&:nth-child(1)
			{
				display: none;
			}
		}
	}

	&.fancybox-button--download
	{
		> i
		{
			.m-faBefore(@fa-var-download);
		}
	}

	&.fancybox-button--thumbs
	{
		> i
		{
			.m-faBefore(@fa-var-grip-horizontal);
		}
	}

	&.fancybox-button--close
	{
		> i
		{
			.m-faBefore(@fa-var-times);
		}
	}

	&.fancybox-button--sidebartoggle
	{
		> i
		{
			.m-faBefore(@fa-var-chevron-double-left);

			.fancybox-show-sidebar &
			{
				.m-faBefore(@fa-var-chevron-double-right);
			}
		}
	}

	&.fancybox-button--arrow_left
	{
		> i
		{
			padding: 7px;
			height: 100%;

			&:before
			{
				.m-faContent(@fa-var-chevron-left, false, ltr);
				.m-faContent(@fa-var-chevron-right, false, rtl);
			}
		}
	}

	&.fancybox-button--arrow_right
	{
		> i
		{
			height: 100%;
			padding: 7px;

			&:before
			{
				.m-faContent(@fa-var-chevron-right, false, ltr);
				.m-faContent(@fa-var-chevron-left, false, rtl);
			}
		}
	}

	&.fancybox-button--play
	{
		> i
		{
			.m-faBefore(@fa-var-play);

			&:nth-child(2)
			{
				display: none;
			}
		}
	}

	&.fancybox-button--pause
	{
		> i
		{
			.m-faBefore(@fa-var-pause);

			&:nth-child(1)
			{
				display: none;
			}
		}
	}
}

.fancybox-sidebartoggle
{
	display: none;
	text-align: right;

	.fancybox-has-sidebar &
	{
		display: block;
	}
}

.fancybox-navigation .fancybox-button
{
	background: transparent;
	i { background: rgba(30, 30, 30, 0.6); }
}

.fancybox-caption
{
	padding-top: 60px;
	padding-bottom: ~"max(10px, env(safe-area-inset-bottom))";
}

.fancybox-caption__body
{
	h4, p
	{
		margin: 0;
	}
}

// move thumbs to bottom of the page
.fancybox-thumbs
{
	top: auto;
	width: auto;
	bottom: 0;
	left: 0;
	right: 0;
	height: auto;
	padding: 0 10px;
	box-sizing: border-box;
	background: rgba(0, 0, 0, 0.3);
}

.fancybox-show-thumbs
{
	.fancybox-inner
	{
		right: 0;
	}

	.fancybox-inner,
	.fancybox-sidebar
	{
		bottom: var(--fancybox-thumb-size);
		margin-bottom: 4px;
	}
}

// round off some edges

.fancybox-navigation .fancybox-button i,
.fancybox-thumbs__list a,
.fancybox-thumbs__list a:before,
.fancybox-image
{
	border-radius: 5px;
}


// sidebar suppprt
@_sidebarWidth: 360px;

.fancybox-show-sidebar
{
	.fancybox-inner
	{
		right: @_sidebarWidth;
	}
}

.fancybox-sidebar
{
	background: @xf-contentBg;
	bottom: 0;
	margin: 0;
	position: absolute;
	right: 0;
	top: 0;
	width: @_sidebarWidth;
	z-index: @zIndex-7;
	overflow-y: auto;

	display: none;

	&.is-active
	{
		display: block;
	}
}

.fancybox-sidebar-loader
{
	opacity: 0;
	position: absolute;
	height: 100%;
	width: 100%;
	left: 0;
	top: 0;
	text-align: center;
	pointer-events: none;

	color: @xf-textColor;
	background: fadeout(@xf-contentBg, 10%);
	z-index: @zIndex-2;

	.m-loadingSpinner();
}

@media (max-width: @xf-responsiveWide)
{
	.fancybox-sidebar
	{
		.block-row
		{
			padding: @xf-paddingSmall @xf-paddingMedium;
		}

		.xfmgInfoBlock-title
		{
			.contentRow-figure
			{
				display: none;
			}

			.contentRow-main
			{
				padding-left: 0;
			}
		}

		.message-responseRow
		{
			.comment-avatar
			{
				display: none;
			}

			.comment-main
			{
				padding-left: 0;
			}
		}
	}
}

@media (max-width: @xf-responsiveEdgeSpacerRemoval)
{
	.fancybox-sidebar
	{
		.block-container
		{
			margin: 0;
		}
	}
}';
	return $__finalCompiled;
}
);