<?php
// FROM HASH: 84a425352733de5a3d178ee960e18ceb
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__vars['xf']['visitor']['user_id']) {
		$__finalCompiled .= '
';
		if ($__templater->func('property', array('xenfocus_guestEnable', ), false)) {
			$__finalCompiled .= '
<div class=\'focus-guest focus-guest-' . $__templater->func('property', array('xenfocus_guestLayout', ), true) . '\'>
    <div class=\'focus-guest-header\'>' . $__templater->escape($__vars['xf']['options']['boardTitle']) . '</div>
    <div class=\'focus-guest-align\'>
	    <div class=\'focus-guest-content\'>' . $__templater->func('property', array('xenfocus_guestContent', ), true) . '</div>
	    <ul class=\'focus-guest-buttons\'>
	        <li><a href="' . $__templater->func('link', array('login', ), true) . '" rel="nofollow" data-xf-click="overlay"><span>' . 'Log in' . '</span></a></li>
			';
			if ($__vars['xf']['options']['registrationSetup']['enabled']) {
				$__finalCompiled .= '<li><a href="' . $__templater->func('link', array('register', ), true) . '" rel="nofollow" data-xf-click="overlay"><span>' . 'Register' . '</span></a></li>';
			}
			$__finalCompiled .= '
	    </ul>
	</div>
</div>
';
		}
		$__finalCompiled .= '
';
	}
	return $__finalCompiled;
}
);