<?php
// FROM HASH: 5fd3cc94a914e4e104c873c42ed26304
return array(
'extensions' => array('header' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
	<h4 class="block-textHeader">
		';
	if ($__vars['details']['title'] AND $__vars['details']['title_link']) {
		$__finalCompiled .= '
			' . 'Pre-registration action' . $__vars['xf']['language']['label_separator'] . ' <a href="' . $__templater->escape($__vars['details']['title_link']) . '">' . $__templater->escape($__vars['details']['title']) . '</a>
		';
	} else if ($__vars['details']['title']) {
		$__finalCompiled .= '
			' . 'Pre-registration action' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['details']['title']) . '
		';
	} else {
		$__finalCompiled .= '
			' . 'Pre-registration action' . '
		';
	}
	$__finalCompiled .= '
	</h4>
';
	return $__finalCompiled;
},
'content' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
	<div>
		';
	if ($__vars['details']['bb_code']) {
		$__finalCompiled .= '
			' . $__templater->func('bb_code', array($__vars['details']['bb_code'], 'pre_reg', $__vars['preRegAction']['User'], ), true) . '
		';
	} else if ($__vars['details']['text']) {
		$__finalCompiled .= '
			' . $__templater->func('structured_text', array($__vars['details']['text'], ), true) . '
		';
	} else {
		$__finalCompiled .= '
			' . 'No additional information available.' . '
		';
	}
	$__finalCompiled .= '
	</div>
';
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->renderExtension('header', $__vars, $__extensions) . '

' . $__templater->renderExtension('content', $__vars, $__extensions);
	return $__finalCompiled;
}
);