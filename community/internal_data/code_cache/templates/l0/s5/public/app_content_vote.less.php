<?php
// FROM HASH: 578b7b43d2739174e8be6d8e894269bf
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '@_contentVote-controlsWidth: 1.41em;
@_contentVote-padding: @xf-paddingMedium;

.contentVote
{
	position: relative;
	display: flex;
	flex-direction: column;
	align-items: center;
	min-width: @_contentVote-controlsWidth;
	color: @xf-textColorMuted;
	font-size: @xf-fontSizeLargest;
}

.contentVote-vote
{
	color: inherit;
	text-decoration: none;
	line-height: 1;
	padding: @_contentVote-padding;
	.m-transition();

	&:hover
	{
		color: inherit;
		text-decoration: none;
	}

	&:before
	{
		.m-faBase();
	}

	&.is-disabled
	{
		opacity: 0.2;
		cursor: not-allowed;
	}

	.contentVote.is-voted &:not(.is-voted)
	{
		opacity: 0.5;
	}

	&.is-voted
	{
		.m-transform(scale(1.75));
	}

	&.contentVote-vote--up
	{
		&.is-voted
		{
			color: @xf-textColorAttention;
		}

		.m-faBefore(@fa-var-angle-up);
	}

	&.contentVote-vote--down
	{
		&.is-voted
		{
			color: @xf-textColorAttention;
		}

		.m-faBefore(@fa-var-angle-down);
	}
}

.contentVote-score
{
	direction: ltr;

	.message &:first-child
	{
		// if there\'s no upvote support, we want to maintain consistent padding
		padding-top: @_contentVote-padding;
	}

	.contentVote.is-voted &
	{
		color: @xf-textColorAttention;
	}
}

.contentVote-description
{
	font-size: @xf-fontSizeLarge;
}

.contentVote.contentVote--small
{
	font-size: @xf-fontSizeNormal;

	.contentVote-description
	{
		font-size: @xf-fontSizeSmaller;
	}
}

.contentVote.contentVote--placeholder
{
	.contentVote-score
	{
		line-height: 1;
	}
}

@media (max-width: @xf-messageSingleColumnWidth)
{
	.message
	{
		.contentVote
		{
			flex-direction: row;
			justify-content: center;
		}

		.contentVote-score
		{
			min-width: @_contentVote-controlsWidth;
			text-align: center;
			padding: 0 @_contentVote-padding;

			&:first-child
			{
				// override padding added here
				padding-top: 0;
			}
		}
	}

}';
	return $__finalCompiled;
}
);