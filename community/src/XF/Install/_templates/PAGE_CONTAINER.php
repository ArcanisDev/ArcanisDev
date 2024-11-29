<?php
	class_exists('XF\Install\App', false) || die('Invalid');
?>
<!DOCTYPE html>
<html id="XF" dir="ltr" class="has-no-js" data-template="<?php echo !empty($templateName) ? $templateName : '' ?>" data-app="install">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo (!empty($title) ? htmlspecialchars($title) . ' | ' : ''); ?>XenForo</title>

	<meta name="robots" content="noindex, nofollow" />

	<link rel="stylesheet" href="install.css" />
</head>
<body>
<div class="p-pageWrapper">
	<header class="p-header">
		<div class="p-header-logo p-header-logo--image">
			<img src="../styles/default/xenforo/xenforo-logo.svg" width="100" height="36" alt="XenForo Ltd." />
		</div>
	</header>
	<div class="p-body">
		<div class="p-main">
			<main class="p-main-inner">

				<noscript><div class="blockMessage blockMessage--important blockMessage--iconic u-noJsOnly"><?php echo \XF::phrase('javascript_is_disabled_please_enable_before_proceeding'); ?></div></noscript>

				<div class="blockMessage blockMessage--important blockMessage--iconic js-browserWarning" style="display: none"><?php echo \XF::phrase('you_are_using_out_of_date_browser_upgrade'); ?></div>

				<div class="p-title">
					<h1 class="p-title-value">
						<?php echo (!empty($title) ? htmlspecialchars($title) : ''); ?>
					</h1>
				</div>

				<div class="p-content" id="content">
					<?php echo (!empty($content) ? $content : ''); ?>
				</div>
			</main>
		</div>
	</div>
	<footer class="p-footer">
		<div class="p-footer-row">
			<div class="p-footer-row-main"></div>
			<div class="p-footer-row-opposite">
				<span class="p-footer-version">v<?php echo \XF::$version; ?></span>
			</div>
		</div>

		<div class="p-footer-copyright">
			<?php echo $templater->fnCopyright($templater, $null); ?>
		</div>
	</footer>
</div>

<?php echo $templater->renderTemplate('js_core'); ?>

</body>
</html>