<?php
	class_exists('XF\Install\App', false) || die('Invalid');
?>

<script type="text/javascript">
	var XF = window.XF || {};

	!function (window, document)
	{
		"use strict";

		XF.ActionIndicator = (function()
		{
			var activeCounter = 0, indicator;

			var initialize = function()
			{
				document.addEventListener('xf:action-start', show);
				document.addEventListener('xf:action-stop', hide);
			};

			var show = function()
			{
				activeCounter++;
				if (activeCounter != 1)
				{
					return;
				}

				if (!indicator)
				{
					var container = document.createElement('div');

					container.innerHTML = '<span class="globalAction">'
						+ '<span class="globalAction-bar"></span>'
						+ '<span class="globalAction-block"><i></i><i></i><i></i></span>'
						+ '</span>';
					indicator = container.firstChild;

					document.body.append(indicator);
				}

				indicator.classList.add('is-active');
			}

			var hide = function()
			{
				activeCounter--;
				if (activeCounter > 0)
				{
					return;
				}

				activeCounter = 0;

				if (indicator)
				{
					indicator.classList.remove('is-active');
				}
			}

			return {
				initialize: initialize,
				show: show,
				hide: hide
			}
		})();

		XF.FormAutoSubmit = (function()
		{
			var form, submit;

			var initialize = function()
			{
				if (!form)
				{
					form = document.querySelector('form.js-autoSubmit');
					if (!form)
					{
						return;
					}
				}

				form.submit();

				if (!submit)
				{
					submit = form.querySelector('button.js-submitButton');
					if (submit)
					{
						submit.style.display = 'none';
					}
				}

				document.dispatchEvent(new Event('xf:action-start'));
			}

			return {
				initialize: initialize
			};
		})();

		if (!XF.browser)
		{
			XF.browser = {
				browser: '',
				version: 0,
				os: '',
				osVersion: null
			};
		}

		XF.BrowserWarning = (function()
		{
			function display()
			{
				var ua = navigator.userAgent.toLowerCase(),
					display = false,
					match, browser, version;

				match = /trident\/.*rv:([0-9.]+)/.exec(ua);
				if (match)
				{
					browser = 'msie';
					version = parseFloat(match[1]);
				}
				else
				{
					// this is different regexes as we need the particular order
					match = /(msie)[ \/]([0-9\.]+)/.exec(ua)
						|| /(edge)[ \/]([0-9\.]+)/.exec(ua)
						|| [];

					browser = match[1] || '';
					version = parseFloat(match[2]) || 0;
				}

				if (browser === 'msie')
				{
					display = true;
				}
				else if (browser === 'edge' && parseInt(version) < 18)
				{
					display = true;
				}

				if (display)
				{
					var warning = document.querySelector('.js-browserWarning');
					if (warning)
					{
						warning.style.display = 'block';
					}
				}
			}

			return {
				display: display
			};
		})();

		XF.onPageLoad = (function()
		{
			document.dispatchEvent(new Event('xf:page-load-start'));

			XF.BrowserWarning.display();
			XF.ActionIndicator.initialize();
			XF.FormAutoSubmit.initialize();

			document.dispatchEvent(new Event('xf:page-load-complete'));
		});

		XF.onPageLoad();
	}
	(window, document)
</script>
