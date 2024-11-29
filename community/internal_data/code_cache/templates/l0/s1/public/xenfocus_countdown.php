<?php
// FROM HASH: 9e88c1b0fafed7e7e5b81b0aac9819a3
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->func('property', array('xenfocus_countdownEnable', ), false)) {
		$__finalCompiled .= '

	<div class=\'focus-timer\'>

		';
		if ($__templater->func('property', array('xenfocus_countdownTitle', ), false)) {
			$__finalCompiled .= '<h3>' . $__templater->func('property', array('xenfocus_countdownTitle', ), true) . '</h3>';
		}
		$__finalCompiled .= '
		';
		if ($__templater->func('property', array('xenfocus_countdownDesc', ), false)) {
			$__finalCompiled .= '<div class=\'focus-timer-desc\'>' . $__templater->func('property', array('xenfocus_countdownDesc', ), true) . '</div>';
		}
		$__finalCompiled .= '
		';
		if ($__templater->func('property', array('xenfocus_countdownDone', ), false)) {
			$__finalCompiled .= '<div class=\'focus-timer-desc-done\'>' . $__templater->func('property', array('xenfocus_countdownDone', ), true) . '</div>';
		}
		$__finalCompiled .= '
		<div class=\'focus-timer-numbers\'></div>

	</div>

';
	}
	return $__finalCompiled;
}
);