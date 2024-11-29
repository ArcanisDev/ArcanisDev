<?php
// FROM HASH: 7af2ffd8acf7044bd62e4625509ebb6e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Profile banner');
	$__finalCompiled .= '

';
	$__templater->includeCss('account_banner.less');
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'src' => 'xf/profile_banner.js',
	));
	$__finalCompiled .= '

';
	$__templater->wrapTemplate('account_wrapper', $__vars);
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . $__templater->func('profile_banner', array($__vars['xf']['visitor'], 'l', false, array(
		'data-xf-init' => 'banner-positioner',
		'class' => 'js-banner',
	), '
					' . $__templater->formHiddenVal('banner_position_y', $__vars['xf']['visitor']['Profile']['banner_position_y'], array(
		'class' => 'js-bannerPosY',
	)) . '
				')) . '
				<div class="profileBannerContainer-explain">
					' . 'You can drag the image to change the focal point of the banner, then click Okay to confirm.' . '
				</div>
			', array(
		'rowtype' => 'noPadding',
		'rowclass' => 'profileBannerContainer ' . ($__vars['xf']['visitor']['Profile']['banner_date'] ? 'profileBannerContainer--withBanner' : ''),
	)) . '
			' . $__templater->formUploadRow(array(
		'name' => 'upload',
		'class' => 'js-uploadBanner',
		'accept' => '.gif,.jpeg,.jpg,.jpe,.png',
	), array(
		'label' => 'Upload new profile banner',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => 'Okay',
		'class' => 'js-overlayClose',
	), array(
		'rowtype' => 'simple',
		'html' => '
				' . $__templater->button('', array(
		'type' => 'submit',
		'name' => 'delete_banner',
		'value' => '1',
		'class' => 'js-deleteBanner',
		'icon' => 'delete',
	), '', array(
	)) . '
			',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('account/banner', ), false),
		'upload' => 'true',
		'ajax' => 'true',
		'class' => 'block',
		'data-xf-init' => 'banner-upload',
	));
	return $__finalCompiled;
}
);