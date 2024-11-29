<?php
// FROM HASH: aa876acd43d4a4b911f6f3fd6b561cc2
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '/***** froala.less *****/

/***** variables.less *****/


// Theme Name.
@theme: \'theme\';

// Generic.
@white: #FFF;
@light-black: #333333;
@black: #000;
@gray: #CCCCCC;
@dark-grey: #999999;
@font-family: Arial, Helvetica, sans-serif;
@border-radius: 2px;
@transition-timing: 0.2s ease 0s;
@bg-color: #f5f5f5;

// UI colors
@ui-color: #0098f7;
@ui-text: #222222;
@ui-hover-light-color: mix(@white, #999, 90%);
@ui-hover-color: mix(@white, #999, 80%);
@ui-focused-color: mix(@white, #999, 60%);
@ui-disabled-color: mix(@white, #000, 74%);
@ui-active-color: #d6d6d6;
@ui-bg: @white;
@ui-font-size: 14px;
@ui-border-color: @ui-text;
@ui-border-top: 5px solid @ui-border-color;
@ui-border-hover-color:#515151;
@ui-bg-color: #efefef;
@ui-svg-size: 24px;
@ui-box-shadow: 0 3px 1px -2px rgba(0,0,0,.2), 0 2px 2px 0 rgba(0,0,0,.14), 0 1px 5px 0 rgba(0,0,0,.12);
@ui-bg-color-more: @bg-color;

// Separator
@separator-size: 1px;
@separator-color: mix(@white, #999, 80%);
@separator-margin: 8px 4px;

// Toolbar
@toolbar-transition-timing: 0.5s;
@toolbar-newline-margin: 9px;
@toolbar-newline-height: 1px;
@toolbar-newline-color: @ui-bg-color;
@btn-more-open-margin-top: 10px;
@btn-more-open-margin-bottom: -1px;
@btn-size: 36px;

// Logo
@logo-svg-height: 20px;
@logo-svg-width: 47px;
@logo-svg-margin: 7px 0;
@logo-transition-timing: 0.3s;
@logo-span-padding: 11px 5px 10px 15px;
@logo-span-font-size: 12px;
@logo-color: #b1b2b7;

// Screen sizes.
@screen-xs: 480px;
@screen-sm: 768px;
@screen-md: 992px;
@screen-lg: 1200px;
@screen-xs-max: (@screen-sm - 1);
@screen-sm-max: (@screen-md - 1);
@screen-md-max: (@screen-lg - 1);
@screen-lg-max: \'auto\';

// Tooltip
@tooltip-bg: @ui-text;
@tooltip-text: @white;
@tooltip-font-size: 11px;
@tooltip-line-height: 22px;

// Editor properties.
@editor-padding: 20px;
@editor-bg: @white;
@editor-font-family: sans-serif;
@editor-font-color: #414141;
@editor-font-size: 14px;
@editor-line-height: 1.6;
@editor-shadow-level: 1;
@editor-border: 1px solid @gray;
@editor-border-radius: 10px;
@editor-align: left;

// Text selection colors.
@selection-bg: rgba(181, 214, 253, 0.8);
@selection-text: #000;

// Placeholder properties.
@placeholder-size: @editor-font-size;
@placeholder-font-family: @editor-font-family;
@placeholder-color: #AAA;

// Button colors.
@btn-text: @light-black;
@btn-hover-text: @light-black;
@btn-hover-bg: #ebebeb;

@btn-active-text: @ui-color;
@btn-active-bg: @ui-active-color;
@btn-active-hover-text: @btn-active-text;

@btn-selected-text: @btn-text;
@btn-selected-bg: @ui-focused-color;

@btn-disabled-color: @ui-disabled-color;
@btn-disabled-opacity: 0.3;

// Button size.
@btn-width: 38px;
@btn-height: 40px;
@btn-margin: 4px;
@btn-font-size: 24px;
@btn-more-toolbar-height: 34px;
@btn-border-radius: 4px;
@btn-dropdown-border-radius: 0 @btn-border-radius @btn-border-radius 0;
@btn-hover-border-radius: @btn-border-radius 0 0 @btn-border-radius;
@btn-svg-size: @ui-svg-size;
@btn-tab-border-radius: 6px 6px 0 0;

// Second toolbar.
@more-toolbar-margin: 0 17px 0 12px;
@more-toolbar-margin-sm: 0 7px 0 6px;
@more-toolbar-btn-height: @btn-height + (@btn-margin * 2);

// Image.
@image-margin: 5px;
@image-padding: 0 1px;

// Image and Video
@handler-size: 12px;
@handler-size-lg: 10px;

// Code View
@code-view-bg: @white;
@code-view-text: @black;

// Table properties.
@table-border: 1px solid #DDD;
@table-resizer: 1px solid @ui-color;

// Insert table grid.
@insert-table-grid: @table-border;

// Quick insert.
@floating-btn-bg: @white;
@floating-btn-text: @light-black;
@floating-btn-hover-bg: @btn-hover-bg;
@floating-btn-hover-text: @floating-btn-text;
@floating-btn-size: 40px;
@floating-btn-font-size: 14px;
@floating-btn-border: none;
@floating-svg-btn-size: @ui-svg-size;
@floating-svg-btn-margin: 8px;
@floating-btn-padding: 6px 10px 10px 10px;
@floating-btn-box-shadow: @ui-box-shadow;

@quick-insert-padding-right: 10px;

// List menu.
@dropdown-arrow-width: 4px;
@dropdown-max-height: 275px;
@dropdown-options-width: 16px;
@dropdown-options-margin-left: -5px;
@dropdown-options-border-left: solid 1px #FAFAFA;
@dropdown-transition-timing: 0.3s;
@dropdown-border-radius: 4px;
@dropdown-list-padding: 8px 0;
@dropdown-list-min-width: 72px;
@dropdown-list-item-font-size: 15px;
@dropdown-menu-box-shadow: @ui-box-shadow;

// Image manager.
@modal-bg: @white;
@modal-overlay-color: @black;
@modal-head-height: 56px;
@modal-head-padding: 0 10px;
@modal-btn-padding: (@floating-btn-size - @floating-svg-btn-size) / 2;
@modal-btn-margin-top: 10px;
@modal-tags-border-radius: 32px;
@modal-tags-padding: 0 20px;
@modal-link-tags-padding: 6px 12px;
@modal-link-tags-margin: 8px 0 8px 8px;
@modal-selected-tag-bg: #EcF5Ff;
@modal-wrapper-border-radius: 10px;
@modal-wrapper-margin-lg: 20px auto;
@modal-wrapper-margin-md: 50px auto;
@modal-wrapper-margin-sm: 30px auto;
@modal-wrapper-box-shadow: 0 3px 5px -1px rgba(0,0,0,.2), 0 6px 10px 0 rgba(0,0,0,.14), 0 1px 18px 0 rgba(0,0,0,.12);
@modal-head-min-height: 42px;
@modal-close-margin: 10px;
@modal-heading-font-size: 20px;
@modal-heading-padding: 19px 10px;
@modal-body-min-width: 150px;
@modal-body-btn-height: @btn-size;
@modal-body-btn-padding: 10px;
@modal-body-padding-bottom: 20px;
@modal-head-line-height: 18px;
@modal-wrapper-min-width: 300px;
@modal-overlay-opacity: 0.5;

// Destroy buttons (delete in image manager).
@modal-destroy-btn-bg: #B8312F;
@modal-destroy-btn-text: @white;
@modal-destroy-btn-hover-bg: mix(contrast(@modal-destroy-btn-bg, @black, @white), @modal-destroy-btn-bg, 10%);
@modal-destroy-btn-hover-text: @white;

// Popups
@popup-layer-width: 260px;
@popup-border-radius: 6px;
@popup-min-width: 276px;
@popup-container-max-height: 200px;
@popup-icon-size: @ui-svg-size;
@popup-tab-button-width: 46px;
@popup-tab-button-height: @btn-height;
@popup-box-shadow: 0 3px 5px -1px rgba(0,0,0,.2), 0 6px 10px 0 rgba(0,0,0,.14), 0 1px 18px 0 rgba(0,0,0,.12);
@popup-action-btn-spacing: 10px;
@popup-margin-top: @popup-action-btn-spacing;
@popup-layer-margin: 20px;
@popup-action-button-font-size: 16px;
@popup-only-btn-padding: 6px 10px;
@popup-btn-svg-size: @ui-svg-size;
@popup-border-margin: 20px;
@popup-border-padding: 20px;
@popup-icon-font-size: 20px;
@popup-padding: 5px;
@popup-icon-padding: 6px;
@popup-emoticon-container-width: 368px;
@popup-sc-container-width: @popup-emoticon-container-width;
@popup-fa-container-width: 506px;
@popup-sm-ie-width: 236px;
@popup-fa-icon-size: 18px;
@popup-fa-icon-padding: 8px;
@popup-fa-icon-margin: 6px;
@popup-fa-icon-font-size: 16px;
@popup-fa-grid-icon-size: 45px;

// Inputs.
@input-border-color: @dark-grey;
@input-label-color: mix(@white, #000, 50%);
@input-line-padding: 15px 0;
@input-border-radius: 2px;
@input-border-width: 1px;
@input-focus-border-width: 2px;
@input-padding-left-right: 12px;
@input-padding-top-bottom: 4px;
@input-padding: @input-padding-top-bottom @input-padding-left-right;
@input-focus-padding: (@input-padding-top-bottom - @input-focus-border-width + @input-border-width) (@input-padding-left-right - @input-focus-border-width + @input-border-width);
@input-height: 46px;
@input-label-font-size: 14px;
@input-label-font-size-after: 11px;
@input-label-top: 29px;
@input-label-top-after: 9px;
@input-label-left: 12px;
@input-label-left-after: 4px;
@input-label-padding: 4px;
@input-margin-bottom: 1px;

// Checkbox
@checkbox-size: 18px;
@checkbox-padding: 10px;
@checkbox-margin: 2px;
@checbox-svg-size: 10px;
@checkbox-line-margin-top: 10px;
@checkbox-line-font-size: 14px;
@checkbox-line-label-margin: 0 5px;
@checkbox-line-height: 1.4px;
@checbox-active-bg: #EcF5Ff;
@checkbox-opacity: 0.8;

// Quote.
@blockquote-level1-color: #5E35B1;
@blockquote-level2-color: #00BCD4;
@blockquote-level3-color: #43A047;

// Char counter.
@char-counter-text-color: @dark-grey;
@char-counter-font-size: 14px;
@char-counter-font-family: sans-serif;
@char-counter-padding: 10px;

@drag-helper-border: solid 1px @ui-color;
@drag-helper-bg: @ui-color;

// Document ready.
@document-ready-padding: 30px;
@document-ready-bg-color: @ui-bg-color;

// Colors
@color-input-line-padding: 15px 0 0;
@color-action-button-padding: 17px 0 0;
@color-span-size: 32px;
@color-remove-svg-margin: 4px;
@color-line-height: 32px;
@color-font-size: 13px;

// Emoticons
@emoticon-tab-padding: 6px;
@emoticon-tab-btn-padding: 0 0 0 14px;

// Image Manager
@image-manager-list-margin: 0 20px;
@image-manager-not-available-padding: 12px 0;

//Special Character
@special-char-btn-padding: 10px 15px;



// ################# CUSTOM OVERRIDES ################
' . $__templater->includeTemplate('editor_override.less', $__vars) . '


/***** mixins.less *****/

.resize(@val) {
  resize: @val;
  -moz-resize: @val;
  -webkit-resize: @val;
}

.opacity(@opacity: 0.5) {
	-webkit-opacity: 	@opacity;
	-moz-opacity: 		@opacity;
	opacity: 		@opacity;
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
}

.transition(@transition...) {
	-webkit-transition: @transition;
	-moz-transition:    @transition;
	-ms-transition:     @transition;
	-o-transition:      @transition;
}

.transform(@string) {
	-webkit-transform: @string;
	-moz-transform: 	 @string;
	-ms-transform: 		 @string;
	-o-transform: 		 @string;
}

.box-sizing(@type: border-box) {
	-webkit-box-sizing: @type;
	-moz-box-sizing:    @type;
	box-sizing:         @type;
}

.border-radius(@radius: 0) {
  border-radius: @radius;
  -moz-border-radius: @radius;
  -webkit-border-radius: @radius;

  -moz-background-clip:    padding;
	-webkit-background-clip: padding-box;
	background-clip:         padding-box;
}

.user-select(@select) {
  user-select: @select;
  -o-user-select:@select;
  -moz-user-select: @select;
  -khtml-user-select: @select;
  -webkit-user-select: @select;
  -ms-user-select: @select;
}

.box-shadow(@shadow) {
  -webkit-box-shadow: @shadow;
  -moz-box-shadow: @shadow;
  box-shadow: @shadow;
}

.fr-clearfix {
  &::after {
    clear: both;
    display: block;
    content: "";
    height: 0;
  }
}

.fr-clearfix {
  &::after {
    clear: both;
    display: block;
    content: "";
    height: 0;
  }
}

.column-count(@count) {
  column-count: @count;
  -moz-column-count: @count;
  -webkit-column-count: @count;
}

.column-gap(@gap) {
  column-gap: @gap;
  -moz-column-gap: @gap;
  -webkit-column-gap: @gap;
}

.animation(@val) {
	-webkit-animation: @val;
  -moz-animation: @val;
  -o-animation: @val;
  animation: @val;
}

.handler-size(@size) {
  .fr-handler {
    width: @size;
    height: @size;

    &.fr-hnw {
      left: (-@size / 2);
      top: (-@size / 2);
    }

    &.fr-hne {
      right: (-@size / 2);
      top: (-@size / 2);
    }

    &.fr-hsw {
      left: (-@size / 2);
      bottom: (-@size / 2);
    }

    &.fr-hse {
      right: (-@size / 2);
      bottom: (-@size / 2);
    }
  }
}

.font-smoothing() {
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

.fr-hide-by-clipping {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0,0,0,0);
  border: 0;
}

.fr-hide-by-clipping {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0,0,0,0);
  border: 0;
}

.display-inline-flex() {

  display: -webkit-inline-flex;
  display: -ms-inline-flexbox;
  display: inline-flex;
}

.keyframes(@animation-name, @rules) {
  @-webkit-keyframes @animation-name {
    @rules();
  }
  @-moz-keyframes @animation-name {
    @rules();
  }
  @-o-keyframes @animation-name {
    @rules();
  }
  @keyframes @animation-name {
    @rules();
  }
}

/***** core/element.less *****/

.fr-element, .fr-element:focus {
  outline: 0 solid transparent;
}

.fr-view.fr-element-scroll-visible {
  overflow-x: visible !important;
}

.fr-box.fr-basic {
  .border-radius(@editor-border-radius);

  .fr-element {
    font-family: @editor-font-family;
    color: @editor-font-color;
    font-size: @editor-font-size;
    line-height: @editor-line-height;

    padding: @editor-padding;
    .box-sizing(border-box);
    overflow-x: auto;
    min-height: (20px + (2 * @editor-padding));
    text-align: @editor-align;
  }

  &.fr-rtl {
    .fr-element {
      text-align: right;
    }
  }
}

.fr-element {
  background: transparent;
  position: relative;
  z-index: 2;

  // CSS rule for iPad not being able to select sometimes.
  -webkit-user-select: auto;

  // Fix bootstrap select.
  a {
    .user-select(auto);
  }

  &.fr-disabled {
    .user-select(none);
  }

  [contenteditable="true"] {
    outline: 0 solid transparent;
  }
}

.fr-box {
  a.fr-floating-btn {
    .box-shadow(@floating-btn-box-shadow);
    .border-radius(100%);
    height: @floating-btn-size;
    width: @floating-btn-size;
    text-align: center;
    background: @floating-btn-bg;
    color: @floating-btn-text;
    .transition(background @transition-timing, color @transition-timing, transform @transition-timing);
    outline: none;
    left: 0;
    top: 0;
    line-height: (@floating-btn-size);
    .transform(scale(0));
    text-align: center;
    display: block;
    .box-sizing(border-box);
    border: @floating-btn-border;

    svg {
      .transition(transform @transition-timing);
      fill: @floating-btn-text;
    }

    i, svg {
      font-size: @floating-btn-font-size;
      line-height: @floating-btn-size;
    }

    &.fr-btn + .fr-btn {
      margin-left: 10px;
    }

    &:hover {
      background: @floating-btn-hover-bg;
      cursor: pointer;

      svg {
        fill: @floating-btn-hover-text;
      }
    }
  }

  .fr-visible {
    a.fr-floating-btn {
      .transform(scale(1));
    }
  }
}



/***** core/iframe.less *****/

iframe.fr-iframe {
  width: 100%;
  border: none;
  position: relative;
  display: block;
  z-index: 2;
  .box-sizing(border-box);
}

/***** core/wrapper.less *****/


.fr-wrapper {
  position: relative;
  z-index: 1;

  .fr-clearfix();

  .fr-placeholder {
    position: absolute;
    font-size: @placeholder-size;
    color: @placeholder-color;
    font-family: @placeholder-font-family;
    z-index: 1;
    display: none;
    top: 0;
    left: 0;
    right: 0;
    overflow: hidden;
  }

  &.show-placeholder {
    .fr-placeholder {
      display: block;
      white-space: nowrap;
      text-overflow: ellipsis;
    }
  }

  ::-moz-selection {
    background: @selection-bg;
    color: @selection-text;
  }

  ::selection {
    background: @selection-bg;
    color: @selection-text;
  }
}

.fr-box.fr-basic {
  .fr-wrapper {
    background: @editor-bg;
    border: @editor-border;
    border-bottom-color: @ui-bg-color;
    top: 0;
    left: 0;
  }
}

.fr-box.fr-basic {
  &.fr-top .fr-wrapper {
    border-top: 0;
  }

  &.fr-bottom .fr-wrapper {
    border-bottom: 0;
    .border-radius(@editor-border-radius @editor-border-radius 0 0);
  }
}

@media (min-width: @screen-md) {
  .fr-box.fr-document {
    min-width: 21cm;

    .fr-wrapper {
      text-align: left;
      padding: @document-ready-padding;
      min-width: 21cm;
      background: @document-ready-bg-color;

      .fr-element {
        text-align: left;
        background: @white;
        width: 21cm;
        margin: auto;
        min-height: 26cm !important;
        padding: 1cm 2cm;
        overflow: visible;
        z-index: auto;

        hr {
          margin-left: -2cm;
          margin-right: -2cm;
          background: @document-ready-bg-color;
          height: 1cm;
          outline: none;
          border: none;
        }

        img {
          z-index: 1;
        }
      }
    }
  }
}


/***** tooltip.less *****/

.fr-tooltip {
  position: absolute;
  top: 0;
  left: 0;
  padding: 0 8px;
  .border-radius(@border-radius);
  background: @tooltip-bg;
  color: @tooltip-text;
  font-size: @tooltip-font-size;
  line-height: @tooltip-line-height;
  font-family: @font-family;
  .transition(opacity @transition-timing);
  .opacity(0);
  left: -3000px;
  .user-select(none);
  z-index: 2147483647;
  text-rendering: optimizelegibility;
  .font-smoothing();

  &.fr-visible {
    .opacity(1);
  }
}

/***** ui/buttons.less *****/

// Command button.

.fr-toolbar, .fr-popup, .fr-modal {
  .fr-btn-wrap {
    float: left;
    white-space: nowrap;
    position: relative;

    &.fr-hidden {
      display: none;
    }
  }

  .fr-command.fr-btn {
    background: transparent;
    color: @btn-text;
  	-moz-outline: 0;
  	outline: none;
    border: 0;
    line-height: 1;
  	cursor: pointer;
    text-align: left;
    margin: @btn-margin (@btn-margin / 2);
    padding: 0;
    .transition(all @toolbar-transition-timing);
    .border-radius(@btn-border-radius);
    z-index: 2;
    position: relative;
    .box-sizing(border-box);
    text-decoration: none;
    .user-select(none);
    float: left;
    height: @btn-height;

    &.fr-dropdown.fr-options {
      .border-radius(@btn-dropdown-border-radius);
    }

    &.fr-btn-hover {
      .border-radius(@btn-hover-border-radius);
    }

    &::-moz-focus-inner {
      border: 0;
      padding: 0
    }

    &.fr-btn-text {
      width: auto;
    }

    i, svg {
      display: block;
      text-align: center;
      float: none;
      margin: ((@btn-height - @btn-svg-size) / 2) ((@btn-width - @btn-svg-size) / 2);
      width: @btn-svg-size;
    }

    svg.fr-svg {
      height: @btn-svg-size;
    }

    svg path {
      .transition(all @toolbar-transition-timing);
      fill: @btn-text;
    }

    // Used for accessibility instead of aria-label.
    span.fr-sr-only {
      .fr-hide-by-clipping();
    }

    span {
      font-size: @ui-font-size;
      display: block;
      line-height:  (@ui-font-size + 3px);
      min-width: (@btn-width - 2 * @btn-margin);
      float: left;
      text-overflow: ellipsis;
      overflow: hidden;
      white-space: nowrap;
      height: (@ui-font-size + 3px);
      font-weight: bold;
      padding: 0 @btn-margin;
    }

    img {
      margin: ((@btn-height - @btn-font-size) / 2) ((@btn-width - @btn-font-size) / 2);
      width: @btn-font-size;
    }

    &.fr-btn-active-popup {
      background: @btn-active-bg;
    }

    &.fr-dropdown {
      &.fr-selection {

        span {
          font-weight: normal;
        }
      }

      i, span, img, svg {
        margin-left: (((@btn-width - @btn-svg-size) / 2) - @dropdown-arrow-width);
        margin-right: (((@btn-width - @btn-svg-size) / 2) + @dropdown-arrow-width);
      }

      &:after {
        position: absolute;
        width: 0;
        height: 0;
        border-left: @dropdown-arrow-width solid transparent;
        border-right: @dropdown-arrow-width solid transparent;
        border-top: @dropdown-arrow-width solid @btn-text;
        right: ceil((((@btn-width - @btn-svg-size) / 2 - @dropdown-arrow-width) / 2));
        top: ((@btn-height - @dropdown-arrow-width) / 2);
        .transition(all @dropdown-transition-timing);
        content: "";
      }

      // Dropdown is visible.
      &.fr-active {
        fill: @btn-text;
        background: @btn-active-bg;
        .transition(@toolbar-transition-timing ease);

        &:hover {
          background: @btn-hover-bg;
          fill: @btn-selected-text;

          &::after {
            border-top-color: @btn-selected-text;
          }
        }

        &:after {
          border-top: 0;
          border-bottom: 4px solid @ui-text;
        }
      }
    }

    &.fr-disabled {
      color: @btn-disabled-color;
      cursor: default;
      .opacity(@btn-disabled-opacity);

      &::after {
        border-top-color: @btn-disabled-color;
      }
    }

    &.fr-hidden {
      display: none;
    }
  }

  .fr-tabs {
    .fr-command.fr-btn {
      margin: 0;
      width: @popup-tab-button-width;
      height: @popup-tab-button-height;
      .border-radius(0);

      &:not(:hover):not(:focus) {
        &.fr-active, &.fr-active-tab {
          background: @ui-bg;
        }
      }

      span {
        height: (@btn-font-size + 3);
      }

      img, svg {
        margin: ((@popup-tab-button-height - @popup-btn-svg-size) / 2) ((@popup-tab-button-width - @popup-btn-svg-size) / 2);
        width: @popup-btn-svg-size;
        height: @popup-btn-svg-size;
      }
    }
  }

  .fr-btn-grp, .fr-more-toolbar, .fr-buttons:not(.fr-tabs) {
    .fr-command.fr-btn {
      &.fr-active:not(.fr-dropdown) {
        svg path {
          fill: @btn-active-text;
        }
      }
    }
  }

  &.fr-disabled {
    .fr-btn, .fr-btn.fr-active {
      color: @btn-disabled-color;
      .opacity(@btn-disabled-opacity);

      &.fr-dropdown::after {
        border-top-color: @btn-disabled-color;
      }
    }
  }

  &.fr-rtl {
    .fr-btn-grp {
      &.fr-float-left {
        float: right;
      }

      &.fr-float-right {
        float: left;
      }
    }
    .fr-command.fr-btn, .fr-btn-wrap {
      float: right;

      &.fr-dropdown.fr-options {
        .border-radius(@btn-hover-border-radius);
      }
  
      &.fr-btn-hover {
        .border-radius(@btn-dropdown-border-radius);
      }
    }
  }
}

.fr-toolbar.fr-inline {
  > .fr-command.fr-btn:not(.fr-hidden), > .fr-btn-wrap:not(.fr-hidden) {
    .display-inline-flex();
    float: none;
  }
}

.fr-desktop {
  .fr-command {
    // Hover.
    &:hover, &:focus, &.fr-btn-hover, &.fr-expanded {
      outline: 0;
      color: @btn-hover-text;

      &:not(.fr-table-cell) {
        background: @btn-hover-bg;
      }

      &::after {
        border-top-color: @btn-hover-text;
      }
    }

    // Button is selected.
    &.fr-selected:not(.fr-table-cell), &:active {
      color: @btn-selected-text;
      background: @btn-selected-bg;
    }

    &.fr-active {
      &:hover, &:focus, &.fr-btn-hover, &.fr-expanded {
        background: @btn-hover-bg;
      }

      &:active {
        background: @btn-active-bg;
      }
    }

    &.fr-disabled {
      &:hover, &:focus, &.fr-selected {
        background: transparent;
      }
    }
  }

  &.fr-disabled {
    .fr-command {
      &:hover, &:focus, &.fr-selected {
        background: transparent;
      }
    }
  }
}

.fr-toolbar.fr-mobile, .fr-popup.fr-mobile {
  .fr-command.fr-blink {
    background: @btn-active-bg;
  }
}



/***** ui/dropdown.less *****/

.fr-command.fr-btn {
  &.fr-options {
    width: @dropdown-options-width;
    margin-left: @dropdown-options-margin-left;

    &.fr-btn-hover, &:hover, &:focus {
      border-left: @dropdown-options-border-left;
      .transition(border-left 0s, background-color 0.5s);
    }
  }

  + .fr-dropdown-menu {
    background: @ui-bg;
    display: inline-block;
    position: absolute;
    right: auto;
    bottom: auto;
    height: auto;
    z-index: 4;
    .border-radius(@dropdown-border-radius);
    -webkit-overflow-scrolling: touch;
    overflow: hidden;
    zoom: 1;
    .box-shadow(@dropdown-menu-box-shadow);

    &.test-height {
      .fr-dropdown-wrapper {
        .transition(none);
        height: auto;
        max-height: @dropdown-max-height;
      }
    }

    .fr-dropdown-wrapper {
      padding: 0;
      margin: auto;
      display: inline-block;
      text-align: left;
      position: relative;
      .box-sizing(border-box);
      .transition(height @dropdown-transition-timing);
      margin-top: 0;
      float: left;
      height: 0;
      margin-top: 0 !important;

      .fr-dropdown-content {
        position: relative;

        ul.fr-dropdown-list {
          list-style-type: none;
          margin: 0;
          padding: @dropdown-list-padding;
          min-width: @dropdown-list-min-width;

          li {
            padding: 0;
            margin: 0;
            font-size: @dropdown-list-item-font-size;

            a {
              padding: 0 (((@dropdown-list-min-width - @floating-svg-btn-size) / 2) - @btn-margin);
              line-height: 200%;
              display: flex;
              cursor: pointer;
              white-space: nowrap;
              color: inherit;
              text-decoration: none;
              .border-radius(0);

              svg {
                width: @floating-svg-btn-size;
                height: @floating-svg-btn-size;
                margin: (@btn-margin - 1) @btn-margin;

                path {
                  fill: @btn-text;
                }
              }

              &.fr-active {
                background: @ui-active-color;
              }

              &.fr-disabled {
                color: @btn-disabled-color;
                cursor: default;
              }

              .fr-shortcut {
                margin-left: 20px;
                font-weight: bold;
                -webkit-opacity: 0.75;
                -moz-opacity: 0.75;
                opacity: 0.75;
              }
            }
          }
        }
      }
    }
  }

  &.fr-active {
    + .fr-dropdown-menu {
      display: inline-block;
      .box-shadow(@dropdown-menu-box-shadow);
    }
  }
}

.fr-bottom > .fr-command.fr-btn {
  + .fr-dropdown-menu {
    .border-radius(@border-radius @border-radius 0 0);
  }
}

.fr-toolbar, .fr-popup {
  &.fr-rtl {
    .fr-dropdown-wrapper {
      text-align: right !important;
    }
  }
}


/***** ui/modal.less *****/

body.fr-prevent-scroll {
  overflow: hidden;

  &.fr-mobile {
    position: fixed;
    -webkit-overflow-scrolling: touch;
  }
}

.fr-modal {
  color: @ui-text;
  font-family: @font-family;
  position: fixed;
  overflow-x: auto;
  overflow-y: scroll;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  width: 100%;
  z-index: 2147483640;
  text-rendering: optimizelegibility;
  .font-smoothing();
  text-align: center;
  line-height: 1.2;

  &.fr-middle {
    .fr-modal-wrapper {
      margin-top: 0;
      margin-bottom: 0;
      margin-left: auto;
      margin-right: auto;
      top: 50%;
      left: 50%;
      .transform(translate(-50%, -50%));
      position: absolute;
    }
  }

  .fr-modal-wrapper {
    .border-radius(@modal-wrapper-border-radius);
    background-clip: padding-box;
    margin: @modal-wrapper-margin-lg;
    display: inline-block;
    background: @modal-bg;
    min-width: @modal-wrapper-min-width;
    .box-shadow(@modal-wrapper-box-shadow);
    border: 0;
    overflow: hidden;
    width: 90%;
    position: relative;

    @media (min-width: @screen-sm) and (max-width: @screen-sm-max) {
      margin: @modal-wrapper-margin-sm;
      width: 70%;
    }

    @media (min-width: @screen-md) {
      margin: @modal-wrapper-margin-md;
      width: 960px;
    }

    .fr-modal-head {
      background: @modal-bg;
      overflow: hidden;
      position: absolute;
      width: 100%;
      min-height: @modal-head-min-height;
      z-index: 3;
      border-bottom: solid @ui-bg-color 1px;
      .transition(all @transition-timing);

      .fr-modal-head-line {
        height: @modal-head-height;
        padding: @modal-head-padding;

      }

      .fr-modal-close {
        margin: @modal-close-margin;
        position: absolute;
        top: 0;
        right: 0;
      }

      h4 {
        font-size: @modal-heading-font-size;
        padding: @modal-heading-padding;
        margin: 0;
        font-weight: 400;
        line-height: @modal-head-line-height;
        display: inline-block;
        float: left;
      }
    }

    div.fr-modal-body {
      height: 100%;
      min-height: @modal-body-min-width;
      overflow-y: auto;
      padding-bottom: @modal-body-padding-bottom;

      &:focus {
        outline: 0;
      }

      button.fr-command {
        height: @modal-body-btn-height;
        line-height: 1;
        color: @ui-color;
        padding: @modal-body-btn-padding;
        cursor: pointer;
        text-decoration: none;
        border: none;
        background: none;
        font-size: 16px;
        outline: none;
        .transition(background @transition-timing);
        .border-radius(@border-radius);

        + button {
          margin-left: 24px;
        }

        &:hover, &:focus {
          background: @btn-hover-bg;
          color: @ui-color;
        }

        &:active {
          background: @btn-active-bg;
          color: @ui-color;
        }
      }

      button::-moz-focus-inner {
        border: 0;
      }
    }
  }
}

.fr-desktop .fr-modal-wrapper {
  .fr-modal-head {
    i:hover {
      background: @ui-hover-color;
    }
  }
}

// Overlay that appears with modal.
.fr-overlay {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: @modal-overlay-color;
  .opacity(@modal-overlay-opacity);
  z-index: 2147483639;
}
ol.decimal_type { counter-reset: item; }
ol.decimal_type > li{ display: block; }
ol.decimal_type > li:before { content: counters(item, ".") ". "; counter-increment: item; }

/***** ui/popup.less *****/

.fr-popup {
  position: absolute;
  display: none;
  color: @ui-text;
  background: @ui-bg;
  .box-shadow(@popup-box-shadow);
  font-family: @font-family;
  .box-sizing(border-box);
  .user-select(none);
  margin-top: @popup-margin-top;
  z-index: 2147483635;
  text-align: left;
  .border-radius(@popup-border-radius);
  text-rendering: optimizelegibility;
  .font-smoothing();
  line-height: 1.2;

  .fr-icon {
    text-align: center;
    vertical-align: middle;
    font-size: @popup-icon-font-size;
    line-height: 1;
    cursor: pointer;
    font-weight: 400;
    box-sizing: content-box;
    padding: @popup-icon-padding;
  }

  .fr-icon-container {
    padding: @popup-border-padding;
    max-height: @popup-container-max-height;
    overflow: auto;
    .box-sizing(border-box);
    
    @supports not (-ms-high-contrast: none) { 
      grid-template-columns: repeat(auto-fill, minmax(@btn-size, @btn-size));
      display: grid;
    }

    @media (min-width: @screen-sm) {
      min-width: @popup-min-width; 
    }

    @media screen and (-ms-high-contrast: active), (-ms-high-contrast: none) {
      display: inline-flex;
      -ms-flex-flow: row wrap;
    }

    @media screen and (-ms-high-contrast: active) and (max-width: @screen-sm), (-ms-high-contrast: none) and (max-width: @screen-sm) {
      width: @popup-sm-ie-width;
    }
  }

  .fr-input-focus {
    background: @ui-hover-light-color;
  }

  &.fr-above {
    margin-top: -10px;
    border-top: 0;
  }

  &.fr-active {
    display: block;
  }


  &.fr-hidden {
    display: none !important;
  }

  &.fr-empty {
    display: none !important;
  }

  .fr-hs {
    display: block !important;

    &.fr-hidden {
      display: none !important;
    }
  }

  .fr-input-line {
    position: relative;
    padding: @input-line-padding;

    input[type="text"], input[type="number"], textarea {
      width: 100%;
      margin-bottom: @input-margin-bottom;
      .border-radius(@input-border-radius);
      border: solid @input-border-width @input-border-color;
      color: @ui-text;
      font-size: @input-label-font-size;
      background: @ui-bg;
      position: relative;
      z-index: 2;
      padding: @input-padding;
      .box-sizing(border-box);
      .transition(border @toolbar-transition-timing, padding @toolbar-transition-timing);

      &:hover {
        border: solid @input-border-width @ui-border-hover-color;
      }

      &:focus {
        border: solid @input-focus-border-width @ui-color;
        padding: @input-focus-padding;
      }
    }

    input[type="text"], input[type="number"] {
      height: @input-height;
    }

    input + label, textarea + label {
      position: absolute;
      top: @input-label-top;
      left: @input-label-left;
      font-size: @input-label-font-size;
      color: grey;
      .transition(all @toolbar-transition-timing ease);
      z-index: 3;
      display: block;
      background: @ui-bg;
      padding: 0;
      cursor: text;
    }

    input.fr-not-empty + label, textarea.fr-not-empty + label {
      color: @input-label-color;
      width: auto;
      left: @input-label-left-after;
      padding: 0 @input-label-padding;
      font-size: @input-label-font-size-after;
      top: @input-label-top-after;
    }
  }

  input, textarea {
    .user-select(text);
    .border-radius(0);
    outline: none;
  }

  textarea {
    resize: none,
  }

  .fr-buttons {
    white-space: nowrap;
    line-height: 0;

    .fr-btn {
      margin-left: @btn-margin;
      margin-right: @btn-margin;
      display: inline-block;
      float: none;

      i {
        float: left;
      }
    }

    .fr-separator {
      display: inline-block;
      float: none;
    }

    &.fr-tabs {
      .border-radius(@btn-tab-border-radius);
      background-color: @ui-bg-color-more;
      overflow: hidden;

      &.fr-tabs-scroll {
        @media (max-width: @screen-sm) {
          overflow: scroll;
          overflow-y: hidden;
          width: @popup-min-width;
        }
      }
    }

    &:not(.fr-tabs) {
      padding: @popup-padding;
    }
  }

  .fr-layer {
    .border-radius(@popup-border-radius);
    width: (@popup-layer-width * 0.75);
    @media (min-width: @screen-sm) {
      width: @popup-layer-width;
    }

    .box-sizing(border-box);
    margin: @popup-layer-margin;
    display: none;

    &.fr-active {
      display: inline-block;
    }
  }

  .fr-action-buttons {
    z-index: 7;
    height: @btn-size;
    text-align: right;

    button.fr-command {
      height: @btn-size;
      line-height: 1;
      color: @ui-color;
      padding: @popup-action-btn-spacing;
      cursor: pointer;
      text-decoration: none;
      border: none;
      background: none;
      font-size: @popup-action-button-font-size;
      outline: none;
      .transition(background @transition-timing);
      .border-radius(@border-radius);

      + button {
        margin-left: 24px;
      }

      &:hover, &:focus {
        background: @btn-hover-bg;
        color: @ui-color;
      }

      &:active {
        background: @btn-active-bg;
        color: @ui-color;
      }
    }

    button::-moz-focus-inner {
      border: 0;
    }
  }

  .fr-checkbox {
    position: relative;
    display: inline-block;
    width: @checkbox-size;
    height: @checkbox-size;
    padding: @checkbox-padding;
    border-radius: 100%;
    line-height: 1;
    .box-sizing(content-box);
    vertical-align: middle;

    svg {
      margin-left: @checkbox-margin;
      margin-top: @checkbox-margin;
      display: none;
      width: @checbox-svg-size;
      height: @checbox-svg-size;
    }

    span {
      .border-radius(@border-radius);
      width: @checkbox-size;
      height: @checkbox-size;
      display: inline-block;
      position: relative;
      z-index: 1;
      .box-sizing(border-box);
      .transition(background @transition-timing, border-color @transition-timing);
    }

    input {
      position: absolute;
      z-index: 2;
      .opacity(0);
      border: 0 none;
      cursor: pointer;
      height: @checkbox-size;
      margin: 0;
      padding: 0;
      width: @checkbox-size;
      top: 7px;
      left: 7px;

      &:not(:checked) {

        & + span {
          border: solid 2px @input-border-color;
        }

        &:active + span {
          background-color: @bg-color;
        }

        &:focus + span, &:hover + span {
          border-color: @ui-border-hover-color;
        }
      }

      &:checked {

        & + span {
          background: @ui-color;
          border: solid 2px @ui-color;

          svg {
            display: block;
          }
        }

        &:active + span {
          background-color: @checbox-active-bg;
        }

        &:focus + span, &:hover + span {
          .opacity(@checkbox-opacity);
        }
      }
    }
  }

  .fr-checkbox-line {
    font-size: @checkbox-line-font-size;
    line-height: @checkbox-line-height;
    margin-top: @checkbox-line-margin-top;

    label {
      cursor: pointer;
      margin: @checkbox-line-label-margin;
      vertical-align: middle;
    }
  }

  &.fr-rtl {
    direction: rtl;
    text-align: right;

    .fr-action-buttons {
      text-align: left;
    }

    .fr-input-line {
      input + label, textarea + label {
        left: auto;
        right: 0;
      }
    }

    .fr-buttons .fr-separator.fr-vs {
      float: right;
    }
  }

}


/***** ui/text_edit.less *****/

.fr-text-edit-layer {
  width: 250px;
  .box-sizing(border-box);
  display: block !important;
}


/***** ui/toolbar.less *****/

.fr-toolbar {
  color: @ui-text;
  background: @ui-bg;
  position: relative;
  font-family: @font-family;
  .fr-clearfix();
  .box-sizing(border-box);
  .user-select(none);
  .border-radius(@border-radius);
  text-align: left;
  border: @editor-border;
  text-rendering: optimizelegibility;
  .font-smoothing();
  line-height: 1.2;
  padding-bottom: 0;
  .transition(padding-bottom @toolbar-transition-timing);

  &::after {
    height: 0;
  }

  .fr-newline {
    clear: both;
    display: block;
    content: "";
    margin-left: @toolbar-newline-margin;
    margin-right: @toolbar-newline-margin;
    background: @toolbar-newline-color;
    height: @toolbar-newline-height;
    .transition(height @toolbar-transition-timing);
  }

  &.fr-toolbar-open {
    .fr-newline {
      height: 0;
    }
  }

  .fr-float-right {
    float: right;
  }

  .fr-float-left {
    float: left;
  }

  .fr-more-toolbar {
    float: left;
    .border-radius(0);
    background-color: @ui-bg-color-more;
    .transition(height @toolbar-transition-timing);
    height: 0;
    // 3803 - toolbar hides when track changes toolbar is on or visible 
    // z-index: 2; remove z index for more toolbars so the popover should come over those toolbars
    overflow: hidden;
    .box-sizing(border-box);
    width: 100%;

    &.fr-expanded {
      height: @more-toolbar-btn-height;
    }

    &.fr-overflow-visible {
      overflow: visible;
    }

    & > .fr-command.fr-btn {
      margin-left: @btn-margin;
      margin-right: @btn-margin;
    }
  }

  .fr-btn-grp {
    display: inline-block;
    margin: @more-toolbar-margin;

    @media (max-width: @screen-sm) {
      margin: @more-toolbar-margin-sm;
    }
  }

  .fr-command.fr-btn.fr-open {
    margin-top: @btn-more-open-margin-top;
    margin-bottom: @btn-more-open-margin-bottom;
    .border-radius(@btn-border-radius @btn-border-radius 0 0);

    &:not(:hover):not(:focus):not(:active) {
      background: @ui-bg-color-more;
    }
  }

  &.fr-rtl {
    text-align: right;
  }

  &.fr-inline {
    display: none;
    .box-shadow(@popup-box-shadow);
    border: 0;
    white-space: nowrap;
    position: absolute;
    margin-top: 5px;
    z-index: 2147483630;

    &.fr-above {
      margin-top: -10px;
      border-top: 0;
    }

    .fr-newline {
      height: 0;
    }

    .fr-more-toolbar {
      position: absolute !important;
      &.fr-expanded {
        position: relative !important;
      }
    }
  }

  &.fr-top {
    top: 0;
    border-bottom: 0;
    .border-radius(@editor-border-radius @editor-border-radius 0 0);
  }

  &.fr-bottom {
    bottom: 0;
    border-top: 0;
    padding-bottom: 0;
    .border-radius(0 0 @editor-border-radius @editor-border-radius);

    .fr-newline {
      padding-top: 0;
      .transition(padding-top @toolbar-transition-timing);
    }

    &.fr-toolbar-open .fr-newline {
      padding-top: @more-toolbar-btn-height;
      background: @white;
    }

    .fr-command.fr-btn.fr-open {
      margin-top: @btn-more-open-margin-bottom;
      margin-bottom: @btn-more-open-margin-top;
      .border-radius(0 0 @btn-border-radius @btn-border-radius);
    }
  }

  &.fr-sticky-on {
    .border-radius(0);
  }
}

.fr-separator {
  background: @separator-color;
  display: block;
  vertical-align: top;
  float: left;

  + .fr-separator {
    display: none;
  }

  &.fr-vs {
    height: (@btn-height - 2 * @btn-margin);
    width: @separator-size;
    margin: @separator-margin;
  }

  &.fr-hs {
    clear: both;
    width: calc(~"100% - (2 * @{btn-margin})");
    margin: 0 @btn-margin;
    height: @separator-size;
  }

  &.fr-hidden {
    display: none !important;
  }
}

.fr-rtl .fr-separator {
  float: right;
}
.fr-toolbar.fr-inline .fr-separator.fr-hs {
  float: none;
}

.fr-toolbar.fr-inline .fr-separator.fr-vs {
  float: none;
  display: inline-block;
}

.fr-second-toolbar {
  border: @editor-border;
  border-top: 0;
  background: @editor-bg;
  line-height: 1.4;
  .border-radius(0 0 @editor-border-radius @editor-border-radius);
  .fr-clearfix();
}

.fr-second-toolbar:empty {
  min-height: calc(~"10px");
  position: relative;
  margin-top: calc(~"-1px");
  z-index: 2;
}

#fr-logo {
  float: left;
  outline: none;

  & > span{
    display: inline-block;
    float: left;
    font-family: sans-serif;
    padding: @logo-span-padding;
    font-size: @logo-span-font-size;
    font-weight: 500;
    color: @logo-color;
    .transition(color @logo-transition-timing);
  }

  & > svg {
    height: @logo-svg-height;
    width: @logo-svg-width;
    margin: @logo-svg-margin;
    cursor: pointer;
  }

  & > svg * {
    .transition(fill @logo-transition-timing);
  }

  &:hover, &:focus {
    & > span {
      color: @btn-active-hover-text;
    }

    & > svg .fr-logo {
      fill: @btn-active-hover-text;
    }
  }
}


/***** helpers.less *****/

.fr-visibility-helper {
  display: none;
  margin-left: 0 !important;

  @media (min-width: @screen-sm) {
    margin-left: 1px !important;
  }

  @media (min-width: @screen-md) {
    margin-left: 2px !important;
  }

  @media (min-width: @screen-lg) {
    margin-left: 3px !important;
  }
}

.fr-opacity-0 {
  .opacity(0);
}

.fr-box {
  position: relative;
}

/**
 * Postion sticky hacks.
 */
.fr-sticky {
  position: -webkit-sticky;
	position: -moz-sticky;
	position: -ms-sticky;
	position: -o-sticky;
	position: sticky;
}

.fr-sticky-off {
	position: relative;
}

.fr-sticky-on {
  position: sticky;
  z-index: 10;

  &.fr-sticky-ios {
    position: absolute;
    left: 0;
    right: 0;
    width: auto !important;
  }
}

.fr-sticky-dummy {
	display: none;
}

.fr-sticky-on + .fr-sticky-dummy, .fr-sticky-box > .fr-sticky-dummy {
	display: block;
}

// Used for accessibility instead of aria-label.
span.fr-sr-only {
  .fr-hide-by-clipping();
}

// merged conflict from master, kept both changes
.fr-view .fr-highlight-change, .fr-highlight-change > img, .fr-highlight-change > .fr-video > video,
.fr-highlight-change > .fr-video > embed, .fr-highlight-change > .fr-video > iframe, .fr-highlight-change > .fr-embedly > .embedly-card > .embedly-card-hug > iframe,
.fr-highlight-change > p, .fr-view .fr-highlight-change > span:not(.fr-tracking-deleted) {
  background-color: #f3eec3;
  opacity: 0.5;
}

.fr-highlight-change.fr-highlight-change > table td, .fr-highlight-change.fr-highlight-change > hr {
  border-color: #f3eec3;
}

.fr-tracking-deleted.fr-tracking-deleted > table td, .fr-tracking-deleted.fr-tracking-deleted > hr {
  border-color: #dc3545;
}

.fr-tracking-deleted img, .fr-tracking-deleted > .fr-video > video, .fr-tracking-deleted > .fr-video > iframe, .fr-tracking-deleted > .fr-embedly > .embedly-card > .embedly-card-hug > iframe {
  opacity: 0.5;
  background-color: #dc3545;
}

.fr-view .fr-tracking-deleted {
  background-color: #dc3545;
  text-decoration: line-through;
  pointer-events: none;
  user-select: none;
  opacity: 1;
}

.fr-highlight-change > .fr-video > iframe, .fr-tracking-deleted > .fr-video > iframe, .fr-highlight-change > .fr-video > video,.fr-tracking-deleted > .fr-video > video, .fr-highlight-change > .fr-video > embed, .fr-highlight-change > .fr-embedly > .embedly-card > .embedly-card-hug > iframe, .fr-tracking-deleted > .fr-embedly > .embedly-card > .embedly-card-hug > iframe {
  padding: 10px !important;
}

.fr-tracking-deleted  img, .fr-highlight-change  img{
  border: 2px solid #f3eec3;
}


.fr-highlight-change #isPasted *:not(table):not(tbody):not(tr):not(td){
  opacity: 0.5; 
  background-color: #f3eec3;
}

.fr-highlight-change #isPasted > table td{
  opacity: 0.5; 
  border-color: #f3eec3;
}


.fr-track-hide {
  display: none;
}

.fr-track-hide-mobile {
  width: 0;
  height: 0;
  overflow: hidden;
  position: absolute;
}

.fr-ios-mobile-disable-select {
  -webkit-touch-callout : none;
  -webkit-user-select : none;
  user-select: none;
}

.fr-bottom-extended {
  flex-wrap: wrap;
  display: flex;
  box-sizing: border-box;
}

.position-relative {
  position: relative !important;
}
// till here

/***** plugins/colors.less *****/

.fr-popup {
  .fr-layer.fr-color-hex-layer {
    margin: 0;
    padding: @popup-border-padding;
    padding-top: 0;
    float: left;

    .fr-input-line {
      float: left;
      width: calc(~"100% - 50px");
      padding: @color-input-line-padding;
    }

    .fr-action-buttons {
      float: right;
      width: @btn-width;
      height: @btn-height;
      padding: @color-action-button-padding;
      margin: 0;
    }

    .fr-action-buttons {
      button.fr-command {
        .border-radius(@border-radius);
        font-size: @color-font-size;
        height: @btn-height;
        width: @btn-width;
      }
    }
  }

  .fr-separator + .fr-colors-tabs {
    margin-left: 2px;
    margin-right: 2px;
  }

  .fr-color-set {
    line-height: 0;
    display: none;

    &.fr-selected-set {
      display: block;
      padding: @popup-border-padding;
      padding-bottom: 0;
    }

    > span {
      display: inline-block;
      width: @color-span-size;
      height: @color-span-size;
      position: relative;
      z-index: 1;

      > i, > svg {
        text-align: center;
        line-height: @color-line-height;
        height: @ui-svg-size;
        width: @ui-svg-size;
        margin: @color-remove-svg-margin;
        font-size: @color-font-size;
        position: absolute;
        bottom: 0;
        cursor: default;
        left: 0;

        path {
          fill: @ui-text;
        }
      }

      .fr-selected-color {
        color: @white;
        font-family: FontAwesome;
        font-size: @color-font-size;
        font-weight: 400;
        line-height: @color-line-height;
        position: absolute;
        top: 0;
        bottom: 0;
        right: 0;
        left: 0;
        text-align: center;
        cursor: default;
      }

      &:hover, &:focus {
        outline: 1px solid @ui-text;
        z-index: 2;
      }
    }
  }
}

.fr-rtl .fr-popup {
  .fr-colors-tabs {
    .fr-colors-tab {
      &.fr-selected-tab {
        &[data-param1="text"] ~ [data-param1="background"]::after {
          .transform(translate3d(100%,0,0));
        }
      }
    }
  }
}


/***** plugins/draggable.less *****/

.fr-drag-helper {
  background: @drag-helper-bg;
  height: 2px;
  margin-top: -1px;
  .opacity(0.2);
  position: absolute;
  z-index: 2147483640;
  display: none;

  &.fr-visible {
    display: block;
  }
}

.fr-dragging {
  .opacity(0.4);
}

/***** plugins/file.less *****/

.fr-popup {
  .fr-file-upload-layer {
    border: dashed 2px @ui-disabled-color;
    padding: 25px 0;
    margin: @popup-border-margin;
    position: relative;
    font-size: 14px;
    letter-spacing: 1px;
    line-height: 140%;
    .box-sizing(border-box);
    text-align: center;

    &:hover {
      background: @ui-hover-color;
    }

    &.fr-drop {
      background: @ui-hover-color;
      border-color: @ui-color;
    }

    .fr-form {
      .opacity(0);
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      z-index: 2147483640;
      overflow: hidden;
      margin: 0 !important;
      padding: 0 !important;
      width: 100% !important;

      input {
        cursor: pointer;
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        width: 500%;
        height: 100%;
        margin: 0;
        font-size: 400px;
      }
    }
  }

  .fr-file-progress-bar-layer {
    .box-sizing(border-box);

    > h3 {
      font-size: 16px;
      margin: 10px 0;
      font-weight: normal;
    }

    > div.fr-action-buttons {
      display: none;
    }

    > div.fr-loader {
      background: mix(@white, @ui-color, 70%);
      height: 10px;
      width: 100%;
      margin-top: 20px;
      overflow: hidden;
      position: relative;

      span {
        display: block;
        height: 100%;
        width: 0%;
        background: @ui-color;
        .transition(width @transition-timing);
      }

      &.fr-indeterminate {
        span {
          width: 30% !important;
          position: absolute;
          top: 0;
          .animation(loading 2s linear infinite);
        }
      }
    }

    &.fr-error {
      > div.fr-loader {
        display: none;
      }

      > div.fr-action-buttons {
        display: block;
      }
    }
  }
}


@keyframes loading {
  from {left: -25%;}
  to {left: 100%}
}

.keyframes(loading, {
  from {left: -25%;}
  to {left: 100%}
});


/***** plugins/image.less *****/

.fr-element img {
  cursor: pointer;
  padding: @image-padding;
}

.fr-image-resizer {
  position: absolute;
  border: solid 1px @ui-color;
  display: none;
  .user-select(none);
  .box-sizing(content-box);

  &.fr-active {
    display: block,
  }

  .fr-handler {
    display: block;
    position: absolute;
    background: @ui-color;
    border: solid 1px @white;
    .border-radius(2px);
    z-index: 4;
    .box-sizing(border-box);

    &.fr-hnw {
      cursor: nw-resize,
    }

    &.fr-hne {
      cursor: ne-resize,
    }

    &.fr-hsw {
      cursor: sw-resize,
    }

    &.fr-hse {
      cursor: se-resize,
    }
  }

  .handler-size(@handler-size);

  @media(min-width: @screen-lg) {
    .handler-size(@handler-size-lg);
  }
}

.fr-image-overlay {
  position: fixed;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  z-index: 2147483640;
  display: none;
}

.fr-popup {
  .fr-image-upload-layer {
    border: dashed 2px @ui-disabled-color;
    padding: 25px 0;
    margin: @popup-border-margin;
    position: relative;
    font-size: 14px;
    letter-spacing: 1px;
    line-height: 140%;
    text-align: center;

    &:hover {
      background: @ui-hover-color;
    }

    &.fr-drop {
      background: @ui-hover-color;
      border-color: @ui-color;
    }

    .fr-form {
      .opacity(0);
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      z-index: 2147483640;
      overflow: hidden;
      margin: 0 !important;
      padding: 0 !important;
      width: 100% !important;

      input {
        cursor: pointer;
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        width: 500%;
        height: 100%;
        margin: 0;
        font-size: 400px;
      }
    }
  }

  .fr-image-progress-bar-layer {
    > h3 {
      font-size: 16px;
      margin: 10px 0;
      font-weight: normal;
    }

    > div.fr-action-buttons {
      display: none;
    }

    > div.fr-loader {
      background: mix(@white, @ui-color, 70%);
      height: 10px;
      width: 100%;
      margin-top: 20px;
      overflow: hidden;
      position: relative;

      span {
        display: block;
        height: 100%;
        width: 0%;
        background: @ui-color;
        .transition(width @transition-timing);
      }

      &.fr-indeterminate {
        span {
          width: 30% !important;
          position: absolute;
          top: 0;
          .animation(loading 2s linear infinite);
        }
      }
    }

    &.fr-error {
      > div.fr-loader {
        display: none;
      }

      > div.fr-action-buttons {
        display: block;
      }
    }
  }
}

.fr-image-size-layer {
  .fr-image-group {
    .fr-input-line {
      width: calc(~"50% - 5px");
      display: inline-block;

      + .fr-input-line {
        margin-left: 10px;
      }
    }
  }
}

.fr-uploading {
  .opacity(0.4);
}

.keyframes(loading, {
  from {left: -25%;}
  to {left: 100%}
});

img.fr-draggable {
  user-select: none;
}


/***** plugins/table.less *****/

.fr-element {
  table {
    td.fr-selected-cell, th.fr-selected-cell {
      border: 1px double @ui-color;
    }

    td, th {
      .user-select(text);
    }
  }

  // Prevent Firefox selection.
  .fr-no-selection {
    table {
      td, th {
        .user-select(none);
      }
    }
  }
}

.fr-table-resizer {
  cursor: col-resize;
  position: absolute;
  z-index: 3;
  display: none;

  &.fr-moving {
    z-index: 2;
  }

  div {
    .opacity(0);
    border-right: @table-resizer;
  }
}

.fr-no-selection {
  .user-select(none);
}

// Table popups.
.fr-popup {

  // Insert table.
  .fr-table-size {

    margin: @popup-border-margin;

    .fr-table-size-info {
      text-align: center;
      font-size: 14px;
    }

    .fr-select-table-size {
      line-height: 0;
      padding: 5px;
      white-space: nowrap;

      > span {
        display: inline-block;
        padding: 0 4px 4px 0;
        background: transparent;

        > span {
          display: inline-block;
          width: 18px;
          height: 18px;
          border: @insert-table-grid;
        }

        &.hover {
          background: transparent;

          > span {
            background: rgba(red(@ui-color), green(@ui-color), blue(@ui-color), 0.3);
            border: solid 1px @ui-color;
          }
        }
      }

      .new-line {	
        .fr-clearfix();
      }
    }
  }

  &.fr-above {
    .fr-table-size {
      .fr-select-table-size {
        > span {
          display: inline-block !important;
        }
      }
    }
  }

  // Table colors.
  .fr-table-colors {
    display: block;
    padding: @popup-border-padding;
    padding-bottom: 0;
  }
}

.fr-popup.fr-desktop .fr-table-size .fr-select-table-size > span > span {
  width: 12px;
  height: 12px;
}

.fr-insert-helper {
  position: absolute;
  z-index: 9999;
  white-space: nowrap;
}


/***** plugins/video.less *****/

.fr-element {
  .fr-video {
    .user-select(none);

    &::after {
      position: absolute;
      content: \'\';
      z-index: 1;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      cursor: pointer;
      display: block;
      background: rgba(0,0,0,0);
    }

    &.fr-active > * {
      z-index: 2;
      position: relative;
    }

    > * {
      .box-sizing(content-box);
      max-width: 100%;
      border: none;
    }
  }
}

.fr-box .fr-video-resizer {
  position: absolute;
  border: solid 1px @ui-color;
  display: none;
  .user-select(none);

  &.fr-active {
    display: block,
  }

  .fr-handler {
    display: block;
    position: absolute;
    background: @ui-color;
    border: solid 1px @white;
    z-index: 4;
    .box-sizing(border-box);

    &.fr-hnw {
      cursor: nw-resize,
    }

    &.fr-hne {
      cursor: ne-resize,
    }

    &.fr-hsw {
      cursor: sw-resize,
    }

    &.fr-hse {
      cursor: se-resize,
    }
  }

  .handler-size(@handler-size);

  @media(min-width: @screen-lg) {
    .handler-size(@handler-size-lg);
  }
}

.fr-popup {
  .fr-video-size-layer {
    .fr-video-group {
      .fr-input-line {
        width: calc(~"50% - 5px");
        display: inline-block;

        + .fr-input-line {
          margin-left: 10px;
        }
      }
    }
  }

  .fr-video-upload-layer {
    border: dashed 2px @ui-disabled-color;
    padding: 25px 0;
    margin: @popup-border-margin;
    position: relative;
    font-size: 14px;
    letter-spacing: 1px;
    line-height: 140%;
    text-align: center;

    &:hover {
      background: @ui-hover-color;
    }

    &.fr-drop {
      background: @ui-hover-color;
      border-color: @ui-color;
    }

    .fr-form {
      .opacity(0);
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      z-index: 2147483640;
      overflow: hidden;
      margin: 0 !important;
      padding: 0 !important;
      width: 100% !important;

      input {
        cursor: pointer;
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        width: 500%;
        height: 100%;
        margin: 0;
        font-size: 400px;
      }
    }
  }

  .fr-video-progress-bar-layer {
    > h3 {
      font-size: 16px;
      margin: 10px 0;
      font-weight: normal;
    }

    > div.fr-action-buttons {
      display: none;
    }

    > div.fr-loader {
      background: mix(@white, @ui-color, 70%);
      height: 10px;
      width: 100%;
      margin-top: 20px;
      overflow: hidden;
      position: relative;

      span {
        display: block;
        height: 100%;
        width: 0%;
        background: @ui-color;
        .transition(width @transition-timing);
      }

      &.fr-indeterminate {
        span {
          width: 30% !important;
          position: absolute;
          top: 0;
          .animation(loading 2s linear infinite);
        }
      }
    }

    &.fr-error {
      > div.fr-loader {
        display: none;
      }

      > div.fr-action-buttons {
        display: block;
      }
    }
  }
}

.fr-video-overlay {
  position: fixed;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  z-index: 2147483640;
  display: none;
}

.fr-autoplay-margin{
  margin-top:0px !important;
}

/* Files: froala.less, plugins/colors.less, plugins/draggable.less, plugins/file.less, plugins/image.less, plugins/table.less, plugins/video.less */';
	return $__finalCompiled;
}
);