<?php
// FROM HASH: 3f3bbafdd561ed55f35a0894e33c74e0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Account details');
	$__finalCompiled .= '

';
	$__templater->wrapTemplate('account_wrapper', $__vars);
	$__finalCompiled .= '

';
	if (!$__templater->method($__vars['xf']['visitor'], 'canEditProfile', array())) {
		$__finalCompiled .= '
	<div class="blockMessage blockMessage--important">' . 'Your full account details are not currently editable.' . '</div>
';
	}
	$__finalCompiled .= '

';
	if ($__vars['pendingUsernameChange']) {
		$__finalCompiled .= '
	<div class="blockMessage blockMessage--important">
		' . 'You recently requested to change your username to ' . $__templater->escape($__vars['pendingUsernameChange']['new_username']) . ' and this is currently awaiting approval by a moderator.' . '
	</div>
';
	}
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__templater->method($__vars['xf']['visitor'], 'canChangeUsername', array())) {
		$__compilerTemp1 .= '
					' . $__templater->button('Change', array(
			'href' => $__templater->func('link', array('account/username', ), false),
			'class' => 'button--link',
			'overlay' => 'true',
		), '', array(
		)) . '
				';
	}
	$__compilerTemp2 = '';
	$__compilerTemp3 = '';
	$__compilerTemp3 .= '
							';
	if ($__vars['xf']['visitor']['username_date']) {
		$__compilerTemp3 .= '
								' . 'Your username was last changed on ' . $__templater->func('date_time', array($__vars['xf']['visitor']['username_date'], ), true) . '.' . '
							';
	}
	$__compilerTemp3 .= '
							';
	if ($__vars['xf']['visitor']['next_allowed_username_change']) {
		$__compilerTemp3 .= '
								' . 'You may next change your username on or after ' . $__templater->func('date', array($__vars['xf']['visitor']['next_allowed_username_change'], ), true) . '.' . '
							';
	}
	$__compilerTemp3 .= '
						';
	if (strlen(trim($__compilerTemp3)) > 0) {
		$__compilerTemp2 .= '
					<div class="formRow-explain">
						' . $__compilerTemp3 . '
					</div>
				';
	}
	$__compilerTemp4 = '';
	if ($__vars['xf']['visitor']['email']) {
		$__compilerTemp4 .= '
					' . $__templater->filter($__vars['xf']['visitor']['email'], array(array('email_display', array()),), true) . '
				';
	} else {
		$__compilerTemp4 .= '
					<i>' . 'None' . '</i>
				';
	}
	$__compilerTemp5 = '';
	if ($__vars['canChangeEmail']) {
		$__compilerTemp5 .= '
					' . $__templater->button('Change', array(
			'href' => $__templater->func('link', array('account/email', ), false),
			'class' => 'button--link',
			'overlay' => 'true',
		), '', array(
		)) . '
				';
	}
	$__compilerTemp6 = '';
	if ($__templater->method($__vars['xf']['visitor'], 'canUploadAvatar', array())) {
		$__compilerTemp6 .= '
				' . $__templater->formRow('

					' . $__templater->func('avatar', array($__vars['xf']['visitor'], 'm', false, array(
			'href' => $__templater->func('link', array('account/avatar', ), false),
			'data-xf-click' => 'overlay',
		))) . '
				', array(
			'label' => 'Avatar',
			'explain' => 'Click the image to change your avatar.',
		)) . '
			';
	}
	$__compilerTemp7 = '';
	if ($__templater->method($__vars['xf']['visitor'], 'canUploadProfileBanner', array())) {
		$__compilerTemp7 .= '
				' . $__templater->formRow('

					' . $__templater->func('profile_banner', array($__vars['xf']['visitor'], 'l', false, array(
			'class' => 'memberProfileBanner--small',
			'href' => $__templater->func('link', array('account/banner', ), false),
			'overlay' => 'true',
			'hideempty' => 'true',
		), '')) . '
					' . $__templater->button('Edit profile banner', array(
			'href' => $__templater->func('link', array('account/banner', ), false),
			'data-xf-click' => 'overlay',
			'class' => 'button--link',
		), '', array(
		)) . '
				', array(
			'label' => 'Profile banner',
		)) . '
			';
	}
	$__compilerTemp8 = '';
	if ($__templater->method($__vars['xf']['visitor'], 'canEditProfile', array())) {
		$__compilerTemp8 .= '
				';
		if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('general', 'editCustomTitle', ))) {
			$__compilerTemp8 .= '
					' . $__templater->formTextBoxRow(array(
				'name' => 'user[custom_title]',
				'value' => $__vars['xf']['visitor']['custom_title_'],
				'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor'], 'custom_title', ), false),
			), array(
				'label' => 'Custom title',
				'explain' => 'If specified, this will replace the title that displays under your name in your posts.',
			)) . '
				';
		}
		$__compilerTemp8 .= '

				<hr class="formRowSep" />

				';
		if (($__vars['xf']['visitor']['Profile']['dob_day'] AND ($__vars['xf']['visitor']['Profile']['dob_month'] AND $__vars['xf']['visitor']['Profile']['dob_year']))) {
			$__compilerTemp8 .= '
					';
			$__vars['birthday'] = $__templater->method($__vars['xf']['visitor']['Profile'], 'getBirthday', array(true, ));
			$__compilerTemp8 .= $__templater->formRow('

						' . '' . '
						' . $__templater->func('date', array($__vars['birthday']['timeStamp'], $__vars['birthday']['format'], ), true) . '
					', array(
				'label' => 'Date of birth',
				'explain' => 'Once your birthday has been entered, it cannot be changed. Please contact an administrator if it is incorrect.',
			)) . '
				';
		} else {
			$__compilerTemp8 .= '
					' . $__templater->callMacro('helper_user_dob_edit', 'dob_edit', array(
				'dobData' => $__vars['xf']['visitor']['Profile'],
			), $__vars) . '
				';
		}
		$__compilerTemp8 .= '

				' . $__templater->callMacro('helper_account', 'dob_privacy_row', array(), $__vars) . '

				<hr class="formRowSep" />

				' . $__templater->formTextBoxRow(array(
			'name' => 'profile[location]',
			'value' => $__vars['xf']['visitor']['Profile']['location_'],
			'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor']['Profile'], 'location', ), false),
		), array(
			'hint' => ($__vars['xf']['options']['registrationSetup']['requireLocation'] ? 'Required' : ''),
			'label' => 'Location',
		)) . '
				' . $__templater->formTextBoxRow(array(
			'name' => 'profile[website]',
			'value' => $__vars['xf']['visitor']['Profile']['website_'],
			'type' => 'url',
			'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor']['Profile'], 'website', ), false),
		), array(
			'label' => 'Website',
		)) . '

				' . $__templater->callMacro('custom_fields_macros', 'custom_fields_edit', array(
			'type' => 'users',
			'group' => 'personal',
			'set' => $__vars['xf']['visitor']['Profile']['custom_fields'],
		), $__vars) . '

				<hr class="formRowSep" />

				' . $__templater->formEditorRow(array(
			'name' => 'about',
			'value' => $__vars['xf']['visitor']['Profile']['about_'],
			'previewable' => '0',
		), array(
			'label' => 'About you',
		)) . '
			';
	}
	$__compilerTemp9 = '';
	if ($__templater->method($__vars['xf']['visitor'], 'canEditProfile', array())) {
		$__compilerTemp9 .= '
			';
		$__compilerTemp10 = '';
		$__compilerTemp10 .= '
						' . $__templater->callMacro('custom_fields_macros', 'custom_fields_edit', array(
			'type' => 'users',
			'group' => 'contact',
			'set' => $__vars['xf']['visitor']['Profile']['custom_fields'],
		), $__vars) . '
					';
		if (strlen(trim($__compilerTemp10)) > 0) {
			$__compilerTemp9 .= '
				<h2 class="block-formSectionHeader"><span class="block-formSectionHeader-aligner">' . 'Identities' . '</span></h2>
				<div class="block-body">
					' . $__compilerTemp10 . '
				</div>
			';
		}
		$__compilerTemp9 .= '
			' . $__templater->formSubmitRow(array(
			'icon' => 'save',
			'sticky' => 'true',
		), array(
		)) . '
		';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRow('

				' . $__templater->escape($__vars['xf']['visitor']['username']) . '
				' . $__compilerTemp1 . '

				' . $__compilerTemp2 . '
			', array(
		'rowtype' => ($__templater->method($__vars['xf']['visitor'], 'canChangeUsername', array()) ? 'button' : ''),
		'label' => 'Username',
	)) . '

			' . $__templater->formRow('

				' . $__compilerTemp4 . '
				' . $__compilerTemp5 . '
			', array(
		'rowtype' => ($__vars['canChangeEmail'] ? 'button' : ''),
		'label' => 'Email',
	)) . '

			' . $__templater->callMacro('helper_account', 'email_options_row', array(
		'showExplain' => true,
	), $__vars) . '

			' . $__compilerTemp6 . '

			' . $__compilerTemp7 . '

			' . $__compilerTemp8 . '
		</div>
		' . $__compilerTemp9 . '
	</div>
', array(
		'action' => $__templater->func('link', array('account/account-details', ), false),
		'ajax' => 'true',
		'class' => 'block',
		'data-force-flash-message' => 'true',
	));
	return $__finalCompiled;
}
);