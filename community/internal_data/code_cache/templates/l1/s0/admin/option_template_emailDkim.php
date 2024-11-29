<?php
// FROM HASH: 3512dcc45f6bf5ef946eff0b3574ac79
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__vars['option']['option_value']['enabled']) {
		$__compilerTemp1 .= '
		';
		if ($__vars['option']['option_value']['verified']) {
			$__compilerTemp1 .= '
			<div class="block-rowMessage block-rowMessage--success">' . 'XenForo is signing your outgoing emails with DKIM.' . '</div>
		';
		} else if ($__vars['option']['option_value']['failed']) {
			$__compilerTemp1 .= '
			<div class="block-rowMessage block-rowMessage--error">' . 'We were unable to verify the DNS record. Please try the setup process again.' . '</div>
		';
		} else {
			$__compilerTemp1 .= '
			<div class="block-rowMessage block-rowMessage--warning">' . 'Attempting to verify your DNS record but it may take up to 24 hours for DNS changes to propagate. If it has been longer, you may need to verify your entries.' . '</div>
		';
		}
		$__compilerTemp1 .= '
	';
	}
	$__compilerTemp2 = '';
	if ($__vars['canUseEmailDkim']) {
		$__compilerTemp2 .= '
		<div class="u-inputSpacer">
			' . $__templater->button('
				' . ($__vars['option']['option_value']['enabled'] ? 'Change' : 'Enable') . '
			', array(
			'href' => $__templater->func('link', array('options/email-dkim-setup', $__vars['option'], ), false),
			'data-xf-click' => 'overlay',
		), '', array(
		)) . '
			';
		if ($__vars['option']['option_value']['enabled']) {
			$__compilerTemp2 .= '
				' . $__templater->button('
					' . 'Disable' . '
				', array(
				'href' => $__templater->func('link', array('options/email-dkim-disable', $__vars['option'], ), false),
			), '', array(
			)) . '
			';
		}
		$__compilerTemp2 .= '
		</div>
	';
	} else {
		$__compilerTemp2 .= '
		<div class="block-rowMessage block-rowMessage--error">' . $__templater->escape($__vars['error']) . '</div>
	';
	}
	$__finalCompiled .= $__templater->formRow('

	' . $__compilerTemp1 . '

	' . $__compilerTemp2 . '
', array(
		'label' => $__templater->escape($__vars['option']['title']),
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['explainHtml']),
		'rowclass' => $__vars['rowClass'],
	));
	return $__finalCompiled;
}
);