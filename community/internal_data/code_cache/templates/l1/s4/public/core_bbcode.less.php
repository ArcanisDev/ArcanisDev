<?php
// FROM HASH: 8038539ad5f8e3c10915c8775d16c9c9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.bbWrapper
{
	// This approach is needed to normalize browser differences that normalize.css won\'t handle within BB code/rich text
	// sections. You may need higher specificity to override some situations because of this.

	ol:not(.is-structureList),
	ul:not(.is-structureList)
	{
		margin-top: 1em;
		margin-bottom: 1em;
		overflow: hidden;
	}

	ol:not(.is-structureList) ol:not(.is-structureList),
	ol:not(.is-structureList) ul:not(.is-structureList),
	ul:not(.is-structureList) ol:not(.is-structureList),
	ul:not(.is-structureList) ul:not(.is-structureList)
	{
		margin-top: 0;
		margin-bottom: 0;
	}

	// note that changes to these rules will likely need to be replicated into editor.less
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

	> :first-child
	{
		margin-top: 0;
	}
}

.bbImage
{
	height: auto;
	max-width: 100%;
}

.bbImageWrapper
{
	display: inline-block;
	max-width: 100%;
}

// classes to handle images being floated left and right via BB code attributes
.bbImage,
.bbImageWrapper
{
	&.bbImageAligned--left
	{
		float: left;
		margin: @xf-bbCodeImgFloatMargin @xf-bbCodeImgFloatMarginAfter @xf-bbCodeImgFloatMarginAfter 0;
	}

	&.bbImageAligned--right
	{
		float: right;
		margin: @xf-bbCodeImgFloatMargin 0 @xf-bbCodeImgFloatMarginAfter @xf-bbCodeImgFloatMarginAfter;
	}
}

.bbMediaWrapper,
.bbMediaJustifier,
.bbOembed
{
	width: 560px;
	max-width: 100%;
	margin: 0;

	&.fb_iframe_widget
	{
		display: block;
	}

	.m-blockAligner();

	&.bbImageAligned--left
	{
		float: left;
		margin: @xf-bbCodeImgFloatMargin @xf-bbCodeImgFloatMarginAfter @xf-bbCodeImgFloatMarginAfter 0;
	}

	&.bbImageAligned--right
	{
		float: right;
		margin: @xf-bbCodeImgFloatMargin 0 @xf-bbCodeImgFloatMarginAfter @xf-bbCodeImgFloatMarginAfter;
	}
}

.fb_iframe_widget
{
	> span,
	iframe
	{
		max-width: 100%;
	}
}

.bbMediaWrapper.bbMediaWrapper--inline
{
	display: inline-block;
}

.bbMediaWrapper-inner
{
	position: relative;
	padding-bottom: 56.25%; /* 16:9 ratio */
	height: 0;

	&.bbMediaWrapper-inner--4to3
	{
		padding-bottom: 75%; /* 4:3 ratio */
	}

	&.bbMediaWrapper-inner--104px
	{
		padding-bottom: 104px;
	}

	&.bbMediaWrapper-inner--110px
	{
		padding-bottom: 110px;
	}

	&.bbMediaWrapper-inner--150px
	{
		padding-bottom: 150px;
	}

	&.bbMediaWrapper-inner--232px
	{
		padding-bottom: 232px;
	}

	&.bbMediaWrapper-inner--500px
	{
		padding-bottom: 500px;
	}

	&.bbMediaWrapper-inner--audio
	{
		padding-bottom: 60px;

		audio
		{
			outline: none;
		}
	}

	iframe,
	object,
	embed,
	video,
	audio,
	.bbMediaWrapper-fallback
	{
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
	}
}

.bbMediaWrapper-fallback
{
	display: flex;
	justify-content: center;
	align-items: center;
	max-width: 100%;
	.xf-minorBlockContent();
}

.bbOembed
{
	&.bbOembed--loaded
	{
		display: block;
	}

	iframe,
	object,
	embed,
	video,
	audio
	{
		max-width: 100%;
	}

	.embedly-card
	{
		margin: 0;
		background: white;
	}
}

.bbTable
{
	max-width: 100%;
	overflow: auto;

	.m-tableBase();
}

.bbCodePlainUnfurl
{
	&.link
	{
		display: block;
	}
}';
	return $__finalCompiled;
}
);