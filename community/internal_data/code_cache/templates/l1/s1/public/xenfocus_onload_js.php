<?php
// FROM HASH: 08bedf10dd42a3ba3ee84ae4443498ba
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<script type=\'text/javascript\'>
var xfhtml = document.getElementById(\'XF\');
function applySetting(settingName, settingOn, allowToggle){
	';
	if ($__templater->func('property', array('xenfocus_themeEditor', ), false)) {
		$__finalCompiled .= '
	// Theme editor is enabled. Check for selected toggle, otherwise apply default
		if(allowToggle === 1){
			var choice = localStorage.getItem(settingName);
			if( (choice === \'on\') || (!choice && (settingOn === 1)) ){
				xfhtml.classList.add(settingName);
			}
		} else if(settingOn === 1){
			xfhtml.classList.add(settingName);
		}
	';
	} else {
		$__finalCompiled .= '
	// Theme editor is disabled, so simply apply the setting if enabled in ACP
		if(settingOn === 1){
			xfhtml.classList.add(settingName);
		}
	';
	}
	$__finalCompiled .= '
}
';
	if ($__templater->func('property', array('xenfocus_mnb_toggle', ), false)) {
		$__finalCompiled .= '
applySetting(\'focus-mobile-navigation-bar\', 1, 1);
';
	}
	$__finalCompiled .= '
';
	if ($__templater->func('property', array('xenfocus_widthEnable', ), false) OR $__templater->func('property', array('xenfocus_widthToggle', ), false)) {
		$__finalCompiled .= '
applySetting(\'focus-fluid\', ' . $__templater->func('property', array('xenfocus_widthEnable', ), true) . ', ' . $__templater->func('property', array('xenfocus_widthToggle', ), true) . ');
';
	}
	$__finalCompiled .= '
';
	if ($__templater->func('property', array('xenfocus_gridEnable', ), false) OR $__templater->func('property', array('xenfocus_gridToggle', ), false)) {
		$__finalCompiled .= '
applySetting(\'focus-grid\', ' . $__templater->func('property', array('xenfocus_gridEnable', ), true) . ', ' . $__templater->func('property', array('xenfocus_gridToggle', ), true) . ');
';
	}
	$__finalCompiled .= '
';
	if ($__templater->func('property', array('xenfocus_stickyBlocks', ), false) OR $__templater->func('property', array('xenfocus_stickyToggle', ), false)) {
		$__finalCompiled .= '
applySetting(\'focus-sidebar-sticky\', ' . $__templater->func('property', array('xenfocus_stickyBlocks', ), true) . ', ' . $__templater->func('property', array('xenfocus_stickyToggle', ), true) . ');
';
	}
	$__finalCompiled .= '
';
	if ($__templater->func('property', array('xenfocus_sidebarFlip', ), false) OR $__templater->func('property', array('xenfocus_sidebarFlipToggle', ), false)) {
		$__finalCompiled .= '
applySetting(\'focus-sidebar-flip\', ' . $__templater->func('property', array('xenfocus_sidebarFlip', ), true) . ', ' . $__templater->func('property', array('xenfocus_sidebarFlipToggle', ), true) . ');
';
	}
	$__finalCompiled .= '
';
	if ($__templater->func('property', array('xenfocus_eventOverlay', ), false) === 'snow') {
		$__finalCompiled .= '
applySetting(\'focus-snow\', ' . $__templater->func('property', array('xenfocus_eventOverlayDefault', ), true) . ', 1);
';
	}
	$__finalCompiled .= '
';
	if ($__templater->func('property', array('xenfocus_eventOverlay', ), false) === 'confetti') {
		$__finalCompiled .= '
applySetting(\'focus-confetti\', ' . $__templater->func('property', array('xenfocus_eventOverlayDefault', ), true) . ', 1);
';
	}
	$__finalCompiled .= '
';
	if ($__templater->func('property', array('xenfocus_countdownEnable', ), false)) {
		$__finalCompiled .= '
applySetting(\'focus-countdown\', 1, ' . $__templater->func('property', array('xenfocus_countdownToggle', ), true) . ');
';
	}
	$__finalCompiled .= '
';
	if ($__templater->func('property', array('xenfocus_picker', ), false)) {
		$__finalCompiled .= '
	var backgroundChoice = localStorage.getItem(\'xenfocusBackground-' . $__templater->escape($__vars['xf']['style']['style_id']) . '\');
	if(backgroundChoice){ xfhtml.setAttribute(\'data-focus-bg\', \'\' + backgroundChoice + \'\');	} else { xfhtml.setAttribute(\'data-focus-bg\', \'' . $__templater->func('property', array('xenfocus_pickerDefault', ), true) . '\'); }
';
	} else {
		$__finalCompiled .= '
	xfhtml.setAttribute(\'data-focus-bg\', \'' . $__templater->func('property', array('xenfocus_pickerDefault', ), true) . '\');
';
	}
	$__finalCompiled .= '
</script>
' . $__templater->includeTemplate('xenfocus_onload_js_extra', $__vars);
	return $__finalCompiled;
}
);