<?php
// FROM HASH: d2b00d203a065a2203d2f35f7100b6d8
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '@pd-text-color: @xf-textColor;
@pd-title-color: @xf-linkColor;
@pd-title-bg: @xf-contentBg;
@pd-picker-bg: @xf-contentBg;
@pd-picker-border: @xf-borderColor;
@pd-picker-border-radius: @xf-borderRadiusMedium;
@pd-th-color: @xf-textColorDimmed;
@pd-day-color: @xf-textColor;
@pd-day-bg: @xf-contentAltBg;
@pd-day-hover-color: @xf-textColorEmphasized;
@pd-day-hover-bg: @xf-contentAccentBg;
@pd-day-today-color: @xf-textColorFeature;
@pd-day-selected-color: @xf-textColorEmphasized;
@pd-day-selected-bg: @xf-contentHighlightBg;
@pd-day-selected-shadow: transparent;
@pd-day-disabled-color: @xf-textColor;
@pd-week-color: @xf-textColorMuted;
@pd-range-color: @xf-textColorAccentContent;
@pd-range-bg: @xf-contentAccentBg;
@pd-range-border: @xf-borderColorAccentContent;

.pika-single {
	z-index: 9999;
	display: block;
	position: relative;
	color: @pd-text-color;
	background: @pd-picker-bg;
	border: 1px solid;
	border-color: @pd-picker-border;
	border-radius: @pd-picker-border-radius;

	&.is-hidden {
		display: none;
	}

	&.is-bound {
		position: absolute;
		.m-dropShadow(0, 5px, 10px, 0, .25);
	}
}

// clear child float (pika-lendar), using the famous micro clearfix hack
// http://nicolasgallagher.com/micro-clearfix-hack/
.pika-single {
	*zoom: 1;

	&:before,
	&:after {
		content: " ";
		display: table;
	}

	&:after { clear: both }
}

.pika-lendar {
	float: left;
	width: 240px;
	margin: 8px;
}

.pika-title {
	position: relative;
	text-align: center;

	select {
		cursor: pointer;
		position: absolute;
		z-index: 9998;
		margin: 0;
		left: 0;
		top: 5px;
		filter: alpha(opacity=0);
		opacity: 0;
	}
}

.pika-label {
	display: inline-block;
	*display: inline;
	position: relative;
	z-index: 9999;
	overflow: hidden;
	margin: 0;
	padding: 5px 3px;
	font-size: 14px;
	line-height: 20px;
	font-weight: bold;
	color: @pd-title-color;
	background-color: @pd-title-bg;
}

.pika-prev,
.pika-next
{
	display: block;
	cursor: pointer;
	position: relative;
	outline: none;
	background: none;
	border: 0;
	padding: 0;
	width: 20px;
	height: 30px;
	white-space: nowrap;
	overflow: hidden;
	opacity: .5;
	font-size: 0;
	color: @pd-title-color;
	background-color: @pd-title-bg;

	&::before
	{
		.m-faBase();
		font-size: @xf-fontSizeLarge;
		vertical-align: middle;
		display: inline-block;
		margin: -4px 6px -4px 0;
	}

	&:hover {
		opacity: 1;
	}

	&.is-disabled {
		cursor: default;
		opacity: .2;
	}
}

.pika-prev
{
	&::before
	{
		.m-faContent(@fa-var-caret-left, .4375em, ltr);
		.m-faContent(@fa-var-caret-right, .4375em, rtl);
	}
}

.pika-next
{
	&::before
	{
		.m-faContent(@fa-var-caret-right, .4375em, ltr);
		.m-faContent(@fa-var-caret-left, .4375em, rtl);
	}
}

.pika-prev {
	float: left;
	*left: 0;
}

.pika-next {
	float: right;
	*right: 0;
}

.pika-select {
	display: inline-block;
	*display: inline;
}

.pika-table {
	width: 100%;
	border-collapse: collapse;
	border-spacing: 0;
	border: 0;

	th,
	td {
		width: 14.285714285714286%;
		padding: 0;
	}

	th {
		color: @pd-th-color;
		font-size: 12px;
		line-height: 25px;
		font-weight: bold;
		text-align: center;
	}

	abbr {
		border-bottom: none;
	}
}

.pika-button {
	cursor: pointer;
	display: block;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	outline: none;
	border: 0;
	margin: 0;
	width: 100%;
	padding: 5px;
	color: @pd-day-color;
	font-size: 12px;
	line-height: 15px;
	text-align: right;
	background: @pd-day-bg;

	.is-today & {
		color: @pd-day-today-color;
		font-weight: bold;
	}

	.is-inrange &,
	.is-startrange &,
	.is-endrange & {
		color: @pd-range-color;
		background: @pd-range-bg;
	}

	.is-startrange &
	{
		.m-borderLeftRadius(3px);
		border-left: 2px solid @pd-range-border;
	}

	.is-endrange &
	{
		.m-borderRightRadius(3px);
		border-right: 2px solid @pd-range-border;
	}

	.is-selected & {
		color: @pd-day-selected-color;
		font-weight: bold;
		background: @pd-day-selected-bg;
		box-shadow: inset 0 1px 3px @pd-day-selected-shadow;
		border-radius: 3px;
	}

	.is-disabled &,
	.is-outside-current-month & {
		pointer-events: none;
		cursor: default;
		color: @pd-day-disabled-color;
		opacity: .3;
	}

	&:hover {
		color: @pd-day-hover-color;
		background: @pd-day-hover-bg;
		box-shadow: none;
		border-radius: 3px;
	}
}

.pika-week {
	font-size: 11px;
	color: @pd-week-color;
}

.pika-time-container {
	clear: both;
}

.pika-time {
	margin: 7px auto 7px;
}';
	return $__finalCompiled;
}
);