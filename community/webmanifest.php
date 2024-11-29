<?php

$dir = __DIR__;
require($dir . '/src/XF.php');

XF::start($dir);
$app = XF::setupApp('XF\Pub\App');

/** @var \XF\WebManifestRenderer $renderer */
$renderer = $app['webManifestRenderer'];

$style = $app->style(0);
$language = $app->language(0);
$response = $renderer->render($style, $language);

$request = $app->request();
$response->send($request);