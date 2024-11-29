<?php
// FROM HASH: 3d811718202f126aff368b2c86ad9b31
return array(
'macros' => array('cookie_consent_form' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

		<div class="cookies-main">
			<h2>' . 'We value your privacy' . '</h2>
			<p>' . 'We use essential <a href="' . $__templater->func('link', array('help/cookies', ), true) . '">cookies</a> to make this site work, and optional cookies to enhance your experience.' . '</p>
			<p><a href="#" data-xf-click="toggle" data-target="#cookieConsentConfig">' . 'See further information and configure your preferences' . '</a></p>
		</div>

		<div class="cookies-buttons u-inputSpacer _u-alignCenter">
			' . $__templater->button('

				' . 'Accept all cookies' . '
			', array(
		'href' => $__templater->func('link', array('misc/cookies', null, array('update' => true, 'accept' => true, 't' => $__templater->func('csrf_token', array(), false), ), ), false),
		'class' => 'button--notice button--primary',
		'data-xf-click' => 'cookie-consent',
		'xicon' => 'confirm',
	), '', array(
	)) . '

			' . $__templater->button('

				' . 'Reject optional cookies' . '
			', array(
		'href' => $__templater->func('link', array('misc/cookies', null, array('update' => true, 'reject' => true, 't' => $__templater->func('csrf_token', array(), false), ), ), false),
		'class' => 'button--link',
		'data-xf-click' => 'cookie-consent',
		'xicon' => 'cancel',
	), '', array(
	)) . '
		</div>

	';
	$__compilerTemp1 = '';
	$__compilerTemp2 = $__templater->method($__vars['xf']['cookieConsent'], 'getGroups', array(false, false, ));
	if ($__templater->isTraversable($__compilerTemp2)) {
		foreach ($__compilerTemp2 AS $__vars['group']) {
			$__compilerTemp1 .= '
				' . $__templater->formCheckBoxRow(array(
			), array(array(
				'name' => 'consent[' . $__vars['group'] . ']',
				'selected' => $__templater->method($__vars['xf']['cookieConsent'], 'isGroupConsented', array($__vars['group'], )),
				'class' => 'js-consent_' . $__vars['group'],
				'labelclass' => 'iconic--toggle',
				'label' => $__templater->escape($__templater->method($__vars['xf']['cookieConsent'], 'getGroupLabel', array($__vars['group'], ))),
				'_type' => 'option',
			)), array(
				'rowtype' => 'fullWidth',
				'explain' => $__templater->escape($__templater->method($__vars['xf']['cookieConsent'], 'getGroupDescription', array($__vars['group'], ))),
			)) . '
			';
		}
	}
	$__compilerTemp3 = '';
	if ($__vars['xf']['privacyPolicyUrl']) {
		$__compilerTemp3 .= '
						<li><a href="' . $__templater->escape($__vars['xf']['privacyPolicyUrl']) . '">' . 'Privacy policy' . '</a></li>
					';
	}
	$__finalCompiled .= $__templater->form('

		<div class="cookies-options">

			' . $__templater->formCheckBoxRow(array(
	), array(array(
		'selected' => true,
		'disabled' => true,
		'labelclass' => 'iconic--toggle',
		'label' => $__templater->escape($__templater->method($__vars['xf']['cookieConsent'], 'getGroupLabel', array('_required', ))),
		'_type' => 'option',
	)), array(
		'rowtype' => 'fullWidth',
		'explain' => $__templater->escape($__templater->method($__vars['xf']['cookieConsent'], 'getGroupDescription', array('_required', ))),
	)) . '

			' . $__compilerTemp1 . '

			' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'consent[_third_party]',
		'selected' => $__templater->method($__vars['xf']['cookieConsent'], 'isGroupConsented', array('_third_party', )),
		'class' => 'js-consent__third_party',
		'labelclass' => 'iconic--toggle',
		'label' => $__templater->escape($__templater->method($__vars['xf']['cookieConsent'], 'getGroupLabel', array('_third_party', ))),
		'_type' => 'option',
	)), array(
		'rowtype' => 'fullWidth',
		'explain' => $__templater->escape($__templater->method($__vars['xf']['cookieConsent'], 'getGroupDescription', array('_third_party', ))),
	)) . '

			' . $__templater->formRow('
				<ul class="listInline listInline--bullet">
					<li><a href="' . $__templater->func('link', array('help/cookies', ), true) . '">' . 'Detailed cookie usage' . '</a></li>
					' . $__compilerTemp3 . '
				</ul>
			', array(
		'rowtype' => 'fullWidth',
	)) . '

		</div>

		' . $__templater->button('Save cookie preferences', array(
		'type' => 'submit',
		'class' => 'button--notice',
	), '', array(
	)) . '
	', array(
		'action' => $__templater->func('link', array('misc/cookies', null, array('update' => true, ), ), false),
		'ajax' => 'true',
		'data-force-flash-message' => 'true',
		'data-xf-init' => 'cookie-consent-form',
		'id' => 'cookieConsentConfig',
	)) . '

';
	return $__finalCompiled;
}
),
'third_party_consent_form' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'unconsented' => array(),
		'embedHtml' => '',
		'siteId' => '',
		'id' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__compilerTemp1 = '';
	if ($__vars['embedHtml']) {
		$__compilerTemp1 .= '
			<template class="js-embedHtml">' . $__templater->filter($__vars['embedHtml'], array(array('raw', array()),), true) . '</template>
		';
	}
	$__finalCompiled .= $__templater->form('

		<div class="block-rowMessage block-rowMessage--alt">
			<div class="u-dimmed u-smaller">
				' . 'To view this content we will need your consent to set third party cookies.<br>
For more detailed information, see our <a href="' . $__templater->func('link', array('help/cookies', ), true) . '">cookies page</a>.
' . '
			</div>
			<div class="u-inputSpacer">
				' . $__templater->button('Accept third party cookies', array(
		'type' => 'submit',
		'class' => 'button--small',
	), '', array(
	)) . '
			</div>

			' . $__templater->formHiddenVal('consent[_third_party]', '1', array(
	)) . '
			' . $__templater->formHiddenVal('_xfRedirect', $__vars['redirect'], array(
	)) . '
		</div>

		' . $__compilerTemp1 . '
	', array(
		'action' => $__templater->func('link', array('misc/cookies', null, array('update' => true, 'add' => true, ), ), false),
		'class' => 'bbMediaJustifier',
		'ajax' => 'true',
		'data-redirect' => 'off',
		'data-media-site-id' => $__vars['siteId'],
		'data-media-key' => $__vars['id'],
		'data-xf-init' => 'cookie-consent-form',
	)) . '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('We value your privacy');
	$__finalCompiled .= '

';
	$__templater->setPageParam('head.' . 'robots', $__templater->preEscaped('<meta name="robots" content="noindex" />'));
	$__finalCompiled .= '

';
	if ($__vars['unconsentedGroups'] OR $__vars['unconsentedThirdParties']) {
		$__finalCompiled .= '
	';
		$__compilerTemp1 = '';
		if ($__vars['unconsentedGroups']) {
			$__compilerTemp1 .= '
						';
			if ($__templater->isTraversable($__vars['unconsented'])) {
				foreach ($__vars['unconsented'] AS $__vars['group']) {
					$__compilerTemp1 .= '
							<dl class="pairs">
								<dt>' . $__templater->escape($__templater->method($__vars['xf']['cookieConsent'], 'getGroupLabel', array($__vars['group'], ))) . '</dt>
								<dd>' . $__templater->escape($__templater->method($__vars['xf']['cookieConsent'], 'getGroupDescription', array($__vars['group'], ))) . '</dd>
							</dl>

							' . $__templater->formHiddenVal('consent[' . $__vars['group'] . ']', '1', array(
					)) . '
						';
				}
			}
			$__compilerTemp1 .= '
					';
		}
		$__compilerTemp2 = '';
		if ($__vars['unconsentedThirdParties']) {
			$__compilerTemp2 .= '
						<dl class="pairs">
							<dt>' . $__templater->escape($__templater->method($__vars['xf']['cookieConsent'], 'getGroupLabel', array('_third_party', ))) . '</dt>
							<dd>' . $__templater->escape($__templater->method($__vars['xf']['cookieConsent'], 'getGroupDescription', array('_third_party', ))) . '</dd>
						</dl>

						' . $__templater->formHiddenVal('consent[_third_party]', '1', array(
			)) . '
					';
		}
		$__finalCompiled .= $__templater->form('

		<div class="block-container">
			<div class="block-body">
				' . $__templater->formInfoRow('
					' . 'To access this page, we will need your consent to set some cookies.' . '
				', array(
		)) . '

				' . $__templater->formRow('
					' . $__compilerTemp1 . '

					' . $__compilerTemp2 . '
				', array(
			'rowtype' => 'fullWidth',
		)) . '
			</div>

			' . $__templater->func('redirect_input', array($__vars['redirect'], null, true)) . '

			' . $__templater->formSubmitRow(array(
			'submit' => 'Accept third party cookies',
		), array(
			'rowtype' => 'simple',
		)) . '
		</div>
	', array(
			'action' => $__templater->func('link', array('misc/cookies', null, array('update' => true, 'add' => true, ), ), false),
			'class' => 'block',
			'ajax' => 'true',
			'data-force-flash-message' => 'true',
			'data-xf-init' => 'cookie-consent-form',
		)) . '
';
	} else {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<div class="block-body block-row">
				' . $__templater->callMacro(null, 'cookie_consent_form', array(), $__vars) . '
			</div>
		</div>
	</div>
';
	}
	$__finalCompiled .= '

' . '

';
	return $__finalCompiled;
}
);