<?php
// FROM HASH: b073a64107b0f174ed19f1133a143748
return array(
'macros' => array('attachment_list_item' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'attachment' => '!',
		'canView' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<li class="file file--linked">
		<a class="u-anchorTarget" id="attachment-' . $__templater->escape($__vars['attachment']['attachment_id']) . '"></a>
		';
	if ($__vars['attachment']['has_thumbnail']) {
		$__finalCompiled .= '
			' . $__templater->callMacro('lightbox_macros', 'setup', array(
			'canViewAttachments' => $__vars['canView'],
		), $__vars) . '

			<a class="file-preview ' . ($__vars['canView'] ? 'js-lbImage' : '') . '" href="' . $__templater->escape($__vars['attachment']['direct_url']) . '" target="_blank">
				<img src="' . $__templater->escape($__vars['attachment']['thumbnail_url']) . '" alt="' . $__templater->escape($__vars['attachment']['filename']) . '"
					width="' . $__templater->escape($__vars['attachment']['thumbnail_width']) . '" height="' . $__templater->escape($__vars['attachment']['thumbnail_height']) . '" loading="lazy" />
			</a>
		';
	} else if ($__vars['attachment']['is_video'] AND $__vars['canView']) {
		$__finalCompiled .= '
			<a class="file-preview" href="' . $__templater->escape($__vars['attachment']['direct_url']) . '" target="_blank">
				<video data-xf-init="video-init">
					<source src="' . $__templater->escape($__vars['attachment']['direct_url']) . '" />
				</video>
			</a>
		';
	} else {
		$__finalCompiled .= '
			<a class="file-preview" href="' . $__templater->escape($__vars['attachment']['direct_url']) . '" target="_blank">
				<span class="file-typeIcon">
					' . $__templater->fontAwesome($__templater->escape($__vars['attachment']['icon']), array(
		)) . '
				</span>
			</a>
		';
	}
	$__finalCompiled .= '

		<div class="file-content">
			<div class="file-info">
				<span class="file-name" title="' . $__templater->escape($__vars['attachment']['filename']) . '">' . $__templater->escape($__vars['attachment']['filename']) . '</span>
				<div class="file-meta">
					' . $__templater->filter($__vars['attachment']['file_size'], array(array('file_size', array()),), true) . '
					';
	if ((!$__vars['attachment']['is_video']) AND (!$__vars['attachment']['is_audio'])) {
		$__finalCompiled .= '
					&middot; ' . 'Views' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->filter($__vars['attachment']['view_count'], array(array('number', array()),), true) . '
					';
	}
	$__finalCompiled .= '
				</div>
			</div>
		</div>
	</li>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';

	return $__finalCompiled;
}
);