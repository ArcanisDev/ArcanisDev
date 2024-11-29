<?php
// FROM HASH: f1aeb943f90f9518133ff07f28287022
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.select2-hidden-accessible
{
	border: 0 !important;
	clip: rect(0 0 0 0) !important;
	height: 1px !important;
	margin: -1px !important;
	overflow: hidden !important;
	padding: 0 !important;
	position: absolute !important;
	width: 1px !important;
}

.select2
{
	line-height: normal;

	*:focus
	{
		outline: none;
	}

	.select2-selection
	{
		padding: 0;
		margin: 0;
		display: block;

		&.input
		{
			cursor: text;
		}

		ul
		{
			list-style: none;
			margin: 0;
			padding: 0 5px;
			width: 100%;
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;

			display: inline-flex;
			flex-wrap: wrap;
			margin-bottom: 5px;

			> li
			{
				&.select2-selection__choice
				{
					float: left;

					font-size: 15px;
					border-radius: @xf-borderRadiusMedium;

					.xf-chip();

					margin-right: 5px;
					margin-top: 5px;
					padding: 0 5px;

					cursor: default;

					.select2-selection__choice__remove
					{
						font-size: 0;
						cursor: pointer;

						&:before
						{
							.m-faBase();
							font-size: 15px;
							.m-faContent("@{fa-var-times}\\20");
							opacity: .5;
							.m-transition(opacity);
						}

						&:hover:before
						{
							opacity: 1;
						}
					}
				}
			}

			.select2-search
			{
				flex-grow: 1;
				min-width: 0;

				&.select2-search--inline
				{
					float: left;
				}

				.select2-search__field
				{
					color: inherit;
					border: none;
					padding: 1px 0;
					margin-top: 5px;
					background: transparent;
					min-width: 100%;
					max-width: 100%;

					&:focus
					{
						outline: none;
					}
				}
			}
		}
	}
}

.select2-container
{
	display: inline-block;

	&.select2-container--disabled
	{
		.input
		{
			.xf-inputDisabled();
		}
	}

	&.select2-container--open
	{
		.select2-dropdown
		{
			-ltr-rtl-left: 0;

			&.select2-dropdown--above
			{
				border-bottom: none;
				border-bottom-left-radius: 0;
				border-bottom-right-radius: 0;
			}

			&.select2-dropdown--below
			{
				border-top: none;
				border-top-left-radius: 0;
				border-top-right-radius: 0;
			}
		}
	}
}

.select2-dropdown
{
	border-radius: @xf-borderRadiusSmall;
	box-sizing: border-box;
	display: block;
	position: absolute;
	-ltr-rtl-left: -100000px;
	width: 100%;
	z-index: 1051;
	padding-top: 2px;

	&.select2-dropdown--above
	{
		padding-bottom: 5px;

		.select2-results__option.loading-results:not(:last-child)
		{
			display: none;
		}
	}
}

.select2-results
{
}

.select2-results__options
{
	display: block;
	.m-listPlain();
}

.select2-results > .select2-results__options
{
	// applies only to the top-level results
	.m-autoCompleteList();

	overflow: auto;
	max-height: 150px;
	max-height: ~"max(150px, 50vh)";
	-webkit-overflow-scrolling: touch;

	li[role="group"]
	{
		padding: 0;
	}
}

.select2-results__options.select2-results__options--nested
{
	margin-left: .8em;

	li
	{
		padding-right: 0;
	}
}

.select2-results__group
{
	display: block;
	padding: @xf-paddingMedium;
}

.select2-results__option
{
	user-select: none;
	-webkit-user-select: none;

	&.select2-results__option--highlighted
	{
		background: @xf-contentHighlightBg;
	}

	&[aria-disabled="true"]
	{
		color: @xf-textColorMuted;
	}
}';
	return $__finalCompiled;
}
);