<?php
// FROM HASH: b114d92ab6d06fcb38f20cb736c23eca
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->setPageParam('template', 'ACTIVITY_SUMMARY_CONTAINER');
	$__finalCompiled .= '

<mail:subject>' . $__templater->escape($__vars['xf']['options']['boardTitle']) . ' - ' . 'See what you have missed' . '</mail:subject>

';
	if ($__vars['displayValues']) {
		$__finalCompiled .= '
	' . $__templater->callMacro('activity_summary_macros', 'outer_header', array(
			'title' => 'A summary of what you missed recently',
		), $__vars) . '

	';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['displayValues'])) {
			foreach ($__vars['displayValues'] AS $__vars['value']) {
				if ($__vars['value']['value'] != 0) {
					$__compilerTemp1 .= '
						<div class="stat">
							<table border="0" width="100%" cellpadding="0" cellspacing="0">
								<tr>
									<td class="stat-label" align="center">' . $__templater->escape($__vars['value']['label']) . '</td>
								</tr>
								<tr>
									<td class="stat-value" align="center">' . $__templater->filter($__vars['value']['value'], array(array('number_short', array()),), true) . '</td>
								</tr>
							</table>
						</div>
					';
				}
			}
		}
		$__vars['content'] = $__templater->preEscaped('
		<table border="0" width="100%" cellpadding="0" cellspacing="0" class="statsContainer">
			<tr>
				<td class="statsGroup" align="center">
					' . $__compilerTemp1 . '
				</td>
			</tr>
		</table>
	');
		$__finalCompiled .= '

	' . $__templater->callMacro('activity_summary_macros', 'block', array(
			'content' => $__vars['content'],
		), $__vars) . '
';
	}
	$__finalCompiled .= '

';
	if ($__templater->isTraversable($__vars['renderedSections'])) {
		foreach ($__vars['renderedSections'] AS $__vars['section']) {
			$__finalCompiled .= '
	' . $__templater->filter($__vars['section'], array(array('raw', array()),), true) . '
';
		}
	}
	$__finalCompiled .= '

<table border="0" width="100%" cellpadding="0" cellspacing="0" class="container container--outer">
	<tr>
		<td align="center" valign="top">
			<p class="minorText">' . 'If you no longer wish to receive these emails, you may <a href="' . $__templater->func('link', array('canonical:email-stop/activity-summary', $__vars['xf']['toUser'], ), true) . '">disable activity summary emails</a> or <a href="' . $__templater->func('link', array('canonical:email-stop/all', $__vars['xf']['toUser'], ), true) . '">disable all emails</a>.' . '</p>
		</td>
	</tr>
</table>';
	return $__finalCompiled;
}
);