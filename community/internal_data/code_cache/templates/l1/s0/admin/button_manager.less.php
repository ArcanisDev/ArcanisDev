<?php
// FROM HASH: b6d7c472d755b61a2d5246d70b95e8df
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.fr-toolbar .fr-command.fr-btn + div.hr
{
	float: left;
	width: 100%;
	height: 11px;
	position: relative;

	&:before
	{
		content: \'\';
		display: block;
		position: absolute;
		top: 5px;
		bottom: 5px;
		left: 5px;
		right: 5px;
		background: @xf-borderColorLight;
	}
}

.toolbar--dragTarget
{
	display: flex;
	min-height: 40px;
	border: solid 1px @xf-borderColorLight;
	border-radius: @xf-borderRadiusMedium;
	padding: @xf-paddingSmall;

	.fr-btn
	{
		position: relative;
		display: inline-flex;
		width: 32px;
		height: 32px;
		align-items: center;
		justify-content: center;

		color: mix(@xf-textColor, @xf-textColorDimmed);
		border-radius: @xf-borderRadiusMedium;

		&.fr-dropdown
		{
			&:after
			{
				position: absolute;
				width: 0;
				height: 0;
				border-left: 4px solid transparent;
				border-right: 4px solid transparent;
				border-top: 4px solid @xf-editorButtonColor;
				right: 0;
				top: 14px;
				.m-transition(all, 0.3s);
				content: "";
			}
		}

		&.fr-btn-text
		{
			height: 35px;
			align-items: center;

			span:first-of-type
			{
				user-select: none;
			}
		}

		svg
		{
			width: 24px;
			height: 24px;
		}

		&[data-cmd="|"]
		{
			background: @xf-contentAltBg;
		}

		&:hover
		{
			color: @xf-textColor;
			background-color: @xf-contentAltBg;
		}
	}
}


.block-row--buttonGroup
{
	display: flex;

	.block-row--buttons
	{
		flex: 1 1 auto;
	}

	.block-row--buttonMenu
	{
		flex: 0 0 auto;

		.button.menuTrigger
		{
			margin-left: @xf-paddingLarge;
			padding-top: 10px;
			padding-bottom: 10px;
		}
	}
}

// mixin to generate 15x \'buttonsVisible\' rules, for up to 15 visible buttons before the \'more\' control
.bvRules (@i) when (@i >= 0)
{
	@j: @i + 1;
	.toolbar-option--buttonsVisible-@{i}
	{
		.fr-btn:nth-child(n + @{j})
		{
			opacity: .4;
		}
	}
	.bvRules(@i - 1);
}
.bvRules(15);

// left and right aligned toolbar options
.toolbar-option--align-right { justify-content: flex-end }

// we want to hide the attach button, as it is non-functional
.js-attachButton
{
	display: none !important;
}

' . $__templater->includeTemplate('public:dragula.less', $__vars);
	return $__finalCompiled;
}
);