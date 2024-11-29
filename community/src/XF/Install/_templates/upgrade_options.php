<?php
	class_exists('XF\Install\App', false) || die('Invalid');

	$templater->setTitle('Setup options');
?>

<?php if (!empty($isReprompt)) { ?>
	<div class="blockMessage blockMessage--important">
		We are making some changes to the anonymous statistics that we collect.
		<?php if (!empty($repromptReasons)) { ?>
			<ul>
				<?php foreach ($repromptReasons AS $repromptReason) { ?>
					<li><?php echo $repromptReason; ?></li>
				<?php } ?>
			</ul>
		<?php } ?>
	</div>
<?php } ?>

<form method="post" action="index.php?upgrade/options" class="block">
	<div class="block-container">
		<div class="block-body">
			<dl class="formRow">
				<dt></dt>
				<dd>
					<ul class="inputChoices">
						<li class="inputChoices-choice">
							<label class="iconic iconic--checkbox iconic--labelled">
								<input type="checkbox" name="options[collectServerStats][enabled]" value="1" <?php echo !empty($isEnabled) ? 'checked' : ''?>><i aria-hidden="true"></i> Send anonymous usage statistics
							</label>
						</li>
					</ul>

					<div class="formRow-explain">
						XenForo would like to collect some anonymous statistics including information about PHP, MySQL and your XenForo installation.<br />
						<br />
						If enabled, any data collected will be stored anonymously and will not include any user data.
					</div>

					<input type="hidden" name="options[collectServerStats][configured]" value="1" />
				</dd>
			</dl>
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
