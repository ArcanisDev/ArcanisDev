<?php
// FROM HASH: 510293dc25657818376924c9c48ac6e5
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__vars['user'] = $__templater->method($__vars['report'], 'getContent', array());
	$__finalCompiled .= '

<div class="block-row block-row--separated block-row--minor">
	<div>
		<dl class="pairs pairs--inline">
			<dt>' . 'Joined' . '</dt>
			<dd>' . $__templater->func('date_dynamic', array($__vars['user']['register_date'], array(
	))) . '</dd>
		</dl>
	</div>
	
	';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= $__templater->func('user_activity', array($__vars['user']));
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
		<div>
			<dl class="pairs pairs--inline">
				<dt>' . 'Last seen' . '</dt>
				<dd dir="auto">
					' . $__compilerTemp1 . '
				</dd>
			</dl>
		</div>
	';
	}
	$__finalCompiled .= '
</div>';
	return $__finalCompiled;
}
);