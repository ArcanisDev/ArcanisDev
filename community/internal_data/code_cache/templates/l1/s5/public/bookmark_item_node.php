<?php
// FROM HASH: 0da544271adc13a30cb6aa9c0ab047e0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->func('snippet', array($__vars['content']['description'], $__templater->func('max_length', array($__vars['bookmark'], 'message', ), false), array('stripHtml' => true, ), ), true);
	return $__finalCompiled;
}
);