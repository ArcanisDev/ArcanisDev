!function($, window, document, _undefined)
{
	"use strict";

	XF.DateInput = XF.Element.newHandler({
		options: {
			weekStart: 0,
			minDate: null,
			maxDate: null,
			disableWeekends: false,
			yearRange: null,
			showWeekNumber: false,
			showDaysInNextAndPreviousMonths: true
		},

		picker: null,

		init: function()
		{
			var minDate = this.options.minDate,
				maxDate = this.options.maxDate;
			if (minDate)
			{
				var minTime = Date.parse(minDate.replace(/-/g, '/'));
				minDate = new Date(minTime);
			}
			if (maxDate)
			{
				var maxTime = Date.parse(maxDate.replace(/-/g, '/'));
				maxDate = new Date(maxTime);
			}

			var self = this,
				$target = this.$target,
				initialValue = $target.val(),
				config = {
					format: 'YYYY-MM-DD',
					toString: function(date, format)
					{
						const day = date.getDate();
						const month = date.getMonth() + 1;
						const year = date.getFullYear();
						return year + '-' + month + '-' + day;
					},
					parse: function(dateString, format)
					{
						// dateString is the result of `toString` method
						const parts = dateString.split('-');
						const year = parseInt(parts[0], 10);
						const month = parseInt(parts[1], 10) - 1;
						const day = parseInt(parts[2], 10);
						return new Date(year, month, day);
					},
					onSelect: function()
					{
						var pad = function(number)
						{
							if (number < 10) { return '0' + number; }
							return number;
						};
						var date = this._d,
							day = String(date.getDate()),
							month = String(date.getMonth() + 1),
							year = String(date.getFullYear());

						self.$target.val(year + '-' + pad(month) + '-' + pad(day));
					},
					onOpen: function()
					{
						if ($target.prop('readonly'))
						{
							this.hide();
						}
					},
					showTime: false,
					firstDay: this.options.weekStart,
					minDate: minDate,
					maxDate: maxDate,
					disableWeekends: this.options.disableWeekends,
					yearRange: this.options.yearRange,
					showWeekNumber: this.options.showWeekNumber,
					showDaysInNextAndPreviousMonths: this.options.showDaysInNextAndPreviousMonths,
					i18n: {
						previousMonth : '',
						nextMonth     : '',
						weekdays      : [0, 1, 2, 3, 4, 5, 6].map(function(day){ return XF.phrase('day' + day) }),
						weekdaysShort : [0, 1, 2, 3, 4, 5, 6].map(function(day){ return XF.phrase('dayShort' + day) }),
						months        : [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11].map(function(month){ return XF.phrase('month' + month) })
					},
					isRTL: false, // this switch doesn't work as expected so rely on our CSS flipping
					field: this.$target[0]
				};

			if (initialValue)
			{
				// Pikaday uses Date.parse() internally which parses yyyy-mm-dd unexpectedly when in UTC-X timezones.
				// This works around that issue.
				var match = initialValue.match(/^(\d{4})-(\d\d?)-(\d\d?)$/);
				if (match)
				{
					config.defaultDate = new Date(parseInt(match[1], 10), parseInt(match[2], 10) - 1, parseInt(match[3]));
					config.setDefaultDate = true;
				}
			}

			this.picker = new Pikaday(config);
			this.$target.val(initialValue);

			var $trigger = this.$target.parent().find('.js-dateTrigger');
			if ($trigger.length)
			{
				$trigger.on('click', function()
				{
					self.picker.show();
				});
			}
		}
	});

	XF.Element.register('date-input', 'XF.DateInput');
}
(jQuery, window, document);