<?php
// FROM HASH: b6b4a7b9ff9821f761b1bdbc553933a3
return array(
'macros' => array('privacy_option' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'user' => '!',
		'name' => '!',
		'label' => '!',
		'hideEveryone' => false,
		'hideFollowed' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['controlId'] = $__templater->func('unique_id', array(), false);
	$__finalCompiled .= '
	<dl class="inputLabelPair">
		<dt><label for="' . $__templater->escape($__vars['controlId']) . '">' . $__templater->escape($__vars['label']) . '</label></dt>
		<dd>
			';
	$__compilerTemp1 = array();
	if (!$__vars['hideEveryone']) {
		$__compilerTemp1[] = array(
			'value' => 'everyone',
			'label' => 'All visitors',
			'_type' => 'option',
		);
	}
	$__compilerTemp1[] = array(
		'value' => 'members',
		'label' => 'Members only',
		'_type' => 'option',
	);
	if (!$__vars['hideFollowed']) {
		$__compilerTemp1[] = array(
			'value' => 'followed',
			'label' => 'People you follow',
			'_type' => 'option',
		);
	}
	$__compilerTemp1[] = array(
		'value' => 'none',
		'label' => 'Nobody',
		'_type' => 'option',
	);
	$__finalCompiled .= $__templater->formSelect(array(
		'id' => $__vars['controlId'],
		'name' => 'privacy[' . $__vars['name'] . ']',
		'value' => $__vars['user']['Privacy'][$__vars['name']],
	), $__compilerTemp1) . '
		</dd>
	</dl>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Privacy');
	$__finalCompiled .= '

';
	$__templater->wrapTemplate('account_wrapper', $__vars);
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__templater->method($__vars['xf']['visitor'], 'canViewProfilePosts', array())) {
		$__compilerTemp1 .= '
					' . $__templater->callMacro(null, 'privacy_option', array(
			'user' => $__vars['xf']['visitor'],
			'name' => 'allow_post_profile',
			'label' => 'Post messages on your profile page',
			'hideEveryone' => true,
		), $__vars) . '
				';
	}
	$__compilerTemp2 = '';
	if ($__vars['xf']['options']['enableNewsFeed']) {
		$__compilerTemp2 .= '
					' . $__templater->callMacro(null, 'privacy_option', array(
			'user' => $__vars['xf']['visitor'],
			'name' => 'allow_receive_news_feed',
			'label' => 'Receive your news feed',
		), $__vars) . '
				';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->callMacro('helper_account', 'activity_privacy_row', array(), $__vars) . '
			' . $__templater->callMacro('helper_account', 'dob_privacy_row', array(), $__vars) . '
			' . $__templater->callMacro('helper_account', 'email_options_row', array(
		'showExplain' => true,
	), $__vars) . '

			' . $__templater->formRow('

				' . $__templater->callMacro(null, 'privacy_option', array(
		'user' => $__vars['xf']['visitor'],
		'name' => 'allow_view_profile',
		'label' => 'View your details on your profile page',
	), $__vars) . '

				' . $__compilerTemp1 . '

				' . $__compilerTemp2 . '

				' . $__templater->callMacro(null, 'privacy_option', array(
		'user' => $__vars['xf']['visitor'],
		'name' => 'allow_send_personal_conversation',
		'label' => 'Start conversations with you',
		'hideEveryone' => true,
	), $__vars) . '

				' . $__templater->callMacro(null, 'privacy_option', array(
		'user' => $__vars['xf']['visitor'],
		'name' => 'allow_view_identities',
		'label' => 'View your identities',
	), $__vars) . '
			', array(
		'rowtype' => 'inputLabelPair',
		'label' => 'Allow users to',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'sticky' => 'true',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('account/privacy', ), false),
		'ajax' => 'true',
		'class' => 'block',
		'data-force-flash-message' => 'true',
	)) . '

';
	return $__finalCompiled;
}
);