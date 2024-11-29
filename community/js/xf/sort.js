!function ($, window, document, _undefined) {
	"use strict";

	// ################################## NESTABLE HANDLER ###########################################

	XF.ListSorter = XF.Element.newHandler({

		options: {
			dragParent: null,
			dragHandle: null,
			undraggable: '.is-undraggable',
			direction: 'vertical',
			submitOnDrop: false
		},

		drake: null,

		init: function()
		{
			if (this.options.dragParent)
			{
				$(window).on('listSorterDuplication', XF.proxy(this, 'drakeSetup'));
			}

			this.$target.on('touchmove', this.options.dragHandle, function(e)
			{
				e.preventDefault();
			});

			this.drakeSetup();
		},

		drakeSetup: function()
		{
			if (this.drake)
			{
				this.drake.destroy();
			}

			var dragContainer = this.options.dragParent
				? this.$target.find(this.options.dragParent).get()
				: [this.$target.get(0)];

			this.drake = dragula(
				dragContainer,
				{
					moves: XF.proxy(this, 'isMoveable'),
					accepts: XF.proxy(this, 'isValidTarget'),
					direction: this.options.direction
				}
			);

			if (this.options.submitOnDrop)
			{
				var $form = $(dragContainer).closest('form');
				if ($form.length)
				{
					this.drake.on('drop', function(e)
					{
						$form.submit();
					});
				}
			}
		},

		isMoveable: function (el, source, handle, sibling)
		{
			var handleIs = this.options.dragHandle,
				undraggableIs = this.options.undraggable;

			if (handleIs)
			{
				if (!$(handle).closest(handleIs).length)
				{
					return false;
				}
			}
			if (undraggableIs)
			{
				if ($(el).closest(undraggableIs).length)
				{
					return false;
				}
			}

			return true;
		},

		isValidTarget: function (el, target, source, sibling)
		{
			var $before = !sibling
				? this.$target.children().last()
				: $(sibling).prev();

			while ($before.length)
			{
				if ($before.is('.js-blockDragafter'))
				{
					return false;
				}

				$before = $before.prev();
			}

			if (sibling)
			{
				var $after = $(sibling);

				while ($after.length)
				{
					if ($after.is('.js-blockDragbefore'))
					{
						return false;
					}

					$after = $after.next();
				}
			}

			return true;
		}
	});

	XF.Element.register('list-sorter', 'XF.ListSorter');
}
(jQuery, window, document);