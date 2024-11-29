<?php
// FROM HASH: 7be2b7a786378625342700e897f30a16
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['title']));
	$__finalCompiled .= '

' . $__templater->callMacro('section_nav_macros', 'section_nav', array(
		'section' => $__vars['entry']['navigation_id'],
	), $__vars);
	return $__finalCompiled;
}
);