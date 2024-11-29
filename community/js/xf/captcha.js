!function($, window, document, _undefined)
{
	"use strict";

	XF.KeyCaptcha = XF.Element.newHandler({

		options: {
			user: null,
			session: null,
			sign: null,
			sign2: null
		},

		$form: null,
		$code: null,

		init: function()
		{
			this.$form = this.$target.closest('form');
			this.$form.xfUniqueId();

			this.$code = this.$form.find('input[name=keycaptcha_code]');
			this.$code.xfUniqueId();

			this.load();
			this.$target.closest('form').on('ajax-submit:error ajax-submit:always', XF.proxy(this, 'reload'));
		},

		load: function()
		{
			if (window.s_s_c_onload)
			{
				this.create();
			}
			else
			{
				window.s_s_c_user_id = this.options.user;
				window.s_s_c_session_id = this.options.session;
				window.s_s_c_captcha_field_id = this.$code.attr('id');
				window.s_s_c_submit_button_id = 'sbutton-#-r';
				window.s_s_c_web_server_sign = this.options.sign;
				window.s_s_c_web_server_sign2 = this.options.sign2;
				document.s_s_c_element = this.$form[0];
				document.s_s_c_debugmode = 1;

				var $div = $('#div_for_keycaptcha');
				if (!$div.length)
				{
					$('body').append('<div id="div_for_keycaptcha" />');
				}

				$.ajax({
					url: 'https://backs.keycaptcha.com/swfs/cap.js',
					dataType: 'script',
					cache: true,
					global: false
				});
			}
		},

		create: function()
		{
			window.s_s_c_onload(this.$form.attr('id'), this.$code.attr('id'), 'sbutton-#-r');
		},

		reload: function(e)
		{
			if (!window.s_s_c_onload)
			{
				return;
			}

			if (!$(e.target).is('form'))
			{
				e.preventDefault();
			}
			this.load();
		}
	});

	XF.ReCaptcha = XF.Element.newHandler({

		options: {
			sitekey: null,
			invisible: null
		},

		$reCaptchaTarget: null,

		reCaptchaId: null,
		invisibleValidated: false,
		reloading: false,

		init: function()
		{
			if (!this.options.sitekey)
			{
				return;
			}

			var $form = this.$target.closest('form');

			if (this.options.invisible)
			{
				var $reCaptchaTarget = $('<div />'),
					$formRow = this.$target.closest('.formRow');

				$formRow.hide();
				$formRow.after($reCaptchaTarget);
				this.$reCaptchaTarget = $reCaptchaTarget;

				$form.on('ajax-submit:before', XF.proxy(this, 'beforeSubmit'));
			}
			else
			{
				this.$reCaptchaTarget = this.$target;
			}

			$form.on('ajax-submit:error ajax-submit:always', XF.proxy(this, 'reload'));

			if (window.grecaptcha)
			{
				this.create();
			}
			else
			{
				XF.ReCaptcha.Callbacks.push(XF.proxy(this, 'create'));

				$.ajax({
					url: 'https://www.recaptcha.net/recaptcha/api.js?onload=XFReCaptchaCallback&render=explicit',
					dataType: 'script',
					cache: true,
					global: false
				});
			}
		},

		create: function()
		{
			if (!window.grecaptcha)
			{
				return;
			}

			var options = {
				sitekey: this.options.sitekey
			};
			if (this.options.invisible)
			{
				options.size = 'invisible';
				options.callback = XF.proxy(this, 'complete');

			}
			this.reCaptchaId = grecaptcha.render(this.$reCaptchaTarget[0], options);
		},

		beforeSubmit: function(e, config)
		{
			if (!this.invisibleValidated)
			{
				e.preventDefault();
				config.preventSubmit = true;

				grecaptcha.execute();
			}
		},

		complete: function()
		{
			this.invisibleValidated = true;
			this.$target.closest('form').submit();
		},

		reload: function()
		{
			if (!window.grecaptcha || this.reCaptchaId === null || this.reloading)
			{
				return;
			}

			this.reloading = true;

			var self = this;
			setTimeout(function()
			{
				grecaptcha.reset(self.reCaptchaId);
				self.reloading = false;
				self.invisibleValidated = false;
			}, 50);
		}
	});
	XF.ReCaptcha.Callbacks = [];
	window.XFReCaptchaCallback = function()
	{
		var cb = XF.ReCaptcha.Callbacks;

		for (var i = 0; i < cb.length; i++)
		{
			cb[i]();
		}
	};

	XF.Turnstile = XF.Element.newHandler({

		options: {
			sitekey: null,
			theme: 'light',
			action: '',
		},

		$turnstileTarget: null,

		turnstileId: null,
		reloading: false,

		init: function()
		{
			if (!this.options.sitekey)
			{
				return;
			}

			var $form = this.$target.closest('form');

			this.$turnstileTarget = this.$target;

			$form.on('ajax-submit:error ajax-submit:always', XF.proxy(this, 'reload'));

			if (window.turnstile)
			{
				this.create();
			}
			else
			{
				XF.Turnstile.Callbacks.push(XF.proxy(this, 'create'));

				$.ajax({
					url: 'https://challenges.cloudflare.com/turnstile/v0/api.js?onload=XFTurnstileCaptchaCallback',
					dataType: 'script',
					cache: true,
					global: false
				});
			}
		},

		create: function()
		{
			if (!window.turnstile)
			{
				return;
			}

			var options = {
				sitekey: this.options.sitekey,
				theme: this.options.theme,
				action: this.options.action,
			};
			this.turnstileId = window.turnstile.render(this.$turnstileTarget[0], options);
		},

		complete: function()
		{
			this.$target.closest('form').submit();
		},

		reload: function()
		{
			if (!window.turnstile || this.turnstileId === null || this.reloading)
			{
				return;
			}

			this.reloading = true;

			var self = this;
			setTimeout(function()
			{
				window.turnstile.reset(self.turnstileId);
				self.reloading = false;
			}, 50);
		}
	});
	XF.Turnstile.Callbacks = [];
	window.XFTurnstileCaptchaCallback = function()
	{
		var cb = XF.Turnstile.Callbacks;

		for (var i = 0; i < cb.length; i++)
		{
			cb[i]();
		}
	};

	XF.HCaptcha = XF.Element.newHandler({

		options: {
			sitekey: null,
			invisible: null,
		},

		$hCaptchaTarget: null,

		hCaptchaId: null,
		invisibleValidated: false,
		reloading: false,

		init: function()
		{
			if (!this.options.sitekey)
			{
				return;
			}

			var $form = this.$target.closest('form');

			$form.on('ajax-submit:error ajax-submit:always', XF.proxy(this, 'reload'));

			if (this.options.invisible)
			{
				var $hCaptchaTarget = $('<div />'),
					$formRow = this.$target.closest('.formRow');

				$formRow.hide();
				$formRow.after($hCaptchaTarget);
				this.$hCaptchaTarget = $hCaptchaTarget;

				$form.on('ajax-submit:before', XF.proxy(this, 'beforeSubmit'));
			}
			else
			{
				this.$hCaptchaTarget = this.$target;
			}

			if (window.hcaptcha)
			{
				this.create();
			}
			else
			{
				XF.HCaptcha.Callbacks.push(XF.proxy(this, 'create'));

				var options = {
					dataType: 'script',
					cache: true,
					global: false
				};

				if (XF.browser.msie)
				{
					// if msie then handle calling callbacks manually due to
					// an apparent issue with onload firing on IE11
					options.url = 'https://hcaptcha.com/1/api.js?render=explicit';
					options.success = window.XFHCaptchaCallback;
				}
				else
				{
					options.url = 'https://hcaptcha.com/1/api.js?onload=XFHCaptchaCallback&render=explicit';
				}

				$.ajax(options);
			}
		},

		create: function()
		{
			if (!window.hcaptcha)
			{
				return;
			}

			var options = {
				sitekey: this.options.sitekey
			};
			if (this.options.invisible)
			{
				options.size = 'invisible';
				options.callback = XF.proxy(this, 'complete');

			}
			this.hCaptchaId = window.hcaptcha.render(this.$hCaptchaTarget[0], options);
		},

		beforeSubmit: function(e, config)
		{
			if (!this.invisibleValidated)
			{
				e.preventDefault();
				config.preventSubmit = true;

				window.hcaptcha.execute(this.hCaptchaId);
			}
		},

		complete: function()
		{
			this.invisibleValidated = true;
			this.$target.closest('form').submit();
		},

		reload: function()
		{
			if (!window.hcaptcha || this.hCaptchaId === null || this.reloading)
			{
				return;
			}

			this.reloading = true;

			var self = this;
			setTimeout(function()
			{
				window.hcaptcha.reset(self.hCaptchaId);
				self.reloading = false;
				self.invisibleValidated = false;
			}, 50);
		}
	});
	XF.HCaptcha.Callbacks = [];
	window.XFHCaptchaCallback = function()
	{
		var cb = XF.HCaptcha.Callbacks;

		for (var i = 0; i < cb.length; i++)
		{
			cb[i]();
		}
	};

	XF.QaCaptcha = XF.Element.newHandler({

		options: {
			url: null
		},

		reloading: false,

		init: function()
		{
			if (!this.options.url)
			{
				return;
			}

			this.$target.closest('form').on('ajax-submit:error ajax-submit:always', XF.proxy(this, 'reload'));
		},

		reload: function()
		{
			if (this.reloading)
			{
				return;
			}

			this.reloading = true;

			this.$target.fadeTo(XF.config.speed.fast, 0.5);
			XF.ajax('get', this.options.url, XF.proxy(this, 'show'));
		},

		show: function(data)
		{
			var $target = this.$target,
				self = this;

			XF.setupHtmlInsert(data.html, function ($html, container, onComplete)
			{
				$html.hide();
				$target.after($html);

				$target.xfFadeUp(XF.config.speed.fast, function()
				{
					$html.xfFadeDown(XF.config.speed.fast);
					$target.remove();
				});

				self.reloading = false;
				onComplete();
			});
		}
	});

	XF.SolveCaptcha = XF.Element.newHandler({

		options: {
			ckey: null,
			theme: 'white'
		},

		instance: null,
		reloading: false,

		init: function()
		{
			if (this.instance)
			{
				this.instance.remove();
			}
			this.instance = this;

			if (!this.options.ckey)
			{
				return;
			}

			this.$target.closest('form').on('ajax-submit:error ajax-submit:always', XF.proxy(this, 'reload'));
			this.$target.siblings('noscript').remove();

			this.load();
			$(window).on('unload', XF.proxy(this, 'remove'));
		},

		load: function()
		{
			if (window.ACPuzzle)
			{
				this.create();
			}
			else
			{
				var prefix = window.location.protocol == 'https:' ? 'https://api-secure' : 'http://api';

				window.ACPuzzleOptions = {
					onload: XF.proxy(this, 'create')
				};
				$.ajax({
					url: prefix + '.solvemedia.com/papi/challenge.ajax',
					dataType: 'script',
					cache: true,
					global: false
				});
			}
		},

		create: function()
		{
			window.ACPuzzle.create(this.options.ckey, this.$target.attr('id'), {
				theme: this.options.theme || 'white',
				lang: $('html').attr('lang').substr(0, 2) || 'en'
			});
		},

		reload: function(e)
		{
			if (!window.ACPuzzle || this.reloading)
			{
				return;
			}

			//this.reloading = true;

			if (!$(e.target).is('form'))
			{
				e.preventDefault();
			}
			window.ACPuzzle.reload();

//			this.reloading = false;
		},

		remove: function()
		{
			this.$target.empty().remove();
			if (window.ACPuzzle)
			{
				window.ACPuzzle.destroy();
			}
		}
	});

	// ################################## GUEST CAPTCHA HANDLER ###########################################

	XF.GuestCaptcha = XF.Element.newHandler({

		options: {
			url: 'index.php?misc/captcha&with_row=1',
			captchaContext: '',
			target: '.js-captchaContainer',
			skip: '[name=more_options]'
		},

		$captchaContainer: null,

		initialized: false,

		init: function()
		{
			var $form = this.$target;
			this.$captchaContainer = $form.find(this.options.target);
			if (!this.$captchaContainer.length)
			{
				return;
			}

			$form.on('focusin', XF.proxy(this, 'initializeCaptcha'));
			$form.on('submit ajax-submit:before', XF.proxy(this, 'submit'));
		},

		initializeCaptcha: function(e)
		{
			var $activeElement = $(document.activeElement);

			if (this.initialized || $activeElement.is(this.options.skip))
			{
				return;
			}

			var rowType = this.$captchaContainer.data('row-type') || '';

			XF.ajax('get',
				XF.canonicalizeUrl(this.options.url),
				{
					row_type: rowType,
					context: this.options.captchaContext
				},
				XF.proxy(this, 'showCaptcha')
			);

			this.initialized = true;
		},

		showCaptcha: function(data)
		{
			var self = this;
			XF.setupHtmlInsert(data.html, function ($html, container, onComplete)
			{
				$html.replaceAll(self.$captchaContainer);

				onComplete();
			});
		},

		submit: function(e)
		{
			if (!this.initialized)
			{
				var $activeElement = $(document.activeElement);

				if (!$activeElement.is(this.options.skip))
				{
					e.preventDefault();
					return false;
				}
			}
		}
	});

	XF.Element.register('key-captcha', 'XF.KeyCaptcha');
	XF.Element.register('re-captcha', 'XF.ReCaptcha');
	XF.Element.register('turnstile', 'XF.Turnstile');
	XF.Element.register('h-captcha', 'XF.HCaptcha');
	XF.Element.register('qa-captcha', 'XF.QaCaptcha');
	XF.Element.register('solve-captcha', 'XF.SolveCaptcha');

	XF.Element.register('guest-captcha', 'XF.GuestCaptcha');
}
(jQuery, window, document);