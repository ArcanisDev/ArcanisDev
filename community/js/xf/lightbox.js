!function($, window, document, _undefined)
{
	"use strict";

	XF.Lightbox = XF.Element.newHandler({
		options: {
			lbInfobar: 1,
			lbSlideShow: 1,
			lbThumbsAuto: 1,
			lbUniversal: 0,
			lbTrigger: '.js-lbImage',
			lbContainer: '.js-lbContainer',
			lbHistory: 0,
			lbPrev: null,
			lbNext: null,
		},

		$sidebar: null,

		initialUrl: null,
		prevUrl: null,
		nextUrl: null,

		thumbsInitialized: false,

		lastIndex: null,

		isJumping: false,

		pushStateCount: 0,

		init: function()
		{
			this.initContainers();

			$(document).on('xf:reinit', XF.proxy(this, 'checkReInit'));

			$(document).on('click', 'a.js-lightboxCloser', function(e)
			{
				var $closer = $(e.target),
					$toolbar = XF.findRelativeIf('< .fancybox-inner | .fancybox-toolbar', $closer);

				$toolbar.find('[data-fancybox-close]').click();
			});
		},

		getInstance: function()
		{
			return $.fancybox.getInstance();
		},

		handlePopstate: function(state)
		{
			if (!this.options.lbHistory)
			{
				return;
			}

			var instance = this.getInstance();
			this.pushStateCount--;

			if (state && typeof state === 'object' && state.hasOwnProperty('slide_src'))
			{
				this.isJumping = true;

				if (instance)
				{
					var index = instance.findIndexFromSrc(state.slide_src);
					if (index !== null)
					{
						instance.jumpTo(index);
					}
				}
			}
			else if (instance)
			{
				this.pushStateCount = 0; // make sure we prevent any navigation
				instance.close();
			}
		},

		initContainers: function()
		{
			var $containers = this.options.lbUniversal ? this.$target : this.$target.find(this.options.lbContainer);
			var self = this;

			$containers.each(function()
			{
				self._initContainer($(this));
			});
		},

		_initContainer: function($container)
		{
			if ($container.data('lbInitialized'))
			{
				return;
			}

			$container.data('lbInitialized', true);

			var t = this;

			$container.find(this.options.lbTrigger).on('click.xflbtrigger mousedown.xflbtrigger', function(e)
			{
				var $target = $(e.target).parent(), open;

				if (e.type === 'mousedown')
				{
					open = e.which === 2;
				}
				else
				{
					open = (e.ctrlKey || e.altKey || e.metaKey || e.shiftKey);
				}

				if (open && t.isSingleImage($target))
				{
					// stop the LB from triggering
					e.stopImmediatePropagation();

					window.open($target.data('src'), '_blank');
				}

				return true;
			});

			$container.find(t.options.lbTrigger).each(function()
			{
				var $target = $(this);
				$target.on('lightbox:image-checked', XF.proxy(t, 'imageChecked'));
				t.checkImageSizes($target, $container);
			});

			var config = $.extend(this.getConfig($container), {
				selector: this.options.lbTrigger + '[data-fancybox="' + this.getContainerId($container) + '"]'
			});

			$container.fancybox(config);

			$container.on('lightbox:init', XF.proxy(this, 'onInit'));
			$container.on('lightbox:activate', XF.proxy(this, 'onActivate'));
			$container.on('lightbox:after-load', XF.proxy(this, 'afterLoad'));
			$container.on('lightbox:before-show', XF.proxy(this, 'beforeShow'));
			$container.on('lightbox:after-show', XF.proxy(this, 'afterShow'));
			$container.on('lightbox:before-close', XF.proxy(this, 'beforeClose'));
			$container.on('lightbox:after-close', XF.proxy(this, 'afterClose'));
		},

		checkReInit: function(e, el)
		{
			if (el == document)
			{
				return;
			}

			if (!this.$target.find(el).length)
			{
				return;
			}

			var $el = $(el),
				lbTrigger = this.options.lbTrigger,
				lbContainer = this.options.lbContainer;

			if (this.options.lbUniversal)
			{
				if ($el.is(lbTrigger) || $el.find(lbTrigger).length)
				{
					// reinit the one container we have
					this._reInitContainer(this.$target);
				}
			}
			else if ($el.is(lbContainer) || $el.find(lbContainer).length)
			{
				// new container, reinit all to pick this one up
				this.initContainers();
			}
			else if ($el.closest(lbContainer).length && ($el.is(lbTrigger) || $el.find(lbTrigger).length))
			{
				// should be an existing container but a new image
				this._reInitContainer($el.closest(lbContainer));
			}
		},

		_reInitContainer: function($container)
		{
			if (!$container.data('lbInitialized'))
			{
				return;
			}

			var instance = this.getInstance();
			if (instance)
			{
				instance.close();
			}

			$container.removeData('lbInitialized');

			$container.off('onThumbsShow.fb');
			$container.off('onThumbsHide.fb');
			this.thumbsInitialized = false;

			$container.off('lightbox:init');
			$container.off('lightbox:activate');
			$container.off('lightbox:before-show');
			$container.off('lightbox:after-show');
			$container.off('lightbox:before-close');
			$container.off('lightbox:after-close');

			this._initContainer($container);
		},

		initSidebar: function(loading)
		{
			var instance = this.getInstance();
			if (!instance)
			{
				return;
			}

			var $fbContainer = instance.$refs.container, $sidebar;

			if (this.$sidebar)
			{
				if (loading)
				{
					this.$sidebar.addClass('is-loading');
				}
			}
			else
			{
				$sidebar = $('<div />')
					.html('<div class="fancybox-sidebar-content"></div><div class="fancybox-sidebar-loader"><i class="fa--xf fa' + XF.config.fontAwesomeWeight + ' fa-spinner-third fa-4x"></i></div>')
					.addClass('fancybox-sidebar')
					.addClass(loading ? 'is-loading' : '');

				this.$sidebar = $sidebar;

				this.$sidebar.appendTo($fbContainer);

				var $toggle = $fbContainer.find('.fancybox-button[data-fancybox-sidebartoggle]');
				$toggle.off('click.lbSidebar').on('click.lbSidebar', XF.proxy(this, 'toggleSidebar'));

				$(window).on('resize.lbSidebar', XF.proxy(this, 'sidebarCheckSize'));
			}

			$fbContainer.addClass('fancybox-has-sidebar');

			if (this.isSidebarEnabled())
			{
				this.$sidebar.addClass('is-active');
				$fbContainer.addClass('fancybox-show-sidebar');
			}

			this.sidebarCheckSize();
		},

		isSidebarEnabled: function()
		{
			return (
				!XF.LocalStorage.get('lbSidebarDisabled')
				&& XF.Breakpoint.isAtOrWiderThan('full')
			);
		},

		setIsSidebarEnabled: function(enabled)
		{
			if (enabled)
			{
				XF.LocalStorage.remove('lbSidebarDisabled');
			}
			else
			{
				XF.LocalStorage.set('lbSidebarDisabled', '1', true);
			}
		},

		toggleSidebar: function()
		{
			var wasActive = this.$sidebar.hasClass('is-active');
			if (wasActive)
			{
				this.closeSidebar(false);
			}
			else
			{
				this.openSidebar(false);
			}
		},

		openSidebar: function(bypassStorage)
		{
			var instance = this.getInstance(),
				$fbContainer = instance.$refs.container;

			this.$sidebar.addClass('is-active');
			$fbContainer.addClass('fancybox-show-sidebar');

			if (!bypassStorage)
			{
				this.setIsSidebarEnabled(true);
			}

			instance.update();
		},

		closeSidebar: function(bypassStorage)
		{
			if (!this.$sidebar)
			{
				return;
			}

			var instance = this.getInstance(),
				$fbContainer = instance.$refs.container;

			this.$sidebar.removeClass('is-active');
			$fbContainer.removeClass('fancybox-show-sidebar');

			if (!bypassStorage)
			{
				this.setIsSidebarEnabled(false);
			}

			instance.update();
		},

		sidebarCheckSize: function()
		{
			var instance = this.getInstance(),
				$fbContainer = instance.$refs.container;

			if (XF.Breakpoint.isAtOrNarrowerThan('medium'))
			{
				$fbContainer.removeClass('fancybox-has-sidebar');
				this.closeSidebar(true);
			}
			else
			{
				$fbContainer.addClass('fancybox-has-sidebar');
			}
		},

		initThumbs: function()
		{
			var instance = this.getInstance(), t = this, scrollbarHeight;
			if (!instance)
			{
				return;
			}

			if (!this.thumbsInitialized)
			{
				if (this.options.lbThumbsAuto)
				{
					scrollbarHeight = this.measureThumbsScrollbar();
					this.setThumbsScrollbarOffset(scrollbarHeight);
				}

				instance.$refs.container.off('onThumbsShow.fb').on('onThumbsShow.fb', function()
				{
					scrollbarHeight = t.measureThumbsScrollbar();
					t.setThumbsScrollbarOffset(scrollbarHeight);
				});
				instance.$refs.container.off('onThumbsHide.fb').on('onThumbsHide.fb', function()
				{
					t.setThumbsScrollbarOffset(0);
				});

				this.thumbsInitialized = true;
			}
		},

		measureThumbsScrollbar: function()
		{
			var instance = this.getInstance();
			if (!instance || !instance.Thumbs || !instance.Thumbs.isActive)
			{
				return 0;
			}

			return XF.measureScrollBar(instance.Thumbs.$grid, 'height');
		},

		setThumbsScrollbarOffset: function(height)
		{
			var instance = this.getInstance();
			if (!instance || !instance.Thumbs || !instance.Thumbs.isActive)
			{
				return;
			}

			instance.$refs.caption.css('padding-bottom', height + 'px');
		},

		updateLastIndex: function()
		{
			var instance = this.getInstance(), slides;
			if (!instance)
			{
				return;
			}

			slides = Object.keys(instance.group);
			this.lastIndex = parseInt(slides[slides.length - 1]);
		},

		onInit: function(e, $container, instance)
		{
			this.updateLastIndex();

			this.prevUrl = this.options.lbPrev;
			this.nextUrl = this.options.lbNext;

			this.thumbsInitialized = false;
		},

		onActivate: function()
		{
			XF.Modal.open();
			XF.Lightbox.activeLb = this;
		},

		afterLoad: function(e, $container, instance, slide)
		{
			if (slide.type === 'ajax')
			{
				var $content = slide.$content,
					$embedContent = $content.find('.js-embedContent'),
					state = {};

				if ($embedContent.length)
				{
					state[$embedContent.data('media-site-id')] = true;
					XF.applyJsState(XF.config.jsState, state);

					slide.$slide
						.removeClass('fancybox-slide--video')
						.addClass('fancybox-slide--embed');
				}

				XF.activate($content);
			}
		},

		beforeShow: function(e, $container, instance, slide)
		{
			XF.hideOverlays();
			XF.hideTooltips();

			var $trigger = slide.opts.$orig;
			if ($trigger)
			{
				var $fbContainer = instance.$refs.container;

				if ($trigger.data('lb-sidebar') || $trigger.data('lb-sidebar-href'))
				{
					this.initSidebar(true);
				}
				else
				{
					$fbContainer.removeClass('fancybox-has-sidebar');
					this.closeSidebar(true);
				}

				if ($trigger.data('lb-type-override'))
				{
					slide.contentType = $trigger.data('lb-type-override');
				}
			}

			this.initThumbs();
		},

		afterShow: function(e, $container, instance, slide)
		{
			var $trigger = slide.opts.$orig,
				$fbContainer = instance.$refs.container,
				t = this,
				srcHref,
				sidebarHref;

			if ($trigger)
			{
				srcHref = $trigger.attr('href') || slide.src;
			}
			else
			{
				srcHref = slide.src;
			}

			var $toolbar = instance.$refs.toolbar;
			$toolbar.find('[data-fancybox-nw]')
				.attr('href', srcHref)
				.attr('target', '_blank');

			if (this.options.lbHistory && !this.isJumping)
			{
				XF.History.push({ slide_src: slide.src }, null, srcHref);

				this.pushStateCount++;
			}

			this.isJumping = false;

			if (
				($trigger.data('lb-sidebar') || $trigger.data('lb-sidebar-href'))
				&& $fbContainer.hasClass('fancybox-has-sidebar')
			)
			{
				if ($trigger)
				{
					sidebarHref = $trigger.data('lb-sidebar-href') || srcHref
				}
				else
				{
					sidebarHref = srcHref
				}

				XF.ajax(
					'get', sidebarHref, { lightbox: true },
					function(data) { t.sidebarLoaded(data); },
					{
						skipDefault: true,
						skipError: true,
						global: false
					}
				);
			}

			if (slide.index === this.lastIndex && this.nextUrl)
			{
				XF.ajax(
					'get', this.nextUrl, { lightbox: true },
					function(data) { t.nextLoaded(data); },
					{
						skipDefault: true,
						skipError: true,
						global: false
					}
				);
			}
			else if (slide.index === 0 && this.prevUrl)
			{
				XF.ajax(
					'get', this.prevUrl, { lightbox: true },
					function(data) { t.prevLoaded(data); },
					{
						skipDefault: true,
						skipError: true,
						global: false
					}
				);
			}
		},

		sidebarLoaded: function(data)
		{
			if (!data.html || !this.$sidebar)
			{
				return;
			}

			var t = this;

			XF.setupHtmlInsert(data.html, function($html, container, onComplete)
			{
				if (t.$sidebar)
				{
					t.$sidebar.find('.fancybox-sidebar-content').html($html);
					t.$sidebar.removeClass('is-loading');
				}
			});
		},

		prevLoaded: function(data)
		{
			if (!data.html)
			{
				this.prevUrl = null; //likely no more items to show
				return;
			}

			var t = this,
				instance = this.getInstance();

			if (!instance)
			{
				return;
			}

			XF.setupHtmlInsert(data.html, function($html, container, onComplete)
			{
				var $container = $html.find(t.options.lbContainer);

				$container.find(t.options.lbTrigger).reverse().each(function()
				{
					var $trigger = $(this);
					t.updateCaption($trigger);
					instance.prependContent($trigger);
					instance.reindexSlides();

					var currIndex = instance.currIndex,
						prevIndex = instance.prevIndex;

					currIndex++;
					prevIndex++;

					instance.currIndex = currIndex;
					instance.currPos = currIndex;
					instance.current.index = currIndex;
					instance.current.pos = currIndex;

					instance.prevIndex = prevIndex;
					instance.prevPos = prevIndex;
				});

				instance.update();
				instance.Thumbs.update();
				t.updateLastIndex();

				t.prevUrl = $container.data('lb-prev');

				onComplete(true);
			});
		},

		nextLoaded: function(data)
		{
			if (!data.html)
			{
				this.nextUrl = null; //likely no more items to show
				return;
			}

			var t = this,
				instance = this.getInstance();

			if (!instance)
			{
				return;
			}

			XF.setupHtmlInsert(data.html, function($html, container, onComplete)
			{
				var $container = $html.find(t.options.lbContainer);

				$container.find(t.options.lbTrigger).each(function()
				{
					var $trigger = $(this);
					t.updateCaption($trigger);
					instance.addContent($trigger);
				});

				t.updateLastIndex();

				t.nextUrl = $container.data('lb-next');

				onComplete(true);
			});
		},

		beforeClose: function(e, $container, instance, slide)
		{
			if (this.options.lbHistory)
			{
				if (this.pushStateCount)
				{
					XF.History.go(-this.pushStateCount);
					this.pushStateCount = 0;
				}
			}

			if (this.$sidebar)
			{
				this.$sidebar.remove();
				this.$sidebar = null;
				$(window).off('resize.lbSidebar');
			}
		},

		afterClose: function()
		{
			XF.Modal.close();
			XF.Lightbox.activeLb = null;
		},

		getContainerId: function($container)
		{
			return 'lb-' + $container.data('lb-id');
		},

		imageChecked: function(e, $target, $container, $image)
		{
			var include = true;

			if ($image && this.isImageNaturalSize($image))
			{
				include = false;
			}

			if (include)
			{
				$target.attr('data-fancybox', this.getContainerId($container));
				$target.css('cursor', 'pointer');
				this.updateCaption($target);
			}
		},

		checkImageSizes: function($target, $container)
		{
			var event = $.Event('lightbox:image-checked');

			if (this.isSingleImage($target))
			{
				var $image = $target.find('img[data-zoom-target=1]');

				if ($image.parents('a').length)
				{
					// embedded inside a link so ignore lightbox entirely
					return;
				}

				// timeout to allow animations to finish (e.g. quick edit)
				setTimeout(function()
				{
					if (!$image.prop('complete'))
					{
						$image.on('load', function()
						{
							$target.trigger(event, [$target, $container, $image]);
						});
					}
					else
					{
						$target.trigger(event, [$target, $container, $image]);
					}
				}, 500);
			}
			else
			{
				$target.trigger(event, [$target, $container]);
			}
		},

		isImageNaturalSize: function($image)
		{
			var dims = {
				width: $image.width(),
				height: $image.height(),
				naturalWidth: $image.prop('naturalWidth'),
				naturalHeight: $image.prop('naturalHeight')
			};

			if (!dims.naturalWidth || !dims.naturalHeight)
			{
				// could be a failed image, ignore
				return true;
			}

			return dims.width == dims.naturalWidth
				&& dims.height == dims.naturalHeight;
		},

		isSingleImage: function($target)
		{
			return $target.is('div') && $target.data('single-image');
		},

		updateCaption: function($target)
		{
			if ($target.data('caption'))
			{
				return;
			}

			var $closestContainer = $target.closest(this.options.lbContainer);

			var template = '<h4>{{title}}</h4><p><a href="{{href}}" class="js-lightboxCloser">{{desc}}</a>{{{extra_html}}}</p>',
				$image = $target.find('img'),
				lbId = $closestContainer.data('lb-id'),
				caption = {
					title: $closestContainer.data('lb-caption-title') || $image.attr('alt') || $image.attr('title') || '',
					desc: $target.data('lb-caption-desc') || $closestContainer.data('lb-caption-desc') || '',
					href: $target.data('lb-caption-href') || (lbId ? (window.location.href.replace(/#.*$/,'') + '#' + lbId) : null),
					extra_html: $target.data('lb-caption-extra-html') || ''
				};

			$target.attr('data-caption', Mustache.render(template, caption));
		},

		getConfig: function($container)
		{
			return {
				hash: false,
				lang: 'xf',
				i18n: {
					xf: this.getLanguage()
				},
				loop: !(
					this.options.lbPrev || this.options.lbNext
				),
				wheel: false,
				closeExisting: true,
				smallBtn: false,
				buttons: [
					'zoom',
					'newWindow',
					'fullScreen',
					'slideShow',
					'download',
					'thumbs',
					'close',
					'sidebarToggle'
				],
				btnTpl: {
					zoom: '<button data-fancybox-zoom class="fancybox-button fancybox-button--zoom" title="{{ZOOM}}"><i></i><i></i></button>',
					newWindow: '<a data-fancybox-nw class="fancybox-button fancybox-button--nw" title="{{NEW_WINDOW}}" href="javascript:;"><i></i></a>',
					fullScreen: '<button data-fancybox-fullscreen class="fancybox-button fancybox-button--fsenter" title="{{FULL_SCREEN}}"><i></i><i></i></button>',
					slideShow: '<button data-fancybox-play class="fancybox-button fancybox-button--play" title="{{PLAY_START}}"><i></i><i></i></button>',
					download: '<a download data-fancybox-download class="fancybox-button fancybox-button--download" title="{{DOWNLOAD}}" href="javascript:;"><i></i></a>',
					thumbs: '<button data-fancybox-thumbs class="fancybox-button fancybox-button--thumbs" title="{{THUMBS}}"><i></i></button>',
					close: '<button data-fancybox-close class="fancybox-button fancybox-button--close" title="{{CLOSE}}"><i></i></button>',
					sidebarToggle: '<div class="fancybox-sidebartoggle"><button data-fancybox-sidebartoggle class="fancybox-button fancybox-button--sidebartoggle" title="{{SIDEBAR_TOGGLE}}"><i></i></button></div>',
					arrowLeft: '<button data-fancybox-prev class="fancybox-button fancybox-button--arrow_left" title="{{PREV}}"><i></i></button>',
					arrowRight: '<button data-fancybox-next class="fancybox-button fancybox-button--arrow_right" title="{{NEXT}}"><i></i></button>'

				},
				slideShow: this.options.lbSlideShow ? {
					autoStart: false,
					speed: 3000
				} : false,
				thumbs: {
					autoStart: this.options.lbThumbsAuto ? true : false,
					axis: 'x'
				},
				video: {
					autoStart: false
				},
				infobar: this.options.lbInfobar,

				onInit: function(instance)
				{
					var event = $.Event('lightbox:init');
					$container.trigger(event, [$container, instance]);
				},

				beforeLoad: function(instance, slide)
				{
					var event = $.Event('lightbox:before-load');
					$container.trigger(event, [$container, instance, slide]);
				},

				afterLoad: function(instance, slide)
				{
					var event = $.Event('lightbox:after-load');
					$container.trigger(event, [$container, instance, slide]);
				},

				beforeShow: function(instance, slide)
				{
					var event = $.Event('lightbox:before-show');
					$container.trigger(event, [$container, instance, slide]);
				},

				afterShow: function(instance, slide)
				{
					var event = $.Event('lightbox:after-show');
					$container.trigger(event, [$container, instance, slide]);
				},

				beforeClose: function(instance, slide)
				{
					var event = $.Event('lightbox:before-close');
					$container.trigger(event, [$container, instance, slide]);
				},

				afterClose: function(instance, slide)
				{
					var event = $.Event('lightbox:after-close');
					$container.trigger(event, [$container, instance, slide]);
				},

				onActivate: function(instance)
				{
					var event = $.Event('lightbox:activate');
					$container.trigger(event, [$container, instance]);
				},

				onDeactivate: function(instance)
				{
					var event = $.Event('lightbox:deactivate');
					$container.trigger(event, [$container, instance]);
				}
			};
		},

		getLanguage: function()
		{
			return {
				CLOSE: XF.phrase('lightbox_close'),
				NEXT: XF.phrase('lightbox_next'),
				PREV: XF.phrase('lightbox_previous'),
				ERROR: XF.phrase('lightbox_error'),
				PLAY_START: XF.phrase('lightbox_start_slideshow'),
				PLAY_STOP: XF.phrase('lightbox_stop_slideshow'),
				FULL_SCREEN: XF.phrase('lightbox_full_screen'),
				THUMBS: XF.phrase('lightbox_thumbnails'),
				DOWNLOAD: XF.phrase('lightbox_download'),
				SHARE: XF.phrase('lightbox_share'),
				ZOOM: XF.phrase('lightbox_zoom'),
				NEW_WINDOW: XF.phrase('lightbox_new_window'),
				SIDEBAR_TOGGLE: XF.phrase('lightbox_toggle_sidebar')
			};
		}
	});
	XF.Lightbox.activeLb = null;

	// Allow deferred loading of this script to enable the lightbox on the container element if needed.
	$(document).on('xf:reinit', function(e, el)
	{
		if (el == document)
		{
			return;
		}

		var $lbContainer = $(el).closest('[data-xf-init~=lightbox]');
		if (!$lbContainer.length)
		{
			return;
		}

		var lbHandler = XF.Element.getHandler($lbContainer, 'lightbox');
		if (lbHandler)
		{
			// already initialized, will handle itself
			return;
		}

		// setTimeout to prevent a double reinit
		setTimeout(function()
		{
			XF.Element.initializeElement($lbContainer);
		}, 0);
	});

	XF.History.handle(function(state)
	{
		var activeLb = XF.Lightbox.activeLb;
		if (activeLb)
		{
			activeLb.handlePopstate(state);
			return true;
		}
	});

	XF.Element.register('lightbox', 'XF.Lightbox');
}
(jQuery, window, document);