<?php
// FROM HASH: 92e4dc82871daffe738be9979451f501
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__vars['options']['advanced_mode']) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container" ' . $__templater->func('widget_data', array($__vars['widget'], ), true) . '>
			';
		if ($__vars['title']) {
			$__finalCompiled .= '
				<h3 class="block-minorHeader">' . $__templater->escape($__vars['title']) . '</h3>
			';
		}
		$__finalCompiled .= '
			<div class="block-body block-row">
				' . $__templater->filter($__vars['template'], array(array('raw', array()),), true) . '
			</div>
		</div>
	</div>
';
	} else {
		$__finalCompiled .= '
	' . $__templater->filter($__vars['template'], array(array('raw', array()),), true) . '
';
	}
	return $__finalCompiled;
}
);