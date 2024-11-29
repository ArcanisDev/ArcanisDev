!function($, window, document, _undefined)
{
	"use strict";

	XF.Rating = XF.Element.newHandler({
		options: {
			theme: 'fontawesome-stars',
			initialRating: null,
			ratingHref: null,
			readonly: false,
			deselectable: false,
			showSelected: true
		},

		ratingOverlay: null,

		$widget: null,
		$ratings: null,

		init: function()
		{
			var $target = this.$target,
				options = this.options,
				initialRating = options.initialRating,
				showSelected = options.showSelected,
				readonly = options.readonly;

			$target.barrating({
				theme: options.theme,
				initialRating: initialRating,
				readonly: readonly ? true : false,
				deselectable: options.deselectable ? true : false,
				showSelectedRating: showSelected ? true : false,
				onSelect: XF.proxy(this, 'ratingSelected')
			});

			var $widget = $target.next('.br-widget'),
				$ratings = $widget.find('[data-rating-text]');

			this.$widget = $widget;
			this.$ratings = $ratings;

			if (initialRating)
			{
				$target.val(initialRating);
			}

			if (showSelected)
			{
				$widget.addClass('br-widget--withSelected');
			}

			if (!readonly)
			{
				var selectId = $target.attr('id'),
					labelledBy = null
				if (selectId)
				{
					var $label = $('label[for="' + selectId + '"]');
					if ($label.length)
					{
						labelledBy = $label.xfUniqueId();
					}
				}

				$widget.attr({
					role: 'radiogroup',
					'aria-labelledby': labelledBy
				});

				$ratings.each(function()
				{
					var $this = $(this),
						checked = initialRating && $this.attr('data-rating-value') == initialRating;

					$this.attr({
						role: 'radio',
						'aria-checked': checked ? 'true' : 'false',
						'aria-label': $this.attr('data-rating-text'),
						tabindex: checked ? 0 : -1
					});
				});

				if (!initialRating)
				{
					$ratings.first().attr('tabindex', 0);
				}

				var t = this;

				$ratings.on('keydown', function(e)
				{
					var handled = false;

					switch (e.keyCode)
					{
						case 37: // left
						case 38: // up
							handled = true;
							t.keySelectPrevious();
							break;

						case 39: // right
						case 40: // down
							handled = true;
							t.keySelectNext();
							break
					}

					if (handled)
					{
						e.preventDefault();
						e.stopPropagation();
					}
				});
			}
		},

		keySelect: function(refMethod)
		{
			var $target = this.$target,
				val = $target.val(),
				$ref = $target.find('option[value="' + val + '"]');

			var $new = $ref[refMethod]();
			if (!$new)
			{
				return;
			}

			var newVal = $new.val();

			$target.barrating('set', newVal);
			this.$ratings.filter('[data-rating-value="' + newVal + '"]').focus();
		},

		keySelectPrevious: function()
		{
			this.keySelect('prev');
		},

		keySelectNext: function()
		{
			this.keySelect('next');
		},

		ratingSelected: function(value, text, event)
		{
			if (this.options.readonly)
			{
				return;
			}

			this.$ratings.attr({
				'aria-checked': 'false',
				tabindex: -1
			});

			if (value)
			{
				this.$ratings.filter('[data-rating-value="' + value + '"]').attr({
					'aria-checked': 'true',
					tabindex: 0
				});
			}
			else
			{
				this.$ratings.first().attr('tabindex', 0);
			}

			if (!this.options.ratingHref)
			{
				return;
			}

			if (this.ratingOverlay)
			{
				this.ratingOverlay.destroy();
			}

			this.$target.barrating('clear');

			XF.ajax('get', this.options.ratingHref, {
				rating: value
			}, XF.proxy(this, 'loadOverlay'));
		},

		loadOverlay: function(data)
		{
			if (data.html)
			{
				var self = this;
				XF.setupHtmlInsert(data.html, function ($html, container)
				{
					var $overlay = XF.getOverlayHtml({
						html: $html,
						title: container.h1 || container.title
					});
					self.ratingOverlay = XF.showOverlay($overlay);
				});
			}
		}
	});

	XF.Element.register('rating', 'XF.Rating');
}
(jQuery, window, document);