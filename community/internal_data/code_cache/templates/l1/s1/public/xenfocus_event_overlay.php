<?php
// FROM HASH: 765509aa0f3f4a89497c99ed46fd244e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->func('property', array('xenfocus_eventOverlay', ), false) === 'snow') {
		$__finalCompiled .= '
<script>
$(document).ready(function(){
	
	$("body").append("<div class=\'xenfocus-snow\'><div class=\'xenfocus-snow-panel xenfocus-snow-panel-1\'><i class=\'f-sF\'></i></div><div class=\'xenfocus-snow-panel xenfocus-snow-panel-2\'><i class=\'f-sF\'></i></div><div class=\'xenfocus-snow-panel xenfocus-snow-panel-3\'><i class=\'f-sF\'></i></div></div>");
	
	$(".xenfocus-snow-panel").each(function(){
		var snowlist = $(this);
		for ( i = 0; i < 25;i++){
		    snowlist.find(\'.f-sF:first\').clone().appendTo(snowlist);
		}
	});
	
});
</script>
';
	}
	$__finalCompiled .= '

';
	if ($__templater->func('property', array('xenfocus_eventOverlay', ), false) === 'confetti') {
		$__finalCompiled .= '
<script>
$(document).ready(function(){
	
	$("body").append("<div class=\'xenfocus-confetti\'><div class=\'xenfocus-confetti-panel xenfocus-confetti-panel-1\'><i class=\'f-con\'></i></div><div class=\'xenfocus-confetti-panel xenfocus-confetti-panel-2\'><i class=\'f-con\'></i></div><div class=\'xenfocus-confetti-panel xenfocus-confetti-panel-3\'><i class=\'f-con\'></i></div></div>");
	
	$(".xenfocus-confetti-panel").each(function(){
		var confettilist = $(this);
		for ( i = 0; i < 17;i++){
		    confettilist.find(\'.f-con:first\').clone().appendTo(confettilist);
		}
	});
	
});
</script>
';
	}
	return $__finalCompiled;
}
);