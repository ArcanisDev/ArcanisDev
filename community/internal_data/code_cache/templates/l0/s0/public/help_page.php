<?php
// FROM HASH: f2eb709eec621aa0e59f84dc64b54e6f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['page']['title']));
	$__finalCompiled .= '

' . $__templater->callMacro('metadata_macros', 'metadata', array(
		'canonicalUrl' => $__templater->func('link', array('canonical:help', $__vars['page'], ), false),
		'description' => $__vars['page']['description'],
	), $__vars) . '

';
	$__templater->breadcrumb($__templater->preEscaped('Help'), $__templater->func('link', array('help', ), false), array(
	));
	$__finalCompiled .= '

';
	$__templater->wrapTemplate('help_wrapper', $__vars);
	$__finalCompiled .= '

';
	if ($__vars['page']['advanced_mode']) {
		$__finalCompiled .= '
	' . $__templater->filter($__vars['templateHtml'], array(array('raw', array()),), true) . '
';
	} else {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<div class="block-body block-row">
				' . $__templater->filter($__vars['templateHtml'], array(array('raw', array()),), true) . '
			</div>
		</div>
	</div>
';
	}
	return $__finalCompiled;
}
);