<?php
	class_exists('XF\Install\App', false) || die('Invalid');

	$templater->setTitle('No upgrade available');
?>

<?php if ($fileErrors) { ?>
	<div class="blockMessage blockMessage--error">
		There are at least <?php echo count($fileErrors); ?> file(s) that do not appear to have the expected contents.
		Reupload the XenForo files and refresh this page.
		Only continue if you are sure all files have been uploaded properly.
	</div>
<?php } else if (!$hasHashes) { ?>
	<div class="blockMessage blockMessage--error">
		One or more files appears to be missing. Please reupload the XenForo files and refresh this page.
		Only continue if you are sure all files have been uploaded properly.
	</div>
<?php } ?>

<div class="block">
	<div class="block-container">
		<div class="block-body block-row">
			You are already running the current version (<?php echo \XF::$version; ?>).
			To do a fresh install, <a href="index.php?install/">click here</a>.
		</div>
		<div class="block-footer">
			<a href="index.php?upgrade/rebuild" class="button button--primary">Rebuild master data</a>
		</div>
	</div>
</div>
