<?php
// FROM HASH: 2d4f43e19687e624c84ffe7b69fc8256
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '@_fileMinSize: 165px;
@_fileBorderRadius: @xf-borderRadiusSmall;

.attachmentUploads
{
	display: none;
	margin-bottom: @xf-paddingLarge;

	&.is-active
	{
		display: block;
	}

	&.attachmentUploads--spaced
	{
		margin-top: @xf-paddingLarge;
	}

	.hScroller-action
	{
		color: @xf-linkColor;

		&:hover
		{
			color: @xf-linkHoverColor;
		}

		&.hScroller-action--start
		{
			&:before
			{
				content: \'\';
				position: absolute;
				left: 0;
				height: 50px;
				width: 35px;
				background: @xf-contentBg;
				.m-borderRightRadius(@xf-borderRadiusMedium);
				.m-dropShadow(1px, 0, 4px, 1px, .3);
			}

			&:after
			{
				position: absolute;
				left: 10px;
			}
		}

		&.hScroller-action--end
		{
			&:before
			{
				content: \'\';
				position: absolute;
				right: 0;
				height: 50px;
				width: 35px;
				background: @xf-contentBg;
				.m-borderLeftRadius(@xf-borderRadiusMedium);
				.m-dropShadow(-1px, 0, 4px, 1px, .3);
			}

			&:after
			{
				position: absolute;
				right: 10px;
			}
		}
	}
}

.attachmentUploads-banner
{
	.xf-contentAltBase();
	border: @xf-borderSize solid @xf-borderColor;
	border-radius: @xf-borderRadiusSmall;
	margin-top: @xf-paddingLarge;
	padding: @xf-paddingSmall @xf-paddingMedium;
}

.attachmentUploads-selectActions
{
	.m-listPlain();
	display: none;
	font-size: @xf-fontSizeSmall;

	.attachmentUploads.is-selecting &
	{
		display: flex;
	}

	> li
	{
		margin-right: .35em;

		.buttonGroup
		{
			vertical-align: middle;
		}

		&:last-of-type
		{
			flex: 1 1 auto;
			text-align: right;
		}
	}

	.selectAll .iconic
	{
		cursor: pointer;

		input + i
		{
			color: @xf-linkColor;
		}
	}
}

.is-selecting button.js-attachmentSelect
{
	float: right;
}

.file
{
	position: relative;
	width: @_fileMinSize;
	height: @_fileMinSize;
	margin-right: @xf-paddingMedium;
	background: @xf-contentAltBg;
	border-radius: @_fileBorderRadius;

	&:last-child
	{
		margin-right: 0;
	}
}

.attachUploadList
{
	.m-listPlain();
	display: block;
	white-space: nowrap;
	font-size: 0;

	.file
	{
		display: inline-block;
		font-size: @xf-fontSizeNormal;
	}
}

.attachmentList
{
	.m-listPlain();

	display: flex;
	flex-wrap: wrap;

	.file
	{
		margin-bottom: @xf-paddingMedium;
	}
}

@supports (display: grid)
{
	.attachmentList
	{
		display: grid;
		grid-template-columns: repeat(auto-fill, minmax(@_fileMinSize, 1fr));
		grid-gap: @xf-paddingMedium;
		gap: @xf-paddingMedium;

		.file
		{
			width: 100%;
			height: auto;
			margin-right: 0;
			margin-bottom: 0;

			&:after
			{
				content: \'\';
				display: block;
				padding-bottom: 100%;
				pointer-events: none;
			}
		}
	}
}

.file-preview
{
	display: flex;
	align-items: center;
	justify-content: center;
	border-radius: @_fileBorderRadius;
	overflow: hidden;
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;

	img, video
	{
		position: absolute;
		top: 0;
		left: 0;
		object-fit: cover;
		width: 100%;
		height: 100%;
	}

	.file--linked &:after
	{
		content: \'\';
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		z-index: @zIndex-1;
	}
}

.file-typeIcon
{
	font-size: 80px;
	vertical-align: middle;
	color: @xf-textColorFeature;
}

.file-error
{
	color: @xf-textColorAttention;
	font-size: @xf-fontSizeSmaller;
	white-space: normal;
	padding: @xf-paddingMedium;
}

.file-progress
{
	position: relative;
	width: 100%;
	width: calc(~\'100% - 8px\');
	font-size: @xf-fontSizeSmallest;
	line-height: 1.3;

	i
	{
		position: absolute;
		top: 0;
		bottom: 0;
		left: 0;
		background: @xf-progressBarColor;
		color: contrast(@xf-progressBarColor);
		border-radius: @xf-borderRadiusSmall;
		padding-right: .2em;
		text-align: right;
		font-style: normal;
		white-space: nowrap;
		min-width: 2em;

		.m-transition(width);
	}
}

.file-content
{
	position: absolute;
	width: 100%;
	height: 100%;
}

.file-info
{
	position: absolute;
	left: 0;
	bottom: 0;
	width: 100%;
	padding: 0 @xf-paddingLarge;
	height: 2.5em;
	line-height: 2.5;
	overflow: hidden;
	.m-transition(height);
	.m-borderBottomRadius(@_fileBorderRadius);

	font-size: @xf-fontSizeSmaller;
	color: rgb(255, 255, 255);
	background: rgba(0, 0, 0, 0.5);
	text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.6);

	@supports (backdrop-filter: blur(3px)) or (-webkit-backdrop-filter: blur(3px))
	{
		.m-backdropFilter(blur(3px));
	}

	a&
	{
		color: rgb(255, 255, 255);

		&:hover
		{
			color: rgb(255, 255, 255);
			text-decoration: none;

			.file-name
			{
				text-decoration: underline;
			}
		}
	}

	&:hover,
	.file--linked:hover &,
	.has-touchevents &
	{
		height: 5em;
	}
}

.file-name,
.file-meta
{
	display: block;
	white-space: nowrap;
	text-overflow: ellipsis;
	overflow: hidden;
}

.file-delete,
.file-insert
{
	position: absolute;
	color: rgb(255, 255, 255);
	text-shadow: 1px 1px 1px rgba(0, 0, 0, .6);
}

.file-checkbox
{
	display: none;

	.attachmentUploads.is-selecting &
	{
		display: block;
	}

	.iconic
	{
		position: static;

		&:after
		{
			content: \'\';
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			z-index: @zIndex-1;
		}

		> i
		{
			position: absolute;
			top: 4px;
			left: 4px;
			box-sizing: content-box;
			width: 1em;
			height: 1em;
			color: rgb(220, 220, 220);
			text-shadow: 1px 1px 1px rgba(0, 0, 0, .6);
			background: rgba(0, 0, 0, .2);
			border-radius: @xf-borderRadiusMedium;
			padding: @xf-paddingMedium;
			line-height: 1;
		}

		&:hover > i
		{
			color: rgb(255, 255, 255);

			&:before
			{
				content: @fa-var-check-square;
			}
		}

		> input + i
		{
			&:before,
			&:after
			{
				top: @xf-paddingMedium;
				left: @xf-paddingMedium;
			}
		}

		> input:checked + i:after
		{
			font-weight: bold;
		}
	}
}

.file-insert
{
	top: 4px;
	left: 4px;
	font-size: @xf-fontSizeSmaller;
	max-width: (@_fileMinSize - 40px);
	white-space: normal;
	word-wrap: break-word;

	&.is-active
	{
		.file-insertLink
		{
			display: none;
		}

		.file-menuOptions
		{
			display: block;
		}
	}
}

.file-delete
{
	top: 4px;
	right: 4px;
	font-size: @xf-fontSizeNormal;
}

.file-insert,
.file-delete
{
	.attachmentUploads.is-selecting &
	{
		display: none;
	}
}

.file-insertLink,
.file-deleteLink
{
	display: inline-block;
}

a.file-deleteLink
{
	color: inherit;
	background: rgba(0, 0, 0, .2);
	border-radius: @xf-borderRadiusMedium;
	padding: @xf-paddingMedium;
	.m-transition(background);

	&:hover
	{
		text-decoration: none;
		background: rgba(0, 0, 0, .5);
	}
}

a.file-insertLink,
.file-menuOptions > a
{
	color: inherit;
	background: rgba(0, 0, 0, 0.4);
	border-radius: @xf-borderRadiusMedium;
	padding: @xf-paddingMedium;
	.m-transition(background);

	&:hover
	{
		text-decoration: none;
		background: rgba(0, 0, 0, .5);
	}
}

.file-menuOptions
{
	.m-listPlain();
	display: none;

	> a
	{
		display: block;
		margin-top: @xf-paddingSmall;
		max-width: max-content;

		&:first-child
		{
			margin-top: 0;
		}
	}
}

@media (max-width: @xf-responsiveNarrow)
{
	.attachmentUploads
	{
		.iconic-label,
		.insert-label
		{
			display: none;
		}
	}
}';
	return $__finalCompiled;
}
);