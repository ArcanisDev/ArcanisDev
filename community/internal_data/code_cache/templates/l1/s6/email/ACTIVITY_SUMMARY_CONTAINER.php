<?php
// FROM HASH: 00e60ad15da3fcade5fcccbcdae74306
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<!DOCTYPE html>
<html lang="' . $__templater->escape($__vars['xf']['language']['language_code']) . '" dir="' . $__templater->escape($__vars['xf']['language']['text_direction']) . '">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<base href="' . $__templater->escape($__vars['xf']['options']['boardUrl']) . '/">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="format-detection" content="telephone=no">
	<title>' . $__templater->escape($__vars['subject']) . '</title>
</head>
<body dir="' . $__templater->escape($__vars['xf']['language']['text_direction']) . '" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="p-activitySummary">

<table id="bodyTable" border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
<tr>
	<td align="center" valign="top" id="bodyTableContainer">
		<table border="0" width="100%" cellpadding="0" cellspacing="0" class="summaryHeaderContainer" dir="' . $__templater->escape($__vars['xf']['language']['text_direction']) . '">
			<tr>
				<td class="summaryHeaderBar" align="center" valign="top">
					';
	if ($__templater->func('property', array('emailPublicLogoUrl', ), false)) {
		$__finalCompiled .= '
						<a href="' . $__templater->func('link', array('canonical:index', ), true) . '"><img src="' . $__templater->func('base_url', array($__templater->func('property', array('emailPublicLogoUrl', ), false), true, ), true) . '" alt="' . $__templater->escape($__vars['xf']['options']['boardTitle']) . '" /></a>
					';
	} else if ($__templater->func('property', array('publicLogoUrl', ), false)) {
		$__finalCompiled .= '
						<a href="' . $__templater->func('link', array('canonical:index', ), true) . '"><img src="' . $__templater->func('base_url', array($__templater->func('property', array('publicLogoUrl', ), false), true, ), true) . '" alt="' . $__templater->escape($__vars['xf']['options']['boardTitle']) . '" width="' . ($__templater->func('property', array('publicLogoWidth', ), true) ?: '') . '" height="' . ($__templater->func('property', array('publicLogoHeight', ), true) ?: '') . '" class="' . (($__templater->filter($__templater->func('property', array('publicLogoUrl', ), false), array(array('to_lower', array()),array('substr', array(-4, )),), false) == '.svg') ? 'logo-svg' : '') . '" /></a>
					';
	} else {
		$__finalCompiled .= '
						<a href="' . $__templater->func('link', array('canonical:index', ), true) . '">' . $__templater->escape($__vars['xf']['options']['boardTitle']) . '</a>
					';
	}
	$__finalCompiled .= '
				</td>
			</tr>
		</table>

		<div class="summaryContentWrapper">
			' . $__templater->filter($__vars['html'], array(array('raw', array()),), true) . '
		</div>

	</td>
</tr>
<tr>
	<td class="footer" align="center" valign="top">
		<div>' . '<a href="' . $__templater->func('link', array('canonical:index', ), true) . '">Visit ' . $__templater->escape($__vars['xf']['options']['boardTitle']) . '</a>' . '</div>

		';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
			<div class="footerExtra">' . $__compilerTemp1 . '</div>
		';
	}
	$__finalCompiled .= '
	</td>
</tr>
</table>

</body>
</html>';
	return $__finalCompiled;
}
);