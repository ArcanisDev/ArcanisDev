<?php
// FROM HASH: d5ea76a827b67e866395d83f5f4195da
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<script>
';
	if ($__templater->func('property', array('xenfocus_searchMenu', ), false) OR $__templater->func('property', array('xenfocus_themeEditor', ), false)) {
		$__finalCompiled .= '
$(document).ready(function(){
	var html = $(\'#XF\');
	
	';
		if ($__templater->func('property', array('xenfocus_searchMenu', ), false)) {
			$__finalCompiled .= '
		// Advanced search menu
		$(\'.focus-search-advanced\').on(\'click\', function(){ html.toggleClass(\'focus-search-menu-active\'); });
		$(\'.focus-search-flex input\').on(\'focus\', function(){ html.addClass(\'focus-search-menu-active\'); });
		$(document).on(\'click\', function() { html.removeClass(\'focus-search-menu-active\'); });
		$(\'.focus-wrap-search\').on(\'click\', function(event){ event.stopPropagation(); });
	';
		}
		$__finalCompiled .= '

	';
		if ($__templater->func('property', array('xenfocus_themeEditor', ), false)) {
			$__finalCompiled .= '
		$("[data-xenfocus-editor]").hover(function() {
			html.addClass(\'focus-picker--loaded\');
		});
		// xenfocus editor: open and close with data-xenfocus-editor
		$("[data-xenfocus-editor]").on(\'click\', function(event){
			html.toggleClass(\'focus-editor-open\').addClass(\'focus-picker--loaded\');
			event.preventDefault();
		});
		// ..and close by pressing ESC
		$(document).keyup(function(e) {
			if (e.keyCode === 27){
				html.removeClass(\'focus-editor-open\');
			}
		});
		';
			if ($__templater->func('property', array('xenfocus_picker', ), false)) {
				$__finalCompiled .= '
			$(".focus-picker span").on(\'click\', function(){
				var styleid = html.attr(\'data-style-id\');
				var backgroundClass = $(this).attr("data-focus-bg");
				html.attr(\'data-focus-bg\', \'\' + backgroundClass + \'\');
				localStorage.setItem(\'xenfocusBackground-\' + styleid + \'\', \'\' + backgroundClass + \'\');
			});
		';
			}
			$__finalCompiled .= '
		$(\'.focus-editor-panel\').each(function(){
			// This value is used for localstorage names and class names.
			var settingName = $(this).attr(\'data-setting\');
			var settingDefault = $(this).attr(\'data-setting-default\');
			var settingChoice = localStorage.getItem(settingName);
			if(settingChoice === \'on\'){
				$(this).attr(\'data-setting-status\',\'on\');
			} else if(settingChoice === \'off\') {
				$(this).attr(\'data-setting-status\',\'off\');
			} else {
				if(settingDefault === \'on\'){
					$(this).attr(\'data-setting-status\',\'on\');
				} else{
					$(this).attr(\'data-setting-status\',\'off\');
				}
			}
		});
		// Change the class and localstorage when the toggle is clicked
		$(\'.focus-editor-panel\').on(\'click\', function(){
			var settingName = $(this).attr(\'data-setting\');
			var settingStatus = $(this).attr(\'data-setting-status\');
			if(settingStatus === \'on\'){
				html.removeClass(settingName);
				localStorage.setItem(settingName, \'off\');
				$(this).attr(\'data-setting-status\', \'off\');
			} else {
				html.addClass(settingName);
				localStorage.setItem(settingName, \'on\');
				$(this).attr(\'data-setting-status\', \'on\');
			}
		});
	';
		}
		$__finalCompiled .= '
});
';
	}
	$__finalCompiled .= '
	
';
	if ($__templater->func('property', array('xenfocus_mobile_navigation_bar', ), false) AND $__templater->func('property', array('xenfocus_mnb_scroll', ), false)) {
		$__finalCompiled .= '
function throttle(func, wait, options) {
	var context, args, result;
	var timeout = null;
	var previous = 0;
	if (!options) options = {};
	var later = function() {
		previous = options.leading === false ? 0 : Date.now();
		timeout = null;
		result = func.apply(context, args);
		if (!timeout) context = args = null;
	};
	return function() {
		var now = Date.now();
		if (!previous && options.leading === false) previous = now;
		var remaining = wait - (now - previous);
		context = this;
		args = arguments;
		if (remaining <= 0 || remaining > wait) {
			if (timeout) {
				clearTimeout(timeout);
				timeout = null;
			}
			previous = now;
			result = func.apply(context, args);
			if (!timeout) context = args = null;
		} else if (!timeout && options.trailing !== false) {
			timeout = setTimeout(later, remaining);
		}
		return result;
	};
};
var lastScrollTop = 0;
function checkScrollDirection() {
	var st = window.pageYOffset || document.documentElement.scrollTop;
	if ((st < lastScrollTop) || (st <= 0)){
		xfhtml.classList.remove(\'mobile-navigation-bar--hidden\');
	} else {
		xfhtml.classList.add(\'mobile-navigation-bar--hidden\');
	}
	lastScrollTop = st;
}
window.addEventListener("scroll", throttle(checkScrollDirection, 500));
';
	}
	$__finalCompiled .= '
</script>';
	return $__finalCompiled;
}
);