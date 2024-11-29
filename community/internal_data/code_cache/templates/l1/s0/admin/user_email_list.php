<?php
// FROM HASH: 5a717d2c092ce98c61f4fddb94d71924
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Email list');
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<div class="block-body block-row">
			<pre style="max-height: 400px; overflow: auto;">';
	if ($__templater->isTraversable($__vars['users'])) {
		foreach ($__vars['users'] AS $__vars['user']) {
			if ($__vars['user']['email']) {
				$__finalCompiled .= $__templater->filter($__vars['user']['email'], array(array('email_display', array()),), true) . '	' . $__templater->escape($__vars['user']['username']) . '
';
			}
		}
	}
	$__finalCompiled .= '</pre>
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);