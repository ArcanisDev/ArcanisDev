<?php
// FROM HASH: 05c4dcdeb17c98b4a4aded617b025bbf
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.formRow.formRow--permissionQuickSet
{
	> dt,
	> dd
	{
		padding-bottom: 0;
	}
}

.permissionChoices
{
	.m-listPlain();
	.m-clearFix();

	> li
	{
		float: left;
		margin-left: 1em;

		&:first-child
		{
			margin-left: 0;
		}
	}
}

.permissionChoices-choice
{
	border: 1px solid transparent;
	border-radius: @xf-borderRadiusMedium;

	&.is-selected
	{
		box-shadow: 1px 1px 5px rgba(0,0,0, .25);

		&.permissionChoices-choice--inherit
		{
			border-color: rgb(199, 199, 199);
			background:   rgb(237, 237, 237);
			color:        rgb(112, 112, 112);
		}

		&.permissionChoices-choice--yes
		{
			border-color: rgb(54, 150, 54);
			background:   rgb(68, 187, 68);
			color:        rgb(196, 253, 196);
		}

		&.permissionChoices-choice--no
		{
			border-color: rgb(229, 149, 36);
			background:   rgb(236, 178, 95);
			color:        rgb(252, 244, 232);
		}

		&.permissionChoices-choice--never
		{
			border-color: rgb(151, 12, 12);
			background:   rgb(203, 16, 16);
			color:        rgb(250, 194, 194);
		}

		label.iconic input + i
		{
			color: inherit;
		}
	}
}

.permissionChoices--flag
{
	label
	{
		display: block;
		min-width: 90px;
		text-align: center;
		padding: 0 @xf-paddingMedium;
	}

	.iconic i
	{
		position: relative;
		vertical-align: top;
	}
}

.permissionChoices--int
{
	.permissionChoices-choice--yes,
	.permissionChoices-choice--inherit
	{
		label
		{
			display: inline-block;
			line-height: 27px;
			padding: 0 @xf-paddingMedium;
			min-width: 90px;
			text-align: center;
		}

		.iconic i
		{
			position: relative;
			vertical-align: top;
		}
	}

	.inputGroup.inputGroup--joined
	{
		position: relative;

		.inputGroup-text
		{
			&.inputNumber-button
			{
				&.inputNumber-button--up
				{
					border-left: 0;
				}
			}
		}

		.input--number
		{
			display: inline;
			width: 80px;
			padding-top: @xf-paddingSmall;
			padding-bottom: @xf-paddingSmall;
		}
	}

	.permissionChoices-choice--int
	{
		&.is-disabled .inputGroup-text
		{
			.xf-inputDisabled(background);
		}

		&.is-disabled .permissionChoices-choiceIntLabel
		{
			display: block;
		}

		&.is-selected .input[type=number],
		&.is-selected .input[type=tel]
		{
			.xf-inputFocus();
		}
	}
}

.permissionChoices-choiceIntLabel
{
	display: none;
	position: absolute;
	top: 0;
	bottom: 0;
	left: 0;
	right: 0;
}

@media (max-width: @xf-responsiveNarrow)
{
	.permissionChoices--flag,
	.permissionChoices--int .permissionChoices-choice--inherit
	{
		label
		{
			min-width: 0;
		}
	}
}';
	return $__finalCompiled;
}
);