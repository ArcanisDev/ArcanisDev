<?php
// FROM HASH: a0d6686d280239c8b56b612970fc635d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.actionBar
{
	.m-clearFix();
}

.actionBar-set
{
	&.actionBar-set--internal
	{
		float: left;
		margin-left: -3px;

		> .actionBar-action:first-child
		{
			margin-left: 0;
		}
	}

	&.actionBar-set--external
	{
		float: right;
		margin-right: -3px;

		> .actionBar-action:last-child
		{
			margin-right: 0;
		}
	}
}

.actionBar-action
{
	display: inline-block;
	padding: 3px;
	border: 1px solid transparent;
	border-radius: @xf-borderRadiusMedium;
	margin-left: 5px;

	&:before
	{
		.m-faBase();
		font-size: 90%;
	}

	&.actionBar-action--menuTrigger
	{
		display: none;

		&.is-displayed
		{
			display: inline;
		}

		&:after
		{
			.m-menuGadget();
		}

		&.is-menuOpen
		{
			// get rid of text decoration when the menu opens
			text-decoration: none;
		}
	}

	&.actionBar-action--inlineMod
	{
		label
		{
			color: @xf-linkColor;
			font-size: 120%;
			vertical-align: -2px;
		}

		input
		{
			.m-checkboxAligner();
		}
	}

	&.actionBar-action--mq
	{
		&:before { .m-faContent("@{fa-var-plus}", .75em); margin-right: 3px; }

		&.is-selected
		{
			background-color: @xf-contentHighlightBg;
			border-color: @xf-borderColorHighlight;

			&:before { content: "@{fa-var-minus}"; }
		}
	}

	&.actionBar-action--postLink
	{
		text-decoration: inherit !important;
		color: inherit !important;
	}

	&.actionBar-action--reply:before { .m-faContent("@{fa-var-reply}", 1.125em); margin-right: 3px; }
	&.actionBar-action--like:before { .m-faContent("@{fa-var-thumbs-up}", 1em); margin-right: 3px; }

	&.actionBar-action--reaction:not(.has-reaction) .reaction-text
	{
		color: inherit;
	}

	&.actionBar-action--view
	{
		background: @xf-contentBg;
		color: @xf-linkColor;
		.m-buttonBorderColorVariation(@xf-borderColor);
		padding-left: @xf-paddingLarge;
		padding-right: @xf-paddingLarge;

		&:hover,
		&:active,
		&:focus
		{
			text-decoration: none;
			background: @xf-contentHighlightBg;
		}
	}
}

@media (max-width: @xf-responsiveNarrow)
{
	.actionBar-action
	{
		&.actionBar-action--menuItem
		{
			display: none !important;
		}

		&.actionBar-action--menuTrigger
		{
			display: inline;
		}
	}
}';
	return $__finalCompiled;
}
);