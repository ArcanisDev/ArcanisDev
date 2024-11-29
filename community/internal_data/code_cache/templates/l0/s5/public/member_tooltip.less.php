<?php
// FROM HASH: 8dd3ad88c25be0efd00622ecbb047d7f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '@_memberTooltip-padding: @xf-paddingMedium;
@_memberTooltip-avatarSize: @avatar-m;

.memberTooltip-header
{
	display: table;
	table-layout: fixed;
	width: 100%;
	padding: @_memberTooltip-padding;
	.xf-memberTooltipHeader();
}

.memberTooltip-avatar
{
	display: table-cell;
	width: ((@_memberTooltip-padding) * 2 + (@_memberTooltip-avatarSize));
	vertical-align: top;
}

.memberTooltip-headerInfo
{
	display: table-cell;
	vertical-align: top;
}

.memberTooltip-name
{
	margin: 0;
	margin-top: -.15em;
	padding: 0;
	font-weight: @xf-fontWeightNormal;
	line-height: .8 * (@xf-lineHeightDefault);
	.xf-memberTooltipName();

	.m-hiddenLinks();

	.memberTooltip-nameChangeIndicator
	{
		color: @xf-textColorMuted;
		font-size: 75%;

		&:hover
		{
			color: @xf-textColorMuted;
		}
	}

	.memberTooltip--withBanner &
	{
		.xf-memberTooltipNameBanner();

		.memberTooltip-nameChangeIndicator
		{
			color: darken(xf-default(@xf-memberTooltipNameBanner--color, white), 20%);

			&:hover
			{
				color: darken(xf-default(@xf-memberTooltipNameBanner--color, white), 20%);
			}
		}
	}
}

// See XF-197998
@_memberTooltip-textStroke: 0 #000;

.memberTooltip-textStroke()
{
	text-shadow:
		-1px -1px @_memberTooltip-textStroke,
		1px -1px @_memberTooltip-textStroke,
		-1px 1px @_memberTooltip-textStroke,
		1px 1px @_memberTooltip-textStroke;
}

.memberTooltip--withBanner
{
	.memberTooltip-nameWrapper
	{
		.username:hover
		{
			text-decoration: none;
		}
	}

	.username
	{
		.memberTooltip-textStroke();
	}

	.memberTooltip-nameChangeIndicator .fa-history
	{
		.memberTooltip-textStroke();
	}
}

.memberTooltip-headerAction
{
	float: right;
}

.memberTooltip-blurbContainer
{
	.memberTooltip--withBanner &
	{
		.xf-memberTooltipBlurbContainerBanner();

		.memberTooltip-blurb
		{
			&:first-child
			{
				margin-top: 0;
			}

			.pairs dt, a
			{
				color: darken(xf-default(@xf-memberTooltipBlurbContainerBanner--color, white), 20%);
			}
		}
	}
}

.memberTooltip-banners,
.memberTooltip-blurb
{
	margin-top: .25em;
}

.memberTooltip-blurb
{
	font-size: @xf-fontSizeSmall;
}

.memberTooltip-stats
{
	font-size: @xf-fontSizeSmall;

	dl.pairs.pairs--rows > dt
	{
		font-size: @xf-fontSizeSmaller;
	}
}

.memberTooltip-info,
.memberTooltip-actions
{
	padding: @_memberTooltip-padding;
}

.memberTooltip-separator
{
	margin: -@xf-borderSize @_memberTooltip-padding 0;
	border: none;
	border-top: @xf-borderSize solid @xf-borderColorLight;
}

@media (max-width: @xf-responsiveNarrow)
{
	.memberTooltip-avatar
	{
		width: ((@_memberTooltip-padding) * 2 + (@_memberTooltip-avatarSize * 2 / 3));

		.avatar
		{
			.m-avatarSize(@_memberTooltip-avatarSize * 2 / 3);
		}
	}
}';
	return $__finalCompiled;
}
);