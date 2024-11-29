<?php
// FROM HASH: 3f8f7dacae3336414c90c79436ade8a3
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['style'], 'isInsert', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add style');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit style' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['style']['title']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['style'], 'isUpdate', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('', array(
			'href' => $__templater->func('link', array('styles/delete', $__vars['style'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

';
	$__compilerTemp1 = array(array(
		'value' => '0',
		'label' => $__vars['xf']['language']['parenthesis_open'] . 'No parent' . $__vars['xf']['language']['parenthesis_close'],
		'_type' => 'option',
	));
	$__compilerTemp2 = $__templater->method($__vars['styleTree'], 'getFlattened', array(1, ));
	if ($__templater->isTraversable($__compilerTemp2)) {
		foreach ($__compilerTemp2 AS $__vars['treeEntry']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['treeEntry']['record']['style_id'],
				'label' => '
						' . $__templater->func('repeat', array('--', $__vars['treeEntry']['depth'], ), true) . ' ' . $__templater->escape($__vars['treeEntry']['record']['title']) . '
					',
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp3 = '';
	$__compilerTemp4 = -1 + 0;
	$__vars['i'] = $__compilerTemp4;
	if ($__templater->isTraversable($__vars['style']['effective_assets'])) {
		foreach ($__vars['style']['effective_assets'] AS $__vars['key'] => $__vars['path']) {
			$__vars['i']++;
			$__compilerTemp3 .= '
						<li class="inputGroup">
							' . $__templater->formTextBox(array(
				'name' => 'assets[' . $__vars['i'] . '][key]',
				'placeholder' => 'Asset key',
				'value' => $__vars['key'],
				'disabled' => ((($__templater->method($__vars['style'], 'isAssetInherited', array($__vars['key'], )) OR $__templater->method($__vars['style'], 'isAssetModified', array($__vars['key'], )))) ? 'disabled' : ''),
			)) . '
							' . $__templater->formHiddenVal('assets[' . $__vars['i'] . '][key]', $__vars['key'], array(
				'class' => 'js-assetKey',
				'disabled' => ((!$__templater->method($__vars['style'], 'isAssetModified', array($__vars['key'], ))) ? 'disabled' : ''),
			)) . '

							<span class="inputGroup-splitter"></span>

							' . $__templater->formTextBox(array(
				'name' => 'assets[' . $__vars['i'] . '][path]',
				'placeholder' => 'Asset path',
				'class' => 'js-assetValue',
				'value' => $__vars['path'],
				'data-parent-value' => ($__templater->method($__vars['style'], 'isAssetModified', array($__vars['key'], )) ? $__templater->method($__vars['style'], 'getParentAssetValue', array($__vars['key'], )) : null),
				'disabled' => ($__templater->method($__vars['style'], 'isAssetInherited', array($__vars['key'], )) ? 'disabled' : ''),
			)) . '

							<span class="inputGroup-splitter"></span>

							';
			if ($__templater->method($__vars['style'], 'isAssetCustom', array($__vars['key'], ))) {
				$__compilerTemp3 .= '
								' . $__templater->button('', array(
					'fa' => 'fa-pencil',
					'class' => 'button--plain button--iconOnly button--adminStyleAsset is-disabled',
				), '', array(
				)) . '
							';
			} else {
				$__compilerTemp3 .= '
								' . $__templater->button('', array(
					'class' => 'button--plain button--icon button--iconOnly button--adminStyleAsset ' . ($__templater->method($__vars['style'], 'isAssetInherited', array($__vars['key'], )) ? 'is-modify js-assetModify' : '') . ' ' . ($__templater->method($__vars['style'], 'isAssetModified', array($__vars['key'], )) ? 'is-revert js-assetModify' : ''),
					'data-xf-init' => 'tooltip',
					'title' => ($__templater->method($__vars['style'], 'isAssetInherited', array($__vars['key'], )) ? 'Modify in this style' : 'Revert value to parent'),
				), '', array(
				)) . '
							';
			}
			$__compilerTemp3 .= '
						</li>
					';
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formTextBoxRow(array(
		'name' => 'title',
		'value' => $__vars['style']['title'],
		'maxlength' => $__templater->func('max_length', array($__vars['style'], 'title', ), false),
	), array(
		'label' => 'Title',
	)) . '

			' . $__templater->formTextAreaRow(array(
		'name' => 'description',
		'value' => $__vars['style']['description'],
		'autosize' => 'true',
		'maxlength' => $__templater->func('max_length', array($__vars['style'], 'description', ), false),
	), array(
		'label' => 'Description',
	)) . '

			' . $__templater->formSelectRow(array(
		'name' => 'parent_id',
		'value' => $__vars['style']['parent_id'],
	), $__compilerTemp1, array(
		'label' => 'Parent style',
	)) . '

			' . $__templater->formRow('

				<ul class="listPlain inputGroup-container">
					' . $__compilerTemp3 . '

					<li class="inputGroup" data-xf-init="field-adder" data-increment-format="assets[{counter}]">
						' . $__templater->formTextBox(array(
		'name' => 'assets[' . $__vars['nextCounter'] . '][key]',
		'placeholder' => 'Asset key',
	)) . '

						<span class="inputGroup-splitter"></span>

						' . $__templater->formTextBox(array(
		'name' => 'assets[' . $__vars['nextCounter'] . '][path]',
		'placeholder' => 'Asset path',
	)) . '

						<span class="inputGroup-splitter"></span>

						' . $__templater->button('', array(
		'fa' => 'fa-pencil',
		'class' => 'button--plain button--iconOnly button--adminStyleAsset is-disabled',
	), '', array(
	)) . '
					</li>
				</ul>
			', array(
		'label' => 'Asset locations',
		'explain' => 'Asset locations describe the location of files that are attached to this style, relative to the XenForo installation directory. Asset locations may be accessed in style properties via <code>%ASSET:key%</code> or in templates using the <code>asset()</code> template function.',
		'rowtype' => 'input',
		'data-xf-init' => 'admin-asset-editor',
	)) . '

			' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'user_selectable',
		'selected' => $__vars['style']['user_selectable'],
		'label' => '
					' . 'Allow user selection' . '
				',
		'_type' => 'option',
	)), array(
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('styles/save', $__vars['style'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);