<?php
// FROM HASH: 6a74b5ea5ec52d17af8fea6fba7cd399
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->func('property', array('xenfocus_holiday', ), false) != 'none') {
		$__finalCompiled .= '
	<span class=\'focus-logo--holiday\'>
		';
		if ($__templater->func('property', array('xenfocus_holiday', ), false) === 'valentines') {
			$__finalCompiled .= '
			<i class="fas fa-heart" aria-hidden="true"></i>
		';
		} else if ($__templater->func('property', array('xenfocus_holiday', ), false) === 'halloween') {
			$__finalCompiled .= '
			<img src="' . $__templater->func('asset', array('xenfocusGlobal', ), true) . '/holidays/halloween-ghost.png" alt=\'\' />
		';
		}
		$__finalCompiled .= '
	</span>
';
	}
	return $__finalCompiled;
}
);