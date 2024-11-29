<?php
// FROM HASH: c83fd2a0a0c639f56fee1ca3846c3f27
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Move thread' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->func('prefix', array('thread', $__vars['thread'], 'escaped', ), true) . $__templater->escape($__vars['thread']['title']));
	$__finalCompiled .= '
';
	$__templater->pageParams['pageH1'] = $__templater->preEscaped('Move thread' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->func('prefix', array('thread', $__vars['thread'], ), true) . $__templater->escape($__vars['thread']['title']));
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['thread'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '

';
	$__compilerTemp1 = array();
	$__compilerTemp2 = $__templater->method($__vars['nodeTree'], 'getFlattened', array(0, ));
	if ($__templater->isTraversable($__compilerTemp2)) {
		foreach ($__compilerTemp2 AS $__vars['treeEntry']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['treeEntry']['record']['node_id'],
				'disabled' => (($__vars['treeEntry']['record']['node_type_id'] != 'Forum') ? 'disabled' : ''),
				'label' => '
						' . $__templater->func('repeat_raw', array('&nbsp; ', $__vars['treeEntry']['depth'], ), true) . ' ' . $__templater->escape($__vars['treeEntry']['record']['title']) . '
					',
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp3 = '';
	if ($__templater->method($__vars['thread'], 'canSendModeratorActionAlert', array())) {
		$__compilerTemp3 .= '
				' . $__templater->callMacro('helper_action', 'thread_alert', array(
			'selected' => true,
		), $__vars) . '
			';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body js-prefixListenContainer">
			' . $__templater->formPrefixInputRow(($__templater->method($__vars['thread'], 'isPrefixEditable', array()) ? $__vars['prefixes'] : array()), array(
		'type' => 'thread',
		'prefix-value' => $__vars['thread']['prefix_id'],
		'textbox-value' => $__vars['thread']['title'],
		'href' => $__templater->func('link', array('forums/prefixes', ), false),
		'listen-to' => '< .js-prefixListenContainer | .js-nodeList',
		'autofocus' => 'autofocus',
		'maxlength' => $__templater->func('max_length', array($__vars['thread'], 'title', ), false),
	), array(
		'label' => 'Title',
	)) . '

			' . $__templater->formSelectRow(array(
		'name' => 'target_node_id',
		'value' => $__vars['forum']['node_id'],
		'class' => 'js-nodeList',
		'data-xf-init' => 'input-validator',
		'data-validation-url' => $__templater->func('link', array('threads/move-warnings', $__vars['thread'], ), false),
		'data-error-target' => '< dd | .js-threadMoveWarnings',
	), $__compilerTemp1, array(
		'label' => 'Destination forum',
		'explain' => '
					<div class="block-rowMessage block-rowMessage--important u-hidden u-hidden--transition js-threadMoveWarnings"></div>
				',
	)) . '

			' . $__templater->callMacro('helper_action', 'thread_redirect', array(
		'label' => 'Redirection notice',
	), $__vars) . '

			' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'notify_watchers',
		'value' => '1',
		'selected' => true,
		'label' => 'Notify members watching the destination forum',
		'_type' => 'option',
	)), array(
	)) . '

			' . $__compilerTemp3 . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'sticky' => 'true',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('threads/move', $__vars['thread'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);