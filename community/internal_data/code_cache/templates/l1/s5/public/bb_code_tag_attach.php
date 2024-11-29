<?php
// FROM HASH: e0451dbbe07159557913d0560e21db7d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__vars['attachment']) {
		$__finalCompiled .= $__templater->func('trim', array('
	<a href="' . $__templater->func('link', array('full:attachments', array('attachment_id' => $__vars['id'], ), ), true) . '" target="_blank">' . 'View attachment ' . $__templater->escape($__vars['id']) . '' . '</a>
'), false);
	} else if ($__vars['attachment']['is_video'] AND ($__vars['full'] AND $__vars['canView'])) {
		$__finalCompiled .= $__templater->func('trim', array('
	<div class="bbMediaWrapper bbMediaWrapper--inline ' . $__templater->escape($__vars['alignClass']) . '">
		<div class="bbMediaWrapper-inner">
			<video controls data-xf-init="video-init"
				style="' . $__templater->escape($__vars['styleAttr']) . '">
				<source src="' . $__templater->escape($__vars['attachment']['direct_url']) . '" />
				<div class="bbMediaWrapper-fallback">' . 'Your browser is not able to display this video.' . '</div>
			</video>
		</div>
	</div>
'), false);
	} else if ($__vars['attachment']['is_audio'] AND ($__vars['full'] AND $__vars['canView'])) {
		$__finalCompiled .= $__templater->func('trim', array('
	<div class="bbMediaWrapper bbMediaWrapper--inline ' . $__templater->escape($__vars['alignClass']) . '">
		<div class="bbMediaWrapper-inner bbMediaWrapper-inner--audio">
			<audio controls
				style="' . $__templater->escape($__vars['styleAttr']) . '">
				<source src="' . $__templater->escape($__vars['attachment']['direct_url']) . '" />
				<div class="bbMediaWrapper-fallback">' . 'your_browser_is_not_able_to_play_this_audio' . '</div>
			</audio>
		</div>
	</div>
'), false);
	} else if (!$__vars['attachment']['has_thumbnail']) {
		$__finalCompiled .= $__templater->func('trim', array('
	<a href="' . $__templater->func('link', array('full:attachments', $__vars['attachment'], array('hash' => $__vars['attachment']['temp_hash'], ), ), true) . '" target="_blank">' . 'View attachment ' . $__templater->escape($__vars['attachment']['filename']) . '' . '</a>
'), false);
	} else if ($__vars['canView'] AND $__vars['full']) {
		$__compilerTemp1 = '';
		if ($__vars['noLightbox']) {
			$__compilerTemp1 .= '
		<img src="' . $__templater->func('link', array('full:attachments', $__vars['attachment'], array('hash' => $__vars['attachment']['temp_hash'], ), ), true) . '"
			class="bbImage ' . $__templater->escape($__vars['alignClass']) . '"
			style="' . $__templater->escape($__vars['styleAttr']) . '"
			alt="' . $__templater->escape($__vars['alt']) . '"
			title="' . $__templater->escape($__vars['alt']) . '"
			width="' . $__templater->escape($__vars['attachment']['width']) . '" height="' . $__templater->escape($__vars['attachment']['height']) . '" loading="lazy" />
	';
		} else {
			$__compilerTemp1 .= '
		' . $__templater->callMacro(null, 'lightbox_macros::single_image', array(
				'canViewAttachments' => $__vars['canView'],
				'id' => 'attachment' . $__vars['attachment']['attachment_id'],
				'src' => $__templater->func('link', array('full:attachments', $__vars['attachment'], array('hash' => $__vars['attachment']['temp_hash'], ), ), false),
				'width' => $__vars['attachment']['width'],
				'height' => $__vars['attachment']['height'],
				'alt' => $__vars['alt'],
				'title' => $__vars['alt'],
				'styleAttr' => $__vars['styleAttr'],
				'alignClass' => $__vars['alignClass'],
			), $__vars) . '
	';
		}
		$__finalCompiled .= $__templater->func('trim', array('
	' . $__compilerTemp1 . '
'), false);
	} else if ($__vars['canView'] AND (!$__vars['noLightbox'])) {
		$__finalCompiled .= $__templater->func('trim', array('
	' . $__templater->callMacro('lightbox_macros', 'setup', array(
			'canViewAttachments' => $__vars['canView'],
		), $__vars) . '
	<a href="' . $__templater->func('link', array('full:attachments', $__vars['attachment'], array('hash' => $__vars['attachment']['temp_hash'], ), ), true) . '"
		target="_blank" class="js-lbImage"><img src="' . $__templater->escape($__vars['attachment']['thumbnail_url_full']) . '"
		class="bbImage ' . $__templater->escape($__vars['alignClass']) . '"
		style="' . $__templater->escape($__vars['styleAttr']) . '"
		alt="' . $__templater->escape($__vars['alt']) . '"
		title="' . $__templater->escape($__vars['alt']) . '"
		width="' . $__templater->escape($__vars['attachment']['thumbnail_width']) . '" height="' . $__templater->escape($__vars['attachment']['thumbnail_height']) . '" loading="lazy" /></a>
'), false);
	} else {
		$__finalCompiled .= $__templater->func('trim', array('
	<a href="' . $__templater->func('link', array('full:attachments', $__vars['attachment'], array('hash' => $__vars['attachment']['temp_hash'], ), ), true) . '"
		target="_blank"><img src="' . $__templater->escape($__vars['attachment']['thumbnail_url_full']) . '"
		class="bbImage ' . $__templater->escape($__vars['alignClass']) . '"
		style="' . $__templater->escape($__vars['styleAttr']) . '"
		alt="' . $__templater->escape($__vars['alt']) . '"
		title="' . $__templater->escape($__vars['alt']) . '"
		width="' . $__templater->escape($__vars['attachment']['thumbnail_width']) . '" height="' . $__templater->escape($__vars['attachment']['thumbnail_height']) . '" loading="lazy" /></a>
'), false);
	}
	return $__finalCompiled;
}
);