<?php
// FROM HASH: 18457ff4db8bed6e412f21ce1629424e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.progressBar
{
	overflow: hidden;
	width: 100%;
	vertical-align: top;
	background: linear-gradient(180deg, @xf-blockFooterBg, mix(@xf-blockFooterBg, @xf-contentBg, 50%));
	border: @xf-borderSize solid @xf-borderColorLight;
	position: relative;
}

.progressBar-progress
{
	background: @xf-contentAccentBg;
	width: 0;
	height: 20px;
	font-size: 80%;
	padding: 2px 0;
}

.progressBar-label
{
	position: absolute;
	overflow: hidden;
	left: 0;
	right: 0;
	color: rgba(0, 0, 0, 0.8);
	text-align: center;
}';
	return $__finalCompiled;
}
);