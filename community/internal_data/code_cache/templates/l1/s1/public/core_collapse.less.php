<?php
// FROM HASH: 0c3e69dfbe6f07e68cd70374248a5b68
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '// ########################################## COLLAPSE / TOGGLERS ##############################

.toggleTarget
{
	display: none;
	.m-transition(all, -xf-height;);
	overflow: hidden;
	height: 0;
	opacity: 0;

	&.is-transitioning
	{
		display: block;
	}

	&.is-active
	{
		display: block;
		height: auto;
		opacity: 1;
	}
}

.collapseTrigger:not(.button)
{
	cursor: pointer;

	&:before
	{
		.m-faBase(\'Pro\', @faWeight-solid);
		.m-faContent(@fa-var-caret-right); //, .63em
		font-size: 80%;
		margin-right: .2em;
	}

	&.is-active:before
	{
		.m-faContent(@fa-var-caret-down); //, .63em
	}

	&.collapseTrigger--block
	{
		display: block;

		&:before
		{
			float: right;
			margin-right: 0;
			margin-left: 5px;
			font-size: 100%;
			line-height: inherit;
		}
	}
}

.collapseTrigger.button--icon
{
	.m-buttonIcon(@fa-var-angle-right, .63em); // only .5em but it\'s a toggle

	&.is-active
	{
		.m-buttonIcon(@fa-var-angle-down, .63em);
	}
}';
	return $__finalCompiled;
}
);