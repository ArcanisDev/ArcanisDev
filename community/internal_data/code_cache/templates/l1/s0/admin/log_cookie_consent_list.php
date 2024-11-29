<?php
// FROM HASH: 87f6761b02943beaaf58873f546d3824
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Cookie consent log');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body block-row">
			' . $__templater->formTextBox(array(
		'name' => 'username',
		'value' => ($__vars['limitUser'] ? $__vars['limitUser']['username'] : ''),
		'type' => 'search',
		'class' => 'input--inline',
		'placeholder' => 'Username' . $__vars['xf']['language']['ellipsis'],
	)) . '

			' . $__templater->formTextBox(array(
		'name' => 'ip',
		'value' => $__vars['limitIp'],
		'type' => 'search',
		'class' => 'input--inline',
		'placeholder' => 'IP address' . $__vars['xf']['language']['ellipsis'],
	)) . '

			' . $__templater->button('Filter', array(
		'type' => 'submit',
	), '', array(
	)) . '
		</div>
	</div>
', array(
		'action' => $__templater->func('link', array('logs/cookie-consent', ), false),
		'class' => 'block',
	)) . '

';
	if (!$__templater->test($__vars['entries'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<div class="block-body">
				';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['entries'])) {
			foreach ($__vars['entries'] AS $__vars['entry']) {
				$__compilerTemp1 .= '
						';
				$__compilerTemp2 = '';
				if ($__templater->isTraversable($__vars['entry']['consented_groups'])) {
					foreach ($__vars['entry']['consented_groups'] AS $__vars['consentedGroup']) {
						$__compilerTemp2 .= $__templater->func('trim', array('
												<li>' . $__templater->escape($__templater->method($__vars['xf']['cookieConsent'], 'getGroupLabel', array($__vars['consentedGroup'], ))) . '
											'), false);
					}
				}
				$__compilerTemp1 .= $__templater->dataRow(array(
				), array(array(
					'_type' => 'cell',
					'html' => $__templater->func('username_link', array($__vars['entry']['User'], false, array(
					'href' => $__templater->func('link', array('users/edit', $__vars['entry']['User'], ), false),
				))),
				),
				array(
					'class' => 'u-ltr',
					'_type' => 'cell',
					'html' => ($__vars['entry']['ip_address'] ? $__templater->filter($__vars['entry']['ip_address'], array(array('ip', array()),), true) : ''),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->func('date_dynamic', array($__vars['entry']['log_date'], array(
				))),
				),
				array(
					'_type' => 'cell',
					'html' => '
								<div>
									<a href="' . $__templater->func('link', array('logs/cookie-consent', $__vars['entry'], ), true) . '" data-xf-click="overlay">
										<ul class="listInline listInline--comma">
											' . $__compilerTemp2 . '
										</ul>
									</a>
								</div>
							',
				))) . '
					';
			}
		}
		$__finalCompiled .= $__templater->dataList('
					' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), array(array(
			'_type' => 'cell',
			'html' => 'User',
		),
		array(
			'_type' => 'cell',
			'html' => 'IP address',
		),
		array(
			'_type' => 'cell',
			'html' => 'Date',
		),
		array(
			'_type' => 'cell',
			'html' => 'Consented groups',
		))) . '

					' . $__compilerTemp1 . '
				', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
			</div>

			<div class="block-footer">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['entries'], $__vars['total'], ), true) . '</span>
			</div>
		</div>

		' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'link' => 'logs/cookie-consent',
			'params' => $__vars['linkFilters'],
			'wrapperclass' => 'block-outer block-outer--after',
			'perPage' => $__vars['perPage'],
		))) . '
	</div>
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'No entries have been logged.' . '</div>
';
	}
	return $__finalCompiled;
}
);