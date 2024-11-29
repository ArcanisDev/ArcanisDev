<?php
// FROM HASH: 3f83c8998bc8af651d4f5127f5a67296
return array(
'macros' => array('upload_link' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'type' => '!',
		'hash' => '!',
		'context' => '!',
		'constraints' => '!',
		'hiddenName' => 'attachment_hash',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__templater->includeJs(array(
		'prod' => 'xf/attachment_manager-compiled.js',
		'dev' => 'vendor/flow.js/flow.min.js, xf/attachment_manager.js',
	));
	$__finalCompiled .= '

	' . $__templater->button('', array(
		'href' => $__templater->func('link', array('attachments/upload', null, array('type' => $__vars['type'], 'context' => $__vars['context'], 'hash' => $__vars['hash'], ), ), false),
		'target' => '_blank',
		'class' => 'button--link js-attachmentUpload',
		'icon' => 'attach',
		'data-accept' => '.' . $__templater->filter($__vars['constraints']['extensions'], array(array('join', array(',.', )),), false),
		'data-video-size' => $__vars['constraints']['video_size'],
	), '', array(
	)) . '
	' . $__templater->formHiddenVal($__vars['hiddenName'], $__vars['hash'], array(
	)) . '
	' . $__templater->formHiddenVal($__vars['hiddenName'] . '_combined', $__templater->filter(array('type' => $__vars['type'], 'context' => $__vars['context'], 'hash' => $__vars['hash'], ), array(array('json', array()),), false), array(
	)) . '
';
	return $__finalCompiled;
}
),
'upload_link_from_data' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'attachmentData' => '!',
		'forceHash' => '',
		'hiddenName' => 'attachment_hash',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->callMacro(null, 'upload_link', array(
		'type' => $__vars['attachmentData']['type'],
		'hash' => ($__vars['forceHash'] ? $__vars['forceHash'] : $__vars['attachmentData']['hash']),
		'context' => $__vars['attachmentData']['context'],
		'constraints' => $__vars['attachmentData']['constraints'],
		'hiddenName' => $__vars['hiddenName'],
	), $__vars) . '
';
	return $__finalCompiled;
}
),
'uploaded_files_list' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'attachments' => array(),
		'class' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeCss('attachments.less');
	$__finalCompiled .= '
	<div class="attachmentUploads js-attachmentUploads ' . $__templater->escape($__vars['class']) . ' ' . (!$__templater->test($__vars['attachments'], 'empty', array()) ? 'is-active' : '') . '">
		<div class="hScroller" data-xf-init="h-scroller">
			<div class="hScroller-scroll">
				<ul class="attachUploadList js-attachmentFiles">
				';
	if ($__templater->isTraversable($__vars['attachments'])) {
		foreach ($__vars['attachments'] AS $__vars['attachment']) {
			$__finalCompiled .= '
					' . $__templater->callMacro(null, 'uploaded_file', array(
				'attachment' => $__vars['attachment'],
			), $__vars) . '
				';
		}
	}
	$__finalCompiled .= '
				</ul>
			</div>
		</div>

		<div class="attachmentUploads-banner js-attachmentInsertMultiRow u-hidden">
			' . $__templater->button('
				' . 'Insert multiple' . $__vars['xf']['language']['ellipsis'] . '
			', array(
		'class' => 'button--link js-attachmentSelect',
		'data-toggle' => 'Cancel',
	), '', array(
	)) . '
			<ul class="attachmentUploads-selectActions js-attachmentSelectActions">
				<li>
					<span class="button button--link selectAll">
						<span class="button-text">
							' . $__templater->formCheckBox(array(
		'standalone' => 'true',
	), array(array(
		'check-all' => '< .attachmentUploads',
		'label' => 'Select all',
		'_type' => 'option',
	))) . '
						</span>
					</span>
				</li>
				<li class="js-attachmentSelectInsertActions">
					<span class="insert-label">' . 'Insert' . $__vars['xf']['language']['label_separator'] . '</span>
					<span class="buttonGroup">
						' . $__templater->button('
							' . 'Thumbnail' . '
						', array(
		'class' => 'button--link js-attachmentSelectAction',
		'data-action' => 'thumbnail',
	), '', array(
	)) . '
						' . $__templater->button('
							' . 'Full image' . '
						', array(
		'class' => 'button--link js-attachmentSelectAction',
		'data-action' => 'full',
	), '', array(
	)) . '
					</span>
				</li>
				<li>
					' . $__templater->button('
						<span class="u-srOnly">' . 'Delete' . '</span>
					', array(
		'class' => 'button--link button--iconOnly js-attachmentSelectAction',
		'fa' => 'fa-trash-alt',
		'data-action' => 'delete',
	), '', array(
	)) . '
				</li>
			</ul>
		</div>

	</div>
	' . $__templater->callMacro(null, 'uploaded_file_template', array(), $__vars) . '
';
	return $__finalCompiled;
}
),
'uploaded_file' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'attachment' => '!',
		'noJsFallback' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<li class="js-attachmentFile file" data-attachment-id="' . $__templater->escape($__vars['attachment']['attachment_id']) . '">
		';
	if ($__vars['attachment']['has_thumbnail']) {
		$__finalCompiled .= '
			<a class="file-preview js-attachmentView" href="' . $__templater->escape($__vars['attachment']['direct_url']) . '" target="_blank">
				<img src="' . $__templater->func('base_url', array($__vars['attachment']['thumbnail_url'], ), true) . '" class="js-attachmentThumb" alt="' . $__templater->escape($__vars['attachment']['filename']) . '"
					width="' . $__templater->escape($__vars['attachment']['thumbnail_width']) . '" height="' . $__templater->escape($__vars['attachment']['thumbnail_height']) . '" loading="lazy" />
			</a>
		';
	} else if ($__vars['attachment']['is_video']) {
		$__finalCompiled .= '
			<a class="file-preview js-attachmentView" href="' . $__templater->escape($__vars['attachment']['direct_url']) . '" target="_blank">
				<video data-xf-init="video-init">
					<source src="' . $__templater->escape($__vars['attachment']['direct_url']) . '" />
				</video>
			</a>
		';
	} else {
		$__finalCompiled .= '
			<a class="file-preview js-attachmentView" href="' . $__templater->escape($__vars['attachment']['direct_url']) . '" target="_blank">
				<span class="file-typeIcon">
					' . $__templater->fontAwesome($__templater->escape($__vars['attachment']['icon']), array(
		)) . '
				</span>
			</a>
		';
	}
	$__finalCompiled .= '

		<div class="file-content">

			';
	if (!$__vars['noJsFallback']) {
		$__finalCompiled .= '
				';
		if ($__vars['attachment']['has_thumbnail']) {
			$__finalCompiled .= '
					<div class="file-insert js-attachmentInsert">
						<a class="file-insertLink"
							data-xf-click="toggle"
							data-target="< .js-attachmentInsert"
							role="button"
							tabindex="0">
							' . 'Insert' . $__vars['xf']['language']['ellipsis'] . '
						</a>
						<div class="file-menuOptions">
							<a class="js-attachmentAction" data-action="thumbnail" role="button" tabindex="0"
								data-xf-click="toggle" data-target="< .js-attachmentInsert">' . 'Thumbnail' . '</a>
							<a class="js-attachmentAction" data-action="full" role="button" tabindex="0"
								data-xf-click="toggle" data-target="< .js-attachmentInsert">' . 'Full image' . '</a>
						</div>
					</div>
				';
		} else if ($__vars['attachment']['is_video']) {
			$__finalCompiled .= '
					<div class="file-insert js-attachmentInsert">
						<a class="file-insertLink js-attachmentAction" data-action="full" data-type="video" role="button" tabindex="0">
							' . 'Insert' . '
						</a>
					</div>
				';
		} else if ($__vars['attachment']['is_audio']) {
			$__finalCompiled .= '
					<div class="file-insert js-attachmentInsert">
						<a class="file-insertLink js-attachmentAction" data-action="full" data-type="audio" role="button" tabindex="0">
							' . 'Insert' . '
						</a>
					</div>
				';
		}
		$__finalCompiled .= '

				<div class="file-checkbox">
					' . $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'value' => '',
			'_type' => 'option',
		))) . '
				</div>
			';
	}
	$__finalCompiled .= '

			<span class="file-delete">
				';
	if ($__vars['noJsFallback']) {
		$__finalCompiled .= '
					' . $__templater->button('
						' . $__templater->fontAwesome('fa-trash-alt', array(
		)) . '
						<span class="u-srOnly">' . 'Delete' . '</span>
					', array(
			'type' => 'submit',
			'class' => 'button--small button--link',
			'name' => 'delete',
			'value' => $__vars['attachment']['attachment_id'],
		), '', array(
		)) . '
				';
	} else {
		$__finalCompiled .= '
					<a class="file-deleteLink js-attachmentAction"
						data-action="delete"
						data-type="' . $__templater->escape($__vars['attachment']['type_grouping']) . '"
						role="button"
						tabindex="0">
						' . $__templater->fontAwesome('fa-trash-alt', array(
		)) . '
						<span class="u-srOnly">' . 'Delete' . '</span>
					</a>
				';
	}
	$__finalCompiled .= '
			</span>

			<a class="file-info"
				href="' . $__templater->escape($__vars['attachment']['direct_url']) . '"
				target="_blank">

				<span class="file-name">' . $__templater->escape($__vars['attachment']['filename']) . '</span>

				<div class="file-meta">
					';
	if ($__vars['attachment']['Data']['width']) {
		$__finalCompiled .= $__templater->escape($__vars['attachment']['Data']['width']) . ' x ' . $__templater->escape($__vars['attachment']['Data']['height']) . ' &middot; ';
	}
	$__finalCompiled .= '
					' . $__templater->filter($__vars['attachment']['file_size'], array(array('file_size', array()),), true) . '
				</div>
			</a>
		</div>
	</li>
';
	return $__finalCompiled;
}
),
'uploaded_file_template' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<script type="text/template" class="js-attachmentUploadTemplate">
		<li class="file js-attachmentFile" ' . $__templater->func('mustache', array('#attachment_id', 'data-attachment-id="{{attachment_id}}"', ), true) . '>
			' . $__templater->func('mustache', array('#uploading', '
				<div class="file-preview">
					<div class="file-progress js-attachmentProgress"></div>
					<span class="file-error js-attachmentError"></span>
				</div>
			')) . '
			' . $__templater->func('mustache', array('^uploading', '
				' . $__templater->func('mustache', array('#thumbnail_url', '
					<a class="file-preview js-attachmentView" href="' . $__templater->func('mustache', array('link', ), true) . '" target="_blank">
						<img src="' . $__templater->func('mustache', array('thumbnail_url', ), true) . '" class="js-attachmentThumb" alt="' . $__templater->func('mustache', array('filename', ), true) . '" />
					</a>
				')) . '
				' . $__templater->func('mustache', array('^thumbnail_url', '
					' . $__templater->func('mustache', array('#is_video', '
						<a class="file-preview js-attachmentView" href="' . $__templater->func('mustache', array('link', ), true) . '" target="_blank">
							<video data-xf-init="video-init">
								<source src="' . $__templater->func('mustache', array('link', ), true) . '" />
							</video>
						</a>
					')) . '
					' . $__templater->func('mustache', array('^is_video', '
						<a class="file-preview js-attachmentView" href="' . $__templater->func('mustache', array('link', ), true) . '" target="_blank">
							<span class="file-typeIcon">
								<i class="fa--xf fa' . $__templater->func('fa_weight', array(), true) . ' ' . $__templater->func('mustache', array('icon', ), true) . '" aria-hidden="true"></i>
							</span>
						</a>
					')) . '
				')) . '
			')) . '

			<div class="file-content">

				' . $__templater->func('mustache', array('#thumbnail_url', '
					<div class="file-insert js-attachmentInsert">
						<a class="file-insertLink"
							data-xf-click="toggle"
							data-target="< .js-attachmentInsert"
							role="button"
							tabindex="0">
							' . 'Insert' . $__vars['xf']['language']['ellipsis'] . '
						</a>
						<div class="file-menuOptions">
							<a class="js-attachmentAction" data-action="thumbnail" role="button" tabindex="0"
								data-xf-click="toggle" data-target="< .js-attachmentInsert">' . 'Thumbnail' . '</a>
							<a class="js-attachmentAction" data-action="full" role="button" tabindex="0"
								data-xf-click="toggle" data-target="< .js-attachmentInsert">' . 'Full image' . '</a>
						</div>
					</div>
				')) . '
				' . $__templater->func('mustache', array('^thumbnail_url', '
					' . $__templater->func('mustache', array('#is_video', '
						<div class="file-insert js-attachmentInsert">
							<a class="file-insertLink js-attachmentAction" data-action="full" data-type="video" role="button" tabindex="0">
								' . 'Insert' . '
							</a>
						</div>
					')) . '
					' . $__templater->func('mustache', array('#is_audio', '
						<div class="file-insert js-attachmentInsert">
							<a class="file-insertLink js-attachmentAction" data-action="full" data-type="audio" role="button" tabindex="0">
								' . 'Insert' . '
							</a>
						</div>
					')) . '
				')) . '

				<div class="file-checkbox">
					' . $__templater->formCheckBox(array(
		'standalone' => 'true',
	), array(array(
		'value' => '',
		'_type' => 'option',
	))) . '
				</div>

				<span class="file-delete">
					' . $__templater->func('mustache', array('#uploading', '
						<a class="file-deleteLink js-attachmentAction"
							data-action="cancel"
							role="button"
							tabindex="0">
							' . $__templater->fontAwesome('fa-trash-alt', array(
	)) . '
							<span class="u-srOnly">' . 'Cancel' . '</span>
						</a>
					')) . '
					' . $__templater->func('mustache', array('^uploading', '
						<a class="file-deleteLink js-attachmentAction"
							data-action="delete"
							data-type="' . $__templater->func('mustache', array('type_grouping', ), true) . '"
							role="button"
							tabindex="0">
							' . $__templater->fontAwesome('fa-trash-alt', array(
	)) . '
							<span class="u-srOnly">' . 'Delete' . '</span>
						</a>
					')) . '
				</span>

				<a class="file-info" href="' . $__templater->func('mustache', array('link', ), true) . '" target="_blank">
					<span class="file-name">' . $__templater->func('mustache', array('filename', ), true) . '</span>

					<div class="file-meta">
						' . $__templater->func('mustache', array('#thumbnail_url', $__templater->func('mustache', array('width', ), true) . ' x ' . $__templater->func('mustache', array('height', ), true) . ' &middot; ')) . '
						' . $__templater->func('mustache', array('file_size_printable', ), true) . '
					</div>
				</a>

			</div>
		</li>
	</script>
';
	return $__finalCompiled;
}
),
'upload_block' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'attachmentData' => '!',
		'forceHash' => '',
		'hiddenName' => 'attachment_hash',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->callMacro(null, 'uploaded_files_list', array(
		'attachments' => $__vars['attachmentData']['attachments'],
	), $__vars) . '

	' . $__templater->callMacro(null, 'upload_link_from_data', array(
		'attachmentData' => $__vars['attachmentData'],
		'forceHash' => $__vars['forceHash'],
		'hiddenName' => $__vars['hiddenName'],
	), $__vars) . '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . '



' . '



' . '



' . '




';
	return $__finalCompiled;
}
);