<?php
// FROM HASH: fad07db146b9c036c91977ed71afa15c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Upgrade XenForo' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['availableUpdate']['version_string']));
	$__finalCompiled .= '

<div class="blocks">

<div class="blockMessage blockMessage--important">
	<b>' . 'Note' . $__vars['xf']['language']['label_separator'] . '</b>
	' . 'It is strongly recommended that you backup your database and files before proceeding. This is not done automatically.' . '
</div>

';
	$__compilerTemp1 = '';
	if ($__vars['availableUpdate']['significant_upgrade']) {
		$__compilerTemp1 .= '
					<br />
					<br />
					' . 'This is a significant upgrade that add new features and contains many changes. Newer versions of styles and add-ons may need to be installed after the upgrade is completed.<br />
<br />
For more details, please see our <a href="https://xenforo.com/community/forums/announcements/" target="_blank">release announcements</a>.' . '
				';
	}
	$__compilerTemp2 = '';
	if ($__vars['upgradeCheck']['license_agreement_required']) {
		$__compilerTemp2 .= '
				' . $__templater->formCheckBoxRow(array(
			'standalone' => 'true',
		), array(array(
			'name' => 'agree',
			'required' => 'required',
			'label' => 'I agree to and accept the terms of the <a href="https://xenforo.com/license-agreement/" target="_blank">XenForo license agreement</a>.',
			'_type' => 'option',
		)), array(
			'rowtype' => 'fullWidth noLabel',
			'explain' => 'License agreement last updated: ' . $__templater->func('date_dynamic', array($__vars['upgradeCheck']['last_agreement_update'], array(
		))),
		)) . '
			';
	}
	$__compilerTemp3 = '';
	if ($__vars['useLatest']) {
		$__compilerTemp3 .= '
		' . $__templater->formHiddenVal('latest', '1', array(
		)) . '
	';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			<div class="block-row">
				' . 'XenForo ' . $__templater->escape($__vars['availableUpdate']['version_string']) . ' is now available for installation.' . '
				' . $__compilerTemp1 . '

				<br />
				<br />
				' . 'You may upgrade to this version from within your control panel. If you proceed, the new version will be downloaded, files copied, and the upgrade will be applied.<br />
<br />
If a CLI upgrade is recommended, you will be given an opportunity to use that instead of the web upgrader.' . '
			</div>

			' . $__compilerTemp2 . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'download',
		'submit' => 'Download and upgrade' . $__vars['xf']['language']['ellipsis'],
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
	' . $__templater->formHiddenVal('confirm_version_id', $__vars['availableUpdate']['version_id'], array(
	)) . '
	' . $__compilerTemp3 . '
', array(
		'action' => $__templater->func('link', array('tools/upgrade-xf', ), false),
		'class' => 'block',
	)) . '

';
	if ($__vars['alternativeVersion']) {
		$__finalCompiled .= '
	<div class="blocks-textJoiner"><span></span><em>' . 'or' . '</em><span></span></div>

	<div class="block">
		<div class="block-container">
			<h2 class="block-minorHeader">' . 'Alternative upgrade: XenForo ' . $__templater->escape($__vars['alternativeVersion']['version_string']) . '' . '</h2>
			<div class="block-body block-row">
				' . 'XenForo ' . $__templater->escape($__vars['alternativeVersion']['version_string']) . ' is now available for installation.' . '
				<br />
				<br />
				' . 'This is a significant upgrade that add new features and contains many changes. Newer versions of styles and add-ons may need to be installed after the upgrade is completed.<br />
<br />
For more details, please see our <a href="https://xenforo.com/community/forums/announcements/" target="_blank">release announcements</a>.' . '
			</div>
			' . $__templater->formSubmitRow(array(
		), array(
			'rowtype' => 'simple',
			'html' => '
				' . $__templater->button('Upgrade to ' . $__templater->escape($__vars['alternativeVersion']['version_string']) . '' . $__vars['xf']['language']['ellipsis'], array(
			'href' => $__templater->func('link', array('tools/upgrade-xf', null, array('latest' => 1, ), ), false),
			'class' => 'button--primary',
		), '', array(
		)) . '
			',
		)) . '
		</div>
	</div>
';
	}
	$__finalCompiled .= '

</div>';
	return $__finalCompiled;
}
);