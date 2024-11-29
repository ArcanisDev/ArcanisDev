<?php
// FROM HASH: 33279fb88edc884988357e47861e87d5
return array(
'macros' => array('reaction_snippet' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'reactionUser' => '!',
		'reactionId' => '!',
		'profilePost' => '!',
		'date' => '!',
		'fallbackName' => 'Unknown member',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="contentRow-title">
		';
	if ($__vars['profilePost']['user_id'] == $__vars['profilePost']['profile_user_id']) {
		$__finalCompiled .= '
			';
		if ($__vars['profilePost']['user_id'] == $__vars['xf']['visitor']['user_id']) {
			$__finalCompiled .= '
				' . '' . $__templater->func('username_link', array($__vars['reactionUser'], false, array('defaultname' => $__vars['fallbackName'], ), ), true) . ' reacted to your <a ' . (('href="' . $__templater->func('link', array('profile-posts', $__vars['profilePost'], ), true)) . '"') . '>status</a> with ' . $__templater->filter($__templater->func('alert_reaction', array($__vars['reactionId'], 'medium', ), false), array(array('preescaped', array()),), true) . '.' . '
			';
		} else {
			$__finalCompiled .= '
				' . '' . $__templater->func('username_link', array($__vars['reactionUser'], false, array('defaultname' => $__vars['fallbackName'], ), ), true) . ' reacted to <a ' . (('href="' . $__templater->func('link', array('profile-posts', $__vars['profilePost'], ), true)) . '"') . '>' . $__templater->escape($__vars['profilePost']['username']) . '\'s status</a> with ' . $__templater->filter($__templater->func('alert_reaction', array($__vars['reactionId'], 'medium', ), false), array(array('preescaped', array()),), true) . '.' . '
			';
		}
		$__finalCompiled .= '
		';
	} else {
		$__finalCompiled .= '
			';
		if ($__vars['profilePost']['user_id'] == $__vars['xf']['visitor']['user_id']) {
			$__finalCompiled .= '
	
				' . '' . $__templater->func('username_link', array($__vars['reactionUser'], false, array('defaultname' => $__vars['fallbackName'], ), ), true) . ' reacted to <a ' . (('href="' . $__templater->func('link', array('profile-posts', $__vars['profilePost'], ), true)) . '"') . '>your post</a> on ' . $__templater->escape($__vars['profilePost']['ProfileUser']['username']) . '\'s profile with ' . $__templater->filter($__templater->func('alert_reaction', array($__vars['reactionId'], 'medium', ), false), array(array('preescaped', array()),), true) . '.' . '
			';
		} else if ($__vars['profilePost']['ProfileUser']['user_id'] == $__vars['xf']['visitor']['user_id']) {
			$__finalCompiled .= '
	
				' . '' . $__templater->func('username_link', array($__vars['reactionUser'], false, array('defaultname' => $__vars['fallbackName'], ), ), true) . ' reacted to <a ' . (('href="' . $__templater->func('link', array('profile-posts', $__vars['profilePost'], ), true)) . '"') . '>' . $__templater->escape($__vars['profilePost']['username']) . '\'s post</a> on your profile with ' . $__templater->filter($__templater->func('alert_reaction', array($__vars['reactionId'], 'medium', ), false), array(array('preescaped', array()),), true) . '.' . '
			';
		} else {
			$__finalCompiled .= '
	
				' . '' . $__templater->func('username_link', array($__vars['reactionUser'], false, array('defaultname' => $__vars['fallbackName'], ), ), true) . ' reacted to <a ' . (('href="' . $__templater->func('link', array('profile-posts', $__vars['profilePost'], ), true)) . '"') . '>' . $__templater->escape($__vars['profilePost']['username']) . '\'s post</a> on ' . $__templater->escape($__vars['profilePost']['ProfileUser']['username']) . '\'s profile with ' . $__templater->filter($__templater->func('alert_reaction', array($__vars['reactionId'], 'medium', ), false), array(array('preescaped', array()),), true) . '.' . '
			';
		}
		$__finalCompiled .= '
		';
	}
	$__finalCompiled .= '
	</div>
	
	<div class="contentRow-snippet">' . $__templater->func('snippet', array($__vars['profilePost']['message'], $__vars['xf']['options']['newsFeedMessageSnippetLength'], array('stripQuote' => true, ), ), true) . '</div>

	<div class="contentRow-minor">' . $__templater->func('date_dynamic', array($__vars['date'], array(
	))) . '</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . $__templater->callMacro(null, 'reaction_snippet', array(
		'reactionUser' => $__vars['reaction']['ReactionUser'],
		'reactionId' => $__vars['reaction']['reaction_id'],
		'profilePost' => $__vars['content'],
		'date' => $__vars['reaction']['reaction_date'],
	), $__vars);
	return $__finalCompiled;
}
);