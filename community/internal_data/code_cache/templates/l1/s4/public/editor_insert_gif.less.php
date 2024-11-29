<?php
// FROM HASH: ad0225e43eec48fe749cb60f2e82eef0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '@_gifMinSize: 110px;
@_gifBorderRadius: @xf-borderRadiusSmall;

.gifContainer
{
	display: grid;
	grid-template-columns: repeat(auto-fill, minmax(@_gifMinSize, 1fr));
	grid-gap: @xf-paddingMedium;
}

.gifContainer-item
{
	position: relative;
	cursor: pointer;

	&:before
	{
		content: "";
		padding-bottom: 100%;
		display: inline-block;
		vertical-align: top;
	}

	img
	{
		position: absolute;
		object-fit: cover;
		width: 100%;
		height: 100%;
	}
}

.gifContainer-cover
{
	opacity: 0;
	text-align: center;
	position: absolute;
	background-color: rgba(0, 0, 0, 0.6);
	.m-textColoredLinks();
	color: white;
	text-shadow: -0.5px -0.5px 0 #000, 0.5px -0.5px 0 #000, -0.5px 0.5px 0 #000, 0.5px 0.5px 0 #000;
	width: 100%;
	height: 100%;
	z-index: 100;

	.m-loadingSpinner();
}';
	return $__finalCompiled;
}
);