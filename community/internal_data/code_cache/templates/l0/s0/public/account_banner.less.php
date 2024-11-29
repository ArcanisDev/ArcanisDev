<?php
// FROM HASH: ce464b27650898e20a8d6caec55bb064
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.profileBannerContainer
{
	display: none;

	+ .formRow
	{
		border-width: 0;
	}

	&.profileBannerContainer--withBanner
	{
		display: block;

		+ .formRow
		{
			border-width: 1px;
		}

		.profileBannerContainer-explain
		{
			margin: @xf-paddingMedium;
			font-style: normal;
			.xf-formExplain();
			.m-textColoredLinks();
		}
	}

	.memberProfileBanner
	{
		height: 200px;
	}
}';
	return $__finalCompiled;
}
);