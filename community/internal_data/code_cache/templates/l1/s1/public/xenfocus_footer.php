<?php
// FROM HASH: 1de835537595d31ccb8f8fad290ed28b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->func('property', array('xenfocus_footerEnable', ), false)) {
		$__finalCompiled .= '

	<div class=\'focus-footer\'>
		<div class=\'focus-width focus-footer__align\'>

			';
		if ($__templater->func('property', array('xenfocus_footer1', ), false)) {
			$__finalCompiled .= '<div class=\'focus-footer-col focus-footer-col--1\'>' . $__templater->func('property', array('xenfocus_footer1', ), true) . '</div>';
		}
		$__finalCompiled .= '
			';
		if ($__templater->func('property', array('xenfocus_footer2', ), false)) {
			$__finalCompiled .= '<div class=\'focus-footer-col focus-footer-col--2\'>' . $__templater->func('property', array('xenfocus_footer2', ), true) . '</div>';
		}
		$__finalCompiled .= '
			';
		if ($__templater->func('property', array('xenfocus_footer3', ), false)) {
			$__finalCompiled .= '<div class=\'focus-footer-col focus-footer-col--3\'>' . $__templater->func('property', array('xenfocus_footer3', ), true) . '</div>';
		}
		$__finalCompiled .= '
			';
		if ($__templater->func('property', array('xenfocus_footer4', ), false)) {
			$__finalCompiled .= '<div class=\'focus-footer-col focus-footer-col--4\'>' . $__templater->func('property', array('xenfocus_footer4', ), true) . '</div>';
		}
		$__finalCompiled .= '

		</div>
	</div>

';
	}
	return $__finalCompiled;
}
);