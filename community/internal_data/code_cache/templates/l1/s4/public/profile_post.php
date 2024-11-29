<?php
// FROM HASH: 70c7c9e191e5da867e1b3255f21f5b6a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Profile post for ' . $__templater->escape($__vars['profilePost']['ProfileUser']['username']) . '');
	$__finalCompiled .= '

';
	if ($__vars['canInlineMod']) {
		$__finalCompiled .= '
	';
		$__templater->includeJs(array(
			'src' => 'xf/inline_mod.js',
			'min' => '1',
		));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

' . $__templater->callMacro('lightbox_macros', 'setup', array(
		'canViewAttachments' => $__templater->method($__vars['profilePost'], 'canViewAttachments', array()),
	), $__vars) . '

<div class="block" data-xf-init="lightbox ' . ($__vars['canInlineMod'] ? 'inline-mod' : '') . '" data-type="profile_post" data-href="' . $__templater->func('link', array('inline-mod', ), true) . '">
	<div class="block-container">
		<div class="block-body">
			' . $__templater->callMacro('profile_post_macros', 'profile_post', array(
		'attachmentData' => $__vars['profilePostAttachData'][$__vars['profilePost']['profile_post_id']],
		'profilePost' => $__vars['profilePost'],
		'showTargetUser' => $__vars['showTargetUser'],
		'allowInlineMod' => $__vars['allowInlineMod'],
	), $__vars) . '
		</div>
	</div>
</div>
';
	return $__finalCompiled;
}
);