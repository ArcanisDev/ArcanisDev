!function($, window, document, _undefined)
{
	"use strict";

	XF.EditorManager = XF.Element.newHandler({
		options: {
			dragListClass: '.js-dragList',
			commandTrayClass: '.js-dragList-commandTray'
		},

		$lists: null,
		trayElements: [],
		listElements: [],
		isScrollable: true,
		dragula: null,
		$cache: null,

		xfEditor: null,

		init: function()
		{
			this.$lists = this.$target.find(this.options.dragListClass);
			this.$lists.each(XF.proxy(this, 'prepareList'));

			this.$cache = this.$target.find('.js-dragListValue');

			this.initDragula();

			var xfEditor = XF.Element.getHandler($('textarea[name=button_layout_preview_html]').first(), 'editor');
			if (xfEditor)
			{
				this.xfEditor = xfEditor;
				xfEditor.$target.on('editor:init', XF.proxy(this, 'rebuildValueCache'));
			}
			else
			{
				this.rebuildValueCache();
			}
		},

		prepareList: function(i, list)
		{
			if ($(list).is(this.options.commandTrayClass))
			{
				this.trayElements.push(list);
			}
			else
			{
				this.listElements[this.listElements.length] = list; // not using .push() because I want them in order

				var self = this,
					listId = this.getListId(list);

				this.getListOptions(listId).on('change', function()
				{
					self.updateList(list, true);
				});
			}

			this.updateList(list);
		},

		initDragula: function()
		{
			// the following is code to workaround an issue which makes the
			// page scroll while dragging elements.
			var t = this;
			document.addEventListener('touchmove', function(e)
			{
				if (!t.isScrollable)
				{
					e.preventDefault();
				}
			}, { passive:false });

			var lists = this.listElements;

			var i;
			for (i in this.trayElements)
			{
				lists.unshift(this.trayElements[i]);
			}

			this.dragula = dragula(lists, {
				direction: 'horizontal',
				removeOnSpill: true,
				copy: function (el, source)
				{
					return t.isTrayElement(source);
				},
				accepts: function (el, target)
				{
					return !t.isTrayElement(target);
				},
				moves: function (el, source, handle, sibling)
				{
					return !$(el).hasClass('toolbar-addDropdown') && !$(el).hasClass('fr-separator');
				}
			});

			this.dragula.on('drag', XF.proxy(this, 'drag'));
			this.dragula.on('dragend', XF.proxy(this, 'dragend'));
			this.dragula.on('drop', XF.proxy(this, 'drop'));
			this.dragula.on('cancel', XF.proxy(this, 'cancel'));
			this.dragula.on('remove', XF.proxy(this, 'remove'));
			this.dragula.on('over', XF.proxy(this, 'over'));
			this.dragula.on('out', XF.proxy(this, 'out'));
		},

		drag: function(el, source)
		{
			this.isScrollable = false;

			var $el = $(el),
				$source = $(source);

			if ($el.hasClass('toolbar-separator') && !$source.hasClass('js-dragList-commandTray'))
			{
				$el.next('.fr-separator').remove();
			}
		},

		dragend: function(el)
		{
			this.isScrollable = true;
			$('.js-dropTarget').remove();
		},

		drop: function(el, target, source, sibling)
		{
			var $el = $(el),
				$target = $(target),
				cmd = $el.data('cmd');

			if ($el.hasClass('toolbar-separator'))
			{
				this.appendSeparator($el);
			}
			else
			{
				if ($el.next().is('.fr-separator'))
				{
					$el.insertAfter($el.next());
				}
			}

			// if dragged from our dropdown tray, remove the menu click attr
			if ($el.attr('data-xf-click') === 'menu')
			{
				$el.attr('data-xf-click', null);
			}

			if (!this.isTrayElement(source))
			{
				this.updateList(source);
			}
			if (!this.isTrayElement(target))
			{
				this.updateList(target);
			}

			this.rebuildValueCache();
		},

		cancel: function(el, container, source)
		{
			var $el = $(el),
				$source = $(source);

			if ($el.hasClass('toolbar-separator') && !$source.hasClass('js-dragList-commandTray'))
			{
				this.appendSeparator($el);
			}
		},

		remove: function(el, container, source)
		{
			if (!this.isTrayElement(source))
			{
				XF.flashMessage(XF.phrase('button_removed'), 1500);
				this.updateList(source, true);
			}
		},

		over: function(el, container, source)
		{
		},

		out: function(el, container, source)
		{
		},

		getListId: function(list)
		{
			return list.id.substr(12); // js-toolbar--$id
		},

		getListOptions: function(listId)
		{
			return $('#js-toolbar-menu--' + listId)
				.find('input, select');
		},

		getListOptionValues: function(listId)
		{
			var optionValues = {
				buttons: []
			};

			this.getListOptions(listId).each(function(i, formEl)
			{
				optionValues[formEl.name] = $(formEl).val();
			});

			return optionValues;
		},

		updateList: function(list, rebuild)
		{
			var listId = this.getListId(list),
				options = this.getListOptionValues(listId);

			$(list).removeClass(function(index, className)
			{
				return (className.match(/toolbar-option--[^\s$]+/g) || []).join(' ');
			})
				.addClass('toolbar-option--buttonsVisible-' + options.buttonsVisible)
				.addClass('toolbar-option--align-' + options.align)
			;

			if (rebuild)
			{
				this.rebuildValueCache();
			}
		},

		rebuildValueCache: function(e)
		{
			var options = {},
				self = this;

			if (!this.$cache.length)
			{
				return;
			}

			this.$lists.not(this.options.commandTrayClass).each(function(i, list)
			{
				var listId = self.getListId(list),
					listValue = self.getListOptionValues(listId);

				$(list).children().each(function(i, cmd)
				{
					var $cmd = $(cmd);

					if (!$cmd.data('cmd'))
					{
						return;
					}

					listValue.buttons.push($cmd.data('cmd'));
				});

				options[listId] = listValue;
			});

			this.$cache.val(JSON.stringify(options));

			// do not update editor preview if triggered by init
			var isInitTriggered = (e && e.type === 'editor:init');
			if (!isInitTriggered)
			{
				this.updateEditorPreview(options);
			}
		},

		updateEditorPreview: function(options)
		{
			var xfEditor = this.xfEditor,
				$jsEditorToolbars = $('.js-editorToolbars').first(),
				cmd;

			if (xfEditor && $jsEditorToolbars.length)
			{
				$jsEditorToolbars.html(JSON.stringify({"toolbarButtons": options}));

				if (xfEditor.ed.$tb.hasClass('fr-toolbar-open'))
				{
					cmd = xfEditor.ed.$tb.find('.fr-btn.fr-open').first().data('cmd');
					xfEditor.reInit({afterInit: function()
					{
						xfEditor.ed.commands[cmd]();
					}});
				}
				else
				{
					xfEditor.reInit();
				}
			}
		},

		appendSeparator: function($el)
		{
			var $sep = $('<div />')
				.addClass('fr-separator')
				.addClass('fr' + $el.data('cmd'));

			$sep.insertAfter($el);
		},

		isTrayElement: function(el)
		{
			return (this.trayElements.indexOf(el) !== -1);
		}
	});

	XF.Element.register('editor-manager', 'XF.EditorManager');
}
(jQuery, window, document);