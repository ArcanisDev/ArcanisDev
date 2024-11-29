<?php
// FROM HASH: b93f49482c319b6f0bbbdc3491126c8e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['node'], 'isInsert', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add search forum');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit search forum' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['node']['title']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['node'], 'isUpdate', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('', array(
			'href' => $__templater->func('link', array('search-forums/delete', $__vars['node'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->callMacro('node_edit_macros', 'title', array(
		'node' => $__vars['node'],
	), $__vars) . '
			' . $__templater->callMacro('node_edit_macros', 'description', array(
		'node' => $__vars['node'],
	), $__vars) . '

			<hr class="formRowSep" />
			' . $__templater->callMacro('node_edit_macros', 'node_name', array(
		'node' => $__vars['node'],
	), $__vars) . '
			' . $__templater->callMacro('node_edit_macros', 'position', array(
		'node' => $__vars['node'],
		'nodeTree' => $__vars['nodeTree'],
	), $__vars) . '
			' . $__templater->callMacro('node_edit_macros', 'navigation', array(
		'node' => $__vars['node'],
		'navChoices' => $__vars['navChoices'],
	), $__vars) . '
			' . $__templater->callMacro('node_edit_macros', 'style', array(
		'node' => $__vars['node'],
		'styleTree' => $__vars['styleTree'],
	), $__vars) . '
			<hr class="formRowSep" />
		</div>

		<h2 class="block-formSectionHeader">
			<span class="block-formSectionHeader-aligner">' . 'Search results' . '</span>
		</h2>
		<div class="block-body">
			<hr class="formRowSep" />

			' . $__templater->formRow('

				<div class="inputPair">
					' . $__templater->formSelect(array(
		'name' => 'sort_order',
		'value' => $__vars['searchForum']['sort_order'],
		'class' => 'input--inline',
	), array(array(
		'value' => 'last_post_date',
		'label' => 'Last message',
		'_type' => 'option',
	),
	array(
		'value' => 'post_date',
		'label' => 'Start date',
		'_type' => 'option',
	),
	array(
		'value' => 'title',
		'label' => 'Title',
		'_type' => 'option',
	),
	array(
		'value' => 'reply_count',
		'label' => 'Replies',
		'_type' => 'option',
	),
	array(
		'value' => 'view_count',
		'label' => 'Views',
		'_type' => 'option',
	))) . '

					' . $__templater->formSelect(array(
		'name' => 'sort_direction',
		'value' => $__vars['searchForum']['sort_direction'],
		'class' => 'input--inline',
	), array(array(
		'value' => 'desc',
		'label' => 'Descending',
		'_type' => 'option',
	),
	array(
		'value' => 'asc',
		'label' => 'Ascending',
		'_type' => 'option',
	))) . '
				</div>
			', array(
		'rowtype' => 'input',
		'label' => 'Sort order',
	)) . '

			' . $__templater->formNumberBoxRow(array(
		'name' => 'max_results',
		'value' => $__vars['searchForum']['max_results'],
		'min' => '20',
		'max' => '1000',
	), array(
		'label' => 'Maximum results',
	)) . '

			' . $__templater->formNumberBoxRow(array(
		'name' => 'cache_ttl',
		'value' => $__vars['searchForum']['cache_ttl'],
		'units' => 'Minutes',
		'min' => '1',
		'max' => '1440',
	), array(
		'label' => 'Cache length',
		'explain' => 'Search results, including their order, will be cached for this length of time. A lower value provides greater accuracy at the expense of performance.',
	)) . '
		</div>

		<h2 class="block-formSectionHeader">
			<span class="block-formSectionHeader-aligner">' . 'Thread criteria' . '</span>
		</h2>
		<div class="block-body">
			' . $__templater->includeTemplate('helper_thread_search_criteria', $__vars) . '
		</div>

		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('search-forums/save', $__vars['node'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);