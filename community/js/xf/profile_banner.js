!function($, window, document, _undefined)
{
	"use strict";

	// ################################## PROFILE BANNER UPLOAD HANDLER ###########################################

	XF.BannerUpload = XF.Element.newHandler({

		options: {},

		init: function()
		{
			var $form = this.$target,
				$file = $form.find('.js-uploadBanner'),
				$banner = $form.find('.js-banner'),
				$container = $banner.closest('.profileBannerContainer'),
				$deleteButton = $form.find('.js-deleteBanner');

			if ($container.hasClass('profileBannerContainer--withBanner'))
			{
				$deleteButton.show();
			}
			else
			{
				$deleteButton.hide();
			}

			$file.on('change', XF.proxy(this, 'changeFile'));
			$form.on('ajax-submit:response', XF.proxy(this, 'ajaxResponse'));
		},

		changeFile: function(e)
		{
			if ($(e.target).val() != '')
			{
				this.$target.submit();
			}
		},

		ajaxResponse: function(e, data)
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

			var $form = this.$target,
				$delete = $form.find('.js-deleteBanner'),
				$file = $form.find('.js-uploadBanner'),
				$banner = $form.find('.js-banner'),
				$container = $banner.closest('.profileBannerContainer'),
				banners = data.banners,
				position = data.position,
				bannerCount = Object.keys(banners).length,
				classPrefix = 'memberProfileBanner-u' + data.userId + '-';

			$file.val('');

			$('.memberProfileBanner').each(function()
			{
				var $thisBanner = $(this),
					$thisParent = $thisBanner.parent(),
					hideEmpty = $thisBanner.data('hide-empty'),
					toggleClass = $thisBanner.data('toggle-class'),
					newBanner;

				if ($thisBanner.is('[class*="' + classPrefix + '"]'))
				{
					if ($thisBanner.hasClass(classPrefix + 'm'))
					{
						newBanner = banners['m'];
					}
					else if ($thisBanner.hasClass(classPrefix + 'l'))
					{
						newBanner = banners['l'];
					}
					else if ($thisBanner.hasClass(classPrefix + 'o'))
					{
						newBanner = banners['o'];
					}
				}

				$thisBanner.css({
					'background-image': newBanner ? 'url(' + newBanner + ')' : 'none',
					'background-position-y': position !== null ? position + '%' : null
				});

				if (hideEmpty)
				{
					if (!newBanner)
					{
						$thisBanner.addClass('memberProfileBanner--empty');
					}
					else
					{
						$thisBanner.removeClass('memberProfileBanner--empty');
					}
				}

				$thisBanner.trigger('profile-banner:refresh');

				if (toggleClass)
				{
					if (!newBanner)
					{
						$thisParent.removeClass(toggleClass);
					}
					else
					{
						$thisParent.addClass(toggleClass);
					}
				}
			});

			if (!bannerCount)
			{
				$delete.hide();
				$container.removeClass('profileBannerContainer--withBanner');
			}
			else
			{
				$delete.show();
				$container.addClass('profileBannerContainer--withBanner');
			}
		}
	});

	// ################################## BANNER POSITIONER HANDLER ###########################################

	XF.BannerPositioner = XF.Element.newHandler({

		options: {},

		$banner: null,
		$value: null,
		y: 0,

		ns: 'bannerPositioner',
		dragging: false,
		scaleFactor: 1,

		init: function()
		{
			var $banner = this.$target;

			this.$banner = $banner;
			$banner.css({
				'touch-action': 'none',
				'cursor': 'move'
			});

			this.$value = $banner.find('.js-bannerPosY');

			this.initDragging();

			var t = this;

			$banner.on('profile-banner:refresh', function()
			{
				var yPos = $banner.css('background-position-y');
				if (yPos)
				{
					t.$value.val(parseFloat(yPos));
				}

				t.stopDragging();
				$banner.off('.' + t.ns);
				t.initDragging();
			});
		},

		initDragging: function()
		{
			var ns = this.ns,
				$banner = this.$banner,
				imageUrl = $banner.css('background-image'),
				image = new Image(),
				t = this;

			imageUrl = imageUrl.replace(/^url\(["']?(.*?)["']?\)$/i, '$1');
			if (!imageUrl)
			{
				return;
			}

			image.onload = function()
			{
				var setup = function()
				{
					// scaling makes pixel-based pointer movements map to percentage shifts
					var displayScale = image.width ? $banner.width() / image.width : 1;
					t.scaleFactor = 1 / (image.height * displayScale / 100);

					$banner.on('mousedown.' + ns + ' touchstart.' + ns, XF.proxy(t, 'dragStart'));
				};

				if ($banner.width() > 0)
				{
					setup();
				}
				else
				{
					// it's possible for this to be triggered when the banner container has been hidden,
					// so only allow this to be triggered again once we know the banner is visible
					$banner.one('mouseover.' + ns + ' touchstart.' + ns, setup);
				}
			};
			image.src = XF.canonicalizeUrl(imageUrl);
		},

		dragStart: function(e)
		{
			e.preventDefault();

			var oe = e.originalEvent,
				ns = this.ns;

			if (oe.touches)
			{
				this.y = oe.touches[0].clientY;
			}
			else
			{
				this.y = oe.clientY;

				if (oe.button > 0)
				{
					// probably a right click or similar
					return;
				}
			}

			this.dragging = true;

			$(window)
				.on('mousemove.' + ns + ' touchmove.' + ns, XF.proxy(this, 'dragMove'))
				.on('mouseup.' + ns + ' touchend.' + ns, XF.proxy(this, 'dragEnd'));
		},

		dragMove: function(e)
		{
			if (this.dragging)
			{
				e.preventDefault();

				var oe = e.originalEvent,
					existingPos = parseFloat(this.$banner.css('background-position-y')),
					newY, newPos;

				if (oe.touches)
				{
					newY = oe.touches[0].clientY;
				}
				else
				{
					newY = oe.clientY;
				}

				newPos = existingPos + (this.y - newY) * this.scaleFactor;
				newPos = Math.min(Math.max(0, newPos), 100);

				this.$banner.css('background-position-y', newPos + '%');
				this.$value.val(newPos);
				this.y = newY;
			}
		},

		dragEnd: function(e)
		{
			this.stopDragging();
		},

		stopDragging: function()
		{
			if (this.dragging)
			{
				$(window).off('.' + this.ns);

				this.y = 0;
				this.dragging = false;
			}
		}
	});

	XF.Element.register('banner-upload', 'XF.BannerUpload');
	XF.Element.register('banner-positioner', 'XF.BannerPositioner');
}
(jQuery, window, document);