<?php
	class_exists('XF\Install\App', false) || die('Invalid');

	$templater->setTitle('Install');
?>

<div class="blockMessage">
	<ul>
		<?php if ($removed) { ?>
			<li>Removed old tables...</li>
		<?php } ?>
		<li><?php echo ($endOffset) ? "Created tables ($endOffset)..." : 'Created tables...'; ?></li>
		<?php if ($endOffset === false) { ?>
			<li>Inserted default data...</li>
		<?php } ?>
	</ul>
</div>

<?php if ($endOffset === false) { ?>
	<form action="index.php?install/step/2b" method="post" class="js-autoSubmit" id="js-continueForm">
		<button accesskey="s" class="button button--primary js-submitButton">Continue...</button>
		<?php echo $templater->fnCsrfInput($templater, $null); ?>
	</form>
<?php } else { ?>
	<form action="index.php?install/step/2" method="post" class="js-autoSubmit" id="js-continueForm">
		<input type="hidden" name="start" value="<?php echo htmlspecialchars($endOffset); ?>" />
		<button accesskey="s" class="button button--primary js-submitButton">Continue...</button>
		<?php echo $templater->fnCsrfInput($templater, $null); ?>
	</form>
<?php }

?>