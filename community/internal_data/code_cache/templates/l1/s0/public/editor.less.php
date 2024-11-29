<?php
// FROM HASH: a111e95bcf7b99ec213490c6c5a9a57c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '/* XF-RTL:disable */
' . $__templater->includeTemplate('editor_base.less', $__vars) . '
/* XF-RTL:enable */

@_editorBorderRadius: xf-default(@xf-input--border-radius, @xf-borderRadiusMedium);
@_editorBorderColor: var(--input-border-heavy) var(--input-border-light) var(--input-border-light) var(--input-border-heavy);
//@_editorFocusBorderColor: xf-default(@xf-inputFocus--border-top-color, @xf-borderColorHeavy) xf-default(@xf-inputFocus--border-right-color, @xf-borderColorLight) xf-default(@xf-inputFocus--border-bottom-color, @xf-borderColorLight) xf-default(@xf-inputFocus--border-left-color, @xf-borderColorHeavy);
@_editorButtonGroupHPadding: 12px;
@_editorButtonGroupHPaddingSmall: 6px;

.fr-box.fr-basic
{
	background: @xf-editorBg;
	border: solid 1px @xf-borderColor;
	border-color: @_editorBorderColor;
	.border-radius(@_editorBorderRadius);

	.fr-toolbar.fr-top
	{
		background: @xf-editorToolsBg;
	}

	&.is-focused
	{
		background: @xf-editorFocusBg;
		//border-color: @_editorFocusBorderColor;

		.fr-element
		{
			color: @xf-editorFocusColor;
		}

		.fr-toolbar.fr-top
		{
			background: @xf-editorToolsFocusBg;
		}
	}

	// regular border instead of an \'input\' border
	&.is-preview,
	&.is-preview .fr-toolbar .fr-btn-grp.rte-tab--preview
	{
		background: @xf-contentBg;
		border-color: @xf-borderColor;
	}

	.fr-wrapper
	{
		border: none;
	}

	.fr-element
	{
		.m-inputZoomFix();
		padding-top: @editor-padding / 2;
	}
}

.fr-toolbar
{
	@_more-spacer: 4px;

	display: flex;
	flex-wrap:  wrap;
	border: none;
	background: transparent;
	.border-radius(@_editorBorderRadius @_editorBorderRadius 0 0);

	.fr-command.fr-btn
	{
		display: inline-flex;
		align-items: center;
		justify-content: center;

		// context sensitivity for toolbar buttons (highlight [B] when cursor is on bold text etc.)
		&.fr-active:not(.fr-disabled)
		{
			color: @xf-editorButtonActiveColor;
		}

		// de-emphasize the \'more\' buttons slightly
		&[data-cmd^="more"]
		{
			opacity: 0.5;

			&.fr-open
			{
				opacity: 1
			}

			i
			{
				width: 16px;
			}
		}

		&.fr-dropdown
		{
			margin-right: 8px;

			&:last-of-type
			{
				margin-right: 2px;
			}
		}
	}

	// BUTTON GROUP HANDLING
	.fr-btn-grp
	{
		// using CSS variables here but we have a fallback for older browsers (for now)
		--hpadding: @_editorButtonGroupHPadding;

		display: inline-flex;

		border-style: solid;
		border-width: 0px;
		border-color: @_editorBorderColor;

		margin: 0;
		padding: @_more-spacer 0 0 @_editorButtonGroupHPadding; // basic padding for older browsers
		padding: @_more-spacer 0 0 var(--hpadding);

		// hide empty groups completely, just in case we have alternative padding specified later on
		&:empty
		{
			padding: 0 !important;
		}

		//&:nth-child(even)
		//{
		//	background: rgba(0,0,0,.05);
		//}

		&.fr-float-left
		{
			+ .fr-btn-grp.fr-float-right:not(.rte-tab--preview)
			{
				flex: 1 1 0;
				justify-content: flex-end;
			}
		}

		&.rte-tab--beforePreview
		{
			padding-right: @_editorButtonGroupHPadding;
			padding-right: var(--hpadding);

			&.fr-float-left
			{
				// make sure this expands to fill the space so the preview border is correct
				flex-grow: 1;
			}
		}

		// tabify inactive groups
		&.rte-tab--inactive
		{
			border-bottom-width: 1px;
		}

		&.rte-tab--preview
		{
			border-left-width: 1px;
			.border-radius(0 @_editorBorderRadius 0 0);

			// pad the button to make it fill the tab
			// normally padding: 4px, 17px, 0, 22px; margin: 0;
			padding: 0 !important;

			.fr-command.fr-btn
			{
				padding: 4px (@_editorButtonGroupHPadding + 5px) 0px (@_editorButtonGroupHPadding + 5px);
				padding: 4px ~\'calc(var(--hpadding) + 5px)\' 0px ~\'calc(var(--hpadding) + 5px)\';
				height: 36px;
				.border-radius(0 @_editorBorderRadius 0 0);

				&:hover
				{
					background: transparent;
				}
			}
		}
	}

	.fr-newline
	{
		margin: 0;
	}

	// \'more\' toolbar stuff
	.fr-command.fr-btn.fr-open
	{
		margin-top: @btn-margin;
		padding-bottom: @_more-spacer;
		height: (@btn-height + @_more-spacer);
	}

	.fr-more-toolbar
	{
		position: absolute;
		bottom: 0;

		&[style*="padding-left: 0px"]
		{
			// Padding is used on the more toolbar for button alignment. If it\'s 0 then we don\'t want
			// the buttons to be jammed up against the edge.
			padding-left: @_editorButtonGroupHPaddingSmall !important;
		}
	}
}

.fr-separator
{
	float: none;
	display: inline-flex;
	align-items: center;
	justify-content: center;
	background-color: @xf-editorButtonDisabledColor;

	&.fr-vs
	{
		height: @btn-height - @btn-margin * 2;
		margin: 4px;
	}

	.fr-toolbar > &
	{
		// hide separators directly under the toolbar rather in groups - this only happens as
		// a resize quirk
		display: none;
	}
}

// RTE disabled (BB code mode) styling
.fr-box textarea.input
{
	border: none;
	background: none;
}

// some adjustments for different screen resolutions
.fr-box.fr-basic
{
	&[data-size="XL"],
	&[data-size="LG"],
	&[data-size="MD"]
	{
		.fr-btn-grp
		{
			padding-right: @_editorButtonGroupHPadding;
		}
	}

	// shrink the \'Preview\' padding at smaller resolutions
	&[data-size="SM"],
	&[data-size="XS"]
	{
		.fr-btn-grp
		{
			--hpadding: @_editorButtonGroupHPaddingSmall;
		}
	}

	// show the \'Preview\' text on the preview tab at larger resolutions
	// this width is defined by the width of the page 50px larger than the size at which quick reply turns on the full-size toolbar
	@media (min-width: 1132px)
	{
		&[data-size="XL"] .rte-tab--preview span.fr-sr-only
		{
			font-size: 13px;

			// undo the original class
			position: static;
			width: auto;
			height: auto;
			clip: auto;
			overflow: visible;
			margin: 0;
		}
	}
}



.fr-toolbar,
.fr-popup,
.fr-modal
{
	// make FontAwesome iconography respect btn-font-size
	.fr-command.fr-btn i
	{
		font-size: @xf-editorButtonSize;
	}

	// improve positioning of FA buttons
	.fr-tabs .fr-command.fr-btn i
	{
		margin: ((@popup-tab-button-height - @popup-btn-svg-size) / 2) ((@popup-tab-button-width - @popup-btn-svg-size) / 2);
	}

	.fr-command.fr-btn svg path
	{
		fill: currentColor;
		.m-transition(none);
	}

	// adjust separator height in this scenario to match button height
	.fr-tabs .fr-separator.fr-vs
	{
		margin-top: 2px;
		margin-bottom: 2px;
	}

	// some elements briefly flash through dropdowns on transition
	z-index: 3;
}

.fr-command.fr-btn + .fr-dropdown-menu .fr-dropdown-wrapper .fr-dropdown-content
{
	ul.fr-dropdown-list li a i
	{
		font-size: @xf-editorButtonSize;
		margin: 8px 7px;
	}
}

// setup visuals in the editor match visuals in messages
.fr-view
{
	img.fr-draggable:not(.smilie),
	.bbImage
	{
		max-width: 100%;
		height: auto;
	}

	.fr-video
	{
		position: relative;

		video
		{
			width: 560px;
			max-width: 100%;
		}
	}

	.fr-audio
	{
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;

		audio
		{
			width: 560px;
			max-width: 100%;
		}
	}

	p
	{
		margin-bottom: 0;
		margin-top: 0;
	}

	&.fr-element
	{
		.fr-disabled
		{
			.xf-inputDisabled() !important;
		}

		@attach-margin: @xf-bbCodeImgFloatMargin;
		@attach-margin-after: @xf-bbCodeImgFloatMarginAfter;

		img.fr-dii
		{
			display: inline-block;
			float: none;
			margin: 0;
			max-width: 100%;

			&.fr-fil
			{
				float: left;
				margin: @attach-margin @attach-margin-after @attach-margin-after 0;
				max-width: calc(~\'100% - @{attach-margin}\');
			}

			&.fr-fir
			{
				float: right;
				margin: @attach-margin 0 @attach-margin-after @attach-margin-after;
				max-width: calc(~\'100% - @{attach-margin}\');
			}
		}

		.fr-video.fr-dvi
		{
			display: inline-block;
			float: none;
			margin-left: @attach-margin;
			margin-right: @attach-margin;
			max-width: calc(~\'100% - (2 * @{attach-margin})\');
			outline: @xf-borderSize solid @xf-borderColorLight;

			&.fr-fvl
			{
				float: left;
				margin: @attach-margin @attach-margin-after @attach-margin-after 0;
				max-width: calc(~\'100% - @{attach-margin}\');
			}

			&.fr-fvr
			{
				float: right;
				margin: @attach-margin 0 @attach-margin-after @attach-margin-after;
				max-width: calc(~\'100% - @{attach-margin}\');
			}
		}
	}

	.m-tableBase();

	h2,
	h3,
	h4
	{
		margin: .5em 0;
		clear: both;
	}

	h2 { font-size: @xf-fontSizeLargest; }
	h3 { font-size: @xf-fontSizeLarger; }
	h4 { font-size: @xf-fontSizeLarge; }

	hr
	{
		border: none;
		border-top: @xf-borderSize solid @xf-borderColorHeavy;
		clear: both;
	}

	// quote tag emulation
	blockquote
	{
		.xf-bbCodeBlock();
		margin: .5em 0;
		padding: @xf-paddingMedium @xf-paddingLarge;
		font-size: @xf-fontSizeSmall;
		display: flow-root;

		.m-tableBase();

		&:first-child
		{
			margin-top: 0;
		}

		&:last-child
		{
			margin-bottom: 0;
		}

		&[data-quote]
		{
			&:before
			{
				display: block;
				content: attr(data-quote) "' . $__templater->escape($__vars['xf']['language']['label_separator']) . '";
				.xf-bbCodeBlockTitle();
				padding: @xf-paddingMedium @xf-paddingLarge;
				margin: -@xf-paddingMedium -@xf-paddingLarge @xf-paddingMedium -@xf-paddingLarge;
				// this margin combination makes the attribution take the full width and have bottom padding
			}
		}
	}
}

// try to make Froala inputs look like ours
.fr-popup
{
	.fr-input-line
	{
		padding: 18px 0 8px;

		input[type="text"],
		textarea
		{
			.xf-input();
			margin: 0;
			line-height: @xf-lineHeightDefault;
			.m-transition(background, color;);
			height: auto;

			&:hover
			{
				.xf-input(border);
			}

			&:focus
			{
				.xf-input(border);
				.xf-input(padding);
				.xf-inputFocus();
			}

			.m-inputZoomFix();
		}

		input + label,
		textarea + label
		{
			line-height: 1.2;
			font-size: 12px;
			color: fade(xf-default(@xf-input--color, @xf-textColor), 40%);
			background: transparent;
			top: 28px;
		}

		input.fr-not-empty + label,
		textarea.fr-not-empty + label
		{
			color: @xf-textColorMuted;
			top: 2px;
		}
	}

	.fr-action-buttons
	{
		height: auto;
		.m-frCommandStyle();
	}

	// fix FA selected color indicator
	.fr-color-set > span .fr-selected-color
	{
		.m-faBase();
	}
}

.fr-quick-insert
{
	padding-right: 0;
	margin-left: (@editor-padding / 2);

	// bring this into our z-index levels
	z-index: @zIndex-2;
}

// this toolbar is redundant and annoying
.fr-second-toolbar
{
	display: none;
}

.m-frCommandStyle()
{
	button.fr-command
	{
		.m-buttonBase();
		.xf-buttonPrimary();
		.m-buttonBlockColorVariationSimple(xf-default(@xf-buttonPrimary--background-color, transparent));

		height: auto;
		min-width: 0;
		line-height: @xf-lineHeightDefault;

		&:hover,
		&:active,
		&:focus
		{
			// overriding Froala\'s hover
			color: @xf-buttonPrimary--color;
		}
	}
}

// Fix for broken CSS in ui/popup.scss, plugin/image.scss, plugin/video.scss
// See: https://github.com/froala/wysiwyg-editor/issues/3878
.fr-popup textarea { resize: none; }

.fr-image-resizer
{
	&.fr-active { display: block; }

	.fr-handler
	{
		&.fr-hnw { cursor: nw-resize; }
		&.fr-hne { cursor: ne-resize; }
		&.fr-hsw { cursor: sw-resize; }
		&.fr-hse { cursor: se-resize; }
	}
}

.fr-box .fr-video-resizer
{
	&.fr-active { display: block; }

	.fr-handler
	{
		&.fr-hnw { cursor: nw-resize; }
		&.fr-hne { cursor: ne-resize; }
		&.fr-hsw { cursor: sw-resize; }
		&.fr-hse { cursor: se-resize; }
	}
}

// #### Smilies, emoji and GIF popup

@_menu-padding: @xf-paddingMedium;
@_menu-padding-large: @xf-paddingLarge;

.menu--emoji
{
	width: 412px;
}

.menu--gif
{
	width: 500px;
}

.menu--emoji,
.menu--gif
{
	max-width: calc(~\'100% - @{xf-pageEdgeSpacer}\');

	.menu-content
	{
		position: relative;
	}

	.menu-scroller
	{
		max-height: 250px;
		border-top: 0;
	}

	.menu-row
	{
		padding: @_menu-padding @_menu-padding;

		&.menu-row--insertedMessage
		{
			.m-hiddenEl(true);
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			border-bottom: @xf-borderSize solid @xf-borderColorLight;
		}

		&.menu-row--search
		{
			border-bottom: @xf-borderSize solid @xf-borderColor;
		}
	}

	.menu-emojiInsertedMessage
	{
		display: flex;
		align-items: center;
		justify-content: center;
		min-height: 35px;
		font-size: @xf-fontSizeNormal;

		img { max-height: 32px; }
		span { margin-left: .5em }
	}

	.menu-header
	{
		background: none;
		.xf-formSectionHeader();
		background-color: @xf-contentBg;
		z-index: @zIndex-1;
		font-size: @xf-fontSizeNormal;
		position: -webkit-sticky;
		position: sticky;
		padding: @_menu-padding @_menu-padding-large;
		top: 0;
	}

	.block-body--emoji
	{
		border-top: @xf-borderSize solid @xf-borderColorLight;
	}

	.is-hidden
	{
		display: none;
	}
}

.emojiList
{
	.m-listPlain();

	display: flex;
	flex-wrap: wrap;
	justify-content: flex-start;

	margin-right: -3px;
	margin-bottom: -3px;

	> li
	{
		min-width: 32px;
		margin-right: 3px;
		margin-bottom: 3px;

		.border-radius(@xf-borderRadiusMedium);
		cursor: pointer;

		&:hover,
		&:focus
		{
			background-color: @xf-paletteColor2;
		}

		a
		{
			min-width: 32px;
			height: 32px;
			font-size: 24px;

			display: flex;
			justify-content: center;
			align-items: center;
			cursor: pointer;
			overflow: hidden;

			&:hover,
			&:focus
			{
				text-decoration: none;
			}

			img
			{
				max-height: 32px;
			}

			.smilie.smilie--emoji
			{
				width: 22px;
			}

			.smilie--lazyLoad
			{
				visibility: hidden;
			}
		}
	}
}

// ### Editor placeholder system (where the editor is hidden until clicked)

.editorPlaceholder
{
	.is-hidden
	{
		display: none;
	}

	cursor: text;

	.editorPlaceholder-placeholder
	{
		.input
		{
			padding: @xf-paddingLarge;

			span
			{
				&:before
				{
					.m-faBase();
					.m-faContent(@fa-var-pen);
				}
			}
		}
	}
}

// ### Editor draft saving indicator

.editorDraftIndicator
{
	.m-transition();
	opacity: 0;
	position: absolute;
	bottom: 6px;
	right: 8px;
	width: 8px;
	height: 8px;
	border-radius: 4px;
	background: rgb(127, 185, 0);

	&.is-active
	{
		opacity: 1;
	}
}

.xfPreview
{
	.m-clearFix();
}';
	return $__finalCompiled;
}
);