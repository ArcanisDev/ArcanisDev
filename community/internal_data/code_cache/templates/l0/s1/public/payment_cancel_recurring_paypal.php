<?php
// FROM HASH: 964be987b86fb7e0386dc22e1fca63c1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div>
	' . $__templater->button('
		' . 'Cancel' . '
	', array(
		'href' => $__vars['endpoint'] . 'myaccount/autopay/',
		'target' => '_blank',
	), '', array(
	)) . '

	<div class="formRow-explain">
		' . 'Note: PayPal subscriptions can only be canceled from your PayPal account. If you do not have a PayPal account, please contact us or contact PayPal directly.' . '
	</div>
</div>';
	return $__finalCompiled;
}
);