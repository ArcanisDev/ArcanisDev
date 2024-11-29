<?php
// FROM HASH: 304e71ba3db88006c4b2457b4b75f4c1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Language chooser');
	$__finalCompiled .= '

';
	$__templater->setPageParam('head.' . 'metaNoindex', $__templater->preEscaped('<meta name="robots" content="noindex" />'));
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<div class="block-body">
			<ul class="listPlain listColumns">
				';
	if ($__templater->isTraversable($__vars['languages'])) {
		foreach ($__vars['languages'] AS $__vars['language']) {
			$__finalCompiled .= '
					<li>
						<a href="' . $__templater->func('link', array('misc/language', null, array('language_id' => $__vars['language']['language_id'], '_xfRedirect' => $__vars['redirect'], 't' => $__templater->func('csrf_token', array(), false), ), ), true) . '" class="menu-linkRow" dir="auto">' . $__templater->escape($__vars['language']['title']) . ((!$__vars['language']['user_selectable']) ? ' *' : '') . '</a>
					</li>
				';
		}
	}
	$__finalCompiled .= '
			</ul>
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);