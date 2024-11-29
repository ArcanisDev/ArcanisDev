<?php
// FROM HASH: d044336dac51872ed70a3cc2a1cc49cc
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<img src="' . $__templater->escape($__vars['imageUrl']) . '" class="bbImage" alt="' . $__templater->filter($__vars['alt'], array(array('for_attr', array()),), true) . '" title="' . $__templater->filter($__vars['alt'], array(array('for_attr', array()),), true) . '" style="' . $__templater->escape($__vars['styleAttr']) . '" />
';
	return $__finalCompiled;
}
);