<?php
// FROM HASH: 584f9f982946ebfeb830016699e402d1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__vars['toggle-icon'] = $__templater->preEscaped('<div class=\'focus-editor-toggle\'><i class=\'focus-toggle\'><i></i></i></div>');
	$__finalCompiled .= '
';
	if ($__templater->func('property', array('xenfocus_themeEditor', ), false)) {
		$__finalCompiled .= '
	<div class=\'focus-editor-wrap\'>
		<div class=\'focus-editor-overlay\' data-xenfocus-editor></div>
		<div class=\'focus-editor\'>

			<div class=\'focus-editor-scroll\'>

				';
		if ($__templater->func('property', array('xenfocus_picker', ), false)) {
			$__finalCompiled .= '
					<div>
						<div class=\'focus-editor__title\' data-focus-text=\'Background Picker\'></div>
						<div class="focus-picker">
						    ';
			if ($__templater->func('property', array('xenfocus_bg1_enable', ), false)) {
				$__finalCompiled .= '<span data-focus-bg=\'1\'><i></i></span>';
			}
			$__finalCompiled .= '
						    ';
			if ($__templater->func('property', array('xenfocus_bg2_enable', ), false)) {
				$__finalCompiled .= '<span data-focus-bg=\'2\'><i></i></span>';
			}
			$__finalCompiled .= '
						    ';
			if ($__templater->func('property', array('xenfocus_bg3_enable', ), false)) {
				$__finalCompiled .= '<span data-focus-bg=\'3\'><i></i></span>';
			}
			$__finalCompiled .= '
						    ';
			if ($__templater->func('property', array('xenfocus_bg4_enable', ), false)) {
				$__finalCompiled .= '<span data-focus-bg=\'4\'><i></i></span>';
			}
			$__finalCompiled .= '
						    ';
			if ($__templater->func('property', array('xenfocus_bg5_enable', ), false)) {
				$__finalCompiled .= '<span data-focus-bg=\'5\'><i></i></span>';
			}
			$__finalCompiled .= '
						    ';
			if ($__templater->func('property', array('xenfocus_bg6_enable', ), false)) {
				$__finalCompiled .= '<span data-focus-bg=\'6\'><i></i></span>';
			}
			$__finalCompiled .= '
							';
			if ($__templater->func('property', array('xenfocus_bg7_enable', ), false)) {
				$__finalCompiled .= '<span data-focus-bg=\'7\'><i></i></span>';
			}
			$__finalCompiled .= '
							';
			if ($__templater->func('property', array('xenfocus_bg8_enable', ), false)) {
				$__finalCompiled .= '<span data-focus-bg=\'8\'><i></i></span>';
			}
			$__finalCompiled .= '
							';
			if ($__templater->func('property', array('xenfocus_bg9_enable', ), false)) {
				$__finalCompiled .= '<span data-focus-bg=\'9\'><i></i></span>';
			}
			$__finalCompiled .= '
							';
			if ($__templater->func('property', array('xenfocus_bg10_enable', ), false)) {
				$__finalCompiled .= '<span data-focus-bg=\'10\'><i></i></span>';
			}
			$__finalCompiled .= '
							';
			if ($__templater->func('property', array('xenfocus_bg11_enable', ), false)) {
				$__finalCompiled .= '<span data-focus-bg=\'11\'><i></i></span>';
			}
			$__finalCompiled .= '
							';
			if ($__templater->func('property', array('xenfocus_bg12_enable', ), false)) {
				$__finalCompiled .= '<span data-focus-bg=\'12\'><i></i></span>';
			}
			$__finalCompiled .= '
						</div>
					</div>
				';
		}
		$__finalCompiled .= '

				' . $__templater->includeTemplate('xenfocus_editor_hook_1', $__vars) . '

				<div>
					<div class=\'focus-editor__title\' data-focus-text=\'Customize layout\'></div>
					
					';
		if ($__templater->func('property', array('xenfocus_mnb_toggle', ), false) AND $__templater->func('property', array('xenfocus_mobile_navigation_bar', ), false)) {
			$__finalCompiled .= '
						<div class=\'focus-editor-panel\' data-setting=\'focus-mobile-navigation-bar\' data-setting-default=\'on\'>
							' . $__templater->filter($__vars['toggle-icon'], array(array('raw', array()),), true) . '
							<div class=\'focus-editor-text\' data-setting-title=\'Mobile navigation bar?\' data-setting-desc=\'Display a navigation bar at the bottom of the site when using a mobile device?\'></div>
						</div>
					';
		}
		$__finalCompiled .= '

					';
		if ($__templater->func('property', array('xenfocus_widthToggle', ), false)) {
			$__finalCompiled .= '
						<div class=\'focus-editor-panel\' data-setting=\'focus-fluid\' data-setting-default=\'';
			if ($__templater->func('property', array('xenfocus_widthEnable', ), false)) {
				$__finalCompiled .= 'on';
			} else {
				$__finalCompiled .= 'off';
			}
			$__finalCompiled .= '\'>
							' . $__templater->filter($__vars['toggle-icon'], array(array('raw', array()),), true) . '
							<div class=\'focus-editor-text\' data-setting-title=\'Fluid width?\' data-setting-desc=\'Enabling this will increase the width of the site so it occupies the width of your browser. Useful for larger screens.\'></div>
						</div>
					';
		}
		$__finalCompiled .= '

					';
		if ($__templater->func('property', array('xenfocus_gridToggle', ), false)) {
			$__finalCompiled .= '
						<div class=\'focus-editor-panel\' data-setting=\'focus-grid\' data-setting-default=\'';
			if ($__templater->func('property', array('xenfocus_gridEnable', ), false)) {
				$__finalCompiled .= 'on';
			} else {
				$__finalCompiled .= 'off';
			}
			$__finalCompiled .= '\'>
							' . $__templater->filter($__vars['toggle-icon'], array(array('raw', array()),), true) . '
							<div class=\'focus-editor-text\' data-setting-title=\'Grid layout?\' data-setting-desc=\'If enabled, the forums will be displayed as a grid instead of a table.\'></div>
						</div>
					';
		}
		$__finalCompiled .= '

					';
		if ($__templater->func('property', array('xenfocus_stickyToggle', ), false)) {
			$__finalCompiled .= '
						<div class=\'focus-editor-panel\' data-setting=\'focus-sidebar-sticky\' data-setting-default=\'';
			if ($__templater->func('property', array('xenfocus_stickyBlocks', ), false)) {
				$__finalCompiled .= 'on';
			} else {
				$__finalCompiled .= 'off';
			}
			$__finalCompiled .= '\'>
							' . $__templater->filter($__vars['toggle-icon'], array(array('raw', array()),), true) . '
							<div class=\'focus-editor-text\' data-setting-title=\'Sticky sidebar?\' data-setting-desc=\'If enabled, the sidebar will stick to the top of the screen for easy access.\'></div>
						</div>
					';
		}
		$__finalCompiled .= '

					';
		if ($__templater->func('property', array('xenfocus_sidebarFlipToggle', ), false)) {
			$__finalCompiled .= '
						<div class=\'focus-editor-panel\' data-setting=\'focus-sidebar-flip\' data-setting-default=\'';
			if ($__templater->func('property', array('xenfocus_sidebarFlip', ), false)) {
				$__finalCompiled .= 'on';
			} else {
				$__finalCompiled .= 'off';
			}
			$__finalCompiled .= '\'>
							' . $__templater->filter($__vars['toggle-icon'], array(array('raw', array()),), true) . '
							<div class=\'focus-editor-text\' data-setting-title=\'Flip sidebar?\' data-setting-desc=\'Flip the sidebar between the left and right sides.\'></div>
						</div>
					';
		}
		$__finalCompiled .= '

					';
		if ($__templater->func('property', array('xenfocus_eventOverlay', ), false) === 'snow') {
			$__finalCompiled .= '
						<div class=\'focus-editor-panel\' data-setting=\'focus-snow\' data-setting-default=\'';
			if ($__templater->func('property', array('xenfocus_eventOverlayDefault', ), false)) {
				$__finalCompiled .= 'on';
			} else {
				$__finalCompiled .= 'off';
			}
			$__finalCompiled .= '\'>
							' . $__templater->filter($__vars['toggle-icon'], array(array('raw', array()),), true) . '
							<div class=\'focus-editor-text\' data-setting-title=\'Enable snow effect?\' data-setting-desc=\'If enabled, animated snow will fall across your browser.\'></div>
						</div>
					';
		}
		$__finalCompiled .= '

					';
		if ($__templater->func('property', array('xenfocus_eventOverlay', ), false) === 'confetti') {
			$__finalCompiled .= '
						<div class=\'focus-editor-panel\' data-setting=\'focus-confetti\' data-setting-default=\'';
			if ($__templater->func('property', array('xenfocus_eventOverlayDefault', ), false)) {
				$__finalCompiled .= 'on';
			} else {
				$__finalCompiled .= 'off';
			}
			$__finalCompiled .= '\'>
							' . $__templater->filter($__vars['toggle-icon'], array(array('raw', array()),), true) . '
							<div class=\'focus-editor-text\' data-setting-title=\'Enable confetti?\' data-setting-desc=\'If enabled, animated confetti will fall across your browser.\'></div>
						</div>
					';
		}
		$__finalCompiled .= '

					';
		if ($__templater->func('property', array('xenfocus_countdownEnable', ), false) AND $__templater->func('property', array('xenfocus_countdownToggle', ), false)) {
			$__finalCompiled .= '
						<div class=\'focus-editor-panel\' data-setting=\'focus-countdown\' data-setting-default=\'on\'>
							' . $__templater->filter($__vars['toggle-icon'], array(array('raw', array()),), true) . '
							<div class=\'focus-editor-text\' data-setting-title=\'Show countdown?\' data-setting-desc=\'If enabled, a countdown will be visible at the top of your page.\'></div>
						</div>
					';
		}
		$__finalCompiled .= '
					
					' . $__templater->includeTemplate('xenfocus_editor_hook_2', $__vars) . '
					
				</div>

			</div>

			<div class=\'focus-editor-save\'>
				<button data-xenfocus-editor data-focus-text=\'Save\'></button>
			</div>

		</div>
	</div>
';
	}
	return $__finalCompiled;
}
);