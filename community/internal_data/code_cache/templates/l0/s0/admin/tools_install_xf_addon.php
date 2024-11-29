<?php
// FROM HASH: 61e07cc040543cdcc594d84bf591c26f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Install official XenForo add-ons');
	$__finalCompiled .= '

';
	$__compilerTemp1 = array();
	if ($__templater->isTraversable($__vars['installableAddOns'])) {
		foreach ($__vars['installableAddOns'] AS $__vars['addOnId'] => $__vars['install']) {
			$__compilerTemp1[] = array(
				'name' => 'confirm_install[' . $__vars['addOnId'] . ']',
				'value' => $__vars['install']['version_id'],
				'label' => '
						' . $__templater->escape($__vars['install']['title']) . ' <span class="u-muted">' . $__templater->escape($__vars['install']['version_string']) . '</span>
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
				' . 'One or more official XenForo add-ons are available to install.<br />
<br />
Select the add-ons you want to install below. The selected add-ons will be downloaded and the add-ons will be installed immediately.' . '
			', array(
	)) . '
			' . $__templater->formCheckBoxRow(array(
	), $__compilerTemp1, array(
		'label' => 'Installable add-ons',
	)) . '
			' . $__compilerTemp2 . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'download',
		'submit' => 'Download and install' . $__vars['xf']['language']['ellipsis'],
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('tools/install-xf-add-on', ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);