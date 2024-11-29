<?php
// FROM HASH: 9e57c0a9795cdd9bd7aab7918856be1f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '// Vital base setup, don\'t change these!

html:after
{
	content: \'full\';
	display: none;

	@media (max-width: @xf-responsiveWide) { content: \'wide\'; }
	@media (max-width: @xf-responsiveMedium) { content: \'medium\'; }
	@media (max-width: @xf-responsiveNarrow) { content: \'narrow\'; }
}

*
{
	// global sizing calculations expect border-box
	box-sizing: border-box;
}

body
{
	// don\'t hide the vertical scrollbar
	overflow-y: scroll !important;
}


[data-xf-click], a[tabindex]
{
	// iOS doesn\'t bubble clicks up to the body where we have a listener, so we need to force that
	cursor: pointer;
}

[dir=auto]
{
	// this will get flipped in RT
	text-align: left;
}

pre, textarea
{
	// soft line wraps
	word-wrap: normal;
}

img
{
	// without specifying this, resized images look worse
	-ms-interpolation-mode: bicubic;
}

em
{
	&:lang(zh),
	&:lang(ja),
	&:lang(ko)
	{
	   font-style: normal;

		.bbWrapper &,
		.fr-element &
		{
			font-style: italic;
		}
	}
}

// #################################################
// Focus handlers, set by XF.NavDeviceWatcher (core.js)

.has-pointer-nav
{
	:focus
	{
		outline: 0
	}

	::-moz-focus-inner
	{
		border: 0;
	}

	.iconic > input:focus + i
	{
		&:before,
		&:after
		{
			outline: 0;
		}
	}
}

.m-keyframes(spin, {
	from
	{
		transform: rotate(0deg);
	}
	to
	{
		transform: rotate(360deg);
	}
});
';
	return $__finalCompiled;
}
);