<?php
// FROM HASH: 0b93ec6c193c5c9e0e31e04367c7039a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '// ####################################### PAGE NAVIGATION ########################

@_page-paddingV: xf-default(@xf-buttonBase--padding-top, 6px);
@_page-paddingH: @xf-paddingLarge;
@_page-paddingHSimple: 10px;

.pageNavWrapper {}

.m-pageNavElCore()
{
	background: @xf-contentBg;
	color: @xf-linkColor;
	font-size: @xf-fontSizeSmall;
	font-weight: 700;
	white-space: nowrap;
	border: @xf-borderSize solid @xf-borderColor;

	&:hover,
	&:active
	{
		background: @xf-paletteAccent1;
		text-decoration: none;
	}
}

.pageNav-jump
{
	display: inline-block;
	.m-pageNavElCore();
	border-radius: @xf-borderRadiusSmall;
	padding: @_page-paddingV @_page-paddingH;

	&:hover {
		color: @xf-textColorEmphasized;
	}
	
	&.pageNav-jump--prev:before,
	&.pageNav-jump--next:after
	{
		.m-faBase(\'Pro\', @faWeight-solid);
		font-size: 80%;
		unicode-bidi: isolate; // maintain position in RTL with LTR text
	}

	&.pageNav-jump--prev:before
	{
		.m-faContent("@{fa-var-caret-left}\\00a0", false, ltr); // .61em
		.m-faContent("@{fa-var-caret-right}\\00a0", false, rtl); // .61em
	}

	&.pageNav-jump--next:after
	{
		.m-faContent("\\00a0@{fa-var-caret-right}", false, ltr); // .61em
		.m-faContent("\\00a0@{fa-var-caret-left}", false, rtl); // .61em
	}
}

.pageNav-main
{
	.m-listPlain();
	display: inline-table;
}

.pageNav-page
{
	display: table-cell;
	.m-pageNavElCore();

	&:not(:last-child)
	{
		border-right: none;
	}

	&:not(:first-child)
	{
		border-left-color: @xf-borderColorLight;
	}

	&:first-child
	{
		.m-borderLeftRadius(@xf-borderRadiusSmall);
	}

	&:last-child
	{
		.m-borderRightRadius(@xf-borderRadiusSmall);
	}

	> a
	{
		display: block;
		padding: @_page-paddingV @_page-paddingH;
		text-decoration: none;
		color: inherit;
	}

	&.pageNav-page--current
	{
		background: @xf-contentHighlightBg;
		color: @xf-textColorEmphasized;
		cursor: pointer;

		&:hover,
		&:active
		{
			background: @xf-contentAccentBg;
		}

		+ .pageNav-page
		{
			border-left: none;
		}
	}
}

// Hide relative page numbers on narrow devices when we have a skip entry as we don\'t necessarily have space.
@media (max-width: @xf-responsiveNarrow)
{
	.pageNav--skipStart
	{
		.pageNav-page.pageNav-page--earlier
		{
			display: none;
		}
	}

	.pageNav--skipEnd
	{
		.pageNav-page.pageNav-page--later
		{
			display: none;
		}

		.pageNav-page.pageNav-page--skipEnd
		{
			border-left: none;
		}
	}
}

// ########################### SIMPLE PAGE NAV VARIANT ########################

.pageNavSimple
{
	display: inline-flex;
}

.pageNavSimple-el
{
	display: inline-block;
	border-radius: @xf-borderRadiusSmall;
	padding: @_page-paddingV @_page-paddingHSimple;
	font-size: @xf-fontSizeSmall;
	text-align: center;
	white-space: nowrap;
	margin-right: 4px;

	&:last-child
	{
		margin-right: 0;
	}

	&.pageNavSimple-el--current
	{
		.xf-contentAccentBase();

		&:hover,
		&:active
		{
			background: xf-intensify(@xf-contentAccentBg, 3%);
			text-decoration: none;
		}
	}

	&.pageNavSimple-el--prev,
	&.pageNavSimple-el--next
	{
		.xf-contentHighlightBase();
		min-width: 75px;

		@media (max-width: 350px)
		{
			min-width: 0;
		}

		&:hover,
		&:active
		{
			background: xf-intensify(@xf-contentHighlightBg, 3%);
			text-decoration: none;
		}

		i:before
		{
			.m-faBase(\'Pro\', @faWeight-solid);
		}
	}

	&.pageNavSimple-el--prev i:before
	{
		.m-faContent(@fa-var-caret-left, false, ltr); // , .44em
		.m-faContent(@fa-var-caret-right, false, rtl); // , .44em
	}

	&.pageNavSimple-el--next i:before
	{
		.m-faContent(@fa-var-caret-right, false, ltr); // , .44em
		.m-faContent(@fa-var-caret-left, false, rtl); // , .44em
	}

	&.pageNavSimple-el--first,
	&.pageNavSimple-el--last
	{
		border-color: transparent;
		padding-left: (@_page-paddingHSimple / 2);
		padding-right: (@_page-paddingHSimple / 2);
		color: fade(@xf-linkColor, 60%);

		&:hover,
		&:active
		{
			.xf-blockBorder();
			background: xf-intensify(@xf-contentHighlightBg, 3%);
			color: @xf-contentHighlightBase--color;
			text-decoration: none;
		}

		i:before
		{
			.m-faBase(\'Pro\', @faWeight-solid);
		}
	}

	&.pageNavSimple-el--first i:before
	{
		.m-faContent(@fa-var-backward, false, ltr); // 1em
		.m-faContent(@fa-var-forward, false, rtl); // 1em
	}

	&.pageNavSimple-el--last i:before
	{
		.m-faContent(@fa-var-forward, false, ltr); // 1em
		.m-faContent(@fa-var-backward, false, rtl); // 1em
	}

	&.is-disabled
	{
		border-color: transparent;
		background: none;
		color: @xf-textColorMuted;
		text-decoration: none;
		pointer-events: none;

		&:hover
		{
			background: none;
			color: @xf-textColorMuted;
		}
	}
}

// #################### DISPLAY VARIANTS #########################

.pageNavWrapper--simple
{
	.pageNav
	{
		display: none;
	}
}

.pageNavWrapper--full
{
	.pageNavSimple
	{
		display: none;
	}
}

.pageNavWrapper--mixed
{
	.pageNavSimple
	{
		display: none;
	}

	@media (max-width: @xf-responsiveMedium)
	{
		.pageNav
		{
			display: none;
		}

		.pageNavSimple
		{
			display: inline-flex;
		}
	}
}

// Hide any block page nav that goes before the block as we will be wasting vertical space.
@media (max-width: @xf-responsiveNarrow)
{
	.block-outer:not(.block-outer--after) .pageNavWrapper:not(.pageNavWrapper--forceShow)
	{
		display: none;
	}

	// this is a sanity check in case .block-outer--after is forgotten
	.block-container + .block-outer .pageNavWrapper
	{
		display: block;
	}
}';
	return $__finalCompiled;
}
);