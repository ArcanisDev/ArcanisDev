<?php
// FROM HASH: 2e113d5ed1e99da078b26cd414a24e26
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Register');
	$__finalCompiled .= '

';
	$__templater->setPageParam('head.' . 'robots', $__templater->preEscaped('<meta name="robots" content="noindex" />'));
	$__finalCompiled .= '

<div class="blockMessage">
	';
	if ($__vars['xf']['visitor']['user_state'] == 'email_confirm') {
		$__finalCompiled .= '
		' . 'Thanks for registering. In order to complete your registration, you must follow the link in the email that has been sent to you.' . '
		';
		if ($__vars['hasPreRegAction']) {
			$__finalCompiled .= '
			<br /><br />
			' . 'Once your registration has been completed, your content will be posted automatically.' . '
		';
		}
		$__finalCompiled .= '
	';
	} else if ($__vars['xf']['visitor']['user_state'] == 'moderated') {
		$__finalCompiled .= '
		' . 'Thanks for registering. Your registration must now be approved by an administrator. You will receive an email when a decision has been taken.' . '
		';
		if ($__vars['hasPreRegAction']) {
			$__finalCompiled .= '
			<br /><br />
			' . 'Once your registration has been completed, your content will be posted automatically.' . '
		';
		}
		$__finalCompiled .= '
	';
	} else if ($__vars['facebook']) {
		$__finalCompiled .= '
		' . 'Thanks for creating an account using Facebook. Your account is now fully active.' . '
	';
	} else {
		$__finalCompiled .= '
		' . 'Thanks for registering. Your registration is now complete.' . '
	';
	}
	$__finalCompiled .= '

	';
	if ($__vars['xf']['session']['preRegContentUrl']) {
		$__finalCompiled .= '
		<br />
		<br />
		' . 'The content you created before registering has been posted automatically.' . '
		<div style="margin-top: .5em">
			' . $__templater->button('View your content', array(
			'href' => $__vars['xf']['session']['preRegContentUrl'],
		), '', array(
		)) . '
		</div>
	';
	}
	$__finalCompiled .= '

	<ul>
		';
	if ($__vars['redirect']) {
		$__finalCompiled .= '<li><a href="' . $__templater->func('link', array($__vars['redirect'], ), true) . '">' . 'Return to the page you were viewing' . '</a></li>';
	}
	$__finalCompiled .= '
		<li><a href="' . $__templater->func('link', array('index', ), true) . '">' . 'Return to the forum home page' . '</a></li>
		';
	if ($__templater->method($__vars['xf']['visitor'], 'canEditProfile', array())) {
		$__finalCompiled .= '
			<li><a href="' . $__templater->func('link', array('account', ), true) . '">' . 'Edit your account details' . '</a></li>
		';
	}
	$__finalCompiled .= '
	</ul>
</div>';
	return $__finalCompiled;
}
);