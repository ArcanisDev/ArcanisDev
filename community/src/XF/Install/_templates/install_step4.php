<?php
	class_exists('XF\Install\App', false) || die('Invalid');

	$templater->setTitle('Setup options');
?>

<form method="post" action="index.php?install/step4b" class="block">
	<div class="block-container">
		<div class="block-body">
			<?php foreach ($options AS $option) { ?>
				<dl class="formRow formRow--input">
					<dt><label class="formRow-label" for="ctrl_<?php echo $option->option_id ?>"><?php echo $option->MasterTitle->phrase_text; ?></label></dt>
					<dd>
						<input type="text" name="options[<?php echo $option->option_id; ?>]" value="<?php echo $option->option_value; ?>" class="input" id="ctrl_<?php echo $option->option_id ?>" />
					</dd>
				</dl>
			<?php } ?>

			<hr class="formRowSep" />

		</div>
		<dl class="formRow formSubmitRow">
			<dt></dt>
			<dd>
				<div class="formSubmitRow-main">
					<div class="formSubmitRow-bar"></div>
					<div class="formSubmitRow-controls">
						<button accesskey="s" class="button button--primary button--icon button--icon--save">
							<span class="button-text">Setup options</span>
						</button>
					</div>
				</div>
			</dd>
		</dl>
	</div>

	<?php echo $templater->fnCsrfInput($templater, $null); ?>
</form>
