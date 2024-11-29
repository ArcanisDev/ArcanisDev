<?php
// FROM HASH: 1814d656c615de710f9d482fbac84dc0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<!DOCTYPE html>
<html id="XF" lang="' . $__templater->escape($__vars['xf']['language']['language_code']) . '" dir="' . $__templater->escape($__vars['xf']['language']['text_direction']) . '"
	data-app="public"
	data-template="' . $__templater->escape($__vars['template']) . '"
	data-container-key="' . $__templater->escape($__vars['containerKey']) . '"
	data-content-key="' . $__templater->escape($__vars['contentKey']) . '"
	data-logged-in="' . ($__vars['xf']['visitor']['user_id'] ? 'true' : 'false') . '"
	data-cookie-prefix="' . $__templater->escape($__vars['xf']['cookie']['prefix']) . '"
	class="' . ($__vars['template'] ? ('template-' . $__templater->escape($__vars['template'])) : '') . '">

	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

		<title>' . $__templater->func('page_title', array('%s | %s', $__vars['xf']['options']['boardTitle'], $__vars['pageNumber'])) . '</title>
		';
	$__vars['description'] = $__templater->preEscaped($__templater->func('page_description'));
	$__finalCompiled .= '

		';
	if ($__templater->func('property', array('metaThemeColor', ), false)) {
		$__finalCompiled .= '
			<meta name="theme-color" content="' . $__templater->func('parse_less_color', array($__templater->func('property', array('metaThemeColor', ), false), ), true) . '" />
		';
	}
	$__finalCompiled .= '

		';
	if ($__templater->isTraversable($__vars['head'])) {
		foreach ($__vars['head'] AS $__vars['headTag']) {
			$__finalCompiled .= '
			' . $__templater->escape($__vars['headTag']) . '
		';
		}
	}
	$__finalCompiled .= '

		';
	if ($__vars['css']) {
		$__finalCompiled .= '
			<style>
				' . $__templater->filter($__vars['css'], array(array('raw', array()),), true) . '
			</style>
		';
	}
	$__finalCompiled .= '
	</head>

	<body data-template="' . $__templater->escape($__vars['template']) . '">
		<h1 class="p-offline-header">' . $__templater->func('page_h1', array($__vars['xf']['options']['boardTitle'])) . '</h1>

		' . $__templater->filter($__vars['content'], array(array('raw', array()),), true) . '
	</body>
</html>';
	return $__finalCompiled;
}
);