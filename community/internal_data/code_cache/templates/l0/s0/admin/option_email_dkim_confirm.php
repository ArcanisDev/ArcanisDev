<?php
// FROM HASH: 630b614bd58464792b6b6e7c2ee97250
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Finish setting up DKIM email authentication');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('To finish setting up DKIM email authentication, you will need to add a new TXT record for your domain. If you are unsure how to do this, please contact your host or domain registrar. Outgoing emails will not be signed with DKIM until the presence of the DNS record is verified.', array(
	)) . '

			' . $__templater->formRow('TXT', array(
		'label' => 'Type',
	)) . '

			' . $__templater->formRow('
				<div class="inputGroup">
					' . $__templater->formTextBox(array(
		'value' => $__vars['dnsKey'],
		'disabled' => 'disabled',
		'class' => 'js-copyDnsKeyTarget',
	)) . '
					<span class="inputGroup-splitter"></span>
					' . $__templater->button('', array(
		'icon' => 'copy',
		'data-xf-init' => 'copy-to-clipboard',
		'data-copy-target' => '.js-copyDnsKeyTarget',
		'class' => 'button--link is-hidden',
	), '', array(
	)) . '
				</div>
			', array(
		'label' => 'Name',
		'rowtype' => 'button',
	)) . '

			' . $__templater->formRow('
				<div class="inputGroup">
					' . $__templater->formTextBox(array(
		'value' => $__vars['dnsValue'],
		'disabled' => 'disabled',
		'class' => 'js-copyDnsValueTarget',
	)) . '
					<span class="inputGroup-splitter"></span>
					' . $__templater->button('', array(
		'icon' => 'copy',
		'data-xf-init' => 'copy-to-clipboard',
		'data-copy-target' => '.js-copyDnsValueTarget',
		'class' => 'button--link is-hidden',
	), '', array(
	)) . '
				</div>
			', array(
		'label' => 'Value',
		'rowtype' => 'button',
	)) . '
		</div>
		
		' . $__templater->formSubmitRow(array(
		'submit' => 'Confirm',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('options/email-dkim-verify', $__vars['option'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);