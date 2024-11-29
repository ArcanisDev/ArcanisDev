<?php
// FROM HASH: 4ede2397ec89be4e6c0086019a2c7183
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '// ############################ FIXED MESSAGE BAR ################

.fixedMessageBar
{
	.xf-fixedMessage();
	.m-transitionFadeDown();
	.m-clearFix();
}

.fixedMessageBar-inner
{
	display: flex;
	align-items: center;
	justify-content: space-between;
}

.fixedMessageBar-message
{
	order: 1;
}

.fixedMessageBar-close
{
	float: right;
	margin-left: 1em;
	order: 2;
	color: inherit;

	&:before
	{
		.m-faBase();
		.m-faContent(@fa-var-times); //, .69em
	}

	&:hover
	{
		text-decoration: none;
		color: xf-intensify(@xf-fixedMessage--color, 10%);
	}
}';
	return $__finalCompiled;
}
);