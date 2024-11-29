<?php
// FROM HASH: c75ba067bf429c67e6f107b1e9399f3c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '// ################## INPUT TYPES LIST ####################

@__borderRadius: @xf-borderRadiusMedium;
@__borderColor: @xf-borderColorHeavy;
@__textColor: @xf-textColorMuted;
@__tabBackground: @xf-contentBg;

.inputTypes
{
	.m-listPlain();

	display: flex;
	flex-wrap: wrap;
	padding: 0 (2 * @xf-paddingLarge);
	border-bottom: solid 1px @__borderColor;
	color: @__textColor;
	font-size: @xf-fontSizeSmall;
}

.inputTypes-title
{
	font-weight: bold;
}

.inputTypes-type
{
	display: block;
}

.inputTypes-input
{
	.m-visuallyHidden();
}

.inputTypes-display
{
	display: flex;
	justify-content: center;
	padding: @xf-paddingMedium @xf-paddingLarge;
	border-radius: @__borderRadius @__borderRadius 0 0;
	border: solid 1px transparent;
	cursor: pointer;
	min-width: 110px;
	position: relative;
	top: 1px;
	margin-right: -1px;
}

.inputTypes-input:checked + .inputTypes-display,
.inputTypes-display:hover
{
	color: @xf-inputTextColor;
	border-color:  @__borderColor;
	background: linear-gradient(180deg, @xf-inputBgColor, @__tabBackground);
}

.inputTypes-input:checked + .inputTypes-display
{
	border-bottom-color: @xf-contentBg;
}

.inputTypes-icon
{
	margin-right: 6px;
}

.inputTypes-defaultIcon
{
	.m-faBase();
	.m-faBefore(@fa-var-comment-dots);
}

.inputTypes--tall
{
	.inputTypes-display
	{
		flex-direction: column;
		align-items: center;
	}

	.inputTypes-icon
	{
		font-size: 40px;
		line-height: 1;
		margin-right: 0;
		padding-bottom: 3px;
	}
}

.inputTypesScroller
{
	.inputTypes
	{
		display: inline-flex;
		min-width: 100%;
		flex-wrap: nowrap;
	}

	.hScroller-action
	{
		.m-hScrollerActionColorVariation(
			@xf-contentBg,
			@xf-linkColor,
			@xf-linkHoverColor
		);
	}
}

@media (max-width: @xf-responsiveMedium)
{
	.inputTypes
	{
		padding-left: 0;
		padding-right: 0;
	}
}';
	return $__finalCompiled;
}
);