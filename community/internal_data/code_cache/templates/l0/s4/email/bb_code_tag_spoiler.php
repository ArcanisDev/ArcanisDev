<?php
// FROM HASH: 6bb509ec721583ff77376cbc5ef131e0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="spoilerPlaceholder">
	';
	if ($__vars['title']) {
		$__finalCompiled .= $__templater->escape($__vars['title']) . ' -';
	}
	$__finalCompiled .= '
	' . 'Spoiler content hidden.' . '
</div>';
	return $__finalCompiled;
}
);