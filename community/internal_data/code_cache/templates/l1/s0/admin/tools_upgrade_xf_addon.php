<?php
// FROM HASH: 692c9e36468230d1964c1a900cb83faf
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Upgrade official XenForo add-ons');
	$__finalCompiled .= '

<div class="blockMessage blockMessage--important">
	<b>' . 'Note' . $__vars['xf']['language']['label_separator'] . '</b>
	' . 'It is strongly recommended that you backup your database and files before proceeding. This is not done automatically.' . '
</div>

';
	$__compilerTemp1 = array();
	if ($__templater->isTraversable($__vars['availableUpdates'])) {
		foreach ($__vars['availableUpdates'] AS $__vars['addOnId'] => $__vars['availableUpdate']) {
			$__compilerTemp1[] = array(
				'name' => 'confirm_updates[' . $__vars['addOnId'] . ']',
				'value' => $__vars['availableUpdate']['version_id'],
				'label' => '
						' . $__templater->escape($__vars['addOns'][$__vars['addOnId']]['title']) . ' <span class="u-muted">' . $__templater->escape($__vars['availableUpdate']['version_string']) . '</span>
					',
				'_type' => 'option',
			);
		}
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
			'rowtype' => '',
			'explain' => 'License agreement last updated: ' . $__templater->func('date_dynamic', array($__vars['upgradeCheck']['last_agreement_update'], array(
		))),
		)) . '
			';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'One or more updates are available for an official XenForo add-on that you have installed.<br />
<br />
Select the updates you want to install below. The selected updates will be downloaded and the upgrades will be applied immediately.' . '
			', array(
	)) . '
			' . $__templater->formCheckBoxRow(array(
	), $__compilerTemp1, array(
		'label' => 'Available add-on upgrades',
		'rowtype' => '',
	)) . '
			' . $__compilerTemp2 . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'download',
		'submit' => 'Download and upgrade' . $__vars['xf']['language']['ellipsis'],
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('tools/upgrade-xf-add-on', ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);