<?php
// FROM HASH: 11fb9088c6da4de05c62bb76e896b14a
return array(
'macros' => array('outer_header' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'title' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<table border="0" width="100%" cellpadding="0" cellspacing="0" class="summaryOuterHeader">
		<tr>
			<td class="summaryOuterHeader-content" valign="top">
				' . $__templater->escape($__vars['title']) . '
			</td>
		</tr>
	</table>
';
	return $__finalCompiled;
}
),
'block' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'header' => '',
		'attribution' => '',
		'content' => '!',
		'footer' => '',
		'footerOpposite' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<table border="0" width="100%" cellpadding="0" cellspacing="0" class="summaryBlock">
		';
	if ($__vars['header']) {
		$__finalCompiled .= '
			<tr>
				<td class="summaryBlock-header" valign="top">
					' . $__templater->escape($__vars['header']) . '
				</td>
			</tr>
		';
	}
	$__finalCompiled .= '
		<tr>
			<td align="center" valign="top">
				<div>
					<table border="0" width="100%" cellpadding="0" cellspacing="0" style="table-layout: fixed">
						';
	if ($__vars['attribution']) {
		$__finalCompiled .= '
							<tr>
								<td class="content content--attribution">
									' . $__templater->escape($__vars['attribution']) . '
								</td>
							</tr>
						';
	}
	$__finalCompiled .= '
						<tr>
							<td class="content">
								' . $__templater->filter($__vars['content'], array(array('raw', array()),), true) . '
							</td>
						</tr>
						';
	if ($__vars['footer'] OR $__vars['footerOpposite']) {
		$__finalCompiled .= '
							<tr>
								<td class="content content--footer">
									<table cellpadding="0" cellspacing="0" border="0" width="100%" class="content-inner">
										<tr>
											<td>' . $__templater->escape($__vars['footer']) . '</td>
											<td class="u-opposite" align="' . ($__vars['xf']['isRtl'] ? 'right' : 'left') . '">' . $__templater->escape($__vars['footerOpposite']) . '</td>
										</tr>
									</table>
								</td>
							</tr>
						';
	}
	$__finalCompiled .= '
					</table>
				</div>
			</td>
	</table>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
);