<?php
// FROM HASH: aa7798c9b9c63050ca89d44c7620f035
return array(
'macros' => array('attached_images' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'attachments' => '!',
		'link' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
				';
	if ($__templater->isTraversable($__vars['attachments'])) {
		foreach ($__vars['attachments'] AS $__vars['attachment']) {
			if ($__vars['attachment']['has_thumbnail']) {
				$__compilerTemp1 .= '
					<li>
						<a href="' . $__templater->escape($__vars['link']) . '"><img src="' . $__templater->escape($__vars['attachment']['thumbnail_url']) . '" alt="' . $__templater->escape($__vars['attachment']['filename']) . '"
							width="' . $__templater->escape($__vars['attachment']['thumbnail_width']) . '" height="' . $__templater->escape($__vars['attachment']['thumbnail_height']) . '" loading="lazy"/></a>
					</li>
				';
			}
		}
	}
	$__compilerTemp1 .= '
			';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
		<ul class="listPlain listInline listInline--block">
			' . $__compilerTemp1 . '
		</ul>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';

	return $__finalCompiled;
}
);