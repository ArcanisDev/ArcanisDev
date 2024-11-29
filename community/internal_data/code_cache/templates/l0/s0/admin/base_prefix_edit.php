<?php
// FROM HASH: 8de9c73c484aee0eac28a7d3b6d4cbff
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['prefix'], 'isInsert', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add prefix');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit prefix' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['prefix']['title']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['prefix'], 'isUpdate', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('', array(
			'href' => $__templater->func('link', array($__vars['linkPrefix'] . '/delete', $__vars['prefix'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__templater->method($__vars['prefix'], 'hasRelation', array('MasterDescription', ))) {
		$__compilerTemp1 .= '
				' . $__templater->formCodeEditorRow(array(
			'name' => 'description',
			'value' => ($__vars['prefix']['prefix_id'] ? $__vars['prefix']['MasterDescription']['phrase_text'] : ''),
			'mode' => 'html',
			'data-line-wrapping' => 'true',
			'rows' => '1',
			'readonly' => '0',
			'class' => 'codeEditor--autoSize',
		), array(
			'label' => 'Description',
			'explain' => 'Should this prefix require additional explanation while viewing an associated item, you may enter a description, optionally using HTML, here.',
		)) . '
			';
	}
	$__compilerTemp2 = '';
	if ($__templater->method($__vars['prefix'], 'hasRelation', array('MasterUsageHelp', ))) {
		$__compilerTemp2 .= '
				' . $__templater->formCodeEditorRow(array(
			'name' => 'usage_help',
			'value' => ($__vars['prefix']['prefix_id'] ? $__vars['prefix']['MasterUsageHelp']['phrase_text'] : ''),
			'mode' => 'html',
			'data-line-wrapping' => 'true',
			'readonly' => '0',
			'class' => 'codeEditor--autoSize',
		), array(
			'label' => 'Prefix usage help',
			'explain' => 'If you would like to explain the use of this prefix to users as they prepare their content, enter a description here. You may use HTML.',
		)) . '
			';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">

			' . $__templater->formTextBoxRow(array(
		'name' => 'title',
		'value' => ($__vars['prefix']['prefix_id'] ? $__vars['prefix']['MasterTitle']['phrase_text'] : ''),
	), array(
		'label' => 'Title',
	)) . '

			' . $__compilerTemp1 . '

			' . $__compilerTemp2 . '

			' . $__templater->callMacro('base_prefix_edit_macros', 'display_style', array(
		'prefix' => $__vars['prefix'],
		'displayStyles' => $__vars['displayStyles'],
	), $__vars) . '

			<hr class="formRowSep" />

			' . $__templater->callMacro('base_prefix_edit_macros', 'prefix_groups', array(
		'prefix' => $__vars['prefix'],
		'prefixGroups' => $__vars['prefixGroups'],
	), $__vars) . '

			' . $__templater->callMacro('display_order_macros', 'row', array(
		'value' => $__vars['prefix']['display_order'],
	), $__vars) . '

			<hr class="formRowSep" />

			' . $__templater->callMacro('helper_user_group_edit', 'checkboxes', array(
		'selectedUserGroups' => ($__vars['prefix']['prefix_id'] ? $__vars['prefix']['allowed_user_group_ids'] : array(-1, )),
	), $__vars) . '

			' . $__templater->filter($__vars['extraOptions'], array(array('raw', array()),), true) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array($__vars['linkPrefix'] . '/save', $__vars['prefix'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);