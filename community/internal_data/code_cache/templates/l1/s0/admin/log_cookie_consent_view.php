<?php
// FROM HASH: 11f5aac51537ce5b4782b3d1b824f313
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Cookie consent log entry');
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRow('
				<a href="' . $__templater->func('link', array('users/edit', $__vars['entry']['User'], ), true) . '">' . $__templater->escape($__vars['entry']['User']['username']) . '</a>
			', array(
		'label' => 'User',
	)) . '

			';
	if ($__vars['entry']['ip_address']) {
		$__finalCompiled .= '
				' . $__templater->formRow('
					<a href="' . $__templater->func('link_type', array('public', 'misc/ip-info', null, array('ip' => $__templater->filter($__vars['entry']['ip_address'], array(array('ip', array()),), false), ), ), true) . '" target="_blank" class="u-ltr">' . $__templater->filter($__vars['entry']['ip_address'], array(array('ip', array()),), true) . '</a>
				', array(
			'label' => 'IP address',
		)) . '
			';
	}
	$__finalCompiled .= '

			' . $__templater->formRow('
				' . $__templater->func('date_dynamic', array($__vars['entry']['log_date'], array(
	))) . '
			', array(
		'label' => 'Date',
	)) . '

			';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['entry']['consented_groups'])) {
		foreach ($__vars['entry']['consented_groups'] AS $__vars['consentedGroup']) {
			$__compilerTemp1 .= $__templater->func('trim', array('
						<li>' . $__templater->escape($__templater->method($__vars['xf']['cookieConsent'], 'getGroupLabel', array($__vars['consentedGroup'], ))) . '
					'), false);
		}
	}
	$__finalCompiled .= $__templater->formRow('
				<ul class="listInline listInline--comma">
					' . $__compilerTemp1 . '
				</ul>
			', array(
		'label' => 'Consented groups',
	)) . '
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);