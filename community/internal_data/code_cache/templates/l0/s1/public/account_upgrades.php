<?php
// FROM HASH: 5a7fe95ea7d62d0cb5f39dc35322532c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Account upgrades');
	$__finalCompiled .= '

';
	$__templater->wrapTemplate('account_wrapper', $__vars);
	$__finalCompiled .= '

';
	$__templater->includeJs(array(
		'src' => 'xf/payment.js',
		'min' => '1',
	));
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '

		';
	if (!$__templater->test($__vars['available'], 'empty', array())) {
		$__compilerTemp1 .= '
			<div class="block">
				<div class="block-container">
					<h2 class="block-header">' . 'Available upgrades' . '</h2>

					<div class="block-body">
					';
		if ($__templater->isTraversable($__vars['available'])) {
			foreach ($__vars['available'] AS $__vars['upgrade']) {
				$__compilerTemp1 .= '
						';
				$__compilerTemp2 = '';
				if (($__templater->func('count', array($__vars['upgrade']['payment_profile_ids'], ), false) > 1)) {
					$__compilerTemp2 .= '
										';
					$__compilerTemp3 = array(array(
						'label' => $__vars['xf']['language']['parenthesis_open'] . 'Choose a payment method' . $__vars['xf']['language']['parenthesis_close'],
						'_type' => 'option',
					));
					if ($__templater->isTraversable($__vars['upgrade']['payment_profile_ids'])) {
						foreach ($__vars['upgrade']['payment_profile_ids'] AS $__vars['profileId']) {
							if ($__vars['profiles'][$__vars['profileId']]) {
								$__compilerTemp3[] = array(
									'value' => $__vars['profileId'],
									'label' => $__templater->escape($__vars['profiles'][$__vars['profileId']]),
									'_type' => 'option',
								);
							}
						}
					}
					$__compilerTemp2 .= $__templater->formSelect(array(
						'name' => 'payment_profile_id',
					), $__compilerTemp3) . '

										<span class="inputGroup-splitter"></span>

										' . $__templater->button('', array(
						'type' => 'submit',
						'icon' => 'purchase',
					), '', array(
					)) . '
									';
				} else {
					$__compilerTemp2 .= '
										' . $__templater->button('', array(
						'type' => 'submit',
						'icon' => 'purchase',
					), '', array(
					)) . '

										' . $__templater->formHiddenVal('payment_profile_id', $__templater->filter($__vars['upgrade']['payment_profile_ids'], array(array('first', array()),), false), array(
					)) . '
									';
				}
				$__compilerTemp1 .= $__templater->formRow('

							' . $__templater->form('
								<div class="inputGroup">
									' . $__compilerTemp2 . '
								</div>
								<div class="js-paymentProviderReply-user_upgrade' . $__templater->escape($__vars['upgrade']['user_upgrade_id']) . '"></div>
							', array(
					'action' => $__templater->func('link', array('purchase', $__vars['upgrade'], array('user_upgrade_id' => $__vars['upgrade']['user_upgrade_id'], ), ), false),
					'ajax' => 'true',
					'data-xf-init' => 'payment-provider-container',
				)) . '

						', array(
					'rowtype' => 'button',
					'label' => $__templater->escape($__vars['upgrade']['title']),
					'hint' => $__templater->escape($__vars['upgrade']['cost_phrase']),
					'explain' => $__templater->filter($__vars['upgrade']['description'], array(array('raw', array()),), true),
				)) . '
					';
			}
		}
		$__compilerTemp1 .= '
					</div>
				</div>
			</div>
		';
	}
	$__compilerTemp1 .= '

		';
	if (!$__templater->test($__vars['purchased'], 'empty', array())) {
		$__compilerTemp1 .= '
			<div class="block">
				<div class="block-container">
					<h2 class="block-header">' . 'Purchased upgrades' . '</h2>

					<ul class="block-body listPlain">
					';
		if ($__templater->isTraversable($__vars['purchased'])) {
			foreach ($__vars['purchased'] AS $__vars['upgrade']) {
				$__compilerTemp1 .= '
						<li>
							<div>
								';
				$__vars['active'] = $__vars['upgrade']['Active'][$__vars['xf']['visitor']['user_id']];
				$__compilerTemp1 .= '
								';
				$__compilerTemp4 = '';
				if ($__vars['active']['end_date']) {
					$__compilerTemp4 .= '
										' . 'Expires' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->func('date_dynamic', array($__vars['active']['end_date'], array(
					))) . '
									';
				} else {
					$__compilerTemp4 .= '
										' . 'Expires: Never' . '
									';
				}
				$__compilerTemp5 = '';
				if ($__vars['upgrade']['length_unit'] AND ($__vars['upgrade']['recurring'] AND $__vars['active']['PurchaseRequest'])) {
					$__compilerTemp5 .= '
										';
					$__vars['provider'] = $__vars['active']['PurchaseRequest']['PaymentProfile']['Provider'];
					$__compilerTemp5 .= '
										' . $__templater->filter($__templater->method($__vars['provider'], 'renderCancellation', array($__vars['active'], )), array(array('raw', array()),), true) . '
									';
				}
				$__compilerTemp1 .= $__templater->formRow('

									' . $__compilerTemp4 . '

									' . $__compilerTemp5 . '
								', array(
					'label' => $__templater->escape($__vars['upgrade']['title']),
					'hint' => $__templater->escape($__vars['upgrade']['cost_phrase']),
					'explain' => $__templater->filter($__vars['upgrade']['description'], array(array('raw', array()),), true),
				)) . '
							</div>
						</li>
					';
			}
		}
		$__compilerTemp1 .= '
					</ul>
				</div>
			</div>
		';
	}
	$__compilerTemp1 .= '
	';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
	' . $__compilerTemp1 . '
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'There are currently no purchasable user upgrades.' . '</div>
';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
);