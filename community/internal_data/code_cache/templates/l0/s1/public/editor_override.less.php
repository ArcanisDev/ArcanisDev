<?php
// FROM HASH: eae45ecd1460312ccb743a6aadf617bd
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '// Generic
@font-family: @xf-fontFamilyUi; // font family for Froala UI elements // Arial, Helvetica, sans-serif;
@border-radius: @xf-borderRadiusSmall; // used for tooltips, menus... // 2px;
@bg-color: @xf-editorToolsOverflowBg; // used for the background of the \'more\' strip? // @bg-color: #f5f5f5;

// UI colors
@ui-color:  @xf-editorImageHandles; // used seemingly randomly for some icons, some borders, some drag handles... // #0098f7;
@ui-text: @xf-textColor; // #222222; // used for \'Drop x here\' type buttons
@ui-hover-color: @xf-contentAltBg; // used for the \'drop image\' box // mix(@white, #999, 80%);
@ui-disabled-color: @xf-editorButtonDisabledColor; // mix(@white, #000, 74%);
@ui-active-color: @xf-majorHeadingBg; // background for active controls (dropdown deployed etc.)? // #d6d6d6;
@ui-bg: @xf-contentBg; // @white;
@ui-border-color: @xf-textColor; // @ui-text;
@ui-bg-color: @xf-textColor;
@ui-bg-color-more: @xf-editorToolsOverflowBg; // @bg-color;

// Tooltip
@tooltip-bg: xf-default(@xf-tooltip--background-color, fade(@xf-paletteNeutral3, 80%)); // @ui-text;
@tooltip-text: xf-default(@xf-tooltip--color, contrast(@xf-paletteNeutral3)); // @white;
@tooltip-font-size: xf-default(@xf-tooltip--font-size, @xf-fontSizeSmaller); // 11px;
@tooltip-line-height: @tooltip-font-size * 2.5; // 22px;

// Editor properties.
@editor-padding: 20px; // 20px;
@editor-bg: transparent; // @white
@editor-font-family: @xf-fontFamilyBody; // sans-serif;
@editor-font-color: @xf-editorColor; // #414141;
@editor-font-size: @xf-fontSizeNormal; // 14px;
@editor-line-height: @xf-lineHeightDefault; // 1.6;
@editor-border: solid 1px @xf-borderColor; // 1px solid @gray;
@editor-border-radius: xf-default(@xf-input--border-radius, @xf-borderRadiusMedium); // 10px;
@editor-align: left;

// Text selection colors.
@selection-bg: @xf-editorSelectionBg;
@selection-text: @xf-editorSelectionColor;

// Placeholder properties.
@placeholder-color: fade(xf-default(@xf-input--color, @xf-textColor), 40%); // #AAA;

// Button colors.
@btn-text: @xf-editorButtonColor; // @light-black;
@btn-hover-text: @xf-editorButtonHoverColor; // @light-black;
@btn-hover-bg: @xf-editorButtonHoverBg; // #ebebeb;
@ui-focused-color: @xf-editorButtonSelectedBg; // mix(@white, #999, 60%);

@btn-active-text: @xf-editorButtonActiveColor; // @ui-color;
@btn-active-bg: @xf-majorHeadingBg; // @ui-active-color;
@btn-active-hover-text: @xf-editorButtonActiveColor; // @btn-active-text;

@btn-disabled-color: @xf-editorButtonDisabledColor; // @ui-disabled-color;
@btn-disabled-opacity: 0.95;

// Button size.
@btn-width: 30px;
@btn-height: 32px;
@btn-margin: 2px;
@btn-more-toolbar-height: 26px;

// Table properties.
@table-border: 1px solid @xf-borderColor; // 1px solid #DDD;
@table-resizer: 1px solid @xf-editorButtonActiveColor; // 1px solid @ui-color;

@toolbar-transition-timing: @xf-animationSpeed;

@popup-layer-margin: 10px;';
	return $__finalCompiled;
}
);