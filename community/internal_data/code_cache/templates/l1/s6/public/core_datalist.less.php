<?php
// FROM HASH: 687639a4807ff773d1570c8c24aa551b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '// ################################# DATA LISTS ###################

.dataList
{
	max-width: 100%;

	&.dataList--separated
	{
		border-top: @xf-borderSize solid @xf-borderColorLight;
		border-bottom: @xf-borderSize solid @xf-borderColorLight;
	}

	&.dataList--separatedTop
	{
		border-top: @xf-borderSize solid @xf-borderColorLight;
	}

	&.dataList--separatedBottom
	{
		border-bottom: @xf-borderSize solid @xf-borderColorLight;
	}

	&.dataList--contained
	{
		overflow-x: auto;
		max-height: 300px;
		max-height: 85vh;
	}

	&.dataList--containedFixed
	{
		overflow-x: auto;
		max-height: 300px;
	}

	&.dataList--autoSize
	{
		display: table;
		width: auto;
		margin: 0 auto;
	}

	@media (max-width: @xf-responsiveMedium)
	{
		overflow-x: auto;
	}

	--imageBgWidth: 64px;
}

.dataList-table
{
	width: 100%;
	border-collapse: separate;
	border-spacing: 0;
}

.dataList-rowGroup
{
	&.is-hidden
	{
		display: none;
	}
}

.m-adjustDataListCellPadding(@paddingV; @paddingH)
{
	padding: @paddingV @paddingH;

	&.dataList-cell--action,
	&.dataList-cell--link
	{
		padding: 0;

		a,
		label,
		.dataList-blockLink
		{
			padding: @paddingV @paddingH;
		}
	}
}

.dataList-row
{
	&:hover:not(.dataList-row--noHover):not(.dataList-row--header):not(.is-spHovered),
	.is-spActive &.is-spChecked
	{
		background: fade(@xf-contentHighlightBg, 50%);
	}

	.is-spActive &.is-spHovered
	{
		background: fade(@xf-contentHighlightBg, 75%);
	}

	.is-spActive &:not(.dataList-row--noHover):not(.dataList-row--header):not(.is-spChecked) *
	{
		color: @xf-textColorMuted;
	}

	&.dataList-row--header
	{
		.dataList-cell
		{
			.xf-dataListHeader();
			.m-adjustDataListCellPadding(@xf-dataListPaddingV/2, @xf-dataListPaddingH);
			.m-textColoredLinks();
			text-align: left;

			&.dataList-cell--min
			{
				text-align: center;
			}
		}
	}

	&.dataList-row--subSection
	{
		.dataList-cell
		{
			.xf-dataListSection();
			.m-adjustDataListCellPadding(@xf-dataListPaddingV/2, @xf-dataListPaddingH);

			a { color: inherit; }
		}

		&:hover:not(.dataList-row--noHover) .dataList-cell
		{
			.xf-dataListSection(background);
		}
	}

	&.dataList-row--note
	{
		.dataList-cell
		{
			text-align: center;
		}
	}

	&.dataList-row--deleted
	{
		.dataList-cell
		{
			opacity: .5;
		}
	}

	&.dataList-row--highlighted
	{
		font-weight: @xf-fontWeightHeavy;
	}

	&.dataList-row--custom
	{
		> .dataList-cell:first-child
		{
			border-left: @xf-borderSizeFeature solid red;
		}

		.dataList-cell--link a
		{
			color: red;
		}
	}

	&.dataList-row--parentCustom
	{
		> .dataList-cell:first-child
		{
			border-left: @xf-borderSizeFeature solid orange;
		}

		.dataList-cell--link a
		{
			color: orange;
		}
	}

	&.dataList-row--protected
	{
		> .dataList-cell:first-child
		{
			border-left: @xf-borderSizeFeature solid @xf-borderColorFeature;
		}
	}

	&.is-hidden
	{
		display: none;
	}

	&.dataList-row--disabled
	{
		.dataList-cell--link a
		{
			color: @xf-textColorMuted;
			.m-transition();
		}
	}

	&.dataList-row--invalid
	{
		opacity: 0.5;
		.m-transition(opacity);

		&:hover
		{
			opacity: 1;
		}
	}

	&.dataList-row--opposite,
	&.dataList-row--header.dataList-row--opposite
	{
		.dataList-cell
		{
			text-align: right;

			&:first-of-type
			{
				text-align: left;
			}
		}
	}

	tbody:last-child &:last-child .dataList-cell
	{
		border-bottom: none;
	}
}

.iconicIcon(@setPosition: true)
{
	.m-iconicIcon(@setPosition);
}

.dataList-cell {
	vertical-align: middle;
	padding: @xf-dataListPaddingV @xf-dataListPaddingH;
	border-bottom: @xf-borderSize solid @xf-borderColorFaint;

	&.dataList-cell--main {
		min-width: 180px;
	}

	&.dataList-cell--minWidth {
		min-width: 17vw;
		min-width: ~"min(17vw, 250px)";
	}

	&.dataList-cell--link,
	&.dataList-cell--action {
		padding: 0;
	}

	&.dataList-cell--alt,
	&.dataList-cell--action {
		background: @xf-contentAltBg;
	}

	&.dataList-cell--highlighted {
		background: @xf-contentHighlightBg;
	}

	&.dataList-cell--separated {
		border-left: @xf-borderSize solid @xf-borderColorFaint;
	}

	&.dataList-cell--min,
	&.dataList-cell--action,
	&.dataList-cell--iconic,
	&.dataList-cell-fa
	{
		width: 1%;
		white-space: nowrap;
		word-wrap: normal;
		text-align: center;
	}

	&.dataList-cell--opposite,
	.dataList-row.dataList-row--header &.dataList-cell--opposite // need higher specificity for header rows
	{
		text-align: right;
	}

	&.dataList-cell--number
	{
		text-align: right !important;
	}

	&.dataList-cell--action {
		font-size: @xf-fontSizeSmaller;
	}

	&.dataList-cell--action,
	&.dataList-cell--link {
		cursor: pointer;
		text-decoration: none;

		&.dataList-cell--alt:hover,
		&.dataList-cell--action:hover {
			background: @xf-contentHighlightBg;
		}

		a,
		label,
		.dataList-blockLink {
			padding: @xf-dataListPaddingV @xf-dataListPaddingH;
			display: block;
			height: 100%;
			text-decoration: none;
			cursor: pointer;
		}

		input {
			cursor: pointer;
		}
	}

	&.dataList-cell--action a:not(.iconic) {
		//	padding: @xf-dataListPaddingV @xf-dataListPaddingH * 2;
	}

	&.dataList-cell--iconic,
	&.dataList-cell--fa
	{
		padding: 0;
		font-size: 125%;
		min-width: 2.5em;
		position: relative;
		text-align: center;
	}

	&.dataList-cell--iconic
	{
		> a.iconic > i
		{
			.m-iconicIcon(false);
		}

		> .iconic
		{
			position: absolute;

			// fill the cell
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;

			> i
			{
				&:before,
				&:after
				{
					left: 50%;
					margin-left: -.5em; // half of icon width

					top: 50%;
					margin-top: -.5em; // half of icon height
				}
			}

			> input[type=checkbox] + i
			{
				&:before,
				&:after
				{
					margin-top: -.7em;
					margin-left: -.4375em; // half of .fa-check-square width
				}
			}

			> input[type=radio] + i
			{
				&:before,
				&:after
				{
					margin-top: -.7em;
					margin-left: -.5em; // half of .fa-check-square width
				}
			}

			&.iconic--toggle > input[type=checkbox] + i
			{
				&:before
				{
					.m-faContent(@fa-var-toggle-off, 1.125em);
				}

				&:after
				{
					.m-faContent(@fa-var-toggle-on, 1.125em);
				}

				&:before,
				&:after
				{
					font-size: 120%;
					margin-top: -.7em;
					margin-left: -.5625em; // half of .fa-toggle-on width
				}
			}

			&.iconic--delete > i
			{
				&:before
				{
					.m-faContent(@fa-var-trash-alt, .875em);
				}

				&:before,
				&:after
				{
					margin-top: -.7em;
					margin-left: -.4375em; // half of .fa-trash-alt width
				}
			}
		}
	}

	&.dataList-cell--attachment
	{
		background: center / cover @xf-contentAltBg no-repeat;

		--size: 120px;
		width: var(--size);
		height: var(--size);
		line-height: var(--size);
		text-align: center;

		a { display: block; padding: 0; }

		.tooltip-element { display: none; }
	}

	&.dataList-cell--image
	{
		padding: 0;

		a
		{
			padding: 0;
		}

		img,
		.dataList-imagePlaceholder
		{
			display: block;
			margin: auto;
			font-size: 30px;
		}
	}

	&.dataList-cell--imageSmall
	{
		img,
		.dataList-imagePlaceholder
		{
			height: 41px;
			max-width: 41px;
			line-height: 41px;
		}

		.avatar
		{
			.m-avatarSize(41px);
			border-radius: 2px;
		}
	}

	&.dataList-cell--imageSmallWide
	{
		img,
		.dataList-imagePlaceholder
		{
			height: 41px;
			max-width: 82px;
			line-height: 41px;
		}

		.avatar
		{
			.m-avatarSize(41px);
			border-radius: 0;
		}
	}

	&.dataList-cell--imageMedium
	{
		img,
		.dataList-imagePlaceholder
		{
			height: 54px;
			max-width: 54px;
			line-height: 54px;
		}

		.avatar
		{
			.m-avatarSize(54px);
			border-radius: 0;
		}
	}

	&.dataList-cell--imageMediumWide
	{
		img,
		.dataList-imagePlaceholder
		{
			height: 54px;
			max-width: 108px;
			line-height: 54px;
		}

		.avatar
		{
			.m-avatarSize(54px);
			border-radius: 0;
		}
	}

	&.dataList-cell--imageBg
	{
		--bg: url(\'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=\');
		width: var(--imageBgWidth);
		background: top left / cover var(--bg);

		.dataList-row--disabled &
		{
			background-image: linear-gradient(black, black), var(--bg);
			background-blend-mode: saturation;
		}
	}

	&.dataList-cell--responsiveMenuTrigger,
	&.dataList-cell--fauxResponsiveMenuTrigger
	{
		display: none;
	}

	&.dataList-cell--breakWord
	{
		word-break: break-word;
	}

	&.dataList-cell--hint,
	.dataList-row--subSection &.dataList-cell--hint
	{
		text-align: right;
		font-size: @xf-fontSizeSmaller;
		color: @xf-textColorMuted;
	}

	// create ten depth classes for the appearance of nested items
	.depthLoop(@i) when (@i <= 10)
	{
		&.dataList-cell--d@{i} { text-indent: (@i - 1) * 25px; }
		.depthLoop(@i + 1);
	}
	.depthLoop(1);

	.is-match
	{
		text-decoration: underline;
		color: red;
	}

	@media (max-width: @xf-responsiveMedium)
	{
		&.dataList-cell--responsiveMenuItem,
		&.dataList-cell--fauxResponsiveMenuItem
		{
			display: none !important;
		}

		&.dataList-cell--responsiveMenuTrigger,
		&.dataList-cell--fauxResponsiveMenuTrigger
		{
			display: table-cell;
		}
	}
}

.dataList-imagePlaceholder
{
	&:after
	{
		content: \'?\';
	}
}

.dataList-mainRow,
.dataList-textRow,
.dataList-subRow
{
	width: 0;
	display: block;
	min-width: 100%;
	line-height: 1.4;
	overflow: hidden;
	word-wrap: normal;
	text-overflow: ellipsis;

	&:empty { display: none; }
}

.dataList-mainRow
{
	font-weight: @xf-fontWeightHeavy;

	.dataList-row--subSection &
	{
		font-weight: @xf-fontWeightNormal;
	}
}

.dataList-secondRow
{
	display: block;
	font-size: @xf-fontSizeSmallest;
}

.dataList-hint,
.dataList-subRow
{
	color: @xf-textColorMuted;
	font-size: @xf-fontSizeSmaller;
	font-weight: @xf-fontWeightNormal;
}

.dataList-hint
{
	display: inline;
}

.dataList-row--footer .dataList-cell
{
	// note that this is applied as a cell style which has higher priority than the row styles normally applied
	padding: @xf-dataListPaddingV/2 @xf-dataListPaddingH;
	border-bottom: none;
	.xf-dataListFooter();
}

.dataList--responsive
{
	.dataList-table,
	tbody,
	thead,
	tfoot
	{
		display: block;
	}

	.dataList-row
	{
		display: block;

		&.dataList-row--headerResponsive
		{
			display: none;
		}
	}

	.dataList-cell
	{
		display: block;
		width: auto;

		&[data-cell-label]
		{
			display: flex;
			align-items: center;

			> *
			{
				min-width: 0;
				text-align: right;
			}

			&:before
			{
				display: table-cell;

				content: attr(data-cell-label) "' . $__templater->escape($__vars['xf']['language']['label_separator']) . '";
				padding-right: @xf-dataListPaddingH;
				margin-right: auto;
				word-break: normal;
				white-space: normal;
				text-align: left;
			}

			> .input:first-child:last-child
			{
				display: inline;
			}

			a
			{
				// commonly a URL, but needed to prevent a potential overflow
				min-width: 0;
			}
		}

		&.dataList-cell--iconic
		{
			&:not([data-cell-label]):before
			{
				content: "";
				display: inline-block;
				height: 1em;
			}

			padding: @xf-dataListPaddingV @xf-dataListPaddingH;
		}

		&.dataList-cell--link,
		&.dataList-cell--action
		{
			&[data-cell-label]:before
			{
				padding: @xf-dataListPaddingV @xf-dataListPaddingH;
			}
		}

		&.dataList-cell--iconic,
		&.dataList-cell--fa
		{
			display: table-cell;
			width: 1%;
		}

		&.dataList-cell--iconic[data-cell-label]
		{
			display: flex;
			width: auto;
			font-size: 100%;

			.iconic
			{
				position: relative;
			}
		}
	}

	.dataList-row:not(.dataList-row--header):not(.dataList-row--subSection)
	{
		border-bottom: @xf-borderSize solid @xf-borderColorLight;

		.dataList-cell
		{
			border-bottom: none;
		}
	}

	tbody:last-child .dataList-row:not(.dataList-row--header):not(.dataList-row--subSection):last-child
	{
		border-bottom: none;
	}

	.dataList-mainRow,
	.dataList-textRow,
	.dataList-subRow
	{
		width: auto;
		min-width: 0;
	}
}';
	return $__finalCompiled;
}
);