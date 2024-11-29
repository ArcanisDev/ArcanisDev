<?php
// FROM HASH: 7b9abecbfa9c26d759e5793d955109ca
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Content types');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add content type field', array(
		'href' => $__templater->func('link', array('content-types/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

';
	if ($__templater->isTraversable($__vars['fieldsGrouped'])) {
		foreach ($__vars['fieldsGrouped'] AS $__vars['contentType'] => $__vars['fields']) {
			$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<h2 class="block-header">
				<a href="' . $__templater->func('link', array('content-types/add', array(), array('content_type' => $__vars['contentType'], ), ), true) . '" class="u-pullRight">' . $__templater->fontAwesome('fa-plus-circle', array(
			)) . '</a>
				' . $__templater->escape($__vars['contentType']) . '
			</h2>
			<div class="block-body">
				';
			$__compilerTemp1 = '';
			if ($__templater->isTraversable($__vars['fields'])) {
				foreach ($__vars['fields'] AS $__vars['field']) {
					$__compilerTemp1 .= '
					' . $__templater->dataRow(array(
						'href' => $__templater->func('link', array('content-types/edit', $__vars['field'], ), false),
						'label' => $__templater->escape($__vars['field']['field_name']),
						'hint' => $__templater->escape($__vars['field']['field_value']),
						'hash' => $__vars['field']['content_type'] . '_' . $__vars['field']['field_name'],
						'dir' => 'auto',
					), array()) . '
				';
				}
			}
			$__finalCompiled .= $__templater->dataList('
				' . $__compilerTemp1 . '
				', array(
			)) . '
			</div>
		</div>
	</div>
';
		}
	}
	return $__finalCompiled;
}
);