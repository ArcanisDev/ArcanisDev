!function($, window, document, _undefined)
{
	"use strict";

	XF.OffCanvasBuilder.acpNav = function($menu, handler)
	{
		$menu.on('off-canvas:opening', function()
		{
			$menu.css('position', '');
		});
	};

	XF.AdminNav = XF.Element.newHandler({
		options: {
			topOffset: '.p-header',
			stickyTarget: '| .js-navSticky',
			sectionTogglers: '.js-navSectionToggle',
			toggleTarget: '.p-nav-section',
			toggleSubTarget: '.p-nav-listSection',
			navTester: '| .js-navTester'
		},

		$stickyTarget: null,

		init: function()
		{
			var $stickyTarget;

			$stickyTarget = XF.findRelativeIf(this.options.stickyTarget, this.$target);
			this.$stickyTarget = $stickyTarget;
			this.refreshSticky();

			this.$target.on('click', this.options.sectionTogglers, XF.proxy(this, 'togglerClick'));

			$(window).resize(XF.proxy(this, 'refreshSticky'));
		},

		isOffCanvas: function()
		{
			var $tester = XF.findRelativeIf(this.options.navTester, this.$target);
			if (!$tester.length)
			{
				return false;
			}

			var val = window.getComputedStyle($tester[0]).getPropertyValue('font-family').replace(/"/g, '');
			return (val == 'off-canvas');
		},

		refreshSticky: function()
		{
			var $stickyTarget = this.$stickyTarget,
				isSticky = $stickyTarget.data('sticky_kit');

			if (this.isOffCanvas())
			{
				if (isSticky)
				{
					$stickyTarget.trigger('sticky_kit:detach').removeData('sticky_kit');
				}
			}
			else
			{
				if (!isSticky)
				{
					this.$target.trigger('off-canvas:close', {instant: true});

					var height = XF.findRelativeIf(this.options.topOffset, this.$target).height();

					$stickyTarget.stick_in_parent({
						offset_top: height
					});
				}
			}
		},

		togglerClick: function(e)
		{
			e.preventDefault();

			var $target = $(e.target),
				$parent = $target.closest(this.options.toggleTarget),
				subTarget = this.options.toggleSubTarget;

			$parent.siblings().not($parent).each(function()
			{
				var $this = $(this);
				$this.removeClassTransitioned('is-active');
				$this.find(subTarget).removeClassTransitioned('is-active');
			});

			$parent.toggleClassTransitioned('is-active', function()
			{
				XF.layoutChange();
			});
			$parent.find(subTarget).toggleClassTransitioned('is-active');
		}
	});

	XF.AdminSearch = XF.Element.newHandler({
		options: {
			input: '| .js-adminSearchInput',
			results: '| .js-adminSearchResults',
			resultsWrapper: '| .js-adminSearchResultsWrapper',
			toggleClass: 'is-active'
		},

		$input: null,
		$results: null,
		$resultsWrapper: null,
		xhr: null,

		init: function()
		{
			var $form = this.$target,
				$input;

			$input = this.$input = XF.findRelativeIf(this.options.input, $form);
			this.$results = XF.findRelativeIf(this.options.results, $form);

			this.$resultsWrapper = XF.findRelativeIf(this.options.resultsWrapper, $form);

			$form.submit(XF.proxy(this, 'submit'));

			XF.watchInputChangeDelayed($input, function()
			{
				$form.submit();
			});

			$input.on('keydown', XF.proxy(this, 'keyDown'));
		},

		submit: function(e)
		{
			e.preventDefault();

			var $form = this.$target,
				$results = this.$results,
				self = this,
				$resultsWrapper = this.$resultsWrapper,
				toggleClass = this.options.toggleClass;

			if (!$.trim(this.$input.val()).length)
			{
				this.emptyResults();
				return;
			}

			if (this.xhr)
			{
				this.xhr.abort();
			}

			this.xhr = XF.ajax('post', $form.attr('action'), $form.serializeArray(), function(data)
			{
				if (data.html)
				{
					XF.setupHtmlInsert(data.html, function($html, data, onComplete)
					{
						if ($html.length)
						{
							$results.html($html);
							onComplete();
							$resultsWrapper.addClass(toggleClass);
							$results.addClassTransitioned(toggleClass);
							$results.find('a').hover(
								function() { $(this).addClass('is-active'); },
								function() { $(this).removeClass('is-active'); }
							);
						}
						else
						{
							self.emptyResults();
						}
					});
				}
			});
		},

		emptyResults: function()
		{
			var $results = this.$results,
				$resultsWrapper = this.$resultsWrapper,
				toggleClass = this.options.toggleClass;

			$results.removeClassTransitioned(toggleClass, function()
			{
				$results.empty();
				$resultsWrapper.removeClass(toggleClass);
			});
		},

		keyDown: function(e)
		{
			switch (e.key)
			{
				case 'ArrowUp': return this.menuNavigate(-1);
				case 'ArrowDown': return this.menuNavigate(1);
				case 'Enter': return this.menuSelect();
			}
		},

		menuNavigate: function(direction)
		{
			var $links = this.$results.find('a'),
				$highlighted = $links.filter('.is-active'),
				newIndex = $links.index($highlighted) + direction;

			$links.removeClass('is-active');

			if (newIndex < 0)
			{
				newIndex = $links.length - 1;
			}
			else if (newIndex >= $links.length)
			{
				newIndex = 0;
			}

			$($links.get(newIndex)).addClass('is-active').focus();

			this.$input.focus();

			return false;
		},

		menuSelect: function()
		{
			var $link = this.$results.find('a.is-active');

			if ($link.length)
			{
				window.location = $link.attr('href');
				return false;
			}
		}
	});

	XF.AdminToggleAdvanced = XF.Element.newHandler({
		options: {
			url: null,
			value: null
		},

		init: function()
		{
			if ($('html').is('.acp--simple-mode'))
			{
				this.unhideLinkedOption();
			}

			this.$target.on('click', XF.proxy(this, 'click'));
		},

		unhideLinkedOption: function()
		{
			var id = window.location.hash.replace(/[^a-zA-Z0-9_-]/g, '');
			if (!id)
			{
				return;
			}

			var $option = $(`span#${id}.u-anchorTarget`).next('dl.acp--advanced');
			if (!$option || !$option.length)
			{
				return;
			}

			$option.show();
			XF.layoutChange();
		},

		click: function(e)
		{
			var advanced;

			if (this.options.value !== null)
			{
				advanced = this.options.value ? 1 : 0;
			}
			else if (this.$target.is(':checkbox'))
			{
				advanced = this.$target.prop('checked') ? 1 : 0;
			}
			else
			{
				console.error('Admin toggler must be a checkbox or provide a data-value');
				return;
			}

			if (this.options.url)
			{
				XF.ajax('POST', this.options.url, {'advanced': advanced});
			}

			$('.js-advancedModeToggle:checkbox').prop('checked', advanced);

			$('html').toggleClass('acp--advanced-mode', advanced)
				.toggleClass('acp--simple-mode', !advanced);

			XF.layoutChange();
		}
	});

	XF.AdminAssetEditor = XF.Element.newHandler({
		options: {},

		init: function()
		{
			this.$target.find('.js-assetModify').on('click', XF.proxy(this, 'modifyClick'));
		},

		modifyClick: function(e)
		{
			var $button = $(e.currentTarget),
				$inputGroup = $button.parent();

			if ($button.hasClass('is-modify'))
			{
				this.enableEditing($inputGroup);
			}
			else if ($button.hasClass('is-revert'))
			{
				this.revertToParent($inputGroup);
			}
		},

		enableEditing: function($inputGroup)
		{
			var $key = $inputGroup.find('.js-assetKey'),
				$value = $inputGroup.find('.js-assetValue'),
				$button = $inputGroup.find('.js-assetModify');

			$key.prop('disabled', false);
			$value.prop('disabled', false);

			if (!$value.data('parent-value'))
			{
				$value.data('parent-value', $value.val());
			}

			$button.removeClass('is-modify').addClass('is-revert');
		},

		revertToParent: function($inputGroup)
		{
			var $key = $inputGroup.find('.js-assetKey'),
				$value = $inputGroup.find('.js-assetValue'),
				$button = $inputGroup.find('.js-assetModify');

			$key.prop('disabled', true);
			$value.prop('disabled', true);

			$value.val($value.data('parent-value'));

			$button.removeClass('is-revert').addClass('is-modify');
		}
	});

	XF.Element.register('admin-toggle-advanced', 'XF.AdminToggleAdvanced');

	XF.Element.register('admin-nav', 'XF.AdminNav');
	XF.Element.register('admin-search', 'XF.AdminSearch');
	XF.Element.register('admin-asset-editor', 'XF.AdminAssetEditor');
}
(jQuery, window, document);