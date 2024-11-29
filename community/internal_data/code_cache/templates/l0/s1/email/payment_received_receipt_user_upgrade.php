<?php
// FROM HASH: fdd61de73981c6c9d6ceed96a9ffe556
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<mail:subject>' . 'Receipt for your account upgrade at ' . $__templater->escape($__vars['xf']['options']['boardTitle']) . '' . '</mail:subject>

<p>' . 'Thank you for purchasing an account upgrade at <a href="' . $__templater->func('link', array('canonical:index', ), true) . '">' . $__templater->escape($__vars['xf']['options']['boardTitle']) . '</a>.' . '</p>

<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr>
	<td><b>' . 'Purchased item' . '</b></td>
	<td align="right"><b>' . 'Price' . '</b></td>
</tr>
<tr>
	<td><a href="' . $__templater->func('link', array('canonical:account/upgrades', ), true) . '">' . $__templater->escape($__vars['purchasable']['title']) . '</a></td>
	<td align="right">' . $__templater->escape($__templater->method($__vars['purchasable']['purchasable'], 'getCostPhraseForPurchaseRequest', array($__vars['purchaseRequest'], ))) . '</td>
</tr>
</table>

<p><a href="' . $__templater->func('link', array('canonical:account/upgrades', ), true) . '" class="button">' . 'Manage your account upgrades' . '</a></p>

';
	if ($__templater->method($__vars['xf']['toUser'], 'canUseContactForm', array())) {
		$__finalCompiled .= '
	<p>' . 'Thank you for your purchase. If you have any questions, please <a href="' . $__templater->func('link', array('canonical:misc/contact', ), true) . '">contact us</a>.' . '</p>
';
	} else {
		$__finalCompiled .= '
	<p>' . 'Thank you for your purchase.' . '</p>
';
	}
	return $__finalCompiled;
}
);