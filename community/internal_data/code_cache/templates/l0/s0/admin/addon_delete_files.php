<?php
// FROM HASH: 966cf17579285c1d30536b69dd3380bd
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if (!$__vars['undeletableFiles']) {
		$__compilerTemp1 .= '
		' . 'Confirm file deletion for ' . $__templater->escape($__vars['addOn']['title']) . '' . '
	';
	} else {
		$__compilerTemp1 .= '
		' . 'Unable to delete files for ' . $__templater->escape($__vars['addOn']['title']) . '' . '
	';
	}
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('
	' . $__compilerTemp1 . '
');
	$__finalCompiled .= '

';
	if (!$__vars['undeletableFiles']) {
		$__finalCompiled .= '
	';
		$__compilerTemp2 = '';
		if ($__vars['conflictingFiles']) {
			$__compilerTemp2 .= '
					<div class="block-row">
						<div class="block-rowMessage block-rowMessage--iconic block-rowMessage--warning">
							' . 'The following files are not deletable as they may be in use by another add-on. These files will <strong>not</strong> be deleted but you may proceed with deleting the rest of the files in this add-on if you wish.' . '
						</div>
						<ul>
							';
			if ($__templater->isTraversable($__vars['conflictingFiles'])) {
				foreach ($__vars['conflictingFiles'] AS $__vars['conflictingFile']) {
					$__compilerTemp2 .= '
								<li><code>' . $__templater->escape($__vars['conflictingFile']) . '</code></li>
							';
				}
			}
			$__compilerTemp2 .= '
						</ul>
					</div>
				';
		}
		$__compilerTemp3 = '';
		if ($__templater->isTraversable($__vars['filesToDelete'])) {
			foreach ($__vars['filesToDelete'] AS $__vars['file']) {
				$__compilerTemp3 .= '
							<li><code>' . $__templater->escape($__vars['file']) . '</code></li>
						';
			}
		}
		$__finalCompiled .= $__templater->form('

		<div class="block-container">
			<div class="block-body">
				' . $__templater->formInfoRow('
					' . 'Please confirm that you wish to delete the files from the following add-on' . $__vars['xf']['language']['label_separator'] . '
					<strong>' . $__templater->escape($__vars['addOn']['title']) . ' ' . $__templater->escape($__vars['addOn']['version_string']) . '</strong>
				', array(
			'rowtype' => 'confirm',
		)) . '

				' . $__compilerTemp2 . '
				<div class="block-row">
					<div class="block-rowMessage block-rowMessage--iconic block-rowMessage--important">
						' . 'All files known to be associated with this add-on will be deleted (unless stated otherwise), but it may not be possible to delete some directories.' . '
					</div>
				</div>
			</div>

			<h3 class="block-formSectionHeader">
				<span class="collapseTrigger collapseTrigger--block" data-xf-click="toggle" data-target="< :up:next">
					' . 'View files to be deleted' . '
				</span>
			</h3>
			<div class="block-body block-body--contained block-body--collapsible" tabindex="-1">
				<div class="block-row">
					<ul>
						' . $__compilerTemp3 . '
					</ul>
				</div>
			</div>

			' . $__templater->formSubmitRow(array(
			'submit' => 'Delete files',
		), array(
			'rowtype' => 'simple',
		)) . '
		</div>

		' . $__templater->func('redirect_input', array(null, null, true)) . '
	', array(
			'action' => $__templater->func('link', array('add-ons/delete-files', $__vars['addOn'], ), false),
			'class' => 'block',
			'ajax' => 'true',
		)) . '
';
	} else {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<div class="block-body">
				';
		$__compilerTemp4 = '';
		if ($__templater->isTraversable($__vars['undeletableFiles'])) {
			foreach ($__vars['undeletableFiles'] AS $__vars['undeletableFile']) {
				$__compilerTemp4 .= '
							<li><code>' . $__templater->escape($__vars['undeletableFile']) . '</code></li>
						';
			}
		}
		$__finalCompiled .= $__templater->formInfoRow('
					<div class="block-rowMessage block-rowMessage--error">
						' . 'The following files or directories are not deletable due to file permissions. We recommend that the add-on files are removed manually.' . '
					</div>
					<ul>
						' . $__compilerTemp4 . '
					</ul>
				', array(
		)) . '
			</div>
		</div>
	</div>
';
	}
	return $__finalCompiled;
}
);