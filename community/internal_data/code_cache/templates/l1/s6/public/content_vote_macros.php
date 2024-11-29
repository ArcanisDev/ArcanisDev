<?php
// FROM HASH: 5df5c3735875a325c4cbaad052b3fa8b
return array(
'macros' => array('vote_control' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'link' => '!',
		'content' => '!',
		'extraClass' => '',
		'includeMicrodata' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__vars['currentVote'] = $__templater->method($__vars['content'], 'getVisitorContentVote', array());
	$__finalCompiled .= '
	';
	$__vars['canVote'] = $__templater->method($__vars['content'], 'canVoteOnContent', array());
	$__finalCompiled .= '
	<div class="contentVote ' . ($__vars['currentVote'] ? 'is-voted' : '') . ' js-contentVote ' . $__templater->escape($__vars['extraClass']) . '" data-xf-init="content-vote" data-content-id="' . $__templater->escape($__templater->method($__vars['content'], 'getEntityContentTypeId', array())) . '">
		';
	if ($__vars['includeMicrodata']) {
		$__finalCompiled .= '
			<meta itemprop="upvoteCount" content="' . $__templater->escape($__vars['content']['vote_score']) . '" />
		';
	}
	$__finalCompiled .= '

		<a href="' . ($__vars['canVote'] ? $__templater->func('link', array($__vars['link'], $__vars['content'], array('type' => 'up', ), ), true) : 'javascript:') . '"
			class="contentVote-vote ' . ($__vars['canVote'] ? '' : 'is-disabled') . ' contentVote-vote--up ' . ((($__vars['currentVote'] == 'up')) ? 'is-voted' : '') . '"
			data-vote="up"><span class="u-srOnly">' . 'Upvote' . '</span></a>

		<span class="contentVote-score ' . (($__vars['content']['vote_score'] > 0) ? 'is-positive' : '') . ' ' . (($__vars['content']['vote_score'] < 0) ? 'is-negative' : '') . ' js-voteCount"
			data-score="' . $__templater->escape($__vars['content']['vote_score']) . '">' . $__templater->escape($__vars['content']['vote_score_short']) . '</span>

		';
	if ($__templater->method($__vars['content'], 'isContentDownvoteSupported', array())) {
		$__finalCompiled .= '
			<a href="' . ($__vars['canVote'] ? $__templater->func('link', array($__vars['link'], $__vars['content'], array('type' => 'down', ), ), true) : 'javascript:') . '"
				class="contentVote-vote ' . ((($__vars['canVote'] AND $__templater->method($__vars['content'], 'canDownvoteContent', array()))) ? '' : 'is-disabled') . ' contentVote-vote--down ' . ((($__vars['currentVote'] == 'down')) ? 'is-voted' : '') . '"
				data-vote="down"><span class="u-srOnly">' . 'Downvote' . '</span></a>
		';
	}
	$__finalCompiled .= '
	</div>

';
	return $__finalCompiled;
}
),
'vote_display' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'content' => '!',
		'extraClass' => '',
		'includeMicrodata' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	<div class="contentVote js-contentVote contentVote--display ' . ($__templater->method($__vars['content'], 'getVisitorContentVote', array()) ? 'is-voted' : '') . ' ' . $__templater->escape($__vars['extraClass']) . '" data-content-id="' . $__templater->escape($__templater->method($__vars['content'], 'getEntityContentTypeId', array())) . '">
		';
	if ($__vars['includeMicrodata']) {
		$__finalCompiled .= '
			<meta itemprop="upvoteCount" content="' . $__templater->escape($__vars['content']['vote_score']) . '" />
		';
	}
	$__finalCompiled .= '

		<span class="contentVote-score ' . (($__vars['content']['vote_score'] > 0) ? 'is-positive' : '') . ' ' . (($__vars['content']['vote_score'] < 0) ? 'is-negative' : '') . ' js-voteCount" data-score="' . $__templater->escape($__vars['content']['vote_score']) . '">' . $__templater->escape($__vars['content']['vote_score_short']) . '</span>
		<span class="contentVote-description">' . (($__vars['content']['vote_score'] == 1) ? 'Vote' : 'Votes') . '</span>
	</div>

';
	return $__finalCompiled;
}
),
'vote_display_placeholder' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'extraClass' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	<div class="contentVote contentVote--display contentVote--placeholder ' . $__templater->escape($__vars['extraClass']) . '">
		<span class="contentVote-score">-</span>
		<span class="contentVote-description">' . 'Votes' . '</span>
	</div>

';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . '

';
	return $__finalCompiled;
}
);