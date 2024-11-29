<?php
// FROM HASH: 315ca88108e9c6dd3cbf9d04af985858
return array(
'macros' => array('summary' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'reactionIds' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
			';
	if ($__templater->isTraversable($__vars['reactionIds'])) {
		foreach ($__vars['reactionIds'] AS $__vars['reactionId']) {
			$__compilerTemp1 .= $__templater->func('trim', array('
				<li>' . $__templater->func('reaction', array(array(
				'id' => $__vars['reactionId'],
				'small' => 'true',
			))) . '</li>
			'), false);
		}
	}
	$__compilerTemp1 .= '
		';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
		<ul class="reactionSummary">
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
	$__finalCompiled .= '

' . $__templater->callMacro(null, 'summary', array(
		'reactionIds' => $__vars['reactionIds'],
	), $__vars);
	return $__finalCompiled;
}
);