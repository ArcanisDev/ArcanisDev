<?php
// FROM HASH: d5c93fcd20b8f0a7b312614d66b997ef
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->func('property', array('xenfocus_countdownEnable', ), false)) {
		$__finalCompiled .= '
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js"></script>
	';
		if ($__templater->func('property', array('xenfocus_countdownZone', ), false)) {
			$__finalCompiled .= '
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.13/moment-timezone-with-data-2012-2022.min.js"></script>
	';
		}
		$__finalCompiled .= '
	<script type=\'text/javascript\'>
	$(document).ready(function(){
		
		';
		if ($__templater->func('property', array('xenfocus_countdownZone', ), false)) {
			$__finalCompiled .= '
			var focusTimer = moment.tz("' . $__templater->func('property', array('xenfocus_countdownDate', ), true) . '", "' . $__templater->func('property', array('xenfocus_countdownZone', ), true) . '");
			var focusDate = focusTimer.toDate();
		';
		} else {
			$__finalCompiled .= '
			var focusDate = "' . $__templater->func('property', array('xenfocus_countdownDate', ), true) . '";
		';
		}
		$__finalCompiled .= '

		$(\'.focus-timer-numbers\').countdown(focusDate)
		.on(\'update.countdown\', function(event) {
			var format = \'%H:%M:%S\';
			if(event.offset.totalDays > 0) {
				format = \'%-d <span data-countdown-text="day%!d and"></span> \' + format;
			}
			if(event.offset.weeks > 0) {
				format = \'%-w <span data-countdown-text="week%!w,"></span> \' + format;
			}
			$(this).html(event.strftime(format));
			$(\'.focus-timer\').addClass(\'focus-timer-counting\');
		})
		.on(\'finish.countdown\', function(event) {
			$(\'.focus-timer\').addClass(\'focus-timer-done\');
		});

	});
	</script>
';
	}
	return $__finalCompiled;
}
);