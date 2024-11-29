<?php
// FROM HASH: 699bf599c75f31affc68a0865145ad90
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<h3 class="menu-header">' . 'Options' . '</h3>
<ul class="listPlain listColumns listColumns--3 listColumns--together">
	';
	if ($__templater->isTraversable($__vars['groups'])) {
		foreach ($__vars['groups'] AS $__vars['groupId'] => $__vars['group']) {
			$__finalCompiled .= '
		<li class="optionGroup ' . ($__vars['group']['advanced'] ? 'acp--advanced' : '') . '">
			<a class="menu-linkRow" href="' . $__templater->func('link', array('options/groups', array('group_id' => $__vars['groupId'], ), ), true) . '">
				';
			if ($__vars['group']['icon']) {
				$__finalCompiled .= '
					' . $__templater->fontAwesome($__templater->escape($__vars['group']['icon']) . ' fa-fw', array(
				)) . '
				';
			} else {
				$__finalCompiled .= '
					' . $__templater->fontAwesome('fa-cogs fa-fw', array(
				)) . '
				';
			}
			$__finalCompiled .= '
				' . $__templater->escape($__vars['group']['title']) . '
			</a>
		</li>
	';
		}
	}
	$__finalCompiled .= '
</ul>
<hr class="menu-separator menu-separator--hard">
<div class="menu-row menu-row--alt">
	' . $__templater->formCheckBox(array(
	), array(array(
		'selected' => $__vars['xf']['visitor']['Admin']['advanced'],
		'class' => 'js-advancedModeToggle',
		'label' => 'Show advanced options',
		'data-xf-init' => 'admin-toggle-advanced',
		'data-url' => $__templater->func('link', array('account/toggle-advanced', ), false),
		'_type' => 'option',
	))) . '
</div>';
	return $__finalCompiled;
}
);