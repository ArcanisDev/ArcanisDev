!function($, window, document, _undefined)
{
	"use strict";

	XF.ThreadEditForm = XF.Element.newHandler({
		options: {
			itemSelector: null
		},

		$item: null,
		$inlineEdit: null,

		init: function()
		{
			this.$item = $(this.options.itemSelector);
			if (!this.$item.length)
			{
				return;
			}

			this.$target.on('ajax-submit:before', XF.proxy(this, 'beforeSubmit'));
			this.$target.on('ajax-submit:response', XF.proxy(this, 'afterSubmit'));
                                              
            this.$inlineEdit = $('<input type="hidden" name="_xfInlineEdit" value="1" />');
		},

		beforeSubmit: function()
		{
			this.$target.append(this.$inlineEdit);
		},

		afterSubmit: function(e, data)
		{
			if (data.errors || data.exception)
			{
				return;
			}

			e.preventDefault();

			if (data.message)
			{
				XF.flashMessage(data.message, 3000);
			}

			var self = this;
			XF.setupHtmlInsert(data.html, function($html, container, onComplete)
			{
				self.$item.replaceWith($html);
				onComplete();
			});

			XF.hideParentOverlay(this.$target);
		}
	});

	// ################################## QUICK THREAD HANDLER ###########################################

	XF.QuickThread = XF.Element.newHandler(
	{
		options: {
			focusActivate: ".js-titleInput",
			focusActivateTarget: ".js-quickThreadFields",
			focusActivateHref: null,
			insertTarget: ".js-threadList",
			replaceTarget: ".js-emptyThreadList"
		},

		xfInserter: null,
		activated: false,
		loading: false,

		init: function()
		{
			var self = this;

			var $focusActivate = $(this.options.focusActivate);
			if ($focusActivate.length)
			{
				this.xfInserter = new XF.Inserter($focusActivate, {
					href: this.options.focusActivateHref,
					replace: this.options.focusActivateTarget,
					afterLoad: function()
					{
						setTimeout(function()
						{
							self.activated = true;
							self.$target.trigger('draft:sync');
						}, 500);
					}
				});

				$focusActivate.on('focus', XF.proxy(function(e)
				{
					if ($(this.options.replace).is(':empty'))
					{
						var extraData = {},
							$prefixSelect = self.$target.find('.js-prefixSelect');

						if ($prefixSelect.length)
						{
							extraData.prefix_id = $prefixSelect.val();
						}

						this.onEvent(e, extraData);
					}
				}, this.xfInserter));
			}

			this.$target.on('ajax-submit:response', XF.proxy(this, 'afterSubmit'))
				.on('reset', XF.proxy(this, 'reset'));

			this.$target.on('draft:beforesave', function(e)
			{
				if (!self.activated)
				{
					e.preventDefault();
				}
			});
		},

		afterSubmit: function(e, data)
		{
			if (this.loading)
			{
				return;
			}

			this.loading = true;

			if (data.errors || data.exception)
			{
				this.loading = false;
				return;
			}

			e.preventDefault();

			if (data.redirect)
			{
				XF.redirect(data.redirect);
			}

			var self = this;
			XF.setupHtmlInsert(data.html, function($html)
			{
				XF.hideTooltips();
				$html.hide();
				$(self.options.insertTarget)[self.options.direction == 'asc' ? 'append' : 'prepend']($html);
				$(self.options.replaceTarget)['replaceWith']($html);
				self.reset(null, function()
				{
					$html.xfFadeDown();

					var scrollTo = self.$target.closest('.block-container').offset().top - 60;
					XF.smoothScroll(scrollTo, false, null, true);

					self.loading = false;
				});
			});
		},

		reset: function(e, onComplete)
		{
			var $fat = $(this.options.focusActivateTarget),
				self = this;

			XF.hideTooltips();

			$fat.xfFadeUp(null, XF.proxy(function()
			{
				self.activated = false;

				$fat.empty();

				if (!e || e.type != 'reset')
				{
					this.$target.get(0).reset();
				}

				if (typeof onComplete == 'function')
				{
					onComplete();
				}
			}, this));
		}
	});

	XF.Element.register('thread-edit-form', 'XF.ThreadEditForm');
	XF.Element.register('quick-thread', 'XF.QuickThread');
}
(jQuery, window, document);