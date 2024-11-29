<?php
// FROM HASH: 0ae6cb93a1797f8fcb7d756b9e97e0dd
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '@_message-actionColumnWidth: 40px;
@_messageSimple-userColumnWidth: 70px;

.message
{
	+ .message,
	&.message--bordered
	{
		border-top: @xf-borderSize solid @xf-borderColor;
	}
}

.message,
.block--messages .message
{
	&.is-mod-selected
	{
		background: @xf-inlineModHighlightColor;

		.message-cell--user,
		.message-cell--vote
		{
			background: @xf-inlineModHighlightColor;
		}

		.message-userArrow:after
		{
			border-right-color: @xf-inlineModHighlightColor;
		}
	}
}

.message-inner
{
	display: flex;

	& + .message-inner
	{
		border-top: @xf-borderSize solid @xf-borderColor;
	}
}

.message-cell
{
	display: block;
	vertical-align: top;
	padding: @xf-messagePadding;

	.message--quickReply &
	{
		//padding-bottom: 35px; // for the submit row

		> .formRow:last-child
		{
			> dd
			{
				padding-bottom: 0;
			}
		}
	}

	&.message-cell--closer
	{
		padding: @xf-messagePaddingSmall;

		&.message-cell--user
		{
			.m-fixedWidthFlex((@xf-messageUserBlockWidth) + 2 * (@xf-messagePaddingSmall));

			.message--simple &
			{
				.m-fixedWidthFlex(@_messageSimple-userColumnWidth + 2 * (@xf-messagePaddingSmall));

			}
		}

		&.message-cell--action
		{
			.m-fixedWidthFlex((@_message-actionColumnWidth) + 2 * (@xf-messagePaddingSmall));
		}
	}

	&.message-cell--user,
	&.message-cell--action
	{
		position: relative;
		.xf-messageUserBlock(no-border);
		border-right: @xf-messageUserBlock--border-width solid @xf-messageUserBlock--border-color;
		min-width: 0;
	}

	&.message-cell--vote
	{
		position: relative;
		.xf-messageUserBlock(no-border);
		border-left: @xf-messageUserBlock--border-width solid @xf-messageUserBlock--border-color;
		border-right: 0;
		padding-top: 0;
		padding-bottom: 0;

		.message--solution &
		{
			background: @xf-successBg;
		}

		.solutionIcon
		{
			margin-top: @xf-paddingMedium;
		}
	}

	&.message-cell--user
	{
		.m-fixedWidthFlex((@xf-messageUserBlockWidth) + 2 * (@xf-messagePadding));

		.message--simple &
		{
			.m-fixedWidthFlex(@_messageSimple-userColumnWidth + 2 * @xf-messagePaddingSmall);
		}
	}

	&.message-cell--action
	{
		.m-fixedWidthFlex((@_message-actionColumnWidth) + 2 * (@xf-messagePadding));
	}

	&.message-cell--main
	{
		flex: 1 1 auto;
		width: 100%;
		min-width: 0;

		&.is-editing
		{
			padding: 0;
		}

		// should really only happen when editing
		.block
		{
			margin: 0;
		}

		.block-container
		{
			margin: 0;
			border: none;
		}
	}

	&.message-cell--alert
	{
		font-size: @xf-fontSizeSmall;
		flex: 1 1 auto;
		width: 100%;
		min-width: 0;
		.xf-contentAccentBase();

		a
		{
			.xf-contentAccentLink();
		}
	}

	&.message-cell--extra
	{
		.m-fixedWidthFlex(180 + 2 * (@xf-messagePadding));
		border-left: @xf-messageUserBlock--border-width solid @xf-messageUserBlock--border-color;
		background: @xf-contentAltBg;

		.formRow-explain
		{
			margin: @xf-paddingMedium 0 0;
			.xf-formExplain();
			.m-textColoredLinks();
			font-size: 80%;
		}
	}

	&.message-cell--header,
	&.message-cell--solutionHeader
	{
		flex: 1 1 auto;
		width: 100%;
		min-width: 0;
		padding: @xf-blockPaddingV @xf-blockPaddingH;
		margin: 0;
	}

	&.message-cell--header
	{
		font-weight: @xf-fontWeightNormal;
		text-decoration: none;
		.xf-blockHeader();
		border-bottom: none;

		.m-hiddenLinks();
	}

	&.message-cell--solutionHeader
	{
		color: @xf-successColor;
		font-size: @xf-fontSizeLarge;
		background: @xf-successBg;
		border-left: @xf-borderSizeFeature solid @xf-successFeatureColor;
	}
}

.message-main
{
	height: 100%;
	display: flex;
	flex-direction: column;
}

.message-content
{
	flex: 1 1 auto;

	// IE11 flex bug
	min-height: 1px;
}

.message-footer
{
	margin-top: auto;
}

.message-expandWrapper
{
	position: relative;
	overflow: hidden;
	.m-transition(-xf-height, height);

	.message-expandContent
	{
		max-height: 250px;
		overflow: hidden;
	}
	.message-expandContent--small
	{
		max-height: 160px;
	}

	&.is-expandable
	{
		.message-expandLink
		{
			display: block;
		}
	}

	&.is-expanded
	{
		.message-expandContent
		{
			max-height: none;
		}

		.message-expandLink
		{
			display: none;
		}
	}
}

.message-column
{
	display: flex;
	flex-direction: column;
	align-items: center;
}

.message-expandLink
{
	display: none;
	position: absolute;
	top: 60%;
	bottom: 0;
	left: 0;
	right: 0;
	cursor: pointer;
	z-index: @zIndex-1;

	.m-gradient(
		fade(@xf-contentBase--background-color, 0%),
		xf-default(@xf-contentBase--background-color, transparent),
		transparent,
		0%,
		70%
	);

	&:empty
	{
		cursor: auto;

		.m-gradient(
			fade(@xf-contentBase--background-color, 0%),
			xf-default(@xf-contentBase--background-color, transparent),
			transparent,
			0%,
			100%
		);
	}

	a
	{
		position: absolute;
		bottom: @xf-messagePadding;
		left: 0;
		right: 0;
		text-align: center;
		font-size: @xf-fontSizeSmall;
		color: @xf-textColorAttention;
		text-decoration: none;
	}
}

@media (max-width: @xf-messageSingleColumnWidth)
{
	.message:not(.message--forceColumns)
	{
		.message-inner
		{
			display: block;
		}

		.message-cell
		{
			display: block;
			.m-clearFix();

			&.message-cell--user
			{
				width: auto;
				border-right: none;
				border-bottom: @xf-messageUserBlock--border-width solid @xf-messageUserBlock--border-color;
			}

			&.message-cell--vote
			{
				width: auto;
				border-left: none;
				border-top: @xf-messageUserBlock--border-width solid @xf-messageUserBlock--border-color;

				.solutionIcon
				{
					margin-top: 0;
				}
			}

			&.message-cell--main
			{
				padding-left: @xf-messagePadding;
			}

			&.message-cell--extra
			{
				width: auto;
				border-left: none;
				border-top: @xf-messageUserBlock--border-width solid @xf-messageUserBlock--border-color;
			}
		}

		.message-column
		{
			flex-direction: row;
			justify-content: space-evenly;
		}
	}

	.message--simple:not(.message--forceColumns),
	.message--quickReply:not(.message--forceColumns)
	{
		.message-cell.message-cell--user
		{
			display: none;
		}
	}
}

// ######################## USER COLUMN #########################

.message-userArrow
{
	position: absolute;
	top: (@xf-messagePadding) * 2;
	right: -1px;

	.m-triangleLeft(xf-default(@xf-messageUserBlock--border-color, transparent), @xf-messagePadding);

	&:after
	{
		position: absolute;
		top: -(@xf-messagePadding - 1px);
		right: -@xf-messagePadding;
		content: "";

		.m-triangleLeft(@xf-contentBg, @xf-messagePadding - 1px);
	}
}

.message-avatar
{
	text-align: center;

	.avatar
	{
		vertical-align: bottom;
	}
}

.message-avatar-wrapper
{
	position: relative;
	display: inline-block;
	vertical-align: bottom;
	margin-bottom: .5em;

	.message-avatar-online
	{
		position: absolute;

		// center bottom position
		left: 50%;
		margin-left: -.615em;
		bottom: -.5em;

		&:before
		{
			.m-faBase();
			.m-faContent(@fa-var-user-circle, .969em);
			line-height: 1;
			font-weight: bold;
			color: rgb(127, 185, 0);
			background: @xf-messageUserBlock--background-color;
			border: @xf-messageUserBlock--background-color solid 2px;
			border-radius: 50%;
			display: inline-block;
		}
	}
}

.message-name
{
	font-weight: @xf-fontWeightHeavy;
	font-size: inherit;
	text-align: center;
	margin: 0;
}

.message-userTitle
{
	font-size: @xf-fontSizeSmaller;
	font-weight: normal;
	text-align: center;
	margin: 0;
}

.message-userBanner.userBanner
{
	display: block;
	margin-top: 3px;
}

.message-userExtras
{
	margin-top: 3px;
	font-size: @xf-fontSizeSmaller;
}

.message--deleted
{
	.message-userDetails
	{
		display: none;
	}

	.message-avatar .avatar
	{
		.m-avatarSize(@avatar-s);
	}
}

@media (max-width: @xf-messageSingleColumnWidth)
{
	.message:not(.message--forceColumns)
	{
		.message-userArrow
		{
			top: auto;
			right: auto;
			bottom: -1px;
			left: ((@avatar-s) / 2);

			border: none;
			.m-triangleUp(xf-default(@xf-messageUserBlock--border-color, transparent), @xf-messagePadding);

			&:after
			{
				top: auto;
				right: auto;
				left: -(@xf-messagePadding - 1px);
				bottom: -@xf-messagePadding;

				border: none;
				.m-triangleUp(@xf-contentBg, @xf-messagePadding - 1px);
			}
		}

		&.is-mod-selected
		{
			.message-userArrow:after
			{
				border-color: transparent;
				border-bottom-color: @xf-inlineModHighlightColor;
			}
		}

		.message-user
		{
			display: flex;
		}

		.message-avatar
		{
			margin-bottom: 0;

			.avatar
			{
				.m-avatarSize(@avatar-s);

				& + .message-avatar-online
				{
					left: auto;
					right: 0;
				}
			}
		}

		.message-userDetails
		{
			flex: 1;
			min-width: 0;
			padding-left: @xf-messagePadding;
		}

		.message-name
		{
			text-align: left;
		}

		.message-userTitle,
		.message-userBanner.userBanner
		{
			display: inline-block;
			text-align: left;
			margin: 0;
		}

		.message-userExtras
		{
			display: none;
		}

		.message--deleted
		{
			.message-userDetails
			{
				display: block;
			}
		}
	}
}

// ####################### MAIN COLUMN ####################

.message-content
{
	position: relative;

	.js-selectToQuoteEnd
	{
		height: 0;
		font-size: 0;
		overflow: hidden;
	}

	.message--multiQuoteList &
	{
		min-height: 80px;
		max-height: 120px;
		overflow: hidden;

		.message-body
		{
			pointer-events: none;
		}
	}
}

.message-attribution
{
	color: @xf-textColorMuted;
	font-size: @xf-fontSizeSmaller;
	padding-bottom: 3px;
	border-bottom: @xf-borderSize solid @xf-borderColorFaint;
	.m-clearFix();

	&.message-attribution--plain
	{
		border-bottom: none;
		font-size: inherit;
		padding-bottom: 0;
	}

	&.message-attribution--split
	{
		display: flex;
		align-items: flex-end;
		flex-wrap: wrap;

		.message-attribution-opposite
		{
			margin-left: auto;
		}
	}
}

.message-attribution-main
{
	float: left;
}

.message-attribution-opposite
{
	float: right;

	&.message-attribution-opposite--list
	{
		display: flex;
		.m-listPlain();

		> li
		{
			margin-left: 14px;

			&:first-child
			{
				margin-left: 0;
			}
		}
	}

	a
	{
		color: inherit;

		&:hover
		{
			text-decoration: none;
			color: @xf-linkHoverColor;
		}
	}
}

.message-attribution-gadget
{
	display: inline-block;
	margin: -3px -7px;
	padding: 3px 7px;
}

.message-attribution-source
{
	font-size: @xf-fontSizeSmaller;
	margin-bottom: @xf-paddingSmall;
}

.message-attribution-user
{
	font-weight: @xf-fontWeightHeavy;

	.avatar
	{
		display: none;
	}

	.attribution
	{
		display: inline;
		font-size: inherit;
		font-weight: inherit;
		margin: 0;
	}
}

.message-newIndicator,
a.message-newIndicator
{
	.xf-messageNewIndicator();
	white-space: nowrap;
}

a.message-newIndicator:hover
{
	color: @xf-messageNewIndicator--color;
}

.message-minorHighlight
{
	font-size: @xf-fontSizeSmall;
	color: @xf-textColorFeature;
}

.message-fields
{
	margin: @xf-messagePadding 0;

	.message--simple &
	{
		margin-top: @xf-messagePaddingSmall;
		margin-bottom: @xf-messagePaddingSmall;
	}

	&:last-child
	{
		margin-bottom: 0;
	}
}

.message-body
{
	margin: @xf-messagePadding 0;
	font-family: @xf-fontFamilyBody;
	.m-clearFix();

	.message--simple &
	{
		margin-top: @xf-messagePaddingSmall;
		margin-bottom: @xf-messagePaddingSmall;
	}

	&:last-child
	{
		margin-bottom: 0;
	}

	.message-title
	{
		// basically replicates .structItem-title
		font-size: @xf-fontSizeLarge;
		font-weight: @xf-fontWeightNormal;
		margin: 0 0 @xf-messagePadding 0;
		padding: 0;
	}
}

.message-attachments
{
	margin: .5em 0;
}

	.message-attachments-list
	{
		.m-listPlain();
	}

.message-lastEdit
{
	margin-top: .5em;
	color: @xf-textColorMuted;
	font-size: @xf-fontSizeSmallest;
	text-align: right;
}

.message-signature
{
	margin-top: @xf-messagePadding;
	.xf-messageSignature();
}

.message-actionBar .actionBar-set
{
	margin-top: @xf-messagePadding;
	font-size: @xf-fontSizeSmall;

	.message--simple &
	{
		margin-top: @xf-messagePaddingSmall;
	}
}

.message .likesBar
{
	margin-top: @xf-messagePadding;
	padding: @xf-messagePaddingSmall;
}

.message .reactionsBar
{
	margin-top: @xf-messagePadding;
	padding: @xf-messagePaddingSmall;
}

.message-historyTarget
{
	margin-top: @xf-messagePadding;
}

.message-gradient
{
	position: absolute;
	bottom: 0;
	left: 0;
	right: 0;
	height: 60px;

	.m-gradient(fade(@xf-contentBg, 0%), @xf-contentBg, @xf-contentBg, 0%, 90%);
}

.message-responses
{
	margin-top: @xf-messagePaddingSmall;
	font-size: @xf-fontSizeSmall;

	.editorPlaceholder
	{
		.input
		{
			font-size: inherit;
		}
	}
}

.message-responseRow
{
	margin-top: -@xf-minorBlockContent--border-width;
	.xf-minorBlockContent();
	padding: @xf-messagePaddingSmall;

	// note that border radiuses are very difficult to do here due to a lot of dynamic showing/hiding

	&.message-responseRow--likes,
	&.message-responseRow--reactions
	{
		.m-transitionFadeDown();
	}
}

@media (max-width: @xf-messageSingleColumnWidth)
{
	.message:not(.message--forceColumns)
	{
		.message-attribution-user .avatar
		{
			display: inline-flex;
			.m-avatarSize((@xf-fontSizeNormal) * (@xf-lineHeightDefault));
		}

		.message-content
		{
			// this is 1px to workaround an IE11 issue - see #139187
			min-height: 1px;
		}
	}
}

@media (max-width: @xf-responsiveNarrow)
{
	.message-signature
	{
		display: none;
	}
}

// MESSAGE MENU

.message-menuGroup
{
	display: inline-block;
}

.message-menuTrigger
{
	display: inline-block;

	&:after
	{
		.m-menuGadget(); // 1em
		text-align: right;
	}

	&:hover:after
	{
		color: black;
	}
}

.message-menu-section
{
	&--editDelete
	{
		.menu-linkRow
		{
			font-weight: @xf-fontWeightHeavy;
			font-size: @xf-fontSizeNormal;
		}
	}
}

.message-menu-link
{
	&--delete i:after
	{
		.m-faContent(@fa-var-trash-alt);
	}
	&--edit i:after
	{
		.m-faContent(@fa-var-edit);
	}
	&--report i:after
	{
		.m-faContent(@fa-var-frown);
	}
	&--warn i:after
	{
		.m-faContent(@fa-var-exclamation-triangle);
	}
	&--spam i:after
	{
		.m-faContent(@fa-var-ban);
	}
	&--ip i:after
	{
		.m-faContent(@fa-var-sitemap);
	}
	&--history i:after
	{
		.m-faContent(@fa-var-history);
	}
	&--follow i:after
	{
		.m-faContent(@fa-var-user-plus);
	}
	&--ignore i:after
	{
		.m-faContent(@fa-var-user-times);
	}
	&--share i:after
	{
		.m-faContent(@fa-var-share-alt);
	}
}

// ############################# CUSTOM FOR MESSAGE VARIANTS ##############

.message-articleUserInfo
{
	.xf-messageUserBlock(no-border);
	border-top: @xf-messageUserBlock--border-width solid @xf-messageUserBlock--border-color;

	&:last-child
	{
		.m-borderBottomRadius(@block-borderRadius-inner);
	}

	.contentRow-figure
	{
		width: @xf-messageUserBlockWidth;
		text-align: center;
	}

	.contentRow-main
	{
		padding-left: 2 * (@xf-messagePadding);
		text-align: left;
	}

	@media (max-width: @xf-messageSingleColumnWidth)
	{
		.contentRow-figure
		{
			width: auto;
		}

		.contentRow-main
		{
			padding-left: @xf-paddingLarge;
		}
	}
}

.message-articleWrittenBy
{
	color: @xf-textColorMuted;
	font-size: @xf-fontSizeSmall;
}

.message-articleUserName
{
	font-weight: @xf-fontWeightHeavy;
	font-size: @xf-fontSizeLarger;
 	margin: 0;
	display: inline;
}

.message-articleUserBlurb,
.message-articleUserBlurb div
{
	font-size: @xf-fontSizeSmall;
	display: inline;
}

.message-articleUserAbout
{
	font-size: @xf-fontSizeSmall;
	margin: .5em 0;
}

.message-articleUserBanners .userBanner
{
	margin-bottom: 3px;
}

.message-articleUserStats
{
	font-size: @xf-fontSizeSmall;
	color: @xf-textColorMuted;
}

@media (max-width: @xf-responsiveNarrow)
{
	.message-articleUserStats
	{
		display: none;
	}
}

// ############################# COMMENTS ###############

.comment
{
}

.comment-inner
{
	display: table;
	table-layout: fixed;
	width: 100%;
}

.comment-avatar
{
	display: table-cell;
	width: 24px;
	vertical-align: top;

	.avatar,
	img
	{
		vertical-align: bottom;
	}
}

.comment-main
{
	display: table-cell;
	padding-left: @xf-messagePadding;
	vertical-align: top;
}

.comment-contentWrapper
{
	margin-bottom: @xf-messagePaddingSmall;
}

.comment-user
{
	font-weight: @xf-fontWeightHeavy;
}

.comment-body
{
	display: inline;
}

.comment-note
{
	color: @xf-textColorMuted;
	font-size: @xf-fontSizeSmallest;
}

.comment-input
{
	display: block;
	height: 2.34em;
	margin-bottom: @xf-messagePaddingSmall;
}

.comment-actionBar .actionBar-set
{
	margin-top: @xf-messagePaddingSmall;
	color: @xf-textColorMuted;
}

.comment-likes,
.comment-reactions
{
	.m-transitionFadeDown();

	margin-top: @xf-messagePaddingSmall;
	font-size: @xf-fontSizeSmaller;
}

// ################################## MESSAGE QUICK REPLY ADDITIONS #############

.formSubmitRow.formSubmitRow--messageQr
{
	.formSubmitRow-controls
	{
		text-align: center;
		padding-left: 0;
		padding-right: 0;
		margin-left: @xf-messagePadding;
		margin-right: @xf-messagePadding;

		@media (max-width: @xf-formResponsive)
		{
			text-align: right;
		}
	}
}

// ################################## MESSAGE NOTICES #############################

.messageNotice
{
	margin: @xf-messagePaddingSmall 0;
	padding: @xf-messagePaddingSmall @xf-messagePadding;
	.xf-contentAccentBase();
	font-size: @xf-fontSizeSmaller;
	border-left: @xf-borderSizeMinorFeature solid @xf-borderColorAttention;

	&.messageNotice--nested
	{
		border-left-width: @xf-borderSize;
	}

	&:not(.messageNotice--highlighted)
	{
		a,
		a:hover
		{
			.xf-contentAccentLink();
		}
	}

	&:before
	{
		display: inline-block;
		.m-faBase();
		padding-right: .2em;
		font-size: 125%;
		color: @xf-textColorAttention;
	}

	&.messageNotice--highlighted
	{
		.xf-contentHighlightBase();
		border-left-color: @xf-borderColorFeature;

		&:before
		{
			color: @xf-textColorFeature;
		}
	}

	&.messageNotice--deleted:before { .m-faContent(@fa-var-trash-alt); } // , .88em
	&.messageNotice--moderated:before { .m-faContent(@fa-var-shield); } // , 1em
	&.messageNotice--warning:before { .m-faContent(@fa-var-exclamation-triangle); } // , 1em
	&.messageNotice--ignored:before { .m-faContent(@fa-var-microphone-slash); } // , 1.25em
}

// ##################### MESSAGE VARIANTS/RESPONSIVE ##################

@media (min-width: @xf-responsiveEdgeSpacerRemoval)
{
	.block:not(.block--messages)
	{
		@{block-noStripSel} > .block-body:first-child > .message:first-child,
		.block-topRadiusContent.message,
		.block-topRadiusContent > .message:first-child
		{
			.message-inner:first-of-type .message-cell
			{
				&:first-child { border-top-left-radius: @block-borderRadius-inner; }
				&:last-child { border-top-right-radius: @block-borderRadius-inner; }
			}
		}

		@{block-noStripSel} > .block-body:last-child > .message:last-child,
		.block-bottomRadiusContent.message,
		.block-bottomRadiusContent > .message:last-child
		{
			.message-inner:last-of-type .message-cell
			{
				&:first-child { border-bottom-left-radius: @block-borderRadius-inner; }
				&:last-child { border-bottom-right-radius: @block-borderRadius-inner; }
			}
		}
	}
}

.block--messages
{
	.block-container
	{
		background: none;
		border: none;
	}

	.message,
	.block-row
	{
		.xf-contentBase();
		.xf-blockBorder();
		border-radius: @xf-blockBorderRadius;

		+ .message,
		+ .block-row
		{
			margin-top: @xf-blockPaddingV;
		}
	}

	.block-filterBar
	{
		.xf-blockBorder();
		border-radius: @xf-blockBorderRadius;
		margin-bottom: @xf-blockPaddingV;
	}

	.message-spacer
	{
		+ .message,
		+ .block-row
		{
			margin-top: @xf-blockPaddingV;
		}
	}

	.message-inner .message-cell
	{
		border-radius: 0;
	}

	.message-inner:first-of-type .message-cell
	{
		&:first-child { border-top-left-radius: @block-borderRadius-inner; }
		&:last-child { border-top-right-radius: @block-borderRadius-inner; }
	}

	.message-inner:last-of-type .message-cell
	{
		&:first-child { border-bottom-left-radius: @block-borderRadius-inner; }
		&:last-child { border-bottom-right-radius: @block-borderRadius-inner; }
	}

	@media (max-width: @xf-messageSingleColumnWidth)
	{
		.message-inner
		{
			.message-cell
			{
				border-radius: 0;
			}

			&:first-of-type .message-cell:first-child
			{
				border-top-left-radius: @block-borderRadius-inner;
				border-top-right-radius: @block-borderRadius-inner;
			}

			&:last-of-type .message-cell:last-child
			{
				border-bottom-left-radius: @block-borderRadius-inner;
				border-bottom-right-radius: @block-borderRadius-inner;
			}
		}

		.message--simple .message-cell--user + .message-cell
		{
			border-radius: 0;
			border-top-left-radius: @block-borderRadius-inner;
			border-top-right-radius: @block-borderRadius-inner;
		}
	}

	@media (max-width: @xf-responsiveEdgeSpacerRemoval)
	{
		.message,
		.block-row,
		.block-filterBar
		{
			border-left: none;
			border-right: none;
			border-radius: 0;
		}

		.message .message-inner .message-cell
		{
			border-radius: 0;

			&:first-child,
			&:last-child
			{
				border-radius: 0;
			}
		}

		.message--simple .message-cell--user + .message-cell
		{
			border-radius: 0;
		}
	}
}

.message--article
{
	&.is-moderated
	{
		background: @xf-contentHighlightBg;
	}

	&.is-deleted
	{
		opacity: .65;
	}
}

// article preview view for thread list
.message--articlePreview
{
	display: flex;
	flex-direction: column;
	min-width: 0;
	margin-bottom: @xf-paddingLarge;

	&:last-child
	{
		margin-bottom: 0;
	}

	.articlePreview-main
	{
		display: flex;
		flex-direction: column;
		flex: 1 1 auto;
	}

	.articlePreview-image
	{
		flex: 0 0 auto;
		align-self: center;
		width: 100%;
		max-width: 750px;
		background: center / cover @xf-contentAltBg no-repeat;
		text-decoration: none;

		&:after
		{
			content: \'\';
			display: block;
			padding-bottom: 75%;
		}

		& + .articlePreview-text
		{
			.bbImageWrapper,
			.bbImage
			{
				display: none;
			}
		}
	}

	.articlePreview-text
	{
		flex: 1 1 auto;
		display: flex;
		min-width: 0;
		flex-direction: column;
		padding: @xf-messagePadding;

		.bbWrapper
		{
			.m-fadeOutLines(8, @xf-contentBg);
		}
	}

	.articlePreview-title
	{
		margin: 0;
		font-size: @xf-fontSizeLarge;
	}

	.articlePreview-content
	{
		flex: 1 1 auto;
	}

	.articlePreview-links
	{
		text-align: right;
		padding-top: @xf-blockPaddingV;
	}

	.articlePreview-statuses
	{
		float: left;
		display: flex;
		list-style: none;
		margin: 0;
		padding: 0;

		> li
		{
			margin-right: 8px;
		}

		.message-newIndicator
		{
			font-size: @xf-fontSizeSmall;
		}
	}

	.articlePreview-footer
	{
		padding: 0 @xf-blockPaddingH;
	}

	.articlePreview-meta
	{
		display: flex;
		align-items: center;

		border-top: solid 1px @xf-borderColor;
		padding: @xf-blockPaddingV 0;

		color: @xf-textColorMuted;
		font-size: @xf-fontSizeSmall;

		> li
		{
			margin-right: @xf-blockPaddingH;

			&:last-child
			{
				margin-right: 0;
			}
		}
	}

	.articlePreview-replies
	{
		white-space: nowrap;
	}

	.articlePreview-by,
	.articlePreview-repliesLabel
	{
		display: none;
	}
}

.block--articles.block--messages.block--expanded
{
	.article-title
	{
		// from .p-title-value
		margin: 0 0 5px;
		font-size: @xf-fontSizeLargest;
		font-weight: @xf-fontWeightNormal;
	}

	.message-snippet-link
	{
		margin-top: .5em;
		text-align: center;
	}

	.message + .message
	{
		margin-top: @xf-paddingLargest;
	}
}

// expanded article grid behavior
@supports (display: grid)
{
	@media (min-width: @xf-responsiveMedium)
	{
		.block--previews .block-body
		{
			display: grid;
			gap: @xf-paddingLarge;
			grid-template-rows: auto;
			grid-template-columns: repeat(2, 1fr);
			grid-template-areas: "a a";

			> .message:first-of-type:last-of-type
			{
				grid-area: a;
			}

			> .message--articlePreview
			{
				margin-bottom: 0;

				// first five
				&:nth-of-type(-n+5)
				{
					.articlePreview-title
					{
						font-size: @xf-fontSizeLarger;
					}

					.articlePreview-image
					{
						max-width: none;

						&:after
						{
							padding-bottom: 60%;
						}
					}

					.articlePreview-meta
					{
						.articlePreview-by
						{
							display: block;
						}
					}
				}

				// first
				&:first-of-type
				{
					grid-area: a;

					.articlePreview-title
					{
						font-size: @xf-fontSizeLargest;
					}

					.articlePreview-meta
					{
						border-top: none;
					}

					.articlePreview-main
					{
						flex-direction: row-reverse;
					}

					.articlePreview-image
					{
						width: 50%;
					}
				}
			}
		}
	}

	// max width multi-columns
	.m-maxPreviewColumns()
	{
		.block--previews .block-body
		{
			grid-template-columns: repeat(4, 1fr);
			grid-template-areas:
				"a a a a"
				"b_1 b_1 b_2 b_2"
				"b_3 b_3 b_4 b_4";

			> .message:first-of-type:last-of-type
			{
				grid-area: a;
			}

			> .message--articlePreview
			{
				&:nth-of-type(1) { grid-area: a; }
				&:nth-of-type(2) { grid-area: b_1; }
				&:nth-of-type(3) { grid-area: b_2; }
				&:nth-of-type(4) { grid-area: b_3; }
				&:nth-of-type(5) { grid-area: b_4; }
			}
		}
	}

	.p-body-main:not(.p-body-main--withSidebar)
	{
		@media (min-width: @xf-responsiveWide)
		{
			.m-maxPreviewColumns();
		}
	}

	.p-body-main--withSidebar
	{
		@media (min-width: (@xf-responsiveWide + @xf-sidebarWidth))
		{
			.m-maxPreviewColumns();
		}
	}
}';
	return $__finalCompiled;
}
);