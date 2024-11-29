/** @param {jQuery} $ jQuery Object */
!function($, window, document, _undefined)
{
	"use strict";

	// ################################## ATTRIBUTION HANDLER ###########################################

	XF.AttributionClick = XF.Event.newHandler({
		eventType: 'click',
		eventNameSpace: 'XFAttributionClick',
		options: {
			contentSelector: null
		},

		init: function()
		{
		},

		click: function(e)
		{
			var hash = this.options.contentSelector,
				$content = $(hash);

			if ($content.length)
			{
				e.preventDefault();
				XF.smoothScroll($content, hash, XF.config.speed.normal);
			}
		}
	});

	// ################################## LIKE HANDLER ###########################################

	XF.LikeClick = XF.Event.newHandler({
		eventType: 'click',
		eventNameSpace: 'XFLikeClick',
		options: {
			likeList: null,
			container: null
		},

		processing: false,
		container: null,

		init: function()
		{
			if (this.options.container)
			{
				this.$container = XF.findRelativeIf(this.options.container, this.$target);
			}
		},

		click: function(e)
		{
			e.preventDefault();

			if (this.processing)
			{
				return;
			}
			this.processing = true;

			var href = this.$target.attr('href'),
				self = this;

			XF.ajax('POST', href, {}, XF.proxy(this, 'handleAjax'), {skipDefaultSuccess: true})
				.always(function()
				{
					setTimeout(function()
					{
						self.processing = false;
					}, 250);
				});
		},

		handleAjax: function(data)
		{
			var $target = this.$target;

			$target.trigger('xf-' + this.eventType + ':before-handleAjax.' + this.eventNameSpace, [this, data]);

			if (data.addClass)
			{
				$target.addClass(data.addClass);
			}
			if (data.removeClass)
			{
				$target.removeClass(data.removeClass);
			}
			if (data.text)
			{
				var $label = $target.find('.label');
				if (!$label.length)
				{
					$label = $target;
				}
				$label.text(data.text);
			}

			if (data.hasOwnProperty('isLiked'))
			{
				$target.toggleClass('is-liked', data.isLiked);
				if (this.$container)
				{
					this.$container.toggleClass('is-liked', data.isLiked);
				}
			}

			var $likeList = this.options.likeList ? XF.findRelativeIf(this.options.likeList, $target) : $([]);

			if (typeof data.html !== 'undefined' && $likeList.length)
			{
				if (data.html.content)
				{
					XF.setupHtmlInsert(data.html, function($html, container)
					{
						$likeList.html($html).addClassTransitioned('is-active');
					});
				}
				else
				{
					$likeList.removeClassTransitioned('is-active', function()
					{
						$likeList.empty();
					});
				}
			}

			$target.trigger('xf-' + this.eventType + ':after-handleAjax.' + this.eventNameSpace, [this, data]);
		}
	});

	// ################################## PREVIEW CLICK ###########################################
	// ### DEPRECATED - Use new editor tab based preview.

	XF.PreviewClick = XF.Event.newHandler({
		eventType: 'click',
		eventNameSpace: 'XFPreviewClick',
		options: {},

		init: function()
		{
			console.warn('XF.PreviewClick is disabled. Use the built in editor preview tab');
		},

		click: function(e)
		{
			e.preventDefault();
		}
	});

	// ################################## SWITCH HANDLER ###########################################

	XF.handleSwitchResponse = function($target, data, allowRedirect)
	{
		if (data.switchKey)
		{
			var switchActions = $target.data('sk-' + data.switchKey),
				syncTitleAttr = false;

			if (switchActions)
			{
				var match, value;
				while (match = switchActions.match(/(\s*,)?\s*(addClass|removeClass|titleAttr):([^,]+)(,|$)/))
				{
					switchActions = switchActions.substring(match[0].length);

					value = $.trim(match[3]);
					if (value.length)
					{
						switch (match[2])
						{
							case 'addClass': $target.addClass(value); break;
							case 'removeClass': $target.removeClass(value); break;
							case 'titleAttr': syncTitleAttr = (value == 'sync'); break;
						}
					}
				}

				switchActions = $.trim(switchActions);

				if (switchActions.length && !data.text)
				{
					data.text = switchActions;
				}
			}
		}

		if (data.addClass)
		{
			$target.addClass(data.addClass);
		}
		if (data.removeClass)
		{
			$target.removeClass(data.removeClass);
		}

		if (data.text)
		{
			var $label = $target.find($target.data('label'));
			if (!$label.length)
			{
				$label = $target;
			}
			$label.text(data.text);

			if (syncTitleAttr)
			{
				$target.attr('title', data.text)
					.removeAttr('data-original-title')
					.trigger('tooltip:refresh')
			}
		}

		if (data.message)
		{
			var doRedirect = (allowRedirect && data.redirect),
				flashLength = doRedirect ? 1000 : 3000;

			XF.flashMessage(data.message, flashLength, function()
			{
				if (doRedirect)
				{
					XF.redirect(data.redirect);
				}
			});
		}
	};

	XF.ScrollToClick = XF.Event.newHandler({
		eventType: 'click',
		eventNameSpace: 'XFScrollToClick',
		options: {
			target: null, // specify a target to which to scroll, when href is not available
			silent: false, // if true and no scroll
			hash: null, // override history hash - off by default, use true to use target's ID or string for arbitrary hash value
			speed: 300 // scroll animation speed
		},

		$scroll: null,

		init: function()
		{
			var $scroll,
				hash = this.options.hash,
				targetHref = this.$target.attr('href');

			if (this.options.target)
			{
				$scroll = XF.findRelativeIf(this.options.target, this.$target);
			}
			if (!$scroll || !$scroll.length)
			{
				if (targetHref && targetHref.length && targetHref.charAt(0) == '#')
				{
					$scroll = $(targetHref);
				}
				else if (this.options.silent)
				{
					// don't let an error happen here, just silently ignore
					return;
				}
			}

			if (!$scroll || !$scroll.length)
			{
				console.error('No scroll target could be found');
				return;
			}

			this.$scroll = $scroll;

			if (hash === true || hash === 'true')
			{
				var id = $scroll.attr('id');
				this.options.hash = (id && id.length) ? id : null;
			}
			else if (hash === false || hash === 'false')
			{
				this.options.hash = null;
			}
		},

		click: function(e)
		{
			if (!this.$scroll)
			{
				return;
			}

			e.preventDefault();
			XF.smoothScroll(this.$scroll, this.options.hash, this.options.speed);
		}
	});

	XF.SwitchClick = XF.Event.newHandler({
		eventType: 'click',
		eventNameSpace: 'XFSwitchClick',
		options: {
			redirect: false,
			overlayOnHtml: true,
			label: '.js-label'
		},

		processing: false,
		overlay: null,

		init: function()
		{
			this.$target.data('label', this.options.label);
		},

		click: function(e)
		{
			e.preventDefault();

			if (this.processing)
			{
				return;
			}
			this.processing = true;

			var href = this.$target.attr('href'),
				self = this;

			XF.ajax('POST', href, {}, XF.proxy(this, 'handleAjax'), {skipDefaultSuccess: true})
				.always(function()
				{
					setTimeout(function()
					{
						self.processing = false;
					}, 250);
				});
		},

		handleAjax: function(data)
		{
			var $target = this.$target,
				event = $.Event('switchclick:complete'),
				self = this;

			$target.trigger(event, data, this);
			if (event.isDefaultPrevented())
			{
				return;
			}

			if (data.html && data.html.content && this.options.overlayOnHtml)
			{
				XF.setupHtmlInsert(data.html, function($html, container)
				{
					if (self.overlay)
					{
						self.overlay.hide();
					}

					var $overlay = XF.getOverlayHtml({
						html: $html,
						title: container.h1 || container.title
					});

					$overlay.find('form').on('ajax-submit:response', XF.proxy(self, 'handleOverlayResponse'));

					self.overlay = XF.showOverlay($overlay);
				});
				return;
			}

			this.applyResponseActions(data);

			if (this.overlay)
			{
				this.overlay.hide();
				this.overlay = null;
			}
		},

		handleOverlayResponse: function(e, data)
		{
			if (data.status == 'ok')
			{
				e.preventDefault();

				this.handleAjax(data);
			}
		},

		applyResponseActions: function(data)
		{
			XF.handleSwitchResponse(this.$target, data, this.options.redirect);
		}
	});

	XF.SwitchOverlayClick = XF.Event.newHandler({
		eventType: 'click',
		eventNameSpace: 'XFSwitchOverlayClick',
		options: {
			redirect: false
		},

		overlay: null,

		init: function()
		{
		},

		click: function(e)
		{
			e.preventDefault();

			if (this.overlay)
			{
				this.overlay.show();
				return;
			}

			var href = this.$target.attr('href');

			XF.loadOverlay(href, {
				cache: false,
				init: XF.proxy(this, 'setupOverlay')
			});
		},

		setupOverlay: function(overlay)
		{
			this.overlay = overlay;

			var $form = overlay.getOverlay().find('form');

			$form.on('ajax-submit:response', XF.proxy(this, 'handleOverlaySubmit'));

			var t = this;
			overlay.on('overlay:hidden', function() { t.overlay = null; });

			return overlay;
		},

		handleOverlaySubmit: function(e, data)
		{
			if (data.status == 'ok')
			{
				e.preventDefault();

				var overlay = this.overlay;
				if (overlay)
				{
					overlay.hide();
				}

				XF.handleSwitchResponse(this.$target, data, this.options.redirect);
			}
		}
	});

	// ################################## ALERTS LIST HANDLER ###########################################

	XF.AlertsList = XF.Element.newHandler({
		options: {},

		processing: false,

		init: function()
		{
			var $markAllRead = XF.findRelativeIf('< .menu-content | .js-alertsMarkRead', this.$target);

			if ($markAllRead.length)
			{
				$markAllRead.on('click', XF.proxy(this, 'markAllReadClick'));
			}

			var $alertToggles = this.$target.find('.js-alertToggle');
			$alertToggles.on('click', this.$target, XF.proxy(this, 'markReadClick'));
		},

		_makeAjaxRequest: function(url, successCallback, requestData)
		{
			if (this.processing)
			{
				return;
			}
			this.processing = true;

			var t = this;

			XF.ajax('POST', url, requestData || {}, successCallback, {skipDefaultSuccess: true})
				.always(function()
				{
					setTimeout(function()
					{
						t.processing = false;
					}, 250);
				});
		},

		markAllReadClick: function(e)
		{
			e.preventDefault();
			this._makeAjaxRequest($(e.target).attr('href'), XF.proxy(this, 'handleMarkAllReadAjax'));
		},

		markReadClick: function(e)
		{
			e.preventDefault();

			var $link = $(e.currentTarget),
				$alert = $link.closest('.js-alert'),
				isUnread = $alert.hasClass('is-unread'),
				alertId = $alert.data('alert-id');

			this._makeAjaxRequest(
				$link.attr('href'),
				XF.proxy(this, 'handleMarkReadAjax', alertId),
				{ unread: isUnread ? 0 : 1 }
			);
		},

		handleMarkAllReadAjax: function(data)
		{
			if (data.message)
			{
				XF.flashMessage(data.message, 3000);
			}

			var $alerts = this.$target.find('.js-alert'),
				t = this;

			$alerts.each(function()
			{
				t.toggleReadStatus($(this), false);
			});
		},

		handleMarkReadAjax: function(alertId, data)
		{
			if (data.message)
			{
				XF.flashMessage(data.message, 3000);
			}

			var $alert = this.$target.find('.js-alert[data-alert-id="' + alertId + '"]');

			this.toggleReadStatus($alert, true);
		},

		toggleReadStatus: function($alert, canMarkUnread)
		{
			var wasUnread = $alert.hasClass('is-unread'),
				$toggle = $alert.find('.js-alertToggle'),
				tooltip = XF.Element.getHandler($toggle, 'tooltip'),
				phrase = $toggle.data('content');

			if (wasUnread)
			{
				$alert.removeClass('is-unread');
				phrase = $toggle.data('unread');
			}
			else if (canMarkUnread)
			{
				$alert.addClass('is-unread');
				phrase = $toggle.data('read');
			}

			tooltip.tooltip.setContent(phrase);
		}
	});


	// ################################## DRAFT HANDLER ###########################################

	XF.Draft = XF.Element.newHandler({
		options: {
			draftAutosave: 60,
			draftName: 'message',
			draftUrl: null,

			saveButton: '.js-saveDraft',
			deleteButton: '.js-deleteDraft',
			actionIndicator: '.draftStatus'
		},

		lastActionContent: null,
		autoSaveRunning: false,

		init: function()
		{
			if (!this.options.draftUrl)
			{
				console.error('No draft URL specified.');
				return;
			}

			var self = this;
			this.$target.on(this.options.saveButton, 'click', function(e)
			{
				e.preventDefault();
				self.triggerSave();
			});
			this.$target.on(this.options.deleteButton, 'click', function(e)
			{
				e.preventDefault();
				self.triggerDelete();
			});

			var proxySync = XF.proxy(this, 'syncState');

			// set the default value and check it after other JS loads
			this.syncState();
			setTimeout(proxySync, 500);

			this.$target.on('draft:sync', proxySync);

			setInterval(XF.proxy(this, 'triggerSave'), this.options.draftAutosave * 1000);
		},

		triggerSave: function()
		{
			if (XF.isRedirecting)
			{
				// we're unloading the page, don't try to save any longer
				return;
			}

			var event = $.Event('draft:beforesave');

			this.$target.trigger(event);
			if (event.isDefaultPrevented())
			{
				return;
			}

			this._executeDraftAction(this.getSaveData());
		},

		triggerDelete: function()
		{
			// prevent re-saving the content until it's changed
			this.lastActionContent = this.getSaveData();

			this._sendDraftAction('delete=1');
		},

		_executeDraftAction: function(data)
		{
			if (data == this.lastActionContent)
			{
				return;
			}
			if (this.autoSaveRunning)
			{
				return false;
			}

			this.lastActionContent = data;
			this._sendDraftAction(data);
		},

		_sendDraftAction: function(data)
		{
			this.autoSaveRunning = true;

			var self = this;

			return XF.ajax(
				'post',
				this.options.draftUrl,
				data,
				XF.proxy(this, 'completeAction'),
				{ skipDefault: true, skipError: true, global: false }
			).always(
				function() { self.autoSaveRunning = false; }
			);
		},

		completeAction: function(data)
		{
			var event = $.Event('draft:complete');
			this.$target.trigger(event, data);
			if (event.isDefaultPrevented() || data.draft.saved === false)
			{
				return;
			}

			var $complete = this.$target.find(this.options.actionIndicator);

			$complete.removeClass('is-active').text(data.complete).addClass('is-active');
			setTimeout(function()
			{
				$complete.removeClass('is-active');
			}, 2000);
		},

		syncState: function()
		{
			this.lastActionContent = this.getSaveData();
		},

		getSaveData: function()
		{
			var $target = this.$target;

			$target.trigger('draft:beforesync');
			return $target.serialize()
				.replace(/(^|&)_xfToken=[^&]+(?=&|$)/g, '')
				.replace(/^&+/, '');
		}
	});

	// ################################## DRAFT TRIGGER ###########################################

	XF.DraftTrigger = XF.Element.newHandler({
		options: {
			delay: 2500
		},

		draftHandler: null,
		timer: null,

		init: function()
		{
			if (!XF.isElementWithinDraftForm(this.$target))
			{
				return;
			}

			var $form = this.$target.closest('form');
			this.draftHandler = XF.Element.getHandler($form, 'draft');

			if (!this.draftHandler)
			{
				return;
			}

			this.$target.on('keyup', XF.proxy(this, 'keyup'));
		},

		keyup: function(e)
		{
			clearTimeout(this.timer);

			var t = this;
			this.timer = setTimeout(function()
			{
				t.draftHandler.triggerSave();
			}, this.options.delay);
		}
	});

	// ################################## FOCUS TRIGGER HANDLER ###########################################

	XF.FocusTrigger = XF.Element.newHandler({
		options: {
			display: null,
			activeClass: 'is-active'
		},

		init: function()
		{
			if (this.$target.attr('autofocus'))
			{
				this.trigger();
			}
			else
			{
				this.$target.one('focusin', XF.proxy(this, 'trigger'));
			}
		},

		trigger: function()
		{
			var display = this.options.display;
			if (display)
			{
				var $display = XF.findRelativeIf(display, this.$target);
				if ($display.length)
				{
					$display.addClassTransitioned(this.options.activeClass);
				}
			}
		}
	});

	// ################################## POLL BLOCK HANDLER ###########################################

	XF.PollBlock = XF.Element.newHandler({
		options: {},

		init: function()
		{
			this.$target.on('ajax-submit:response', XF.proxy(this, 'afterSubmit'));
		},

		afterSubmit: function(e, data)
		{
			if (data.errors || data.exception)
			{
				return;
			}

			e.preventDefault();

			if (data.redirect)
			{
				XF.redirect(data.redirect);
			}

			var self = this;
			XF.setupHtmlInsert(data.html, function($html, container)
			{
				$html.hide();
				$html.insertAfter(self.$target);

				self.$target.xfFadeUp(null, function()
				{
					self.$target.remove();

					$html.xfFadeDown();
				});
			});
		}
	});

	// ################################## PREVIEW HANDLER ###########################################

	XF.Preview = XF.Element.newHandler({
		options: {
			previewUrl: null,
			previewButton: 'button.js-previewButton'
		},

		previewing: null,

		init: function()
		{
			var $form = this.$target,
				$button = XF.findRelativeIf(this.options.previewButton, $form);

			if (!this.options.previewUrl)
			{
				console.warn('Preview form has no data-preview-url: %o', $form);
				return;
			}

			if (!$button.length)
			{
				console.warn('Preview form has no preview button: %o', $form);
				return;
			}

			$button.on({
				click: XF.proxy(this, 'preview')
			});
		},

		preview: function(e)
		{
			e.preventDefault();

			if (this.previewing)
			{
				return false;
			}
			this.previewing = true;

			var draftHandler = XF.Element.getHandler(this.$target, 'draft');
			if (draftHandler)
			{
				draftHandler.triggerSave();
			}

			var t = this;
			XF.ajax('post', this.options.previewUrl, this.$target.serializeArray(), function(data)
			{
				if (data.html)
				{
					XF.setupHtmlInsert(data.html, function ($html, container, onComplete)
					{
						XF.overlayMessage(container.title, $html);
					});
				}
			}).always(function()
			{
				t.previewing = false;
			});
		}
	});

	// ################################## SHARE BUTTONS HANDLER ###########################################

	XF.ShareButtons = XF.Element.newHandler({
		options: {
			buttons: '.shareButtons-button',
			iconic: '.shareButtons--iconic',
			pageUrl: null,
			pageTitle: null,
			pageDesc: null,
			pageImage: null,
		},

		pageUrl: null,
		pageTitle: null,
		pageDesc: null,
		pageImage: null,

		init: function()
		{
			var buttonSel = this.options.buttons,
				iconic = this.options.iconic;

			this.$target
				.on('focus mouseenter', buttonSel, XF.proxy(this, 'focus'))
				.on('click', buttonSel, XF.proxy(this, 'click'));

			if (typeof iconic == 'string')
			{
				iconic = this.$target.is(iconic);
			}
			this.$target.find(buttonSel).each(function()
			{
				var $el = $(this);
				if (iconic)
				{
					XF.Element.applyHandler($el, 'element-tooltip', {
						element: '> span'
					});
				}
				if ($el.data('clipboard') && navigator.clipboard)
				{
					$el.removeClass('is-hidden');
				}
			});
		},

		setupPageData: function()
		{
			if (this.options.pageTitle && this.options.pageTitle.length)
			{
				this.pageTitle = this.options.pageTitle;
			}
			else
			{
				this.pageTitle = $('meta[property="og:title"]').attr('content');
				if (!this.pageTitle)
				{
					this.pageTitle = $('title').text();
				}
			}

			if (this.options.pageUrl && this.options.pageUrl.length)
			{
				this.pageUrl = this.options.pageUrl;
			}
			else
			{
				var $overlay = this.$target.closest('.overlay');
				if ($overlay.length)
				{
					this.pageUrl = $overlay.data('url');
				}

				if (!this.pageUrl)
				{
					this.pageUrl = $('meta[property="og:url"]').attr('content');
				}
				if (!this.pageUrl)
				{
					this.pageUrl = window.location.href;
				}
			}

			if (this.options.pageDesc && this.options.pageDesc.length)
			{
				this.pageDesc = this.options.pageDesc;
			}
			else
			{
				this.pageDesc = $('meta[property="og:description"]').attr('content');
				if (!this.pageDesc)
				{
					this.pageDesc = $('meta[name=description]').attr('content') || '';
				}
			}

			if (this.options.pageImage && this.options.pageImage.length)
			{
				this.pageImage = this.options.pageImage;
			}
			else
			{
				this.pageImage = $('meta[property="og:image"]').attr('content');
				if (!this.pageImage)
				{
					this.pageImage = XF.config.publicMetadataLogoUrl || '';
				}
			}
		},

		focus: function(e)
		{
			var $el = $(e.currentTarget);

			if ($el.attr('href'))
			{
				return;
			}

			if ($el.is('.shareButtons-button--share'))
			{
				return;
			}

			if (!this.pageUrl)
			{
				this.setupPageData();
			}

			var href = $el.data('href');
			if (!href)
			{
				if ($el.data('clipboard'))
				{
					// handled on click
					return;
				}
				else
				{
					console.error('No data-href or data-clipboard on share button %o', e.currentTarget);
				}
			}

			href = href.replace('{url}', encodeURIComponent(this.pageUrl))
				.replace('{title}', encodeURIComponent(this.pageTitle))
				.replace('{desc}', encodeURIComponent(this.pageDesc))
				.replace('{image}', encodeURIComponent(this.pageImage));

			$el.attr('href', href);
		},

		click: function(e)
		{
			var $el = $(e.currentTarget),
				href = $el.attr('href'),
				popupWidth = $el.data('popup-width') || 600,
				popupHeight = $el.data('popup-height') || 400;

			if ($el.is('.shareButtons-button--share'))
			{
				return;
			}

			if (e.altKey || e.ctrlKey || e.metaKey || e.shiftKey)
			{
				return;
			}

			if ($el.data('clipboard'))
			{
				e.preventDefault();

				var text = $el.data('clipboard')
					.replace('{url}', this.pageUrl)
					.replace('{title}', this.pageTitle)
					.replace('{desc}', this.pageDesc)
					.replace('{image}', this.pageImage);

				navigator.clipboard.writeText(text)
					.then(function()
					{
						XF.flashMessage(XF.phrase('link_copied_to_clipboard'), 3000);
					});
			}
			else if (href && href.match(/^https?:/i))
			{
				e.preventDefault();

				var popupLeft = (screen.width - popupWidth) / 2,
					popupTop = (screen.height - popupHeight) / 2;

				window.open(href, 'share',
					'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes'
					+ ',width=' + popupWidth + ',height=' + popupHeight
					+ ',left=' + popupLeft + ',top=' + popupTop
				);
			}
		}
	});

	// ################################## SHARE INPUT HANDLER ###########################################

	XF.ShareInput = XF.Element.newHandler({
		options: {
			button: '.js-shareButton',
			input: '.js-shareInput',
			successText: '',
		},

		$button: null,
		$input: null,

		init: function()
		{
			this.$button = this.$target.find(this.options.button);
			this.$input = this.$target.find(this.options.input);

			if (navigator.clipboard)
			{
				this.$button.removeClass('is-hidden');
			}

			this.$button.on('click', XF.proxy(this, 'buttonClick'));
			this.$input.on('click', XF.proxy(this, 'inputClick'));
		},

		buttonClick: function(e)
		{
			var t = this;

			navigator.clipboard.writeText(this.$input.val())
				.then(function()
				{
					XF.flashMessage(t.options.successText ? t.options.successText : XF.phrase('text_copied_to_clipboard'), 3000);
				});
		},

		inputClick: function(e)
		{
			this.$input.select();
		}
	});

	// ################################## SHARE INPUT HANDLER ###########################################

	XF.WebShare = XF.Element.newHandler({
		options: {
			fetch: false,
			url: null,
			title: null,
			text: null,
			hide: null,
			hideContainerEls: true
		},

		url: null,
		title: null,
		text: null,

		fetchUrl: null,

		init: function()
		{
			if (!this.isSupported())
			{
				return;
			}

			if (this.options.fetch)
			{
				this.fetchUrl = this.options.fetch;
			}

			this.hideSpecified();
			this.hideContainerElements();
			this.setupShareData();

			this.$target
				.removeClass('is-hidden')
				.on('click', XF.proxy(this, 'click'));
		},

		isSupported: function()
		{
			var os = XF.browser.os;

			return (
				'share' in navigator
				&& window.location.protocol == 'https:'
				&& (os == 'android' || os == 'ios')
			);
		},

		hideSpecified: function()
		{
			if (!this.options.hide)
			{
				return;
			}

			var $hide = $(this.options.hide);
			if (!$hide || !$hide.length)
			{
				return;
			}

			$hide.addClass('is-hidden');
		},

		hideContainerElements: function()
		{
			if (!this.options.hideContainerEls)
			{
				return;
			}

			var $shareContainer = this.$target.parents('.block, .blockMessage');
			if ($shareContainer.length)
			{
				$shareContainer.find('.shareButtons').removeClass('shareButtons--iconic');
				$shareContainer.find('.block-minorHeader').hide();
				$shareContainer.find('.shareButtons-label').hide();
			}
		},

		setupShareData: function()
		{
			if (!this.fetchUrl)
			{
				if (this.options.url)
				{
					this.url = this.options.url;
				}
				else
				{
					this.url = $('meta[property="og:url"]').attr('content');
					if (!this.url)
					{
						this.url = window.location.href;
					}
				}

				if (this.options.title)
				{
					this.title = this.options.title;
				}
				else
				{
					this.title = $('meta[property="og:title"]').attr('content');
					if (!this.title)
					{
						this.title = $('title').text();
					}
				}

				if (this.options.text)
				{
					this.text = this.options.text;
				}
				else
				{
					this.text = $('meta[property="og:description"]').attr('content');
					if (!this.text)
					{
						this.text = $('meta[name=description]').attr('content') || '';
					}
				}
			}
		},

		click: function(e)
		{
			e.preventDefault();

			if (this.fetchUrl)
			{
				var t = this;

				XF.ajax(
					'get', this.fetchUrl, { web_share: true },
					function (data)
					{
						if (data.status === 'ok')
						{
							t.setShareOptions(data);
							t.share();
						}
						else
						{
							// some sort of error in the request so
							// redirect to the original URL passed in
							XF.redirect(t.options.url);
						}
					},
					{
						skipDefault: true,
						skipError: true,
						global: false
					}
				);
			}
			else
			{
				this.share();
			}
		},

		share: function()
		{
			navigator
				.share(this.getShareOptions())
				.catch(function (error) {});
		},

		setShareOptions: function(data)
		{
			this.url = data.contentUrl;
			this.title = data.contentTitle;
			this.text = data.contentDesc || data.contentTitle;

			this.fetchUrl = null;
		},

		getShareOptions: function()
		{
			var shareOptions = {
				url: this.url,
				title: '',
				text: ''
			};

			if (this.title)
			{
				shareOptions.title = this.title;
			}

			if (this.text)
			{
				shareOptions.text = this.text;
			}
			else
			{
				shareOptions.text = shareOptions.title;
			}

			return shareOptions;
		}
	});

	// ################################## COPY TO CLIPBOARD HANDLER ###########################################

	XF.CopyToClipboard = XF.Element.newHandler({
		options: {
			copyText: '',
			copyTarget: '',
			success: ''
		},

		copyText: null,

		init: function()
		{
			if (navigator.clipboard)
			{
				this.$target.removeClass('is-hidden');
			}

			if (this.options.copyText)
			{
				this.copyText = this.options.copyText;
			}
			else if (this.options.copyTarget)
			{
				var $target = $(this.options.copyTarget);

				if ($target.is('input[type="text"], textarea')) // TODO: expand to other types?
				{
					this.copyText = $target.val();
				}
				else
				{
					this.copyText = $target.text();
				}
			}

			if (!this.copyText)
			{
				console.error('No text to copy to clipboard');
				return;
			}

			this.$target.on('click', XF.proxy(this, 'click'));
		},

		click: function()
		{
			var t = this;

			navigator.clipboard.writeText(this.copyText)
				.then(function()
				{
					if (t.options.success)
					{
						XF.flashMessage(t.options.success, 3000);
					}
					else
					{
						var flashText = XF.phrase('text_copied_to_clipboard');

						if (t.copyText.match(/^[a-z0-9-]+:\/\/[^\s"<>{}`]+$/i))
						{
							flashText =  XF.phrase('link_copied_to_clipboard');
						}
						XF.flashMessage(flashText, 3000);
					}
				});
		}
	});

	// ################################## PUSH NOTIFICATION TOGGLE HANDLER ###########################################

	XF.PushToggle = XF.Element.newHandler({
		options: {},

		isSubscribed: false,
		cancellingSub: null,

		init: function()
		{
			if (!XF.Push.isSupported())
			{
				this.updateButton(XF.phrase('push_not_supported_label'), false);
				console.error('XF.Push.isSupported() returned false');
				return;
			}

			if (Notification.permission === 'denied')
			{
				this.updateButton(XF.phrase('push_blocked_label'), false);
				console.error('Notification.permission === denied');
				return;
			}

			this.registerWorker();
		},

		registerWorker: function()
		{
			var t = this;

			var onRegisterSuccess = function()
			{
				t.$target.on('click', XF.proxy(t, 'buttonClick'));

				$(document).on('push:init-subscribed', function()
				{
					t.updateButton(XF.phrase('push_disable_label'), true);
				});

				$(document).on('push:init-unsubscribed', function()
				{
					t.updateButton(XF.phrase('push_enable_label'), true);
				});
			};
			var	onRegisterError = function()
			{
				t.updateButton(XF.phrase('push_not_supported_label'), false);
				console.error('navigator.serviceWorker.register threw an error.');
			};
			XF.Push.registerWorker(onRegisterSuccess, onRegisterError);
		},

		buttonClick: function(e)
		{
			var t = this;

			var onUnsubscribe = function()
			{
				t.updateButton(XF.phrase('push_enable_label'), true);

				// dismiss the push CTA for the current session
				// after push has just been explicitly disabled.
				XF.Cookie.set('push_notice_dismiss', '1');

				if (XF.config.userId)
				{
					// also remove history entry as this is an explicit unsubscribe
					XF.Push.removeUserFromPushHistory();
				}
			};
			var onSubscribe = function()
			{
				t.updateButton(XF.phrase('push_disable_label'), true);
			};
			var onSubscribeError = function()
			{
				t.updateButton(XF.phrase('push_not_supported_label'), false);
			};
			XF.Push.handleToggleAction(onUnsubscribe, false, onSubscribe, onSubscribeError);
		},

		updateButton: function(phrase, enable)
		{
			this.$target.find('.button-text').text(phrase);
			if (enable)
			{
				this.$target.removeClass('is-disabled');
			}
			else
			{
				this.$target.addClass('is-disabled');
			}
		}
	});

	XF.PushCta = XF.Element.newHandler({
		options: {},

		init: function()
		{
			if (XF.config.skipPushNotificationCta)
			{
				return;
			}

			if (!XF.Push.isSupported())
			{
				return;
			}

			if (Notification.permission === 'denied')
			{
				return;
			}

			this.registerWorker();
		},

		registerWorker: function()
		{
			var t = this;

			var onRegisterSuccess = function()
			{
				$(document).on('push:init-unsubscribed', function()
				{
					if (XF.Push.hasUserPreviouslySubscribed())
					{
						try
						{
							XF.Push.handleSubscribeAction(true);
						}
						catch (e)
						{
							XF.Push.removeUserFromPushHistory();
						}
					}
					else
					{
						if (t.getDismissCookie())
						{
							return;
						}

						t.$target
							.closest('.js-enablePushContainer')
							.xfFadeDown(XF.config.speed.fast, XF.proxy(t, 'initLinks'));
					}
				});
			};
			XF.Push.registerWorker(onRegisterSuccess);
		},

		initLinks: function()
		{
			var $target = this.$target;
			$target.find('.js-enablePushLink').on('click', XF.proxy(this, 'linkClick'));
			$target.siblings('.js-enablePushDismiss').on('click', XF.proxy(this, 'dismissClick'));
		},

		linkClick: function(e)
		{
			e.preventDefault();

			this.hidePushContainer();
			this.setDismissCookie(true, 12 * 3600 * 1000); // 12 hours - it's possible the browser may not allow the setup to complete

			XF.Push.handleSubscribeAction(false);
		},

		dismissClick: function(e)
		{
			e.preventDefault();

			$(e.currentTarget).hide();

			this.$target
				.closest('.js-enablePushContainer')
				.addClass('notice--accent')
				.removeClass('notice--primary');

			this.$target.find('.js-initialMessage')
				.hide();

			var $dismissMessage = this.$target.find('.js-dismissMessage');

			$dismissMessage.show();
			$dismissMessage.find('.js-dismissTemp').on('click', XF.proxy(this, 'dismissTemp'));
			$dismissMessage.find('.js-dismissPerm').on('click', XF.proxy(this, 'dismissPerm'));
		},

		dismissTemp: function(e)
		{
			e.preventDefault();

			this.hidePushContainer();

			this.setDismissCookie(false);
		},

		dismissPerm: function(e)
		{
			e.preventDefault();

			this.hidePushContainer();

			this.setDismissCookie(true);
		},

		setDismissCookie: function(perm, permLength)
		{
			if (perm) // 10 years should do it
			{
				if (!permLength)
				{
					permLength = (86400 * 1000) * 365 * 10; // ~10 years
				}

				XF.Cookie.set(
					'push_notice_dismiss',
					'1',
					new Date(Date.now() + permLength)
				);
			}
			else
			{
				XF.Cookie.set(
					'push_notice_dismiss',
					'1'
				);
			}
		},

		getDismissCookie: function()
		{
			return XF.Cookie.get('push_notice_dismiss');
		},

		hidePushContainer: function()
		{
			this.$target
				.closest('.js-enablePushContainer')
				.xfFadeUp(XF.config.speed.fast);
		}
	});

	XF.Reaction = XF.Element.newHandler({
		options: {
			delay: 200,
			reactionList: null
		},

		$tooltipHtml: null,
		trigger: null,
		tooltip: null,
		href: null,

		loading: false,

		init: function()
		{
			if (!this.$target.is('a') || !this.$target.attr('href'))
			{
				// no href so can't do anything
				return;
			}

			this.href = this.$target.attr('href');

			// check if we have a tooltip template. if we do not then it
			// likely means that all reactions (except like) are disabled
			// so there's little point in displaying it.
			var $tooltipTemplate = $('#xfReactTooltipTemplate');
			if ($tooltipTemplate.length)
			{
				this.$tooltipHtml = $($.parseHTML($tooltipTemplate.html()));

				this.tooltip = new XF.TooltipElement(XF.proxy(this, 'getContent'), {
					extraClass: 'tooltip--reaction',
					html: true
				});
				this.trigger = new XF.TooltipTrigger(this.$target, this.tooltip, {
					maintain: true,
					delayIn: this.options.delay,
					trigger: 'hover focus touchhold',
					onShow: XF.proxy(this, 'onShow'),
					onHide: XF.proxy(this, 'onHide')
				});
				this.trigger.init();
			}

			this.$target.on('click', XF.proxy(this, 'actionClick'));
		},

		getContent: function()
		{
			var href = this.href;

			href = href.replace(/(\?|&)reaction_id=[^&]*(&|$)/, '$1reaction_id=');

			this.$tooltipHtml.find('.reaction').each(function()
			{
				var $this = $(this),
					reactionId = $this.data('reaction-id');

				$this.attr('href', reactionId ? href + parseInt(reactionId, 10) : false);
			});

			this.$tooltipHtml.find('[data-xf-init~="tooltip"]').attr('data-delay-in', 50).attr('data-delay-out', 50);

			this.$tooltipHtml.on('click', '.reaction', XF.proxy(this, 'actionClick'));

			return this.$tooltipHtml;
		},

		onShow: function()
		{
			var activeTooltip = XF.Reaction.activeTooltip;
			if (activeTooltip && activeTooltip !== this)
			{
				activeTooltip.hide();
			}

			XF.Reaction.activeTooltip = this;
		},

		onHide: function()
		{
			// it's possible for another show event to trigger so don't empty this if it isn't us
			if (XF.Reaction.activeTooltip === this)
			{
				XF.Reaction.activeTooltip = null;
			}

			this.$target.removeData('tooltip:taphold');
		},

		show: function()
		{
			if (this.trigger)
			{
				this.trigger.show();
			}
		},

		hide: function()
		{
			if (this.trigger)
			{
				this.trigger.hide();
			}
		},

		actionClick: function(e)
		{
			e.preventDefault();

			if (this.$target.data('tooltip:taphold') && this.$target.is(e.currentTarget))
			{
				// click originated from taphold event
				this.$target.removeData('tooltip:taphold');
				return;
			}

			if (this.loading)
			{
				return;
			}
			this.loading = true;

			var t = this;

			XF.ajax(
				'post',
				$(e.currentTarget).attr('href'),
				XF.proxy(this, 'actionComplete')
			).always(function()
			{
				setTimeout(function()
				{
					t.loading = false;
				}, 250);
			});
		},

		actionComplete: function(data)
		{
			if (!data.html)
			{
				return;
			}

			var $target = this.$target,
				oldReactionId = $target.data('reaction-id'),
				newReactionId = data.reactionId,
				linkReactionId = data.linkReactionId,
				t = this;

			XF.setupHtmlInsert(data.html, function($html, container, onComplete)
			{
				t.hide();

				var $reaction = $html.find('.js-reaction'),
					$reactionText = $html.find('.js-reactionText'),
					$originalReaction = $target.find('.js-reaction'),
					$originalReactionText = $target.find('.js-reactionText'),
					originalHref = $target.attr('href'), newHref;

				if (linkReactionId)
				{
					newHref = originalHref.replace(/(\?|&)reaction_id=\d+(?=&|$)/, '$1reaction_id=' + linkReactionId);
					$target.attr('href', newHref);
				}

				if (newReactionId)
				{
					$target.addClass('has-reaction');
					$target.removeClass('reaction--imageHidden');
					if (!oldReactionId)
					{
						// always remove reaction--1 (like) as that is the default state
						oldReactionId = 1;
					}
					$target.removeClass('reaction--' + oldReactionId);
					$target.addClass('reaction--' + newReactionId);
					$target.data('reaction-id', newReactionId);
				}
				else
				{
					$target.removeClass('has-reaction');
					$target.addClass('reaction--imageHidden');
					if (oldReactionId)
					{
						$target.removeClass('reaction--' + oldReactionId);
						$target.addClass('reaction--' + $html.data('reaction-id'));
						$target.data('reaction-id', 0);
					}
				}

				$originalReaction.replaceWith($reaction);
				if ($originalReactionText && $reactionText)
				{
					$originalReactionText.replaceWith($reactionText);
				}
			});

			var $reactionList = this.options.reactionList ? XF.findRelativeIf(this.options.reactionList, $target) : $([]);

			if (typeof data.reactionList !== 'undefined' && $reactionList.length)
			{
				if (data.reactionList.content)
				{
					XF.setupHtmlInsert(data.reactionList, function($html, container)
					{
						$reactionList.html($html).addClassTransitioned('is-active');
					});
				}
				else
				{
					$reactionList.removeClassTransitioned('is-active', function()
					{
						$reactionList.empty();
					});
				}
			}
		}
	});
	XF.Reaction.activeTooltip = null;

	XF.BookmarkClick = XF.Event.newHandler({
		eventType: 'click',
		eventNameSpace: 'XFBookmarkClick',

		processing: false,

		href: null,
		tooltip: null,
		trigger: null,
		$tooltipHtml: null,
		clickE: null,

		init: function()
		{
			this.href = this.$target.attr('href');

			this.tooltip = new XF.TooltipElement(XF.proxy(this, 'getTooltipContent'), {
				extraClass: 'tooltip--bookmark',
				html: true,
				loadRequired: true
			});
			this.trigger = new XF.TooltipTrigger(this.$target, this.tooltip, {
				maintain: true,
				trigger: ''
			});
			this.trigger.init();
		},

		click: function(e)
		{
			if (e.button > 0 || e.ctrlKey || e.shiftKey || e.metaKey || e.altKey)
			{
				return;
			}

			e.preventDefault();

			this.clickE = e;

			if (this.$target.hasClass('is-bookmarked'))
			{
				this.trigger.clickShow(e);
			}
			else
			{
				if (this.processing)
				{
					return;
				}
				this.processing = true;

				var self = this;

				XF.ajax('POST', this.href, {tooltip: 1}, XF.proxy(this, 'handleSwitchClick'), {skipDefaultSuccess: true})
					.always(function()
					{
						setTimeout(function()
						{
							self.processing = false;
						}, 250);
					});
			}
		},

		handleSwitchClick: function(data)
		{
			var t = this,
				onReady = function()
				{
					var $target = t.$target;
					XF.handleSwitchResponse($target, data);
					//t.trigger.show();
					t.trigger.clickShow(t.clickE);
				};

			if (data.html)
			{
				XF.setupHtmlInsert(data.html, function($html, data, onComplete)
				{
					if (t.tooltip.requiresLoad())
					{
						t.$tooltipHtml = $html;
						t.tooltip.setLoadRequired(false);
					}
					onReady();

				});
			}
			else
			{
				onReady();
			}
		},

		getTooltipContent: function(onContent)
		{
			if (this.$tooltipHtml && !this.tooltip.requiresLoad())
			{
				this.initializeTooltip(this.$tooltipHtml);

				return this.$tooltipHtml;
			}

			var t = this,
				options = {
					skipDefault: true,
					skipError: true,
					global: false
				};

			if (this.trigger.wasClickTriggered())
			{
				options.global = true;
			}

			XF.ajax(
				'get', this.href, { tooltip: 1 },
				function(data) { t.tooltipLoaded(data, onContent); },
				options
			);
		},

		tooltipLoaded: function(data, onContent)
		{
			var t = this;
			XF.setupHtmlInsert(data.html, function($html, container, onComplete)
			{
				t.initializeTooltip($html);
				onContent($html);
			});
		},

		initializeTooltip: function($html)
		{
			var $form = $html.find('form');
			$form.on('ajax-submit:response', XF.proxy(this, 'handleOverlaySubmit'));
		},

		handleOverlaySubmit: function(e, data)
		{
			if (data.status == 'ok')
			{
				e.preventDefault();

				if (this.trigger)
				{
					this.trigger.hide();
				}

				XF.handleSwitchResponse(this.$target, data);

				if (data.switchKey == 'bookmarkremoved')
				{
					var $form = e.currentTarget;
					$form.reset();
				}
			}
		}
	});

	XF.BookmarkLabelFilter = XF.Element.newHandler({
		options: {
			target: null,
			showAllLinkTarget: null
		},

		loading: false,
		$filterTarget: null,
		$showAllLinkTarget: null,

		init: function()
		{
			this.$filterTarget = XF.findRelativeIf(this.options.target, this.$target);
			if (!this.$filterTarget.length)
			{
				console.error('No filter target found.');
				return;
			}

			if (this.options.showAllLinkTarget)
			{
				this.$showAllLinkTarget = XF.findRelativeIf(this.options.showAllLinkTarget, this.$target);
			}

			var t = this;

			this.$target.on('select2:select', XF.proxy(this, 'loadResults'));
			this.$target.on('select2:unselect', function(e)
			{
				t.loadResults();
			});
		},

		loadResults: function()
		{
			if (this.loading)
			{
				return;
			}

			this.loading = true;

			var label = this.$target.find('.js-labelFilter').val();

			var t = this;
			XF.ajax('get', XF.canonicalizeUrl('index.php?account/bookmarks-popup'), { label: label }, function(data)
			{
				if (data.html)
				{
					if (t.$showAllLinkTarget && data.showAllUrl)
					{
						t.$showAllLinkTarget.attr('href', data.showAllUrl);
					}

					XF.setupHtmlInsert(data.html, function($html, container)
					{
						t.$target.find('.js-tokenSelect').select2('close');
						t.$filterTarget.empty();
						t.$filterTarget.append($html);
					});
				}
			}).always(function()
			{
				t.loading = false;
			});
		}
	});

	// ################################## CONTENT VOTE HANDLER ###########################################

	XF.ContentVote = XF.Element.newHandler({
		options: {
			contentId: null
		},

		processing: false,

		init: function()
		{
			this.$target.on('click', '[data-vote]', XF.proxy(this, 'voteClick'));
		},

		voteClick: function(e)
		{
			e.preventDefault();

			var $link = $(e.currentTarget);

			if ($link.hasClass('is-disabled'))
			{
				return;
			}

			if (this.processing)
			{
				return;
			}

			this.processing = true;

			var href = $link.attr('href'),
				t = this;

			XF.ajax(
				'POST',
				href,
				{},
				XF.proxy(this, 'handleAjax'),
				{skipDefaultSuccess: false}
			).always(function()
				{
					setTimeout(function()
					{
						t.processing = false;
					}, 250);
				}
			);
		},

		handleAjax: function(data)
		{
			this.updateData(data);

			if (this.options.contentId)
			{
				var $sharedVotes = $('.js-contentVote[data-content-id="' + this.options.contentId + '"]'),
					t = this,
					$target = this.$target;
				$sharedVotes.each(function()
				{
					if ($target[0] === this)
					{
						// don't need to do anything on itself
						return;
					}

					var $this = $(this);
					if ($this.is('[data-xf-init~="content-vote"]'))
					{
						XF.Element.getHandler($this, 'content-vote').updateData(data);
					}
					else
					{
						// this is a content vote display, but not interactive
						t.updateDisplay($this, data);
					}
				})
			}
		},

		updateData: function(data)
		{
			this.updateDisplay(this.$target, data);
		},

		updateDisplay: function($target, data)
		{
			var $voteCount = $target.find('.js-voteCount'),
				$currentVote = $target.find('.is-voted');

			$currentVote.removeClass('is-voted');

			if (data.vote)
			{
				$target.find('[data-vote="' + data.vote + '"]').addClass('is-voted');
				$target.addClass('is-voted');
			}
			else
			{
				$target.removeClass('is-voted');
			}

			$voteCount.fadeOut('fast', function()
			{
				$voteCount.attr('data-score', data.voteScore).text(data.voteScoreShort);
				if (data.voteScore > 0)
				{
					$voteCount.removeClass('is-negative').addClass('is-positive');
				}
				else if (data.voteScore < 0)
				{
					$voteCount.removeClass('is-positive').addClass('is-negative');
				}
				else
				{
					$voteCount.removeClass('is-positive').removeClass('is-negative');
				}
				$voteCount.fadeIn('fast');
			});
		}
	});

	XF.InstallPrompt = XF.Element.newHandler({
		options: {
			button: '| .js-installPromptButton',
			installTemplateIOS: '| .js-installTemplateIOS'
		},

		$button: null,
		$installTemplate: null,
		bipEvent: null,
		isIOS: false,

		init: function()
		{
			this.$button = XF.findRelativeIf(this.options.button, this.$target);
			if (!this.$button || !this.$button.length)
			{
				console.error('No install button found for %o', this.$target[0]);
				return;
			}

			var $window = $(window);
			$window.on('beforeinstallprompt', XF.proxy(this, 'beforeInstallPrompt'));
			$window.on('appinstalled', XF.proxy(this, 'appInstalled'));

			if (XF.isIOS() && !XF.Feature.has('displaymodestandalone'))
			{
				this.initIOS();
			}

			this.$button.on('click', XF.proxy(this, 'buttonClick'));
		},

		initIOS: function()
		{
			this.isIOS = true;
			this.$target.show();
		},

		beforeInstallPrompt: function(e)
		{
			e.preventDefault();
			this.bipEvent = e.originalEvent;
			this.$target.show();
		},

		appInstalled: function(e)
		{
			this.$target.hide();
		},

		buttonClick: function()
		{
			if (this.isIOS)
			{
				const $installTemplate = XF.findRelativeIf(this.options.installTemplateIOS, this.$target);
				if (!$installTemplate || !$installTemplate.length)
				{
					return;
				}

				const $content = $($installTemplate[0].content.cloneNode(true));
				XF.overlayMessage(null, $content);

				return;
			}

			if (!this.bipEvent)
			{
				console.error('No beforeinstallprompt event was captured');
				return;
			}

			this.bipEvent.prompt();
		}
	});

	XF.Event.register('click', 'attribution', 'XF.AttributionClick');
	XF.Event.register('click', 'like', 'XF.LikeClick');
	XF.Event.register('click', 'preview-click', 'XF.PreviewClick');
	XF.Event.register('click', 'scroll-to', 'XF.ScrollToClick');
	XF.Event.register('click', 'switch', 'XF.SwitchClick');
	XF.Event.register('click', 'switch-overlay', 'XF.SwitchOverlayClick');

	XF.Element.register('alerts-list', 'XF.AlertsList');
	XF.Element.register('draft', 'XF.Draft');
	XF.Element.register('draft-trigger', 'XF.DraftTrigger');
	XF.Element.register('focus-trigger', 'XF.FocusTrigger');
	XF.Element.register('poll-block', 'XF.PollBlock');
	XF.Element.register('preview', 'XF.Preview');
	XF.Element.register('share-buttons', 'XF.ShareButtons');
	XF.Element.register('share-input', 'XF.ShareInput');
	XF.Element.register('web-share', 'XF.WebShare');
	XF.Element.register('copy-to-clipboard', 'XF.CopyToClipboard');
	XF.Element.register('push-toggle', 'XF.PushToggle');
	XF.Element.register('push-cta', 'XF.PushCta');
	XF.Element.register('reaction', 'XF.Reaction');
	XF.Element.register('bookmark-click', 'XF.BookmarkClick');
	XF.Element.register('bookmark-label-filter', 'XF.BookmarkLabelFilter');
	XF.Element.register('content-vote', 'XF.ContentVote');
	XF.Element.register('install-prompt', 'XF.InstallPrompt');
}
(jQuery, window, document);