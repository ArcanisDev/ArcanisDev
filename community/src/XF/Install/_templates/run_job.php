<?php
	class_exists('XF\Install\App', false) || die('Invalid');

	$templater->setTitle('Processing...');
?>

<form action="<?php echo htmlspecialchars($submitUrl); ?>" method="post" class="blockMessage js-autoSubmit">

	<div><?php echo (!empty($status) ? htmlspecialchars($status) : 'Processing...'); ?></div>

	<div class="u-noJsOnly">
		<button accesskey="s" class="button js-submitButton">Proceed...</button>
	</div>

	<?php echo $templater->fnRedirectInput($templater, $null, $redirect, null, false); ?>
	<?php echo $templater->fnCsrfInput($templater, $null); ?>

	<input type="hidden" name="execute" value="1" />
</form>