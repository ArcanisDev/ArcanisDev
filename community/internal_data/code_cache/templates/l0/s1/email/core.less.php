<?php
// FROM HASH: 96d28f787815ee20c0e27a1117e4fa65
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '// NOTE: THIS DOES NOT HAVE ACCESS TO public:setup.less automatically!
// THE LESS HERE SHOULD BE KEPT AS SIMPLE AS POSSIBLE

body
{
	margin: 0;
	padding: 0;
	word-wrap: break-word;
	-ms-text-size-adjust: 100%;
	-webkit-text-size-adjust: 100%;

	background-color: @xf-emailBg;
	font-size: @xf-fontSizeNormal;
	font-family: @xf-emailFont;
	line-height: @xf-lineHeightDefault;
	color: @xf-emailTextColor;
}

table
{
	border-spacing: 0;
	mso-table-lspace: 0pt;
	mso-table-rspace: 0pt;
}

table,
td
{
	border-collapse: collapse;
}

a
{
	color: @xf-emailLinkColor;
	text-decoration: none;
}

.bbImage
{
	height: auto;
	max-width: 100%;
}

#bodyTable
{
	height: 100% !important;
	width: 100% !important;
	margin: 0;
	padding: 0;
	background-color: @xf-emailBg;
}

#bodyTableContainer
{
	background-color: @xf-emailBg;
}

.container
{
	width: 100%;
	max-width: 600px;
}

.header
{
	color: @xf-emailHeaderColor;
	padding: @xf-paddingMedium @xf-paddingLarge;
	border-top-left-radius: @xf-borderRadiusMedium;
	border-top-right-radius: @xf-borderRadiusMedium;
	font-family: @xf-emailFont;
	font-size: @xf-fontSizeLargest;
	line-height: @xf-lineHeightDefault;
}

.header a
{
	color: @xf-emailHeaderColor;
}

.content
{
	background-color: @xf-emailContentBg;
	border-radius: @xf-borderRadiusSmall;
	color: @xf-emailTextColor;
	padding: @xf-paddingLarge;
}

.content,
.content-inner
{
	font-size: @xf-fontSizeNormal;
	font-family: @xf-emailFont;
	line-height: @xf-lineHeightDefault;
}

.content .bbImage
{
	max-width: 100%;
}

.content > p:first-child
{
	margin-top: 0;
}

.content > p:last-child
{
	margin-bottom: 0;
}

.footer
{
	padding: @xf-paddingMedium @xf-paddingLarge;
	text-align: center;
	color: @xf-emailTextColorMuted;
	font-size: @xf-fontSizeSmall;
	font-family: @xf-emailFont;
	line-height: @xf-lineHeightDefault;
}

.footer a
{
	color: @xf-emailTextColorMuted;
	text-decoration: underline;
}

.footerExtra
{
	margin-top: 1em;
}

h2
{
	font-size: @xf-fontSizeLargest;
	font-weight: normal;
	margin: @xf-paddingLarge 0;
	padding: 0;
}

hr
{
	border: 0;
	border-bottom: @xf-borderSize solid @xf-emailBorderColor;
}

div.message
{
	border-left: @xf-borderSizeFeature solid @xf-borderColorFeature;
	margin: @xf-paddingLarge 0;
	padding: @xf-paddingLarge;
}

div.quote
{
	border-left: @xf-borderSizeFeature solid @xf-borderColorAttention;
	border-top: @xf-borderSize solid @xf-emailBorderColor;
	border-bottom: @xf-borderSize solid @xf-emailBorderColor;
	border-right: @xf-borderSize solid @xf-emailBorderColor;
	background: @xf-emailContentAltBg;
	margin: @xf-paddingLarge 0;
	padding: @xf-paddingLarge;
}

.quote-name
{
	color: @xf-textColorAttention;
	font-size: @xf-fontSizeSmall;
	margin-bottom: @xf-paddingMedium;
}

pre.code
{
	margin: @xf-paddingLarge 0;
	padding: @xf-paddingLarge;
	border-left: @xf-borderSizeFeature solid @xf-borderColorAttention;
	border-top: @xf-borderSize solid @xf-emailBorderColor;
	border-bottom: @xf-borderSize solid @xf-emailBorderColor;
	border-right: @xf-borderSize solid @xf-emailBorderColor;
	background: @xf-emailContentAltBg;
	max-width: 600px;
	overflow: auto;
}

.textLink
{
	color: @xf-emailTextColor;
	text-decoration: none;
}

.linkBar
{
	padding: @xf-paddingMedium;
	background-color: @xf-emailContentAltBg;
	border-top: @xf-borderSize solid @xf-emailBorderColor;
}

.button
{
	display: inline-block;
	padding: 5px 10px;
	background-color: @xf-buttonBg;
	border: none;
	border-radius: @xf-borderRadiusMedium;
	font-size: @xf-fontSizeSmall;
	color: @xf-buttonTextColor;
	text-decoration: none;
	white-space: nowrap;

	&.button--link
	{
		color: @xf-emailLinkColor;
		background-color: @xf-emailContentBg;
		border: @xf-borderSize solid @xf-emailBorderColor;
	}
}

.buttonFake
{
	display: inline-block;
	padding: 5px 10px;
	font-size: @xf-fontSizeSmall;
}

.minorText,
.unsubscribeLink
{
	font-size: @xf-fontSizeSmall;
	color: @xf-emailTextColorMuted;
}

.minorText a,
.unsubscribeLink a
{
	color: @xf-emailTextColorMuted;
	text-decoration: underline;
}

.unsubscribeLink
{
	margin-top: 1em;
	text-align: center;
}

.mediaPlaceholder,
.spoilerPlaceholder
{
	border-radius: @xf-borderRadiusSmall;
	margin: @xf-paddingMedium 0;
	padding: @xf-paddingMedium;
	font-size: @xf-fontSizeLargest;
	line-height: 3;
	text-align: center;
	border: @xf-borderSize solid @xf-emailBorderColor;
	background-color: @xf-emailContentAltBg;
}

.inlineSpoilerPlaceholder
{
	font-size: @xf-fontSizeSmall;
	background-color: @xf-contentAltBg;
	border: @xf-borderSize solid @xf-borderColorLight;
	border-radius: @xf-borderRadiusSmall;
	padding: 1px @xf-paddingSmall;
}

.u-opposite { text-align: right; }

// ################################ ACTIVITY SUMMARY ###############################

.p-activitySummary #bodyTableContainer
{
	padding: 0;
}

.summaryContentWrapper
{
	padding: 0 @xf-paddingLarge;
	max-width: 1200px;
}

.summaryHeaderBar
{
	color: @xf-chromeTextColor;
	background: @xf-chromeBg;
	font-family: @xf-emailFont;
	font-size: @xf-fontSizeLargest;
	line-height: @xf-lineHeightDefault;
	padding: @xf-paddingMedium @xf-paddingLarge;

	a
	{
		color:@xf-chromeTextColor;
	}

	img
	{
		max-height: 200px;
		vertical-align: bottom;

		&.logo-svg
		{
			max-width: 200px;
		}
	}
}

.summaryOuterHeader
{
	width: 100%;
	table-layout: fixed;
	margin: @xf-paddingLargest 0;
}

.summaryOuterHeader-content
{
	font-size: @xf-fontSizeLarger;
	font-weight: @xf-fontWeightNormal;
	color: @xf-emailTextColorMuted;
}

.summaryBlock
{
	color: @xf-emailTextColor;
	background-color: @xf-emailContentBg;
	border: @xf-borderSize solid @xf-emailBorderColor;
	border-radius: @xf-borderRadiusSmall;
	border-collapse: separate;

	width: 100%;
	table-layout: fixed;
	margin: @xf-paddingLargest 0;
}

.summaryBlock-header
{
	font-size: @xf-fontSizeLarger;
	color: @xf-majorHeadingTextColor;
	background: @xf-majorHeadingBg;
	border-bottom: @xf-borderSize solid @xf-borderColorLight;
	border-top-left-radius: @xf-borderRadiusSmall;
	border-top-right-radius: @xf-borderRadiusSmall;
	padding: @xf-blockPaddingV @xf-blockPaddingH;

	a
	{
		color: @xf-majorHeadingTextColor;
	}
}

.statsGroup
{
	display: flex;
	flex-flow: row wrap;
	font-size: @xf-fontSizeLarge;
}

.stat
{
	flex: auto;
	vertical-align: top;
	margin-right: @xf-paddingMedium;
	margin-bottom: @xf-paddingMedium;
}

.stat-label
{
	font-size: @xf-fontSizeSmall;
	color: @xf-emailTextColorMuted;
}

.p-activitySummary .content.content--attribution,
.p-activitySummary .content.content--footer,
.p-activitySummary .content.content--footer table
{
	font-size: @xf-fontSizeSmall;
	color: @xf-emailTextColorMuted;

	a:not(.button)
	{
		color: inherit;
		text-decoration: underline;
	}
}';
	return $__finalCompiled;
}
);