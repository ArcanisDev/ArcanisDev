<?php
// FROM HASH: 68f7a2011f9b79cdd3c4330e815a1fca
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.alert
{
	&.is-unread
	{
		.xf-contentHighlightBase();
	}
}

.alertToggler
{
	text-decoration: none !important;
	padding: @xf-paddingMedium;
	margin-right: -@xf-paddingMedium;

	.alert &
	{
		opacity: 0;
	}

	.alert:hover &,
	.has-touchevents &
	{
		opacity: 1;
	}
}

.alertToggler-icon
{
	font-size: .75em;
	font-weight: min(@xf-fontAwesomeWeight, @faWeight-regular);

	.is-unread &
	{
		font-weight: @faWeight-solid;
	}
}';
	return $__finalCompiled;
}
);